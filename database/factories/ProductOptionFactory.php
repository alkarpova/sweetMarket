<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOption>
 */
class ProductOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::value('id'),
            'name' => $this->faker->unique()->name,
            'price' => $this->faker->randomFloat(2, 0, 10),
            'quantity' => $this->faker->numberBetween(0, 100),
            'is_required' => $this->faker->boolean,
        ];
    }
}
