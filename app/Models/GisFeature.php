<?php

namespace App\Models;

use Database\Factories\GisFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GisFeature extends Model
{
    /** @use HasFactory<GisFeatureFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'category',
        'description',
        'latitude',
        'longitude',
    ];
}
