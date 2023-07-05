<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->stateAbbr(),
            'name' => fake()->jobTitle(),
            'description' => fake()->sentence(),

            // 'code' => $this->faker->stateAbbr(),
            // 'name' => $this->faker->jobTitle(),
            // 'description' => $this->faker->sentence(),
        ];
    }
}
