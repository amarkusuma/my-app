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

    public function slideNewsList()
    {
        $slide = News::with('news_categories')->where('slide', true)->get();

        return $this->success('get slide news data successfull', $slide);
    }
}
