<?php

namespace App\Livewire\Pages;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
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
                'allergens',
                'ingredients',
                'themes',
                'reviews',
            ])
            ->status()
            ->firstOrFail();

        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->canAddToCart = false;
        }
    }

    public function addToCart(): void
    {
        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->dispatch('alert', 'You can not add your own product to cart', 'error');

            return;
        }

        Cart::add($this->record, $this->quantity);

        $this->dispatch('cartUpdated');
        $this->dispatch('alert', 'Product added to cart', 'success');
    }

    public function render()
    {
        return view('livewire.pages.product-page');
    }
}
