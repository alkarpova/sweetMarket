<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfilePage extends Component
{
    public ?User $user;

    #[On('userUpdated')]
    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.auth.profile-page');
    }
}
