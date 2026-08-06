<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Template SKTM Sekolah ─────────────────────────────────────────────────
        $sktmSekolah = JenisSurat::where('kode', 'sktm_sekolah')->first();

        if ($sktmSekolah) {
            TemplateSurat::updateOrCreate(
                ['jenis_surat_id' => $sktmSekolah->id],
                [
                    'judul'      => 'Template Surat Keterangan Tidak Mampu (Sekolah)',
                    'is_active'  => true,
                    'konten_html' => <<<'HTML'
<div style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000;">

  <!-- KOP SURAT -->
  <table style="width: 100%; border-bottom: 3px double #000; margin-bottom: 10px; padding-bottom: 8px;">
    <tr>
      <td style="width: 90px; vertical-align: middle; text-align: center;">
        <img src="/images/logo-malang.png" alt="Logo Kabupaten Malang"
             style="width: 80px; height: 80px; object-fit: contain;" />
      </td>
      <td style="vertical-align: middle; text-align: center; line-height: 1.3;">
        <p style="font-size: 12pt; font-weight: normal; margin: 0;">PEMERINTAH KABUPATEN MALANG</p>
        <p style="font-size: 12pt; font-weight: normal; margin: 0;">KECAMATAN TUMPANG</p>
        <p style="font-size: 16pt; font-weight: bold; margin: 2px 0;">DESA TULUSBESAR</p>
        <p style="font-size: 9pt; margin: 0;">Jalan Raya Tulusbesar No. 012 RT.04 RW.01, Kabupaten Malang, Jawa Timur</p>
        <p style="font-size: 9pt; margin: 0;">Telpon 0813-3311-4564 Laman : malangtulusbesar.desa.kemendesa.go.id</p>
        <p style="font-size: 9pt; margin: 0; text-decoration: underline;">Pos-el: email:pemdes.tulusbesar2018@gmail.com, Kode Pos : 65156</p>
      </td>
    </tr>
  </table>

  <!-- JUDUL SURAT -->
  <p style="text-align: center; font-weight: bold; font-size: 13pt; text-decoration: underline; text-transform: uppercase; margin: 14px 0 4px;">
    SURAT KETERANGAN TIDAK MAMPU
  </p>
  <p style="text-align: center; font-size: 11pt; margin: 0 0 14px;">
    Nomor : {{nomor_surat}}
  </p>

  <!-- PEMBUKA -->
  <p style="text-align: justify; margin: 0 0 16px; text-indent: 40px;">
    Yang bertanda tangan di bawah ini, Kepala Desa Tulusbesar Kecamatan Tumpang Kabupaten Malang menerangkan dengan sebenarnya bahwa :
  </p>

  <!-- DATA PEMOHON -->
  <table style="width: 100%; margin: 0 0 14px 20px; border-collapse: collapse;">
    <tr>
      <td style="width: 160px; padding: 2px 0; vertical-align: top;">Nama</td>
      <td style="width: 20px; padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;"><strong>{{nama}}</strong></td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">NIK</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{nik}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Jenis Kelamin</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{jenis_kelamin}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Tempat, tgl. lahir</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{tempat_tanggal_lahir}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Agama</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{agama}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Status Perkawinan</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{status_perkawinan}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Pekerjaan</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{pekerjaan}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Alamat</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{alamat}}</td>
    </tr>
  </table>

  <!-- ISI / KETERANGAN -->
  <p style="text-align: justify; margin: 0 0 12px; text-indent: 40px;">
    Bahwa orang tersebut di atas adalah penduduk Desa Tulusbesar Kecamatan Tumpang Kabupaten Malang <em>termasuk dalam kategori tidak mampu.</em>
  </p>

  <p style="text-align: justify; margin: 0 0 16px; text-indent: 40px;">
    Surat Keterangan ini dibuat untuk <em><strong>kelengkapan pengajuan {{keperluan}}</strong></em> :
  </p>

  <!-- DATA ANAK / SISWA -->
  <table style="width: 100%; margin: 0 0 14px 20px; border-collapse: collapse;">
    <tr>
      <td style="width: 160px; padding: 2px 0; vertical-align: top;">Nama</td>
      <td style="width: 20px; padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;"><strong>{{nama_anak}}</strong></td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">NIK</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{nik_anak}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Sekolah</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;"><strong>{{nama_sekolah}}</strong></td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Kelas</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;"><strong>{{kelas_anak}}</strong></td>
    </tr>
  </table>

  <!-- PENUTUP -->
  <p style="text-align: justify; margin: 0 0 30px; text-indent: 40px;">
    Demikian surat keterangan ini dibuat untuk dapatnya dipergunakan sebagaimana mestinya.
  </p>

  <!-- TANDA TANGAN -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="width: 50%; vertical-align: top; padding-top: 0;">
        <p style="margin: 0;">Pemohon</p>
        <br /><br /><br /><br />
        <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{nama}}</p>
      </td>
      <td style="width: 50%; vertical-align: top; text-align: center;">
        <p style="margin: 0;">Tulusbesar, {{tanggal_surat}}</p>
        <p style="margin: 2px 0 0;"><strong>KEPALA DESA TULUSBESAR</strong></p>
        <br /><br /><br /><br />
        <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{nama_kepala_desa}}</p>
      </td>
    </tr>
  </table>

</div>
HTML,
                ]
            );
        }

        // ─── Template SKU ──────────────────────────────────────────────────────────
        $sku = JenisSurat::where('kode', 'sku')->first();

        if ($sku) {
            TemplateSurat::updateOrCreate(
                ['jenis_surat_id' => $sku->id],
                [
                    'judul'      => 'Template Surat Keterangan Usaha (SKU)',
                    'is_active'  => true,
                    'konten_html' => <<<'HTML'
<div style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000;">

  <!-- KOP SURAT -->
  <table style="width: 100%; border-bottom: 3px double #000; margin-bottom: 10px; padding-bottom: 8px;">
    <tr>
      <td style="width: 90px; vertical-align: middle; text-align: center;">
        <img src="/images/logo-malang.png" alt="Logo Kabupaten Malang"
             style="width: 80px; height: 80px; object-fit: contain;" />
      </td>
      <td style="vertical-align: middle; text-align: center; line-height: 1.3;">
        <p style="font-size: 12pt; font-weight: normal; margin: 0;">PEMERINTAH KABUPATEN MALANG</p>
        <p style="font-size: 12pt; font-weight: normal; margin: 0;">KECAMATAN TUMPANG</p>
        <p style="font-size: 16pt; font-weight: bold; margin: 2px 0;">DESA TULUSBESAR</p>
        <p style="font-size: 9pt; margin: 0;">Jalan Raya Tulusbesar No. 012 RT.04 RW.01, Kabupaten Malang, Jawa Timur</p>
        <p style="font-size: 9pt; margin: 0;">Telpon 0813-3311-4564 Laman : malangtulusbesar.desa.kemendesa.go.id</p>
        <p style="font-size: 9pt; margin: 0; text-decoration: underline;">Pos-el: email:pemdes.tulusbesar2018@gmail.com, Kode Pos : 65156</p>
      </td>
    </tr>
  </table>

  <!-- JUDUL SURAT -->
  <p style="text-align: center; font-weight: bold; font-size: 13pt; text-decoration: underline; text-transform: uppercase; margin: 14px 0 4px;">
    SURAT KETERANGAN USAHA
  </p>
  <p style="text-align: center; font-size: 11pt; margin: 0 0 14px;">
    Nomor : {{nomor_surat}}
  </p>

  <!-- PEMBUKA -->
  <p style="text-align: justify; margin: 0 0 16px; text-indent: 40px;">
    Yang bertanda tangan di bawah ini, Kepala Desa Tulusbesar, Kecamatan Tumpang, Kabupaten Malang, dengan ini menerangkan bahwa:
  </p>

  <!-- DATA PEMOHON -->
  <table style="width: 100%; margin: 0 0 14px 20px; border-collapse: collapse;">
    <tr>
      <td style="width: 160px; padding: 2px 0; vertical-align: top;">Nama Lengkap</td>
      <td style="width: 20px; padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;"><strong>{{nama}}</strong></td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">NIK</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{nik}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Tempat/Tgl Lahir</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{tempat_tanggal_lahir}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Jenis Kelamin</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{jenis_kelamin}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Agama</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{agama}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Pekerjaan</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{pekerjaan}}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; vertical-align: top;">Alamat</td>
      <td style="padding: 2px 0; vertical-align: top; text-align: center;">:</td>
      <td style="padding: 2px 0; vertical-align: top;">{{alamat}}</td>
    </tr>
  </table>

  <!-- ISI -->
  <p style="text-align: justify; margin: 0 0 12px; text-indent: 40px;">
    Berdasarkan surat pengantar dari RT/RW setempat serta sepengetahuan kami, nama tersebut di atas memang benar penduduk yang berdomisili di Desa Tulusbesar, dan pada saat ini benar-benar memiliki usaha berupa:
  </p>

  <p style="text-align: center; font-weight: bold; margin: 8px 0 12px; text-transform: uppercase;">
    {{keperluan}}
  </p>

  <!-- PENUTUP -->
  <p style="text-align: justify; margin: 0 0 30px; text-indent: 40px;">
    Demikian Surat Keterangan Usaha ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya. Kepada pihak yang berkepentingan diharap maklum.
  </p>

  <!-- TANDA TANGAN -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="width: 50%; vertical-align: top;"></td>
      <td style="width: 50%; vertical-align: top; text-align: center;">
        <p style="margin: 0;">Tulusbesar, {{tanggal_surat}}</p>
        <p style="margin: 2px 0 0;">Kepala Desa Tulusbesar</p>
        <br /><br /><br /><br />
        <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{nama_kepala_desa}}</p>
        <p style="font-size: 10pt; margin: 2px 0;">NIP. {{nip_kepala_desa}}</p>
      </td>
    </tr>
  </table>

</div>
HTML,
                ]
            );
        }
    }
}
