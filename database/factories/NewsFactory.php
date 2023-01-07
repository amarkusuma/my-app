<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $this->faker->create('id_ID');
        $slug = $this->faker->words(2, true);
        $category = NewsCategories::get();

        return [
            'news_category_id' => $this->faker->randomElement(collect($category)->pluck('id')),
            'title'      => $this->faker->sentence(2,true),
            'slug'      => Str::slug($slug),
            'description'       => $this->faker->paragraph(4,true),
            'popular_counts' => $this->faker->numberBetween(10, 100),
            'date_text' => $this->faker->randomElement(['14 Des 2021 20:09', '20 Nov 2022 11.30', '11 Jan 2022 12.11']),
            'author_by' => $this->faker->name(),
            'post_by'  =>  $this->faker->name(),
        ];
    }
}
