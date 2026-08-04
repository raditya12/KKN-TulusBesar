<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Models\JenisSurat;
use App\Models\Pengaturan;
use App\Models\Surat;
use App\Models\TemplateSurat;
use App\Services\Surat\PlaceholderService;
use App\Services\Surat\SuratService;
use BackedEnum;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;

class PembuatanSuratPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi';

    protected static ?string $navigationLabel = 'Pembuatan Surat';

    protected static ?string $title = 'Layanan Surat Menyurat (Pelayanan Publik)';

    protected static ?string $slug = 'pembuatan-surat';

    protected static ?int $navigationSort = 9;

    public function getSubheading(): ?string
    {
        return 'Buat dan cetak surat keterangan resmi untuk warga desa dengan cepat.';
    }

    protected string $view = 'filament.pages.pembuatan-surat-page';

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public ?string $searchNik = '';

    public string|int $jenis_surat_id = 0;

    public ?int $template_surat_id = null;

    public ?string $nomor_surat = null;

    public ?string $tanggal_surat = null;

    /** @var array<string, string> */
    public array $fieldValues = [];

    /** @var array<array{key: string, label: string, placeholder_raw: string}> */
    public array $dynamicFields = [];

    public string $previewHtml = '';

    public bool $isCustom = false;

    public ?string $kontenCustom = null;

    public ?string $namaSuratCustom = null;

    public string $namaDesa = '';

    public string $namaKecamatan = '';

    public string $namaKabupaten = '';

    public string $namaKepalaDesa = '';

    public string $nipKepalaDesa = '';

    public function mount(): void
    {
        $this->tanggal_surat = now()->toDateString();
        $this->namaDesa = preg_replace('/^(desa|kelurahan)\s+/i', '', trim(Pengaturan::get('nama_desa', 'TULUSBESAR')));
        $this->namaKecamatan = preg_replace('/^(kecamatan)\s+/i', '', trim(Pengaturan::get('nama_kecamatan', 'TUMPANG')));
        $this->namaKabupaten = preg_replace('/^(kabupaten|kota)\s+/i', '', trim(Pengaturan::get('nama_kabupaten', 'MALANG')));
        $this->namaKepalaDesa = Pengaturan::get('nama_kepala_desa', 'Budi Santoso, S.E.');
        $this->nipKepalaDesa = Pengaturan::get('nip_kepala_desa', '19750312 200501 1 004');

        $this->nomor_surat = '451.1 / 023 / DS / '.Carbon::now()->format('m / Y');

        // Select first active jenis surat by default
        $firstJenis = JenisSurat::where('is_active', true)->first();
        if ($firstJenis) {
            $this->jenis_surat_id = $firstJenis->id;
            $this->updatedJenisSuratId($firstJenis->id);
        }
    }

    public function updatedSearchNik(string $value): void
    {
        if (! empty($value)) {
            $this->fieldValues['nik'] = $value;
            $this->refreshPreview();
        }
    }

    public function updatedJenisSuratId(mixed $value): void
    {
        $this->fieldValues = [];
        $this->dynamicFields = [];
        $this->extraPlaceholders = [];
        $this->previewHtml = '';
        $this->template_surat_id = null;
        $this->isCustom = false;
        $this->namaSuratCustom = null;

        if ($value === 'custom') {
            $this->isCustom = true;
            $this->jenis_surat_id = 0;

            return;
        }

        $intValue = (int) $value;
        $this->jenis_surat_id = $intValue;

        if (! $intValue) {
            return;
        }

        $template = TemplateSurat::where('jenis_surat_id', $intValue)
            ->where('is_active', true)
            ->first();

        if ($template) {
            $this->template_surat_id = $template->id;

            // Dynamically extract placeholders from template HTML
            $placeholderService = app(PlaceholderService::class);
            $fields = $placeholderService->buildFormFields($template->konten_html ?? '');

            // Filter out system placeholders
            $systemKeys = ['nomor_surat', 'tanggal_surat', 'nama_kepala_desa', 'nip_kepala_desa'];
            $this->dynamicFields = array_values(array_filter($fields, fn ($f) => ! in_array($f['key'], $systemKeys)));

            // Pre-fill initial empty values
            foreach ($this->dynamicFields as $field) {
                $this->fieldValues[$field['key']] = '';
            }

            $this->refreshPreview();
        } else {
            Notification::make()
                ->title('Template belum tersedia')
                ->body('Jenis surat ini belum memiliki template aktif.')
                ->warning()
                ->send();
        }
    }

    public function updatedFieldValues(): void
    {
        $this->refreshPreview();
    }

    public function refreshPreview(): void
    {
        if ($this->template_surat_id) {
            $template = TemplateSurat::find($this->template_surat_id);
            if ($template) {
                $this->previewHtml = app(PlaceholderService::class)->replacePlaceholders(
                    $template->konten_html ?? '',
                    array_merge($this->fieldValues, [
                        'nomor_surat' => ! empty($this->nomor_surat) ? $this->nomor_surat : '____/____/____',
                        'tanggal_surat' => $this->tanggal_surat
                            ? Carbon::parse($this->tanggal_surat)->translatedFormat('d F Y')
                            : Carbon::now()->translatedFormat('d F Y'),
                        'nama_kepala_desa' => $this->namaKepalaDesa,
                        'nip_kepala_desa' => $this->nipKepalaDesa,
                    ])
                );
            }
        }
    }

    public function updatedNomorSurat(): void
    {
        $this->refreshPreview();
    }

    public function updatedTanggalSurat(): void
    {
        $this->refreshPreview();
    }

    public function generateSurat(): void
    {
        $this->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
        ]);

        if (! $this->template_surat_id && ! $this->isCustom) {
            Notification::make()
                ->title('Pilih jenis surat terlebih dahulu')
                ->warning()
                ->send();

            return;
        }

        try {
            $template = $this->template_surat_id
                ? TemplateSurat::find($this->template_surat_id)
                : null;

            $kontenHtmlRaw = $template?->konten_html ?? $this->kontenCustom ?? '';

            $mergedData = array_merge($this->fieldValues, [
                'nomor_surat' => $this->nomor_surat ?? '',
                'tanggal_surat' => $this->tanggal_surat
                    ? Carbon::parse($this->tanggal_surat)->translatedFormat('d F Y')
                    : '',
                'nama_kepala_desa' => $this->namaKepalaDesa,
                'nip_kepala_desa' => $this->nipKepalaDesa,
            ]);

            $suratService = app(SuratService::class);
            $surat = $suratService->generateSurat([
                'nomor_surat' => $this->nomor_surat,
                'jenis_surat_id' => $this->jenis_surat_id ?: (JenisSurat::first()?->id ?? 1),
                'template_surat_id' => $this->template_surat_id,
                'nama_warga' => $this->fieldValues['nama'] ?? ($this->namaSuratCustom ?? 'Warga Desa'),
                'nik' => $this->fieldValues['nik'] ?? null,
                'data_surat' => $mergedData,
                'tanggal_surat' => $this->tanggal_surat,
                'is_custom' => $this->isCustom,
                'nama_surat_custom' => $this->namaSuratCustom,
                'konten_html_raw' => $kontenHtmlRaw,
            ]);

            Notification::make()
                ->title('Surat Berhasil Dibuat!')
                ->body("Surat {$surat->nomor_surat} telah disimpan di Arsip Surat.")
                ->success()
                ->send();

            $this->redirect(SuratResource::getUrl('index'));

        } catch (\RuntimeException $e) {
            Notification::make()
                ->title('Gagal Generate Surat')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function downloadPdf(): void
    {
        $this->generateSurat();
    }

    protected function getViewData(): array
    {
        return [
            'jenisSuratOptions' => JenisSurat::where('is_active', true)
                ->orderBy('nama')
                ->pluck('nama', 'id')
                ->toArray(),
            'riwayatSurat' => Surat::with('jenisSurat')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}
