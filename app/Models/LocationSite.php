<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationSite extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'location_category_id',
        'latitude',
        'longitude',
        'image_path',
        'gallery',
        'status',
        'qr_code',
        'qr_visits',
        'whatsapp_number',
    ];

    protected $casts = [
        'gallery' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'qr_visits' => 'integer',
    ];

    public function locationCategory()
    {
        return $this->belongsTo(LocationCategory::class);
    }

    public function getShortUrlAttribute(): string
    {
        return $this->qr_code ? url('/qr/'.$this->qr_code) : '';
    }
}
