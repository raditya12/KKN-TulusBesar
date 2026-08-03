<?php

namespace App\Services\Surat;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\TemplateSurat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuratService
{
    public function __construct(
        private readonly PlaceholderService $placeholderService,
        private readonly PdfGeneratorService $pdfGeneratorService,
    ) {}

    /**
     * Generate a new surat from form data.
     * Orchestrates: replace placeholders → build snapshot → generate PDF → persist.
     *
     * @param  array{
     *     nomor_surat: string,
     *     jenis_surat_id: int,
     *     template_surat_id: int|null,
     *     nama_warga: string,
     *     nik: string|null,
     *     data_surat: array<string, string>,
     *     tanggal_surat: string,
     *     is_custom: bool,
     *     nama_surat_custom: string|null,
     *     konten_html_raw: string,
     * } $data
     *
     * @throws \RuntimeException When there are still unreplaced placeholders
     */
    public function generateSurat(array $data): Surat
    {
        // Build the final HTML snapshot by replacing all placeholders
        $snapshot = $this->placeholderService->replacePlaceholders(
            $data['konten_html_raw'],
            $data['data_surat']
        );

        // Verify no placeholders remain unreplaced
        if ($this->placeholderService->hasUnreplacedPlaceholders($snapshot)) {
            $remaining = $this->placeholderService->getRemainingPlaceholders($snapshot);
            throw new \RuntimeException(
                'Masih terdapat placeholder yang belum diisi: '.implode(', ', $remaining)
            );
        }

        return DB::transaction(function () use ($data, $snapshot): Surat {
            $surat = Surat::create([
                'nomor_surat' => $data['nomor_surat'],
                'jenis_surat_id' => $data['jenis_surat_id'],
                'template_surat_id' => $data['template_surat_id'] ?? null,
                'nama_warga' => $data['nama_warga'],
                'nik' => $data['nik'] ?? null,
                'data_surat' => $data['data_surat'],
                'konten_snapshot' => $snapshot,
                'status' => 'draft',
                'tanggal_surat' => $data['tanggal_surat'],
                'is_custom' => $data['is_custom'] ?? false,
                'nama_surat_custom' => $data['nama_surat_custom'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Generate PDF and update the record
            $pdfPath = $this->pdfGeneratorService->generate($surat);

            $surat->update([
                'pdf_generated_path' => $pdfPath,
                'status' => 'dicetak',
                'tanggal_terbit' => now()->toDateString(),
            ]);

            return $surat->fresh();
        });
    }

    /**
     * Auto-detect and create a new JenisSurat and TemplateSurat from a custom surat.
     */
    public function promoteCustomSuratToTemplate(Surat $surat): TemplateSurat
    {
        return DB::transaction(function () use ($surat): TemplateSurat {
            $kode = Str::slug($surat->nama_surat_custom ?? 'custom', '_');

            $jenisSurat = JenisSurat::firstOrCreate(
                ['kode' => $kode],
                [
                    'nama' => $surat->nama_surat_custom,
                    'deskripsi' => 'Dibuat otomatis dari Custom Surat.',
                    'is_system' => false,
                    'is_active' => true,
                ]
            );

            $template = TemplateSurat::create([
                'jenis_surat_id' => $jenisSurat->id,
                'judul' => $surat->nama_surat_custom,
                'konten_html' => $surat->konten_snapshot,
                'is_active' => true,
                'created_by' => auth()->id(),
            ]);

            return $template;
        });
    }
}
