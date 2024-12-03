<?php

namespace App\Livewire\Pages;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ProductPage extends Component
{
    public ?Product $record;
    public int $quantity = 1;

    /**
     * Get the product by id
     *
     * @param string $id
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
            ])
            ->status()
            ->firstOrFail();
    }

    public function addToCart(): void
    {
        Cart::add($this->record, $this->quantity);

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.pages.product-page');
    }
}
