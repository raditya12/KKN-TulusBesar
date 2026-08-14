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
        'document_category_id',
        'description',
        'file_path',
        'requirement_image_path',
        'requirements_text',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function getFileSizeAttribute()
    {
        if ($this->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->file_path)) {
            $bytes = \Illuminate\Support\Facades\Storage::disk('public')->size($this->file_path);
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, 2) . ' ' . $units[$pow];
        }
        return 'Unknown Size';
    }

    public function getFileExtensionAttribute()
    {
        if ($this->file_path) {
            return strtoupper(pathinfo($this->file_path, PATHINFO_EXTENSION));
        }
        return 'UNKNOWN';
    }
}
