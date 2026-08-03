<?php

namespace App\Filament\Pages;

use App\Models\Pengaturan as PengaturanModel;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Pengaturan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    public ?string $nama_desa = null;

    public ?string $nama_kecamatan = null;

    public ?string $nama_kabupaten = null;

    public ?string $nama_provinsi = null;

    public ?string $kode_pos = null;

    public ?string $nomor_telepon = null;

    public ?string $alamat_kantor = null;

    public ?string $email_desa = null;

    public ?string $nama_kepala_desa = null;

    public ?string $nip_kepala_desa = null;

    public ?string $logo_path = null;

    public ?string $kop_surat_html = null;

    public function mount(): void
    {
        $settings = PengaturanModel::pluck('value', 'key')->toArray();

        foreach (array_keys($this->getAllSettings()) as $key) {
            $this->{$key} = $settings[$key] ?? null;
        }
    }

    public function save(): void
    {
        foreach ($this->getAllSettings() as $key => $label) {
            PengaturanModel::set($key, $this->{$key});
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }

    /**
     * @return array<string, string>
     */
    private function getAllSettings(): array
    {
        return [
            'nama_desa' => 'Nama Desa',
            'nama_kecamatan' => 'Nama Kecamatan',
            'nama_kabupaten' => 'Nama Kabupaten',
            'nama_provinsi' => 'Nama Provinsi',
            'kode_pos' => 'Kode Pos',
            'nomor_telepon' => 'Nomor Telepon',
            'alamat_kantor' => 'Alamat Kantor Desa',
            'email_desa' => 'Email Desa',
            'nama_kepala_desa' => 'Nama Kepala Desa',
            'nip_kepala_desa' => 'NIP Kepala Desa',
            'logo_path' => 'Logo Desa (path)',
            'kop_surat_html' => 'Kop Surat (HTML)',
        ];
    }
}
