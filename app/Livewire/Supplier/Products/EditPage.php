<?php

namespace App\Livewire\Supplier\Products;

use App\Enums\ProductStatus;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPage extends Component
{
    use WithFileUploads;

    public string $productId;
    public string $category;
    public array $selectedThemes = [];
    public array $selectedAllergens = [];
    public array $selectedIngredients = [];
    public string $name = '';
    public string $description = '';
    public $photo;
    public $image;
    public float $price = 0.0;
    public int $minimum = 1;
    public int $quantity = 1;
    public float $weight = 0;
    public int $status = ProductStatus::Pending->value;
    public array $statuses = [];

    public function mount($product): void
    {
        if (!auth()->user()->country_id || !auth()->user()->region_id || !auth()->user()->city_id) {
            $this->redirect(route('profile-page'));
        }

        $this->statuses = ProductStatus::cases();

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
        $this->status = $query->status->value;
    }

    public function updateProduct(): void
    {
        // Validate
        $this->validate([
            'category' => 'required|exists:categories,id',
            'selectedThemes.*' => 'nullable|exists:themes,id',
            'selectedAllergens.*' => 'nullable|exists:allergens,id',
            'selectedIngredients.*' => 'nullable|exists:ingredients,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'minimum' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0',
            'status' => ['required', new Enum(ProductStatus::class)],
        ]);

        // Update product
        $product = Product::findOrFail($this->productId);
        $product->country_id = auth()->user()?->country_id;
        $product->region_id = auth()->user()?->region_id;
        $product->city_id = auth()->user()?->city_id;
        $product->category_id = $this->category;
        $product->name = trim($this->name);
        $product->description = trim($this->description);
        $product->price = $this->price;
        $product->minimum = $this->minimum;
        $product->quantity = $this->quantity;
        $product->weight = $this->weight;

        if ($this->status === ProductStatus::Draft->value) {
            $product->status = ProductStatus::Draft;
        } else {
            $product->status = ProductStatus::Pending;
        }

        // Check if a photo has been provided before proceeding.
        if ($this->photo) {
            // Generate a unique name for the photo to avoid file name conflicts.
            $photoName = md5($this->photo . microtime()).'.'.$this->photo->extension();
            // Save the photo to the publicly accessible storage directory.
            $this->photo->storePubliclyAs(path: 'public', name: $photoName);
            // Assign the generated photo name to the product's image attribute.
            $product->image = $photoName;
        }

        $product->save();

        // Save relationships
        $product->themes()->sync($this->selectedThemes);
        $product->allergens()->sync($this->selectedAllergens);
        $product->ingredients()->sync($this->selectedIngredients);

        // Notify
        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Product updated',
        ]);

        // Redirect
        $this->redirect(route('supplier-products-page'));
    }

    public function deleteProduct(): void
    {
        // Find product
        $product = Product::findOrFail($this->productId);

        // Delete product
        $product->delete();

        // Notify
        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Product deleted',
        ]);

        // Redirect
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
