<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    #[Computed, On('cartUpdated')]
    public function cartTotal(): float
    {
        return \App\Facades\Cart::total();
    }

    public function render()
    {
        return view('livewire.components.cart');
    }
}
