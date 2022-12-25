<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategories extends Model
{
    use HasFactory;

    protected $table = 'news_categories';

    protected $fillable = [
      'category', 'description'
    ];

    public function news()
    {
        return $this->hasMany(NewsCategories::class);
    }
}
