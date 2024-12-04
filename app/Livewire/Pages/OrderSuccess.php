<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use Livewire\Component;

class OrderSuccess extends Component
{
    public ?Order $order;

    public function mount(string $number): void
    {
        $this->order = Order::where('number', $number)
            ->with([
                'items',
                'items.supplier',
                'items.product',
            ])
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.order-success');
    }
}
