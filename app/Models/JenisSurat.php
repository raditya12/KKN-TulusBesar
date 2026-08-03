<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'is_system',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function templateSurat(): HasMany
    {
        return $this->hasMany(TemplateSurat::class);
    }

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    /**
     * Get the currently active template for this jenis surat.
     */
    public function templateAktif(): ?TemplateSurat
    {
        return $this->templateSurat()->where('is_active', true)->latest()->first();
    }
}
