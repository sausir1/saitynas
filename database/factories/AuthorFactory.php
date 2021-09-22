<?php

namespace Database\Factories;

use App\Models\Author as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
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
            "name" => $this->faker->name(),
            "surname" => $this->faker->lastName(),
            "age" => $this->faker->randomNumber(2),
            "nationality" => $this->faker->country(),
            "website" => $this->faker->url(),
            "about" => $this->faker->paragraph(2)
        ];
    }
}
