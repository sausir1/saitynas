<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book as Model;
use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(3),
            "about" => $this->faker->paragraph(3),
            "slug" => $this->faker->slug(3),
            "price" => $this->faker->randomFloat(null, 1, 200),
            "pages" => $this->faker->numberBetween(15, 600),
            "author_id" => Author::factory(),
            "category_id" => Category::factory()
        ];
    }
}
