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
        $jenisSurat = [
            [
                'nama' => 'Surat Keterangan Domisili',
                'kode' => 'skd',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa seseorang berdomisili di suatu wilayah desa.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'kode' => 'sku',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa warga memiliki usaha di wilayah desa.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Domisili Usaha',
                'kode' => 'skdu',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa suatu usaha berdomisili di wilayah desa.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Tidak Mampu Sekolah',
                'kode' => 'sktm_sekolah',
                'deskripsi' => 'Surat keterangan tidak mampu yang diperuntukkan bagi keperluan sekolah/pendidikan.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Tidak Mampu Masyarakat',
                'kode' => 'sktm_masyarakat',
                'deskripsi' => 'Surat keterangan tidak mampu untuk keperluan umum masyarakat.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Penghasilan Orang Tua',
                'kode' => 'skpot',
                'deskripsi' => 'Surat keterangan yang menyatakan penghasilan orang tua warga.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Keterangan Kehilangan',
                'kode' => 'skk',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa warga kehilangan suatu barang atau dokumen.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Pernyataan Belum Menikah',
                'kode' => 'spbm',
                'deskripsi' => 'Surat pernyataan yang menyatakan bahwa seseorang belum menikah.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Beda Nama',
                'kode' => 'sbn',
                'deskripsi' => 'Surat keterangan yang menerangkan perbedaan nama pada dokumen kependudukan.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Kelahiran',
                'kode' => 'sk_lahir',
                'deskripsi' => 'Surat keterangan kelahiran warga desa.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Kematian',
                'kode' => 'sk_mati',
                'deskripsi' => 'Surat keterangan kematian warga desa.',
                'is_system' => true,
                'is_active' => true,
            ],
            [
                'nama' => 'Surat Boro Kerja',
                'kode' => 'sbk',
                'deskripsi' => 'Surat keterangan yang digunakan warga untuk mencari pekerjaan di luar daerah.',
                'is_system' => true,
                'is_active' => true,
            ],
        ];

        foreach ($jenisSurat as $data) {
            JenisSurat::firstOrCreate(
                ['kode' => $data['kode']],
                $data
            );
        }
    }
}
