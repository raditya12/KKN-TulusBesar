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
        'file_paths',
        'requirement_image_path',
        'requirements_text',
    ];

    protected $casts = [
        'file_paths' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function getFileSizeAttribute()
    {
        $totalBytes = 0;
        
        if ($this->file_paths && is_array($this->file_paths)) {
            foreach ($this->file_paths as $path) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    $totalBytes += \Illuminate\Support\Facades\Storage::disk('public')->size($path);
                }
            }
        }
        
        if ($totalBytes > 0) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $pow = floor(($totalBytes ? log($totalBytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes = $totalBytes / pow(1024, $pow);
            $fileCount = is_array($this->file_paths) ? count($this->file_paths) : 0;
            return $fileCount . ' File' . ($fileCount > 1 ? 's' : '') . ' (' . round($bytes, 2) . ' ' . $units[$pow] . ')';
        }

        return '0 Files';
    }

    public function getFileExtensionAttribute()
    {
        if ($this->file_paths && is_array($this->file_paths) && count($this->file_paths) > 0) {
            if (count($this->file_paths) === 1) {
                return strtoupper(pathinfo($this->file_paths[0], PATHINFO_EXTENSION));
            }
            return 'MULTIPLE';
        }
        return 'UNKNOWN';
    }
}
