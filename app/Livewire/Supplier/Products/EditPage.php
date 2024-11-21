<?php

namespace App\Livewire\Supplier\Products;

use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EditPage extends Component
{
    public $category;
    public $selectedThemes;
    public $selectedAllergens;
    public $selectedIngredients;
    public $name;
    public $description;
    public $image;
    public $price;
    public $minimum;
    public $maximum;
    public $quantity;
    public $weight;

    public function mount($product)
    {
        $query = Product::where('id', $product)
            ->status()
            ->firstOrFail();

        $this->category = $query->category_id;
        $this->selectedThemes = $query->themes->pluck('id')->toArray();
        $this->selectedAllergens = $query->allergens->pluck('id')->toArray();
        $this->selectedIngredients = $query->ingredients->pluck('id')->toArray();
        $this->name = $query->name;
        $this->description = $query->description;
        $this->price = $query->price;
        $this->minimum = $query->minimum;
        $this->maximum = $query->maximum;
        $this->quantity = $query->quantity;
        $this->weight = $query->weight;
    }

    public function updateProduct(): void
    {
        $this->validate([
            'category_id' => 'required|exists:categories,id',
            'selectedThemes.*' => 'nullable|array|exists:themes,id',
            'selectedAllergens.*' => 'nullable|array|exists:allergens,id',
            'selectedIngredients.*' => 'nullable|array|exists:ingredients,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric',
            'minimum' => 'required|integer',
            'maximum' => 'required|integer',
            'quantity' => 'required|integer',
            'weight' => 'nullable|numeric',
        ]);

        $product = new Product();
        $product->category_id = $this->category;
        $product->name = $this->name;
        $product->description = $this->description;
        $product->price = $this->price;
        $product->minimum = $this->minimum;
        $product->maximum = $this->maximum;
        $product->quantity = $this->quantity;
        $product->weight = $this->weight;
        $product->save();

        $product->themes()->sync($this->selectedThemes);
        $product->allergens()->sync($this->selectedAllergens);
        $product->ingredients()->sync($this->selectedIngredients);

        if ($this->image) {
            $product->update([
                'image' => Storage::putFile('products', $this->image),
            ]);
        }

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
        return view('livewire.supplier.products.edit-page');
    }
}
