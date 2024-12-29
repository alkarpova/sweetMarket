<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Ingredient;
use App\Models\Product;
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
        Country::factory()->create([
            'name' => 'Latvia',
            'iso2' => 'LV',
            'status' => true,
        ]);

        $regionKurzeme = Region::factory()->create([
            'name' => 'Kurzeme',
            'status' => true,
        ]);

        $regionLatgale = Region::factory()->create([
            'name' => 'Latgale',
            'status' => true,
        ]);

        $regionVidzeme = Region::factory()->create([
            'name' => 'Vidzeme',
            'status' => true,
        ]);

        $regionZemgale = Region::factory()->create([
            'name' => 'Zemgale',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionVidzeme->id,
            'name' => 'Rīga',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionVidzeme->id,
            'name' => 'Jūrmala',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionVidzeme->id,
            'name' => 'Sigulda',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionVidzeme->id,
            'name' => 'Ogre',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionVidzeme->id,
            'name' => 'Valmiera',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionKurzeme->id,
            'name' => 'Liepāja',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionKurzeme->id,
            'name' => 'Ventspils',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionKurzeme->id,
            'name' => 'Tukums',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionZemgale->id,
            'name' => 'Jelgava',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionZemgale->id,
            'name' => 'Bauska',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionLatgale->id,
            'name' => 'Daugavpils',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionLatgale->id,
            'name' => 'Rēzekne',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionLatgale->id,
            'name' => 'Preiļi',
            'status' => true,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => \App\Enums\UserRole::Admin,
        ]);

        $categoryMap = [
            'Cakes',
            'Bento Cakes',
            'Pies',
            'Hand Pies',
            'Cupcakes',
            'Patties',
            'Kringles',
            'Roll Cakes',
            'Eclairs',
            'Eastern Delicacies',
            'Other',
        ];

        $categories = collect();
        foreach ($categoryMap as $categoryName) {
            $cat = Category::factory()->create([
                'name' => $categoryName,
                'status' => true,
            ]);

            $categories->push($cat);
        }

        $themeMap = [
            'For Children',
            'Birthday',
            'Wedding',
            'Christmas',
            'Easter',
        ];

        $themes = collect();
        foreach ($themeMap as $themeName) {
            $theme = Theme::factory()->create([
                'name' => $themeName,
                'status' => true,
            ]);

            $themes->push($theme);
        }

        $ingredientMap = [
            'Chocolate',
            'Blueberries',
            'Strawberries',
            'Honey',
            'Cottage Cheese',
            'Apples',
            'Oranges',
            'Cherries',
            'Custard',
            'Raspberries',
            'Banana',
            'Nuts',
            'Cinnamon',
            'Poppy Seeds',
            'Plums',
            'Condensed Milk',
            'Apricots',
            'Caramel',
            'Eggs',
            'Cheese',
            'Meat',
            'Cabbage',
            'Onions',
            'Mushrooms',
            'Potatoes',
        ];

        $ingredients = collect();
        foreach ($ingredientMap as $ingredientName) {
            $ingredient = Ingredient::factory()->create([
                'name' => $ingredientName,
                'status' => true,
            ]);

            $ingredients->push($ingredient);
        }

        $allergenMap = [
            'Dairy Products',
            'Eggs',
            'Nuts',
            'Celery',
            'Sulphites',
            'Mustard',
            'Lupin and Lupin Products',
            'Gluten from Cereals',
            'Soybeans and Soy Products',
            'Sesame',
        ];

        $allergens = collect();
        foreach ($allergenMap as $allergenName) {
            $allergen = Allergen::factory()->create([
                'name' => $allergenName,
                'status' => true,
            ]);

            $allergens->push($allergen);
        }

        // Create suppliers
        $users = User::factory(10)->create([
            'role' => \App\Enums\UserRole::Supplier,
        ]);

        $users->each(function ($user) use ($categories) {
            $categories->each(function ($category) use ($user) {
                Product::factory(10)->create([
                    'user_id' => $user->id,
                    'country_id' => Country::all()->random()->id,
                    'region_id' => Region::all()->random()->id,
                    'city_id' => City::all()->random()->id,
                    'category_id' => $category->id,
                    'status' => \App\Enums\ProductStatus::Published,
                ])->each(function ($product) {
                    $product->allergens()->attach(
                        Allergen::inRandomOrder()->limit(3)->get()
                    );
                    $product->ingredients()->attach(
                        Ingredient::inRandomOrder()->limit(3)->get()
                    );
                    $product->themes()->attach(
                        Theme::inRandomOrder()->limit(3)->get()
                    );
                });
            });
        });
    }
}
