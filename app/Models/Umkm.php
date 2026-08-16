<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $guarded = [];
    protected $appends = ['images'];

    public function getImagesAttribute()
    {
        $val = $this->attributes['image_path'] ?? null;
        if (empty($val)) return [];
        $decoded = json_decode($val, true);
        return is_array($decoded) ? $decoded : [$val];
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['image_path'] = is_array($value) ? json_encode(array_values($value)) : null;
    }

    public function getImagePathAttribute($value)
    {
        if (empty($value)) return null;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? ($decoded[0] ?? null) : $value;
    }
}
