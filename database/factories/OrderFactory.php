<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'number' => $this->faker->uuid,
            'shipping_address' => $this->faker->address,
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'notes' => $this->faker->text,
            'status' => $this->faker->randomElement(OrderStatus::cases())->value,
        ];
    }
}
