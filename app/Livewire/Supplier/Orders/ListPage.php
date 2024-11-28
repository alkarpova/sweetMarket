<?php

namespace App\Livewire\Supplier\Orders;

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListPage extends Component
{
    use WithPagination;

    #[Computed]
    public function orders()
    {
        return Order::whereHas('items', function ($query) {
            $query->where('supplier_id', auth()->user()->id);
        })->paginate();
    }

    public function render()
    {
        return view('livewire.supplier.orders.list-page');
    }
}
