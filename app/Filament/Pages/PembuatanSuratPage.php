<?php

namespace App\Filament\Pages;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Services\DocxService;
use Filament\Actions\Action;
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

    // ── Edit State ───────────────────────────────────────────────────────────────
    public ?int $surat_id = null;

    protected $queryString = [
        'surat_id' => ['except' => null],
    ];

    public function mount(): void
    {
        if ($this->surat_id) {
            $surat = Surat::find($this->surat_id);
            if ($surat) {
                $this->jenis_surat_id = $surat->jenis_surat_id;
                $this->nomor_surat = $surat->nomor_surat;
                
                // Parse date from data_json or fallback to today
                $this->tanggal_surat = date('Y-m-d');
                $this->formData = $surat->data_json ?? [];
                
                $this->loadTemplateAndPlaceholders($this->jenis_surat_id, false);
            }
        } else {
            $this->tanggal_surat = date('Y-m-d');
            $this->nomor_surat = '470 / ' . rand(100, 999) . ' / 35.07.19.2005 / ' . date('Y');
            $this->jenis_surat_id = null;
        }
    }

    public function updated($property): void
    {
        if ($property === 'jenis_surat_id') {
            $this->loadTemplateAndPlaceholders($this->jenis_surat_id ? (int) $this->jenis_surat_id : null, true);
        }
    }

    public function loadTemplateAndPlaceholders(?int $jenisSuratId, bool $resetForm = true): void
    {
        if ($resetForm) {
            $this->formData = [];
        }
        $this->placeholders = [];
        $this->hasTemplate = false;
        $this->templateFileName = null;

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

        if ($resetForm) {
            foreach ($this->placeholders as $ph) {
                $this->formData[$ph] = '';
            }
        }
    }

    public function previewTemplateAction(): Action
    {
        return Action::make('previewTemplate')
            ->label('Preview Template')
            ->icon('heroicon-o-eye')
            ->color('info')
            ->modalHeading(fn () => 'Preview Template: ' . ($this->jenisSuratNama ?? 'Surat'))
            ->modalWidth('4xl')
            ->modalSubmitAction(false)
            ->modalCancelAction(fn ($action) => $action->label('Tutup'))
            ->modalContent(function () {
                $template = TemplateSurat::where('jenis_surat_id', $this->jenis_surat_id)
                    ->where('is_active', true)
                    ->first();

                if (! $template || ! $template->file_docx) {
                    return view('filament.pages.partials.empty-template-error');
                }

                $docxPath = Storage::disk('public')->path($template->file_docx);
                
                if (!file_exists($docxPath)) {
                    return view('filament.pages.partials.empty-template-error');
                }

                /** @var DocxService $docxService */
                $docxService = app(DocxService::class);
                
                Storage::disk('public')->makeDirectory('temp-template-preview');
                $pdfName = md5($docxPath . filemtime($docxPath)) . '.pdf';
                $pdfPath = 'temp-template-preview/' . $pdfName;
                $fullPdfPath = Storage::disk('public')->path($pdfPath);

                if (!file_exists($fullPdfPath)) {
                    $docxService->generatePdfFromDocx($docxPath, $fullPdfPath, useNativeWord: true);
                }

                return view('filament.pages.partials.template-preview-modal', [
                    'pdfUrl' => Storage::url($pdfPath)
                ]);
            })
            ->visible(fn () => $this->hasTemplate);
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

    public function generateSurat()
    {
        $this->validateForm();

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

        if (!$template || !$template->file_docx) {
            Notification::make()
                ->title('Template Tidak Ditemukan')
                ->danger()
                ->send();
            return;
        }

        /** @var DocxService $docxService */
        $docxService = app(DocxService::class);

        // 1. Generate DOCX Final
        $docxService->generateDocx(
            Storage::disk('public')->path($template->file_docx),
            $this->getMergedValues(),
            $fullDocxPath
        );

        // 2. Generate PDF Final
        $docxService->generatePdfFromDocx($fullDocxPath, $fullPdfPath, useNativeWord: true);

        // 3. Simpan / Update Database (Arsip)
        $data = [
            'nomor_surat'    => $this->nomor_surat,
            'jenis_surat_id' => $this->jenis_surat_id,
            'nama_pemohon'   => $this->extractNamaPemohon(),
            'data_json'      => $this->formData,
            'file_docx'      => $relativeDocxPath,
            'file_pdf'       => file_exists($fullPdfPath) ? $relativePdfPath : null,
        ];

        if ($this->surat_id) {
            $surat = Surat::find($this->surat_id);
            if ($surat) {
                // Delete old files if they exist and are different
                if ($surat->file_docx && Storage::disk('public')->exists($surat->file_docx)) {
                    Storage::disk('public')->delete($surat->file_docx);
                }
                if ($surat->file_pdf && Storage::disk('public')->exists($surat->file_pdf)) {
                    Storage::disk('public')->delete($surat->file_pdf);
                }
                
                $surat->update($data);
            } else {
                $surat = Surat::create($data);
            }
        } else {
            $surat = Surat::create($data);
        }

        Notification::make()
            ->title('Surat Berhasil Di-generate & Diarsipkan')
            ->success()
            ->send();

        // 4. Redirect ke Halaman Preview
        return redirect()->route('filament.admin.pages.preview-surat-page', ['record' => $surat->id]);
    }

    public function getViewData(): array
    {
        return [
            'jenisSuratOptions' => JenisSurat::active()->pluck('nama_surat', 'id')->toArray(),
        ];
    }
}
