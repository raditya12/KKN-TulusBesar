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
        'surat_id'       => ['except' => null],
        // Parameter ini diisi saat user kembali dari preview tanpa simpan
        'restore_jenis'  => ['except' => null],
        'restore_nomor'  => ['except' => null],
        'restore_tgl'    => ['except' => null],
        'restore_data'   => ['except' => null],  // base64-encoded JSON
    ];

    public ?string $restore_jenis = null;
    public ?string $restore_nomor = null;
    public ?string $restore_tgl   = null;
    public ?string $restore_data  = null;

    public function mount(): void
    {
        if ($this->surat_id) {
            // Edit surat yang sudah ada di DB
            $surat = Surat::find($this->surat_id);
            if ($surat) {
                $this->jenis_surat_id = $surat->jenis_surat_id;
                $this->nomor_surat    = $surat->nomor_surat;
                $this->tanggal_surat  = date('Y-m-d');
                $this->formData       = $surat->data_json ?? [];

                $this->loadTemplateAndPlaceholders($this->jenis_surat_id, false);
            }
        } elseif ($this->restore_jenis) {
            // Kembali dari halaman preview tanpa simpan — restore form data
            $this->jenis_surat_id = (int) $this->restore_jenis;
            $this->nomor_surat    = $this->restore_nomor ?? '';
            $this->tanggal_surat  = $this->restore_tgl ?? date('Y-m-d');
            $this->formData       = $this->restore_data
                ? (json_decode(base64_decode($this->restore_data), true) ?? [])
                : [];

            $this->loadTemplateAndPlaceholders($this->jenis_surat_id, false);
        } else {
            // Form baru
            $this->tanggal_surat  = date('Y-m-d');
            $this->nomor_surat    = '470 / ' . rand(100, 999) . ' / 35.07.19.2005 / ' . date('Y');
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

        $messages = [];
        foreach ($this->placeholders as $ph) {
            $label = $this->getLabel($ph);
            $messages['formData.' . $ph . '.required'] = "Data {$label} wajib diisi.";
            $messages['formData.' . $ph . '.string']   = "Data {$label} harus berupa teks.";
        }
        $messages['jenis_surat_id.required'] = 'Jenis Surat wajib dipilih.';
        $messages['jenis_surat_id.exists']   = 'Jenis Surat yang dipilih tidak valid.';
        $messages['nomor_surat.required']    = 'Nomor Surat wajib diisi.';
        $messages['nomor_surat.max']         = 'Nomor Surat terlalu panjang (maks. 255 karakter).';
        $messages['tanggal_surat.required']  = 'Tanggal Surat wajib diisi.';
        $messages['tanggal_surat.date']      = 'Format Tanggal Surat tidak valid.';

        $this->validate($rules, $messages, $attributes);
    }

    public function generateSurat()
    {
        $this->validateForm();

        $jenisSurat = JenisSurat::find($this->jenis_surat_id);
        $safeName   = preg_replace('/[^A-Za-z0-9_\-]/', '_', $jenisSurat ? $jenisSurat->nama_surat : 'Surat');
        $timestamp  = date('Ymd_His');

        Storage::disk('public')->makeDirectory('temp-surat-preview');

        $relativeDocxPath = 'temp-surat-preview/' . $safeName . '_' . $timestamp . '.docx';
        $relativePdfPath  = 'temp-surat-preview/' . $safeName . '_' . $timestamp . '.pdf';

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

        // 1. Generate DOCX dari template + isi form
        $docxService->generateDocx(
            Storage::disk('public')->path($template->file_docx),
            $this->getMergedValues(),
            $fullDocxPath
        );

        // 2. Generate PDF untuk preview
        $docxService->generatePdfFromDocx($fullDocxPath, $fullPdfPath, useNativeWord: true);

        // 3. Redirect ke halaman preview — belum simpan ke DB
        return redirect()->route('filament.admin.pages.preview-surat-page', [
            'temp_docx'      => $relativeDocxPath,
            'temp_pdf'       => file_exists($fullPdfPath) ? $relativePdfPath : null,
            'jenis_surat_id' => $this->jenis_surat_id,
            'nomor_surat'    => $this->nomor_surat,
            'tanggal_surat'  => $this->tanggal_surat,
            'form_data'      => base64_encode(json_encode($this->formData)),
            'surat_id'       => $this->surat_id, // null jika baru
        ]);
    }

    public function getViewData(): array
    {
        return [
            'jenisSuratOptions' => JenisSurat::active()->pluck('nama_surat', 'id')->toArray(),
        ];
    }
}
