<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'nama_desa',
                'value' => 'Tulusbesar',
                'label' => 'Nama Desa',
            ],
            [
                'key' => 'nama_kecamatan',
                'value' => 'Tumpang',
                'label' => 'Nama Kecamatan',
            ],
            [
                'key' => 'nama_kabupaten',
                'value' => 'Malang',
                'label' => 'Nama Kabupaten',
            ],
            [
                'key' => 'nama_provinsi',
                'value' => 'Jawa Timur',
                'label' => 'Nama Provinsi',
            ],
            [
                'key' => 'kode_pos',
                'value' => '',
                'label' => 'Kode Pos',
            ],
            [
                'key' => 'nomor_telepon',
                'value' => '',
                'label' => 'Nomor Telepon Kantor Desa',
            ],
            [
                'key' => 'alamat_kantor',
                'value' => '',
                'label' => 'Alamat Kantor Desa',
            ],
            [
                'key' => 'email_desa',
                'value' => '',
                'label' => 'Email Desa',
            ],
            [
                'key' => 'nama_kepala_desa',
                'value' => '',
                'label' => 'Nama Kepala Desa',
            ],
            [
                'key' => 'nip_kepala_desa',
                'value' => '',
                'label' => 'NIP Kepala Desa',
            ],
            [
                'key' => 'logo_path',
                'value' => '',
                'label' => 'Logo Desa (path file)',
            ],
            [
                'key' => 'kop_surat_html',
                'value' => '',
                'label' => 'Kop Surat (HTML)',
            ],
        ];

        foreach ($settings as $setting) {
            Pengaturan::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
