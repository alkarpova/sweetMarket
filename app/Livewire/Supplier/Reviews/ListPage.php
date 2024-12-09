<?php

namespace App\Livewire\Supplier\Reviews;

use App\Models\Review;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListPage extends Component
{
    use WithPagination;

    #[Computed]
    public function reviews()
    {
        return Review::where('supplier_id', auth()->user()->id)
            ->with([
                'user',
                'order',
            ])
            ->paginate();
    }

    public function render()
    {
        return view('livewire.supplier.reviews.list-page');
    }
}
