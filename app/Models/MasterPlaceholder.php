<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPlaceholder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_placeholders';

    protected $fillable = [
        'nama_field',
        'placeholder',
        'kategori',
        'deskripsi',
    ];

    /**
     * Return the placeholder key (without braces) for matching.
     * e.g. "{{nama}}" → "nama"
     */
    public function getKeyAttribute(): string
    {
        return trim(str_replace(['{{', '}}'], '', $this->placeholder));
    }
}
