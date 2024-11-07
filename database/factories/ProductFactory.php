<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Theme;
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
            'user_id' => User::value('id'),
            'country_id' => Country::value('id'),
            'region_id' => Region::value('id'),
            'city_id' => City::value('id'),
            'category_id' => Category::value('id'),
            'name' => $this->faker->name,
            'image' => $this->faker->imageUrl(640, 480, null , false, false, false, 'jpg'),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'weight' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
