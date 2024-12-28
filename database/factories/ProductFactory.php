<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create()->id,
            'country_id' => fn () => Country::factory()->create()->id,
            'region_id' => fn () => Region::factory()->create()->id,
            'city_id' => fn () => City::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'name' => $this->faker->sentence,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'weight' => $this->faker->randomFloat(2, 0, 100),
            'quantity' => 10,
            'minimum' => 1,
            'status' => $this->faker->randomElement(ProductStatus::cases())->value,
        ];
    }
}
