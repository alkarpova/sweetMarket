<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductPage extends Component
{
    public string $id;

    #[Computed]
    public function product(): Product
    {
        return Product::where('id', $this->id)
            ->with([
                'user',
                'allergens',
                'ingredients',
                'themes',
            ])
            ->status()
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.product-page', [
            'product' => $this->product(),
        ]);
    }
}
