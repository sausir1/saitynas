<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Goal as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
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
            "name" => $this->faker->word(),
            "goal" => $this->faker->numberBetween(15, 255),
            "until" => $this->faker->dateTime(),
            "progress" => $this->faker->numberBetween(0, 100),
            "user_id" => User::factory()
        ];
    }
}
