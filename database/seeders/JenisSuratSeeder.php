<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surats = [
            ['nama_surat' => 'Surat Keterangan domisli', 'kode_surat' => 'SK-DOMISILI'],
            ['nama_surat' => 'SK domisli usaha', 'kode_surat' => 'SK-DOMISILI-USAHA'],
            ['nama_surat' => 'SK tidak mampu sekolah', 'kode_surat' => 'SK-TM-SEKOLAH'],
            ['nama_surat' => 'SK tidak mampu masyarakat', 'kode_surat' => 'SK-TM-MASYARAKAT'],
            ['nama_surat' => 'SK Penghasilan orang tua', 'kode_surat' => 'SK-PENGHASILAN-ORTU'],
            ['nama_surat' => 'SK kehilangan', 'kode_surat' => 'SK-KEHILANGAN'],
            ['nama_surat' => 'SK Pernyataan belum menikah', 'kode_surat' => 'SK-BLM-MENIKAH'],
            ['nama_surat' => 'Surat beda nama', 'kode_surat' => 'SURAT-BEDA-NAMA'],
            ['nama_surat' => 'Surat Kelahiran', 'kode_surat' => 'SURAT-KELAHIRAN'],
            ['nama_surat' => 'Surat Kematian', 'kode_surat' => 'SURAT-KEMATIAN'],
            ['nama_surat' => 'Surat Boro kerja', 'kode_surat' => 'SURAT-BORO-KERJA'],
        ];

        foreach ($surats as $surat) {
            JenisSurat::updateOrCreate(
                ['kode_surat' => $surat['kode_surat']],
                ['nama_surat' => $surat['nama_surat'], 'is_active' => true]
            );
        }
    }
}
