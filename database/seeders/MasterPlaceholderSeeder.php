<?php

namespace Database\Seeders;

use App\Models\MasterPlaceholder;
use Illuminate\Database\Seeder;

class MasterPlaceholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeholders = [
            // Kategori: Data Warga
            [
                'nama_field' => 'Nama Lengkap',
                'placeholder' => '{{nama}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Nama lengkap warga sesuai KTP.',
            ],
            [
                'nama_field' => 'NIK',
                'placeholder' => '{{nik}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Nomor Induk Kependudukan (16 digit).',
            ],
            [
                'nama_field' => 'Alamat',
                'placeholder' => '{{alamat}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Alamat lengkap warga.',
            ],
            [
                'nama_field' => 'Tempat Lahir',
                'placeholder' => '{{tempat_lahir}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Tempat lahir warga.',
            ],
            [
                'nama_field' => 'Tanggal Lahir',
                'placeholder' => '{{tanggal_lahir}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Tanggal lahir warga (format: DD Bulan YYYY).',
            ],
            [
                'nama_field' => 'Jenis Kelamin',
                'placeholder' => '{{jenis_kelamin}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Jenis kelamin warga (Laki-laki / Perempuan).',
            ],
            [
                'nama_field' => 'Agama',
                'placeholder' => '{{agama}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Agama yang dianut warga.',
            ],
            [
                'nama_field' => 'Pekerjaan',
                'placeholder' => '{{pekerjaan}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Pekerjaan atau profesi warga.',
            ],
            [
                'nama_field' => 'Status Perkawinan',
                'placeholder' => '{{status_perkawinan}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Status perkawinan warga (Belum Kawin / Kawin / Cerai).',
            ],
            [
                'nama_field' => 'Kewarganegaraan',
                'placeholder' => '{{kewarganegaraan}}',
                'kategori' => 'Data Warga',
                'deskripsi' => 'Kewarganegaraan warga, default: WNI.',
            ],

            // Kategori: Data Surat
            [
                'nama_field' => 'Nomor Surat',
                'placeholder' => '{{nomor_surat}}',
                'kategori' => 'Data Surat',
                'deskripsi' => 'Nomor surat yang diinput operator.',
            ],
            [
                'nama_field' => 'Tanggal Surat',
                'placeholder' => '{{tanggal_surat}}',
                'kategori' => 'Data Surat',
                'deskripsi' => 'Tanggal penerbitan surat (format: DD Bulan YYYY).',
            ],
            [
                'nama_field' => 'Keperluan',
                'placeholder' => '{{keperluan}}',
                'kategori' => 'Data Surat',
                'deskripsi' => 'Keperluan atau tujuan penerbitan surat.',
            ],
            [
                'nama_field' => 'Perihal',
                'placeholder' => '{{perihal}}',
                'kategori' => 'Data Surat',
                'deskripsi' => 'Perihal / subjek surat.',
            ],

            // Kategori: Data Orang Tua
            [
                'nama_field' => 'Nama Ayah',
                'placeholder' => '{{nama_ayah}}',
                'kategori' => 'Data Orang Tua',
                'deskripsi' => 'Nama lengkap ayah warga.',
            ],
            [
                'nama_field' => 'Nama Ibu',
                'placeholder' => '{{nama_ibu}}',
                'kategori' => 'Data Orang Tua',
                'deskripsi' => 'Nama lengkap ibu warga.',
            ],
            [
                'nama_field' => 'Pekerjaan Ayah',
                'placeholder' => '{{pekerjaan_ayah}}',
                'kategori' => 'Data Orang Tua',
                'deskripsi' => 'Pekerjaan/profesi ayah warga.',
            ],
            [
                'nama_field' => 'Penghasilan',
                'placeholder' => '{{penghasilan}}',
                'kategori' => 'Data Orang Tua',
                'deskripsi' => 'Penghasilan per bulan (ditulis dalam format angka atau terbilang).',
            ],

            // Kategori: Data Usaha
            [
                'nama_field' => 'Nama Usaha',
                'placeholder' => '{{nama_usaha}}',
                'kategori' => 'Data Usaha',
                'deskripsi' => 'Nama usaha atau toko.',
            ],
            [
                'nama_field' => 'Jenis Usaha',
                'placeholder' => '{{jenis_usaha}}',
                'kategori' => 'Data Usaha',
                'deskripsi' => 'Jenis atau bidang usaha.',
            ],
            [
                'nama_field' => 'Alamat Usaha',
                'placeholder' => '{{alamat_usaha}}',
                'kategori' => 'Data Usaha',
                'deskripsi' => 'Alamat lokasi usaha.',
            ],

            // Kategori: Kelahiran & Kematian
            [
                'nama_field' => 'Nama Bayi',
                'placeholder' => '{{nama_bayi}}',
                'kategori' => 'Kelahiran & Kematian',
                'deskripsi' => 'Nama bayi yang baru lahir.',
            ],
            [
                'nama_field' => 'Tanggal Lahir Bayi',
                'placeholder' => '{{tanggal_lahir_bayi}}',
                'kategori' => 'Kelahiran & Kematian',
                'deskripsi' => 'Tanggal lahir bayi.',
            ],
            [
                'nama_field' => 'Nama Almarhum',
                'placeholder' => '{{nama_almarhum}}',
                'kategori' => 'Kelahiran & Kematian',
                'deskripsi' => 'Nama warga yang meninggal dunia.',
            ],
            [
                'nama_field' => 'Tanggal Meninggal',
                'placeholder' => '{{tanggal_meninggal}}',
                'kategori' => 'Kelahiran & Kematian',
                'deskripsi' => 'Tanggal meninggalnya warga.',
            ],

            // Kategori: Kehilangan & Beda Nama
            [
                'nama_field' => 'Barang Hilang',
                'placeholder' => '{{barang_hilang}}',
                'kategori' => 'Kehilangan',
                'deskripsi' => 'Deskripsi barang atau dokumen yang hilang.',
            ],
            [
                'nama_field' => 'Nama di Dokumen Lain',
                'placeholder' => '{{nama_dokumen_lain}}',
                'kategori' => 'Beda Nama',
                'deskripsi' => 'Nama yang tertulis pada dokumen lain (berbeda dengan KTP).',
            ],
            [
                'nama_field' => 'Jenis Dokumen',
                'placeholder' => '{{jenis_dokumen}}',
                'kategori' => 'Beda Nama',
                'deskripsi' => 'Jenis dokumen yang memiliki perbedaan nama (misal: Ijazah, Akta Kelahiran).',
            ],

            // Kategori: Tanda Tangan
            [
                'nama_field' => 'Nama Kepala Desa',
                'placeholder' => '{{nama_kepala_desa}}',
                'kategori' => 'Tanda Tangan',
                'deskripsi' => 'Nama lengkap kepala desa.',
            ],
            [
                'nama_field' => 'NIP Kepala Desa',
                'placeholder' => '{{nip_kepala_desa}}',
                'kategori' => 'Tanda Tangan',
                'deskripsi' => 'NIP kepala desa (kosongkan jika tidak ada).',
            ],
        ];

        foreach ($placeholders as $data) {
            MasterPlaceholder::firstOrCreate(
                ['placeholder' => $data['placeholder']],
                $data
            );
        }
    }
}
