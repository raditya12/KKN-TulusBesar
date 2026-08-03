<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        $sku = JenisSurat::where('kode', 'sku')->first();

        if ($sku) {
            TemplateSurat::updateOrCreate(
                ['jenis_surat_id' => $sku->id],
                [
                    'judul' => 'Template Surat Keterangan Usaha (SKU)',
                    'konten_html' => <<<'HTML'
<div style="text-align: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 3px double #000;">
    <p style="font-weight: bold; font-size: 13pt; text-transform: uppercase; margin: 0; line-height: 1.2;">
        PEMERINTAH KABUPATEN MALANG
    </p>
    <p style="font-weight: bold; font-size: 12pt; text-transform: uppercase; margin: 2px 0; line-height: 1.2;">
        KECAMATAN TUMPANG
    </p>
    <p style="font-weight: bold; font-size: 15pt; text-transform: uppercase; margin: 0; line-height: 1.2;">
        DESA TULUS BESAR
    </p>
</div>

<div style="text-align: center; margin: 20px 0 16px;">
    <p style="font-weight: bold; font-size: 13pt; text-decoration: underline; text-transform: uppercase; margin: 0;">
        SURAT KETERANGAN USAHA
    </p>
    <p style="font-size: 10.5pt; margin: 4px 0 0;">
        Nomor: {{nomor_surat}}
    </p>
</div>

<div style="margin-bottom: 16px; text-align: justify;">
    <p>
        Yang bertanda tangan di bawah ini, Kepala Desa Tulus Besar, Kecamatan Tumpang, Kabupaten Malang, dengan ini menerangkan bahwa:
    </p>
</div>

<table style="margin: 12px 0 16px 20px; width: 95%;">
    <tr>
        <td style="width: 170px;">Nama Lengkap</td>
        <td style="width: 15px;">:</td>
        <td><strong>{{nama}}</strong></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{nik}}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{tempat_tanggal_lahir}}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{jenis_kelamin}}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{agama}}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{pekerjaan}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{alamat}}</td>
    </tr>
</table>

<p style="text-align: justify; margin-bottom: 12px;">
    Berdasarkan surat pengantar dari RT/RW setempat serta sepengetahuan kami, nama tersebut di atas memang benar penduduk yang berdomisili di Desa Tulus Besar, dan pada saat ini benar-benar memiliki usaha berupa:
</p>

<div style="background: #f3f4f6; border: 1px solid #e5e7eb; padding: 10px; text-align: center; font-weight: bold; margin: 12px 0 16px; border-radius: 4px; text-transform: uppercase;">
    {{keperluan}}
</div>

<p style="text-align: justify; margin-bottom: 24px;">
    Demikian Surat Keterangan Usaha ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya. Kepada pihak yang berkepentingan diharap maklum.
</p>

<div style="float: right; text-align: center; width: 240px; margin-top: 20px;">
    <p style="margin: 0;">Tulus Besar, {{tanggal_surat}}</p>
    <p style="margin: 2px 0 60px;">Kepala Desa Tulus Besar</p>
    <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{nama_kepala_desa}}</p>
    <p style="font-size: 10pt; margin: 2px 0;">NIP. {{nip_kepala_desa}}</p>
</div>
<div style="clear: both;"></div>
HTML,
                    'is_active' => true,
                ]
            );
        }
    }
}
