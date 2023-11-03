<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text,
            'number_of_points' => $this->faker->numberBetween(5,10),
            'number_of_keys' => $this->faker->numberBetween(1,2),
            'important' => $this->faker->boolean(),
            'date_deadline' => $this->faker->dateTimeBetween('now', '+10 days')->format('Y-m-d'),
            'time_deadline' => $this->faker->time('H:i')
        ];
    }
}
