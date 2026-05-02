<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'user_id' => rand(1, 3),
            'category_id' => rand(1, 5),
            'jobs_type_id' => rand(1, 5),
            'vacancy' => $this->faker->numberBetween(1, 10),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'company_name' => $this->faker->company(),
            'experience' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '10_plus']),
        ];
    }
}
