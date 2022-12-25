<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function newsList()
    {
        $news = News::with('news_categories')->get();

        return $this->success('get news data successfull', $news);
    }
}
