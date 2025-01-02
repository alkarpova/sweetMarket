<?php

namespace App\Livewire\Customer\Orders;

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListPage extends Component
{
    use WithPagination;

    /**
     * Get the orders
     */
    #[Computed]
    public function orders()
    {
        return Order::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.customer.orders.list-page');
    }
}
