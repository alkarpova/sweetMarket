<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allergen>
 */
class AllergenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->sentence,
            'severity_level' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->boolean,
        ];
    }
}
