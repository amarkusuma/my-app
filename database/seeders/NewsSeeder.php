<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategories;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewsCategories::factory(25)->create();
        News::factory(25)->create();
    }
}
