<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat',
        'jenis_surat_id',
        'nama_pemohon',
        'data_json',
        'file_docx',
        'file_pdf',
        'file_dokumen',
    ];

    protected function casts(): array
    {
        return [
            'data_json' => 'array',
        ];
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}
