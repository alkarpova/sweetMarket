<?php

namespace App\Livewire\Supplier\Products;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListPage extends Component
{
    use WithPagination;

    #[Computed]
    public function products()
    {
        return Product::where('user_id', auth()->id())
            ->paginate();
    }

    public function render()
    {
        return view('livewire.supplier.products.list-page');
    }
}
