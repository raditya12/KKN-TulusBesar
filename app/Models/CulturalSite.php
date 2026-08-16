<?php

namespace App\Models;

use Database\Factories\CulturalSiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalSite extends Model
{
    /** @use HasFactory<CulturalSiteFactory> */
    use HasFactory;



    protected $fillable = [
        'name',
        'category',
        'slug',
        'description',
        'latitude',
        'longitude',
        'image_path',
        'images',
    ];
    
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
