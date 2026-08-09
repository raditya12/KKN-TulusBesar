<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_surat',
        'kode_surat',
        'deskripsi',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function templateSurat(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TemplateSurat::class, 'jenis_surat_id')->where('is_active', true);
    }

    public function templates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TemplateSurat::class, 'jenis_surat_id');
    }
}
