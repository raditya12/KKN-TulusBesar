<?php

namespace App\Models;

use Database\Factories\CulturalSiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalSite extends Model
{
    /** @use HasFactory<CulturalSiteFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'latitude',
        'longitude',
        'image_path',
        'status',
    ];
}
