<?php

namespace App\Livewire\Pages;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductPage extends Component
{
    public ?Product $record;

    #[Locked]
    public bool $canAddToCart = true;

    public int $quantity = 1;

    /**
     * Get the product by id
     */
    public function mount(string $id): void
    {
        $this->record = Product::where('id', $id)
            ->whereHas('user', fn (Builder $query) => $query->whereNull('deleted_at'))
            ->with([
                'category',
                'user',
                'allergens' => fn ($query) => $query->status(),
                'ingredients' => fn ($query) => $query->status(),
                'themes' => fn ($query) => $query->status(),
                'reviews',
            ])
            ->status()
            ->firstOrFail();

        // Check if the category is active
        if (! $this->record->category->status) {
            abort(404);
        }

        // Check if user is the owner of the product
        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->canAddToCart = false;
        }
    }

    /**
     * Add the product to the cart
     */
    public function addToCart(): void
    {
        $this->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if user is the owner of the product
        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->dispatch('alert', 'You can not add your own product to cart', 'error');

            return;
        }

        // Add the product to the cart
        Cart::add($this->record, $this->quantity);

        // Check if the product has warnings
        $warning = Cart::getWarnings();
        if ($warning->isNotEmpty()) {
            $warning->each(function ($message) {
                if ($this->record->id === $message['id']) {
                    $this->dispatch('alert', $message['warning'], 'warning');
                }
            });
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('alert', "Product added to cart", 'success');
    }

    public function render()
    {
        return view('livewire.pages.product-page');
    }
}
