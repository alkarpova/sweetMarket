<?php

namespace Database\Seeders;

use App\Models\Allergen;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Region;
use App\Models\Theme;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Country::factory()->create([
            'name' => 'Latvia',
            'iso2' => 'LV',
        ]);

        Region::factory()->create([
            'name' => 'Rīga',
        ]);

        Region::factory()->create([
            'name' => 'Pierīga',
        ]);

        Region::factory()->create([
            'name' => 'Kurzeme',
        ]);

        Region::factory()->create([
            'name' => 'Latgale',
        ]);

        Region::factory()->create([
            'name' => 'Vidzeme',
        ]);

        Region::factory()->create([
            'name' => 'Zemgale',
        ]);

        City::factory()->create([
            'name' => 'Rīga',
        ]);

        Allergen::factory(10)->create();
        Ingredient::factory(10)->create();
        Theme::factory(10)->create();

        Category::factory()->create([
            'name' => 'Cakes',
        ]);

        Category::factory()->create([
            'name' => 'Cookies',
        ]);

        Category::factory()->create([
            'name' => 'Pies',
        ]);

        $items = Product::factory(10)->create();

        $items->each(function ($product) {
            $product->options()->saveMany(
                ProductOption::factory(3)->make()
            );
        });
    }
}
