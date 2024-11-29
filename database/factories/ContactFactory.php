<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'topic' => $this->faker->randomElement(\App\Enums\ContactTopic::cases())->value,
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'comment' => $this->faker->sentence,
        ];
    }
}
