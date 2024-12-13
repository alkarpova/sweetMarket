<?php

namespace App\Livewire\Supplier\Products;

use App\Enums\ProductStatus;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPage extends Component
{
    use WithFileUploads;

    public $productId;

    public $category;

    public $selectedThemes;

    public $selectedAllergens;

    public $selectedIngredients;

    public $name;

    public $description;

    #[Validate('image|max:2048')]
    public $image;

    public $price;

    public $minimum;

    public $quantity;

    public $weight;

    public function mount($product)
    {
        $query = Product::where('id', $product)
            ->firstOrFail();

        $this->productId = $query->id;
        $this->category = $query->category_id;
        $this->selectedThemes = $query->themes->pluck('id')->toArray();
        $this->selectedAllergens = $query->allergens->pluck('id')->toArray();
        $this->selectedIngredients = $query->ingredients->pluck('id')->toArray();
        $this->name = $query->name;
        $this->description = $query->description;
        $this->image = $query->image;
        $this->price = $query->price;
        $this->minimum = $query->minimum;
        $this->quantity = $query->quantity;
        $this->weight = $query->weight;
    }

    public function updateProduct(): void
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
            'quantity' => 'required|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $validated['image'] = $this->image->store('products', 'public');

        $product = Product::findOrFail($this->productId);

        $product->country_id = auth()->user()?->country_id;
        $product->region_id = auth()->user()?->region_id;
        $product->city_id = auth()->user()?->city_id;
        $product->category_id = $validated['category'];
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->minimum = $validated['minimum'];
        $product->quantity = $validated['quantity'];
        $product->weight = $validated['weight'];
        $product->image = $validated['image'];
        $product->status = ProductStatus::Pending;
        $product->save();

        $product->themes()->sync($this->selectedThemes);
        $product->allergens()->sync($this->selectedAllergens);
        $product->ingredients()->sync($this->selectedIngredients);

        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Product updated',
        ]);

        $this->redirect(route('supplier-products-page'));
    }

    public function deleteProduct(): void
    {
        $product = Product::findOrFail($this->productId);

        $product->delete();

        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Product deleted',
        ]);

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
