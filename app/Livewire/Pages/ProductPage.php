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

        if (! $this->record->category->status) {
            abort(404);
        }

        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->canAddToCart = false;
        }
    }

    public function addToCart(): void
    {
        $this->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (auth()->check() && auth()->user()->id === $this->record->user->id) {
            $this->dispatch('alert', 'You can not add your own product to cart', 'error');

            return;
        }

        Cart::add($this->record, $this->quantity);
        Cart::validateProduct($this->record, $this->productCountInCart());

        $warning = Cart::getWarnings();

        if ($warning->isNotEmpty()) {
            $this->dispatch('alert', $warning->first()['warning'], 'warning');
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('alert', "Product added to cart", 'success');
    }

    public function productCountInCart(): int
    {
        $cartItems = Cart::getContent();

        if ($cartItems->has($this->record->id)) {
            return $cartItems->get($this->record->id)['quantity'];
        }

        return 0;
    }

    #[Computed]
    public function getCartWarnings(): Collection
    {
        return Cart::getWarnings();
    }

    public function render()
    {
        return view('livewire.pages.product-page');
    }
}
