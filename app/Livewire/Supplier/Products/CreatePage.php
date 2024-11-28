<?php

namespace App\Livewire\Supplier\Products;

use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePage extends Component
{
    use WithFileUploads;

    public $category;
    public $selectedThemes = [];
    public $selectedAllergens = [];
    public $selectedIngredients = [];
    public $name;
    public $description;
    public $image;
    public $price;
    public $minimum = 1;
    public $maximum = 1;
    public $quantity = 1;
    public $weight;
    public $status = 1;

    public function createProduct(): void
    {
        $validated = $this->validate([
            'category' => 'required|exists:categories,id',
            'selectedThemes.*' => 'nullable|exists:themes,id',
            'selectedAllergens.*' => 'nullable|exists:allergens,id',
            'selectedIngredients.*' => 'nullable|exists:ingredients,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'minimum' => 'required|integer|min:1',
            'maximum' => 'required|integer|min:1|gte:minimum',
            'quantity' => 'required|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $validated['image'] = $this->image->store('products', 'public');

        $product = Product::create([
            'user_id' => auth()->user()->id,
            'country_id' => auth()->user()?->country_id,
            'region_id' => auth()->user()?->region_id,
            'city_id' => auth()->user()?->city_id,
            'category_id' => $validated['category'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'minimum' => $validated['minimum'],
            'maximum' => $validated['maximum'],
            'quantity' => $validated['quantity'],
            'weight' => $validated['weight'],
            'image' => $validated['image'],
            'status' => $validated['status'],
        ]);

        $product->themes()->sync($this->selectedThemes);
        $product->allergens()->sync($this->selectedAllergens);
        $product->ingredients()->sync($this->selectedIngredients);

        $this->redirect(route('supplier-products-page'));
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::status()->get();
    }

    #[Computed]
    public function themes(): Collection
    {
        return Theme::status()->get();
    }

    #[Computed]
    public function allergens(): Collection
    {
        return Allergen::status()->get();
    }

    #[Computed]
    public function ingredients(): Collection
    {
        return Ingredient::status()->get();
    }

    public function render()
    {
        return view('livewire.supplier.products.create-page');
    }
}
