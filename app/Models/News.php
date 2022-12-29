<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    const IMAGE_PATH = 'images/news/';
    protected $table = 'news';

    protected $fillable = [
      'news_category_id', 'title', 'slug', 'popular_counts',
      'date_text', 'image', 'author_by', 'post_by', 'description'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        $status = Storage::disk('local')->exists(self::IMAGE_PATH . $this->image);
        if ($status && $this->image) {
            return asset('storage/'.self::IMAGE_PATH . $this->image);
        } else {
            return null;
        }
    }

    public function news_categories()
    {
        return $this->belongsTo(NewsCategories::class, 'news_category_id');
    }
}
