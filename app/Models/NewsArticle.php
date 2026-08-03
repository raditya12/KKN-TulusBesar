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

    protected $fillable = [
        'title',
        'slug',
        'content',
        'video_link',
        'image_path',
        'published_at',
    ];
}
