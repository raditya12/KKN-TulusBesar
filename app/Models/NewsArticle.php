<?php

namespace App\Models;

use Database\Factories\NewsArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    /** @use HasFactory<NewsArticleFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'video_link',
        'image_path',
        'images',
        'published_at',
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
