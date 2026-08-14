<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Models\JenisSurat;
use App\Models\Surat;
use App\Services\DocxService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PreviewSuratPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.preview-surat-page';

    protected static ?string $title = 'Preview Hasil Surat';

    protected static bool $shouldRegisterNavigation = false;

    // ── Mode: saved record ────────────────────────────────────────────────────
    public ?int $record = null;
    public ?Surat $surat = null;

    // ── Mode: temp preview (belum disimpan) ───────────────────────────────────
    public ?string $temp_docx      = null;
    public ?string $temp_pdf       = null;
    public ?int    $jenis_surat_id = null;
    public ?string $nomor_surat    = null;
    public ?string $tanggal_surat  = null;
    public ?string $form_data      = null;  // base64-encoded JSON
    public ?int    $surat_id       = null;  // existing surat being edited

    /** True when we arrived from generateSurat() without saving yet. */
    public bool $isTempPreview = false;

    public function mount(): void
    {
        $this->record = request()->query('record');

        if ($this->record) {
            // Saved mode — load from DB
            $this->surat = Surat::findOrFail($this->record);
            $this->isTempPreview = false;
        } else {
            // Temp preview mode — all data comes from query string
            $this->temp_docx      = request()->query('temp_docx');
            $this->temp_pdf       = request()->query('temp_pdf');
            $this->jenis_surat_id = request()->query('jenis_surat_id');
            $this->nomor_surat    = request()->query('nomor_surat');
            $this->tanggal_surat  = request()->query('tanggal_surat');
            $this->form_data      = request()->query('form_data');
            $this->surat_id       = request()->query('surat_id') ?: null;
            $this->isTempPreview  = true;

            if (! $this->temp_docx) {
                abort(404, 'Data preview tidak ditemukan');
            }
        }
    }

    // ── Actions for saved mode ────────────────────────────────────────────────

    public function editData()
    {
        if ($this->isTempPreview) {
            // Hapus temp files karena user memilih untuk edit ulang, bukan simpan
            $this->cleanupTempFiles();

            // Kembalikan ke form dengan data yang sudah diisi sebelumnya
            return redirect()->route('filament.admin.pages.pembuatan-surat-page', [
                'restore_jenis' => $this->jenis_surat_id,
                'restore_nomor' => $this->nomor_surat,
                'restore_tgl'   => $this->tanggal_surat,
                'restore_data'  => $this->form_data,  // sudah base64
            ]);
        }

        return redirect()->route('filament.admin.pages.pembuatan-surat-page', [
            'surat_id' => $this->surat->id,
        ]);
    }

    /** Hapus file temp dari storage. */
    private function cleanupTempFiles(): void
    {
        foreach ([$this->temp_docx, $this->temp_pdf] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }


    public function downloadDocx(): ?BinaryFileResponse
    {
        $path = $this->isTempPreview
            ? $this->temp_docx
            : ($this->surat?->file_docx ?? null);

        if ($path && Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }
        return null;
    }

    public function downloadPdf(): ?BinaryFileResponse
    {
        $path = $this->isTempPreview
            ? $this->temp_pdf
            : ($this->surat?->file_pdf ?? null);

        if ($path && Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }
        return null;
    }

    /** Simpan temp files ke arsip permanen dan catat ke DB. */
    public function simpanArsip()
    {
        if (! $this->isTempPreview) {
            return;
        }

        $formData = $this->form_data
            ? json_decode(base64_decode($this->form_data), true)
            : [];

        // Pindahkan file dari temp ke folder arsip permanen
        Storage::disk('public')->makeDirectory('arsip-surat/docx');
        Storage::disk('public')->makeDirectory('arsip-surat/pdf');

        $docxDest = null;
        $pdfDest  = null;

        if ($this->temp_docx && Storage::disk('public')->exists($this->temp_docx)) {
            $docxDest = 'arsip-surat/docx/' . basename($this->temp_docx);
            Storage::disk('public')->move($this->temp_docx, $docxDest);
        }

        if ($this->temp_pdf && Storage::disk('public')->exists($this->temp_pdf)) {
            $pdfDest = 'arsip-surat/pdf/' . basename($this->temp_pdf);
            Storage::disk('public')->move($this->temp_pdf, $pdfDest);
        }

        $namaPemohon = $this->extractNamaPemohon($formData);

        $data = [
            'nomor_surat'    => $this->nomor_surat,
            'jenis_surat_id' => $this->jenis_surat_id,
            'nama_pemohon'   => $namaPemohon,
            'data_json'      => $formData,
            'file_docx'      => $docxDest,
            'file_pdf'       => $pdfDest,
        ];

        if ($this->surat_id) {
            // Edit mode — update existing, hapus file lama
            $surat = Surat::find($this->surat_id);
            if ($surat) {
                foreach (['file_docx', 'file_pdf'] as $field) {
                    if ($surat->$field && Storage::disk('public')->exists($surat->$field)) {
                        Storage::disk('public')->delete($surat->$field);
                    }
                }
                $surat->update($data);
            } else {
                $surat = Surat::create($data);
            }
        } else {
            $surat = Surat::create($data);
        }

        Notification::make()
            ->title('Surat Berhasil Diarsipkan')
            ->body('Surat telah disimpan ke arsip.')
            ->success()
            ->send();

        // Redirect ke halaman list Arsip Surat
        return $this->redirect(SuratResource::getUrl('index'), navigate: true);
    }

    private function extractNamaPemohon(array $formData): string
    {
        foreach ($formData as $key => $val) {
            $cleanKey = strtolower(str_replace(['_', '-', ' '], '', $key));
            if (in_array($cleanKey, ['nama', 'namapemohon', 'namawarga', 'namalengkap', 'namaortu', 'namabayi', 'namaibu'])) {
                if (! empty(trim((string) $val))) {
                    return trim((string) $val);
                }
            }
        }
        foreach ($formData as $val) {
            if (! empty(trim((string) $val))) {
                return trim((string) $val);
            }
        }
        return 'Warga / Pemohon';
    }

    public function getPdfUrlProperty(): ?string
    {
        if ($this->isTempPreview) {
            return $this->temp_pdf
                ? Storage::url($this->temp_pdf)
                : null;
        }

        return ($this->surat && $this->surat->file_pdf)
            ? Storage::url($this->surat->file_pdf)
            : null;
    }
}
