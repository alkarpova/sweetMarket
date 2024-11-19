<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use Livewire\Component;

class ProductPage extends Component
{
    public ?Product $record;

    /**
     * Get the product by id
     *
     * @param string $id
     */
    public function mount(string $id)
    {
        $this->record = Product::where('id', $id)
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

    public function render()
    {
        return view('livewire.pages.product-page');
    }
}
