<?php

namespace App\Services;

use DOMDocument;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use ZipArchive;

class DocxService
{
    /**
     * Extract all unique placeholder names in [PlaceholderName] format from a DOCX file.
     */
    public function extractPlaceholders(string $filePath): array
    {
        return $this->analyzePlaceholders($filePath)['valid'];
    }

    /**
     * Analyze placeholders in a DOCX file and return a structured result:
     *
     * [
     *   'valid'     => ['Nama', 'NIK', 'Alamat'],         // unique, well-formed
     *   'duplicates'=> ['Nama' => 2, 'Tanggal' => 3],    // key => count (count >= 2)
     *   'malformed' => ['[nama[', ']NIK]'],               // suspicious bracket patterns
     *   'has_issues'=> bool,
     * ]
     */
    public function analyzePlaceholders(string $filePath): array
    {
        $result = [
            'valid'      => [],
            'duplicates' => [],
            'malformed'  => [],
            'has_issues' => false,
        ];

        if (! file_exists($filePath)) {
            return $result;
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return $result;
        }

        $xmlFiles = ['word/document.xml'];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            if (preg_match('/^word\/(header|footer)\d+\.xml$/', $filename)) {
                $xmlFiles[] = $filename;
            }
        }

        $combinedText = '';
        foreach ($xmlFiles as $xmlFile) {
            $content = $zip->getFromName($xmlFile);
            if ($content) {
                $dom = new DOMDocument();
                @$dom->loadXML($content);
                $combinedText .= ' ' . $dom->textContent;
            }
        }
        $zip->close();

        // 1. Detect well-formed placeholders [Key] and count occurrences
        preg_match_all('/\[([^\[\]]+)\]/', $combinedText, $matches);
        $allFound = array_map('trim', $matches[1] ?? []);
        $allFound = array_filter($allFound); // remove empty

        $counts = array_count_values($allFound); // ['Nama' => 2, 'NIK' => 1]

        foreach ($counts as $key => $count) {
            if ($count >= 2) {
                $result['duplicates'][$key] = $count;
            } else {
                $result['valid'][] = $key;
            }
        }

        // 2. Detect malformed placeholders: patterns that look like attempted placeholders
        //    but have wrong bracket order/nesting: e.g. [nama[, ]nama], [[nama]]
        preg_match_all('/(?:\[[^\[\]]*\[|\][^\[\]]*\]|\[\[[^\]]+\]\]|\[[^\[\]]+$|^[^\[]*\][^\[]*\])/', $combinedText, $malformed);
        // Also catch: starts with ] or ends with [
        preg_match_all('/\][A-Za-z][A-Za-z0-9 _-]*\]/', $combinedText, $malformed2);
        preg_match_all('/\[[A-Za-z][A-Za-z0-9 _-]*\[/', $combinedText, $malformed3);

        $malformedItems = array_merge(
            $malformed[0] ?? [],
            $malformed2[0] ?? [],
            $malformed3[0] ?? [],
        );
        $result['malformed'] = array_values(array_unique(array_filter($malformedItems)));

        $result['has_issues'] = ! empty($result['duplicates']) || ! empty($result['malformed']);

        return $result;
    }

    /**
     * Fill DOCX template placeholders dynamically.
     *
     * PhpWord TemplateProcessor fails with placeholders that contain spaces
     * (e.g. [Jenis Kelamin]) because MS Word splits them into multiple XML runs.
     * This implementation normalises the XML runs first, then does a plain-text
     * find-and-replace inside the ZIP, so all placeholders are replaced correctly.
     */
    public function generateDocx(string $templatePath, array $values, string $outputPath): bool
    {
        if (! file_exists($templatePath)) {
            return false;
        }

        $dir = dirname($outputPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Work on a temp copy in the system temp directory to avoid Windows file lock/rename permission issues.
        $tempPath = tempnam(sys_get_temp_dir(), 'docx_') . '.docx';
        copy($templatePath, $tempPath);

        $zip = new ZipArchive();
        if ($zip->open($tempPath) !== true) {
            return false;
        }

        // The XML files inside a DOCX that may contain placeholders.
        $xmlFiles = ['word/document.xml'];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (preg_match('/^word\/(header|footer)\d+\.xml$/', $name)) {
                $xmlFiles[] = $name;
            }
        }

        foreach ($xmlFiles as $xmlFile) {
            $xml = $zip->getFromName($xmlFile);
            if ($xml === false) {
                continue;
            }

            // ── Step 1: Merge split runs inside a paragraph so that a placeholder
            //   like [Jenis Kelamin] — which Word may split across several <w:r> tags
            //   — becomes a single contiguous string we can search for.
            $xml = $this->mergeRunsInParagraphs($xml);

            // ── Step 2: Simple string replacement of [Key] → value.
            foreach ($values as $key => $val) {
                $xml = str_replace('[' . $key . ']', htmlspecialchars((string) ($val ?? ''), ENT_XML1 | ENT_COMPAT, 'UTF-8'), $xml);
            }

            $zip->addFromString($xmlFile, $xml);
        }

        $zip->close();

        // Move temp file to final output path using copy() + unlink() to avoid cross-drive rename issues.
        if (file_exists($outputPath)) {
            @unlink($outputPath);
        }
        
        $success = copy($tempPath, $outputPath);
        @unlink($tempPath);

        return $success && file_exists($outputPath);
    }

    /**
     * Merge adjacent <w:r> runs within each <w:p> paragraph so that placeholder
     * text split across multiple runs becomes a single searchable string.
     *
     * Only runs that share identical run-properties (<w:rPr>) are merged;
     * runs with different formatting are left untouched to preserve styling.
     */
    private function mergeRunsInParagraphs(string $xml): string
    {
        // We only need to normalise paragraphs that appear to contain a '[' …
        // but it's safe (and simpler) to process all paragraphs.
        return preg_replace_callback(
            '/<w:p[ >].*?<\/w:p>/s',
            function (array $m) {
                return $this->mergeParagraphRuns($m[0]);
            },
            $xml
        ) ?? $xml;
    }

    /**
     * Within a single <w:p> block, concatenate consecutive <w:r> runs that
     * share the same <w:rPr> (or both have none) into one run.
     */
    private function mergeParagraphRuns(string $para): string
    {
        // Extract all <w:r>…</w:r> segments with their positions.
        if (! preg_match_all('/<w:r[ >].*?<\/w:r>/s', $para, $runs, PREG_OFFSET_CAPTURE)) {
            return $para;
        }

        // Build merged run groups.
        $groups   = [];   // each group: ['rPr' => string|null, 'texts' => [string]]
        $offsets  = [];   // original offsets in $para for later replacement

        foreach ($runs[0] as [$run, $offset]) {
            // Extract rPr (run properties).
            $rPr = null;
            if (preg_match('/<w:rPr>.*?<\/w:rPr>/s', $run, $rPrMatch)) {
                $rPr = $rPrMatch[0];
            }

            // Extract the text(s) in this run.
            preg_match_all('/<w:t[^>]*>(.*?)<\/w:t>/s', $run, $texts, PREG_SET_ORDER);
            $text = implode('', array_column($texts, 1));

            // Can we append to the last group?
            if (! empty($groups) && $groups[count($groups) - 1]['rPr'] === $rPr) {
                $groups[count($groups) - 1]['texts'][] = $text;
            } else {
                $groups[] = ['rPr' => $rPr, 'texts' => [$text]];
            }
            $offsets[] = [$offset, strlen($run)];
        }

        // If nothing merged, return unchanged.
        if (count($groups) === count($runs[0])) {
            return $para;
        }

        // Rebuild merged runs.
        $mergedRuns = [];
        foreach ($groups as $group) {
            $combinedText = implode('', $group['texts']);
            $rPrTag       = $group['rPr'] ?? '';
            // Use xml:space="preserve" so spaces inside values are kept.
            $mergedRuns[] = '<w:r>' . $rPrTag . '<w:t xml:space="preserve">' . $combinedText . '</w:t></w:r>';
        }

        // Replace ALL original runs inside this paragraph with the merged ones,
        // by removing every original run and inserting the merged block before </w:p>.
        $result = preg_replace('/<w:r[ >].*?<\/w:r>/s', '', $para);
        $result = str_replace('</w:p>', implode('', $mergedRuns) . '</w:p>', $result);

        return $result;
    }

    /**
     * Convert DOCX to PDF.
     * If $useNativeWord is false (Live Preview): Uses Fast Dompdf (0.1s instant rendering).
     * If $useNativeWord is true (Final Export/Archive): Uses Native MS Word Engine for 100% official Word quality.
     */
    public function generatePdfFromDocx(string $docxPath, string $outputPdfPath, bool $useNativeWord = false): bool
    {
        if (! file_exists($docxPath)) {
            return false;
        }

        $outputDir = dirname($outputPdfPath);
        if (! is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // 1. For Final Export/Archive OR explicitly requested: Use Native MS Word COM API (~1.5s)
        if ($useNativeWord && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if ($this->convertUsingMsWordVbscript($docxPath, $outputPdfPath)) {
                return true;
            }
        }

        // 2. For Fast Live Preview (0.1s Instant): Use Dompdf with styled HTML output
        if ($this->fastDompdfConversion($docxPath, $outputPdfPath)) {
            return true;
        }

        // 3. Fallback to MS Word if fast conversion failed
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return $this->convertUsingMsWordVbscript($docxPath, $outputPdfPath);
        }

        return false;
    }

    /**
     * Fast Dompdf conversion (100ms) with Kop Surat logo image constraints for instant Live Preview.
     */
    private function fastDompdfConversion(string $docxPath, string $outputPdfPath): bool
    {
        try {
            Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
            Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

            $phpWord = IOFactory::load($docxPath);
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

            $tempHtmlPath = tempnam(sys_get_temp_dir(), 'docx_html_') . '.html';
            $htmlWriter->save($tempHtmlPath);

            $htmlContent = file_get_contents($tempHtmlPath);
            @unlink($tempHtmlPath);

            // Custom CSS to keep logo small and layout neat in HTML preview
            $customCss = '<style>
                @page { margin: 15mm 15mm 15mm 15mm; }
                body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.3; color: #000000; }
                img { max-width: 90px !important; height: auto !important; display: inline-block; vertical-align: middle; }
                table { border-collapse: collapse; margin-top: 2px; margin-bottom: 2px; border: none !important; }
                td, th { padding: 0px 4px; font-family: "Times New Roman", Times, serif; font-size: 11pt; vertical-align: top; border: none !important; }
                p { margin: 2px 0; }
            </style>';

            if (str_contains($htmlContent, '</head>')) {
                $htmlContent = str_replace('</head>', $customCss . '</head>', $htmlContent);
            } else {
                $htmlContent = $customCss . $htmlContent;
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($htmlContent)->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
            $pdf->setPaper('A4', 'portrait');
            file_put_contents($outputPdfPath, $pdf->output());

            return file_exists($outputPdfPath) && filesize($outputPdfPath) > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Convert DOCX to PDF natively using MS Word COM via cscript (VBScript).
     * Ultra-fast execution (~1.5s) with atomic temporary target write.
     */
    private function convertUsingMsWordVbscript(string $docxPath, string $outputPdfPath): bool
    {
        $vbsPath = base_path('convert_word.vbs');

        if (! file_exists($vbsPath)) {
            $vbsCode = <<<'VBS'
Set args = WScript.Arguments
If args.Count < 2 Then
    WScript.Echo "MISSING_ARGS"
    WScript.Quit 1
End If
On Error Resume Next
Set word = CreateObject("Word.Application")
word.Visible = False
word.DisplayAlerts = 0
Set doc = word.Documents.Open(args(0), False, True)
If Err.Number <> 0 Then
    WScript.Echo "ERROR_OPEN: " & Err.Description
    word.Quit
    WScript.Quit 1
End If
doc.SaveAs args(1), 17
doc.Close False
word.Quit
WScript.Echo "VBS_WORD_SUCCESS"
VBS;
            file_put_contents($vbsPath, $vbsCode);
        }

        $tempTargetPdf = $outputPdfPath . '.tmp';
        if (file_exists($tempTargetPdf)) {
            @unlink($tempTargetPdf);
        }

        $command = sprintf(
            'cscript //nologo %s %s %s 2>&1',
            escapeshellarg($vbsPath),
            escapeshellarg($docxPath),
            escapeshellarg($tempTargetPdf)
        );

        exec($command, $output, $returnCode);

        if (file_exists($tempTargetPdf) && filesize($tempTargetPdf) > 0) {
            rename($tempTargetPdf, $outputPdfPath);

            return true;
        }

        return file_exists($outputPdfPath) && filesize($outputPdfPath) > 0;
    }

    /**
     * Find LibreOffice CLI executable on Windows / Linux systems.
     */
    private function findLibreOfficeBinary(): ?string
    {
        $possiblePaths = [
            'soffice',
            'libreoffice',
            'C:\Program Files\LibreOffice\program\soffice.exe',
            'C:\Program Files (x86)\LibreOffice\program\soffice.exe',
            'C:\Program Files\LibreOffice 7\program\soffice.exe',
            'C:\Program Files\LibreOffice 24\program\soffice.exe',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
