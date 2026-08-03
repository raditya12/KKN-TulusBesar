<?php

namespace App\Services\Surat;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

class DocxConverterService
{
    /**
     * Convert a .docx file to HTML string.
     *
     * @param  string  $absolutePath  Absolute path to the .docx file
     *
     * @throws \Exception When file cannot be read or converted
     */
    public function convert(string $absolutePath): string
    {
        if (! file_exists($absolutePath)) {
            throw new \RuntimeException("File DOCX tidak ditemukan: {$absolutePath}");
        }

        // Configure temporary directory for PhpWord
        Settings::setTempDir(sys_get_temp_dir());

        $phpWord = IOFactory::load($absolutePath);

        // Use HTML writer to convert
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        ob_start();
        $htmlWriter->save('php://output');
        $rawHtml = ob_get_clean();

        return $this->cleanHtml((string) $rawHtml);
    }

    /**
     * Clean and simplify the generated HTML for use in the rich editor.
     */
    private function cleanHtml(string $html): string
    {
        // Extract body content if full document HTML was returned
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
            $html = $matches[1];
        }

        // Remove MS Word specific XML namespaces and attributes
        $html = preg_replace('/\s*xmlns[^=]*="[^"]*"/', '', $html) ?? $html;

        // Remove empty paragraphs that only contain whitespace or &nbsp;
        $html = preg_replace('/<p[^>]*>(\s|&nbsp;)*<\/p>/', '', $html) ?? $html;

        // Normalize line endings
        $html = str_replace(["\r\n", "\r"], "\n", $html);

        return trim($html);
    }
}
