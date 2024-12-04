<?php

namespace App\Livewire\Customer\Orders;

use App\Models\Order;
use Livewire\Component;

class ViewPage extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $order->where('user_id', auth()->user()->id)
            ->with([
                'items.product',
                'items.supplier',
                'items.review',
            ])
            ->get();
    }

    public function render()
    {
        return view('livewire.customer.orders.view-page');
    }
}
