<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
    ];

    public function locationSites()
    {
        return $this->hasMany(LocationSite::class);
    }
}
