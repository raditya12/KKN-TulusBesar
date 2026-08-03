<?php

namespace App\Services\Surat;

use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGeneratorService
{
    /**
     * Generate a PDF from a Surat's snapshot HTML, save to storage, and return the storage path.
     *
     * @throws \RuntimeException When snapshot is empty or generation fails
     */
    public function generate(Surat $surat): string
    {
        if (empty($surat->konten_snapshot)) {
            throw new \RuntimeException('Snapshot surat kosong, tidak dapat generate PDF.');
        }

        $html = $this->buildFullHtml($surat);

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'dpi' => 150,
            ]);

        $filename = $this->buildFilename($surat);
        $storagePath = 'generated/'.$filename;

        Storage::disk('public')->put($storagePath, $pdf->output());

        return $storagePath;
    }

    /**
     * Build a full HTML document wrapping the surat snapshot.
     */
    private function buildFullHtml(Surat $surat): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Surat {$surat->nomor_surat}</title>
            <style>
                body {
                    font-family: "Times New Roman", Times, serif;
                    font-size: 12pt;
                    line-height: 1.6;
                    color: #000;
                    margin: 0;
                    padding: 0;
                }
                .surat-container {
                    width: 100%;
                    max-width: 700px;
                    margin: 0 auto;
                    padding: 20mm 25mm;
                }
                p {
                    margin: 4pt 0;
                    text-align: justify;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                td, th {
                    padding: 4pt 8pt;
                    vertical-align: top;
                }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .text-justify { text-align: justify; }
                strong, b { font-weight: bold; }
                em, i { font-style: italic; }
                u { text-decoration: underline; }
                hr {
                    border: none;
                    border-top: 2px solid #000;
                    margin: 4pt 0;
                }
            </style>
        </head>
        <body>
            <div class="surat-container">
                {$surat->konten_snapshot}
            </div>
        </body>
        </html>
        HTML;
    }

    /**
     * Build a safe filename for the generated PDF.
     */
    private function buildFilename(Surat $surat): string
    {
        $safeNomor = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $surat->nomor_surat);
        $timestamp = now()->format('Ymd_His');

        return "surat_{$safeNomor}_{$surat->id}_{$timestamp}.pdf";
    }
}
