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

        $regionRiga = Region::factory()->create([
            'country_id' => Country::all()->random()->id,
            'name' => 'Rīga',
            'status' => true,
        ]);

        Region::factory()->create([
            'name' => 'Pierīga',
            'status' => true,
        ]);

        Region::factory()->create([
            'name' => 'Kurzeme',
            'status' => true,
        ]);

        Region::factory()->create([
            'name' => 'Latgale',
            'status' => true,
        ]);

        Region::factory()->create([
            'name' => 'Vidzeme',
            'status' => true,
        ]);

        Region::factory()->create([
            'name' => 'Zemgale',
            'status' => true,
        ]);

        City::factory()->create([
            'country_id' => Country::all()->random()->id,
            'region_id' => $regionRiga->id,
            'name' => 'Rīga',
            'status' => true,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => \App\Enums\UserRole::Admin,
        ]);

        // Create suppliers
        User::factory(10)->create([
            'role' => \App\Enums\UserRole::Supplier,
        ]);

        $categoryMap = [
            'Tortes',
            'Smalkmaizes',
            'Pīrādziņi',
            'Ruletes',
            'Ekleri',
            'Riekstiņi',
            'Kūkas',
            'Kliņģeri',
            'Zefīrs',
            'Austrumu saldumi',
            'Cits',
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
            'Bērniem',
            'Dzimšanas diena',
            'Kāzas',
            'Ziemassvētki',
            'Lieldienas',
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
            'Šokolāde',
            'Mellenes',
            'Zemenes',
            'Medus',
            'Biezpiens',
            'Āboli',
            'Apelsīni',
            'Ķirši',
            'Vārītais krēms',
            'Avenes',
            'Banāns',
            'Rieksti',
            'Kanēlis',
            'Magones',
            'Plūmes',
            'Iebiezinātais piens',
            'Aprikozes',
            'Karamele',
            'Olas',
            'Siers',
            'Gaļa',
            'Kāposti',
            'Sīpoli',
            'Sēnes',
            'Kartupeļi',
            'Cits',
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
            'Glutēns',
            'Laktoze',
            'Olu',
            'Soja',
            'Rieksti',
            'Zivis',
            'Garneles',
            'Jūras veltes',
            'Zirņi',
            'Sinepes',
            'Sēnes',
            'Sulfiți',
            'Lupīna',
            'Kukurūza',
            'Kvieši',
            'Piena olbaltumvielas',
            'Mitrālija',
            'Kakao',
            'Kokosrieksti',
            'Mandarīni',
            'Piena šokolāde',
            'Kivi',
            'Mango',
            'Ananāsi',
            'Piena produkti',
            'Melnā šokolāde',
            'Baltais šokolāde',
            'Kafija',
            'Cits',
        ];

        $allergens = collect();
        foreach ($allergenMap as $allergenName) {
            $allergen = Allergen::factory()->create([
                'name' => $allergenName,
                'status' => true,
            ]);

            $allergens->push($allergen);
        }

        // make products
        $categories->each(function ($category) {
            // Create products
            $products = Product::factory(50)->create([
                'user_id' => User::all()->random()->id,
                'country_id' => Country::all()->random()->id,
                'region_id' => Region::all()->random()->id,
                'city_id' => City::all()->random()->id,
                'category_id' => $category->id,
                'status' => ProductStatus::Published,
            ]);

            $products->each(function ($product) {
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
    }
}
