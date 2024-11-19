<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class CheckoutPage extends Component
{
    protected $cart;

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.pages.checkout-page');
    }
}
