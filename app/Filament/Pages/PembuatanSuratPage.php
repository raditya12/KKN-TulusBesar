<?php

namespace App\Filament\Pages;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Services\DocxService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembuatanSuratPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    protected string $view = 'filament.pages.pembuatan-surat-page';

    protected static ?string $navigationLabel = 'Pembuatan Surat';

    protected static ?string $title = 'Pembuatan Surat';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static ?int $navigationSort = 3;

    // ── Form State ───────────────────────────────────────────────────────────────
    public ?int $jenis_surat_id = null;

    public ?string $nomor_surat = null;

    public ?string $tanggal_surat = null;

    public array $formData = [];

    // ── Template Metadata ────────────────────────────────────────────────────────
    public array $placeholders = [];

    public bool $hasTemplate = false;

    public ?string $templateFileName = null;

    public ?string $jenisSuratNama = null;

    // ── Preview State ────────────────────────────────────────────────────────────
    public ?string $previewToken = null;

    public bool $previewReady = false;

    public ?string $lastGeneratedHash = null;

    public function mount(): void
    {
        $sessionId = session()->getId() ?: md5(uniqid('', true));
        $this->previewToken = 'sess_' . preg_replace('/[^a-zA-Z0-9]/', '_', $sessionId);

        $this->tanggal_surat = date('Y-m-d');
        $this->nomor_surat = '470 / ' . rand(100, 999) . ' / 35.07.19.2005 / ' . date('Y');

        // Initial state on page open: No Jenis Surat selected, preview NOT ready
        $this->previewReady = false;
        $this->jenis_surat_id = null;
    }

    public function updated($property): void
    {
        if ($property === 'jenis_surat_id') {
            $this->loadTemplateAndPlaceholders($this->jenis_surat_id ? (int) $this->jenis_surat_id : null);
        }
    }

    public function loadTemplateAndPlaceholders(?int $jenisSuratId): void
    {
        $this->formData = [];
        $this->placeholders = [];
        $this->hasTemplate = false;
        $this->templateFileName = null;
        $this->previewReady = false;
        $this->lastGeneratedHash = null;

        if (! $jenisSuratId) {
            return;
        }

        $jenisSurat = JenisSurat::find($jenisSuratId);
        if (! $jenisSurat) {
            return;
        }

        $this->jenisSuratNama = $jenisSurat->nama_surat;

        $template = TemplateSurat::where('jenis_surat_id', $jenisSuratId)
            ->where('is_active', true)
            ->first();

        if (! $template || ! $template->file_docx) {
            Notification::make()
                ->title('Template Tidak Ditemukan')
                ->body('Jenis surat "' . $jenisSurat->nama_surat . '" belum memiliki template Word (.docx) yang aktif.')
                ->warning()
                ->send();

            return;
        }

        $filePath = Storage::disk('public')->path($template->file_docx);

        if (! file_exists($filePath)) {
            Notification::make()
                ->title('File Template Hilang')
                ->body('File template "' . basename($template->file_docx) . '" tidak ditemukan di storage.')
                ->danger()
                ->send();

            return;
        }

        /** @var DocxService $docxService */
        $docxService = app(DocxService::class);
        $this->placeholders = $docxService->extractPlaceholders($filePath);
        $this->hasTemplate = true;
        $this->templateFileName = basename($template->file_docx);

        foreach ($this->placeholders as $ph) {
            $this->formData[$ph] = '';
        }

        $this->reloadPreview(useNativeWord: false);
    }

    public function reloadPreview(bool $useNativeWord = false): void
    {
        if (! $this->jenis_surat_id || ! $this->hasTemplate) {
            $this->previewReady = false;

            return;
        }

        $currentHash = $this->computeFormHash() . ($useNativeWord ? '_word' : '_fast');
        if ($this->lastGeneratedHash === $currentHash && $this->previewReady) {
            $this->dispatch('preview-stable');

            return;
        }

        $template = TemplateSurat::where('jenis_surat_id', $this->jenis_surat_id)
            ->where('is_active', true)
            ->first();

        if (! $template || ! $template->file_docx) {
            return;
        }

        $templatePath = Storage::disk('public')->path($template->file_docx);

        Storage::disk('public')->makeDirectory('temp-preview');

        $fullDocxPath = $this->getTempDocxPath();
        $fullPdfPath  = $this->getTempPdfPath();

        /** @var DocxService $docxService */
        $docxService = app(DocxService::class);

        // 1. Generate DOCX with current form values
        $docxService->generateDocx($templatePath, $this->getMergedValues(), $fullDocxPath);

        // 2. Convert to PDF (Fast 0.1s for live preview, Native Word when requested)
        $docxService->generatePdfFromDocx($fullDocxPath, $fullPdfPath, useNativeWord: $useNativeWord);

        if (file_exists($fullPdfPath) && filesize($fullPdfPath) > 0) {
            $this->previewReady = true;
            $this->lastGeneratedHash = $currentHash;

            $this->dispatch('reload-iframe');
        }
    }

    public function reloadMsWordPreview(): void
    {
        $this->reloadPreview(useNativeWord: true);
    }

    private function getTempDocxPath(): string
    {
        return Storage::disk('public')->path('temp-preview/preview_' . $this->previewToken . '.docx');
    }

    private function getTempPdfPath(): string
    {
        return Storage::disk('public')->path('temp-preview/preview_' . $this->previewToken . '.pdf');
    }

    public function getPreviewUrl(): string
    {
        if (empty($this->previewToken)) {
            $sessionId = session()->getId() ?: md5(uniqid('', true));
            $this->previewToken = 'sess_' . preg_replace('/[^a-zA-Z0-9]/', '_', $sessionId);
        }

        return route('surat.preview-pdf', ['sessionId' => $this->previewToken]);
    }

    private function computeFormHash(): string
    {
        return md5(json_encode([
            'jenis_surat_id' => $this->jenis_surat_id,
            'nomor_surat'    => $this->nomor_surat,
            'tanggal_surat'  => $this->tanggal_surat,
            'formData'       => $this->formData,
        ]));
    }

    public function getLabel(string $key): string
    {
        return Str::headline($key);
    }

    public function getMergedValues(): array
    {
        $formattedDate = '';
        if ($this->tanggal_surat) {
            $timestamp = strtotime($this->tanggal_surat);
            $bulanIndo = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
            ];
            $m = (int) date('n', $timestamp);
            $formattedDate = date('j', $timestamp) . ' ' . ($bulanIndo[$m] ?? date('F', $timestamp)) . ' ' . date('Y', $timestamp);
        }

        $merged = [
            'nomor_surat'   => $this->nomor_surat,
            'tanggal_surat' => $formattedDate,
            'Nomor_Surat'   => $this->nomor_surat,
            'Tanggal_Surat' => $formattedDate,
            'tanggal'       => $formattedDate,
            'Tanggal'       => $formattedDate,
        ];

        foreach ($this->formData as $key => $val) {
            $valStr = (string) ($val ?? '');
            $merged[$key] = $valStr;
            $merged[str_replace(' ', '', $key)] = $valStr;
            $merged[Str::snake($key)] = $valStr;
            $merged[Str::headline($key)] = $valStr;
        }

        return $merged;
    }

    protected function extractNamaPemohon(): string
    {
        foreach ($this->formData as $key => $val) {
            $cleanKey = strtolower(str_replace(['_', '-', ' '], '', $key));
            if (in_array($cleanKey, ['nama', 'namapemohon', 'namawarga', 'namalengkap', 'namaortu', 'namabayi', 'namaibu'])) {
                if (! empty(trim((string) $val))) {
                    return trim((string) $val);
                }
            }
        }
        foreach ($this->formData as $val) {
            if (! empty(trim((string) $val))) {
                return trim((string) $val);
            }
        }

        return 'Warga / Pemohon';
    }

    protected function saveToArchive(): Surat
    {
        $jenisSurat = JenisSurat::find($this->jenis_surat_id);
        $safeName   = preg_replace('/[^A-Za-z0-9_\-]/', '_', $jenisSurat ? $jenisSurat->nama_surat : 'Surat');
        $timestamp  = date('Ymd_His');

        Storage::disk('public')->makeDirectory('arsip-surat/docx');
        Storage::disk('public')->makeDirectory('arsip-surat/pdf');

        $relativeDocxPath = 'arsip-surat/docx/' . $safeName . '_' . $timestamp . '.docx';
        $relativePdfPath  = 'arsip-surat/pdf/' . $safeName . '_' . $timestamp . '.pdf';

        $fullDocxPath = Storage::disk('public')->path($relativeDocxPath);
        $fullPdfPath  = Storage::disk('public')->path($relativePdfPath);

        $template = TemplateSurat::where('jenis_surat_id', $this->jenis_surat_id)
            ->where('is_active', true)
            ->first();

        /** @var DocxService $docxService */
        $docxService = app(DocxService::class);

        if ($template) {
            $docxService->generateDocx(
                Storage::disk('public')->path($template->file_docx),
                $this->getMergedValues(),
                $fullDocxPath
            );
        }

        $docxService->generatePdfFromDocx($fullDocxPath, $fullPdfPath, useNativeWord: true);

        return Surat::create([
            'nomor_surat'    => $this->nomor_surat,
            'jenis_surat_id' => $this->jenis_surat_id,
            'nama_pemohon'   => $this->extractNamaPemohon(),
            'data_json'      => $this->formData,
            'file_docx'      => $relativeDocxPath,
            'file_pdf'       => file_exists($fullPdfPath) ? $relativePdfPath : null,
            'status_scan'    => 'belum_upload',
        ]);
    }

    public function generateDocx()
    {
        $this->validateForm();
        $surat = $this->saveToArchive();

        Notification::make()
            ->title('Surat Berhasil Dibuat & Diarsipkan')
            ->body('Mengunduh dokumen Word (DOCX) resmi...')
            ->success()
            ->send();

        return response()->download(Storage::disk('public')->path($surat->file_docx));
    }

    public function generatePdf()
    {
        $this->validateForm();
        $surat = $this->saveToArchive();

        if (! $surat->file_pdf || ! Storage::disk('public')->exists($surat->file_pdf)) {
            Notification::make()
                ->title('Gagal Generate PDF')
                ->body('Terjadi kesalahan saat membuat file PDF.')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Surat Berhasil Dibuat & Diarsipkan')
            ->body('Mengunduh dokumen PDF resmi...')
            ->success()
            ->send();

        return response()->download(Storage::disk('public')->path($surat->file_pdf));
    }

    protected function validateForm(): void
    {
        $rules = [
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'nomor_surat'    => ['required', 'string', 'max:255'],
            'tanggal_surat'  => ['required', 'date'],
        ];

        $attributes = [
            'jenis_surat_id' => 'Jenis Surat',
            'nomor_surat'    => 'Nomor Surat',
            'tanggal_surat'  => 'Tanggal Surat',
        ];

        foreach ($this->placeholders as $ph) {
            $rules['formData.' . $ph] = ['required', 'string'];
            $attributes['formData.' . $ph] = $this->getLabel($ph);
        }

        $this->validate($rules, [], $attributes);
    }

    public function getViewData(): array
    {
        return [
            'jenisSuratOptions' => JenisSurat::active()->pluck('nama_surat', 'id')->toArray(),
        ];
    }
}
