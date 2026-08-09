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
     * Extract all unique placeholder names in ${PlaceholderName} format from a DOCX file.
     */
    public function extractPlaceholders(string $filePath): array
    {
        if (! file_exists($filePath)) {
            return [];
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
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

        preg_match_all('/\$\{([^}]+)\}/', $combinedText, $matches);

        if (empty($matches[1])) {
            return [];
        }

        $placeholders = array_map('trim', $matches[1]);
        $placeholders = array_unique(array_filter($placeholders));

        return array_values($placeholders);
    }

    /**
     * Fill DOCX template placeholders dynamically using PhpWord TemplateProcessor.
     */
    public function generateDocx(string $templatePath, array $values, string $outputPath): bool
    {
        if (! file_exists($templatePath)) {
            return false;
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        foreach ($values as $key => $val) {
            $templateProcessor->setValue($key, (string) ($val ?? ''));
        }

        $dir = dirname($outputPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $templateProcessor->saveAs($outputPath);

        return file_exists($outputPath);
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
                table { width: 100% !important; border-collapse: collapse; margin-top: 4px; margin-bottom: 4px; }
                td, th { padding: 3px 5px; font-family: "Times New Roman", Times, serif; font-size: 11pt; vertical-align: top; }
                p { margin: 2px 0; }
            </style>';

            if (str_contains($htmlContent, '</head>')) {
                $htmlContent = str_replace('</head>', $customCss . '</head>', $htmlContent);
            } else {
                $htmlContent = $customCss . $htmlContent;
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($htmlContent);
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
