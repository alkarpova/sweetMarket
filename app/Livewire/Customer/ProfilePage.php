<?php

namespace App\Livewire\Customer;

use App\Models\User;
use Livewire\Component;

class ProfilePage extends Component
{
    public ?User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function updateProfile(): void
    {
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'user.phone' => 'required|string|max:255',
            'user.region_id' => 'required|exists:regions,id',
            'user.city_id' => 'required|exists:cities,id',
            'user.address' => 'required|string|max:255',
        ]);

        $this->user->save();
    }

    public function render()
    {
        return view('livewire.customer.profile-page');
    }
}
