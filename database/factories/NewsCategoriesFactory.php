<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\NewsCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsCategories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category'         => $this->faker->randomElement(['Politik', 'Pendidikan', 'Olahraga', 'Hobi']),
            'description'       => $this->faker->paragraph(4,true),
        ];
    }
}
