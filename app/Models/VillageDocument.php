<?php

namespace App\Models;

use Database\Factories\VillageDocumentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageDocument extends Model
{
    /** @use HasFactory<VillageDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
    ];
}
