<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat',
        'jenis_surat_id',
        'template_surat_id',
        'nama_warga',
        'nik',
        'data_surat',
        'konten_snapshot',
        'pdf_generated_path',
        'status',
        'tanggal_surat',
        'tanggal_terbit',
        'is_custom',
        'nama_surat_custom',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'data_surat' => 'array',
            'is_custom' => 'boolean',
            'tanggal_surat' => 'date',
            'tanggal_terbit' => 'date',
        ];
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(TemplateSurat::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scan(): HasOne
    {
        return $this->hasOne(SuratScan::class);
    }

    /**
     * Check whether all placeholders in the snapshot have been replaced.
     */
    public function hasPendingPlaceholders(): bool
    {
        return (bool) preg_match('/\{\{[a-z_]+\}\}/', $this->konten_snapshot ?? '');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'dicetak' => 'Sudah Dicetak',
            'scan_uploaded' => 'Sudah Upload Scan',
            default => $this->status,
        };
    }
}
