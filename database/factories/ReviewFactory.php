<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::value('id'),
            'order_item_id' => \App\Models\OrderItem::value('id'),
            'full_name' => $this->faker->name,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text,
            'status' => $this->faker->boolean,
        ];
    }
}
