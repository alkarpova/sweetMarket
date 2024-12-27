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
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePage extends Component
{
    use WithFileUploads;

    public string $category = '';
    public array $selectedThemes = [];
    public array $selectedAllergens = [];
    public array $selectedIngredients = [];
    public string $name = '';
    public string $description = '';
    public $photo;
    public float $price = 0;
    public int $minimum = 1;
    public int $quantity = 1;
    public float $weight = 0;
    public int $status = ProductStatus::Pending->value;

    public array $statuses = [];

    public function mount(): void
    {
        $this->statuses = array_filter(
            ProductStatus::cases(),
            static fn($status) => !in_array($status->name, ['Rejected', 'Published'])
        );

        if (!auth()->user()->country_id || !auth()->user()->region_id || !auth()->user()->city_id) {
            $this->redirect(route('profile-page'));
        }
    }

    public function createProduct(): void
    {
        // Validate
        $this->validate([
            'category' => 'required|exists:categories,id',
            'selectedThemes.*' => 'nullable|exists:themes,id',
            'selectedAllergens.*' => 'nullable|exists:allergens,id',
            'selectedIngredients.*' => 'nullable|exists:ingredients,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|max:2048',
            'price' => 'required|numeric|min:0',
            'minimum' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        // Generate a unique name for the photo to avoid file name conflicts.
        // The final result is a unique file name in the format: "hash.extension".
        $photoName = md5($this->photo . microtime()).'.'.$this->photo->extension();

        // Save the file to the publicly accessible storage directory.
        $this->photo->storePubliclyAs(path: 'public', name: $photoName);

        // Create product
        $product = Product::create([
            'user_id' => auth()->user()->id,
            'country_id' => auth()->user()?->country_id,
            'region_id' => auth()->user()?->region_id,
            'city_id' => auth()->user()?->city_id,
            'category_id' => $this->category,
            'name' => trim($this->name),
            'description' => trim($this->description),
            'price' => $this->price,
            'minimum' => $this->minimum,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'image' => $photoName,
        ]);

        if ($this->status === ProductStatus::Draft->value) {
            $product->update([
                'status' => ProductStatus::Draft,
            ]);
        } else {
            $product->update([
                'status' => ProductStatus::Pending,
            ]);
        }

        // Save relationships
        $product->themes()->sync($this->selectedThemes);
        $product->allergens()->sync($this->selectedAllergens);
        $product->ingredients()->sync($this->selectedIngredients);

        // Notify
        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Product added',
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
        return view('livewire.supplier.products.create-page');
    }
}
