<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateSurat extends Model
{
    protected $table = 'template_surat';

    protected $fillable = [
        'jenis_surat_id',
        'file_docx',
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

    protected static function booted(): void
    {
        static::creating(function (TemplateSurat $template) {
            if ($template->is_active) {
                static::where('jenis_surat_id', $template->jenis_surat_id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
        });

        static::updating(function (TemplateSurat $template) {
            if ($template->isDirty('is_active') && $template->is_active) {
                static::where('jenis_surat_id', $template->jenis_surat_id)
                    ->where('id', '!=', $template->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
