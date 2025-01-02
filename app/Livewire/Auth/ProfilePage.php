<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfilePage extends Component
{
    public ?User $user;

    /**
     * Get the user profile.
     */
    #[On('userUpdated')]
    public function mount(): void
    {
        $this->user = User::where('id', auth()->user()->id)
            ->with([
                'country',
                'region',
                'city',
            ])
            ->firstOrFail();
    }

    /**
     * Delete the user profile.
     */
    public function deleteProfile(): void
    {
        // Logout the user and delete the profile
        auth()->logout();
        $this->user->delete();

        session()->flash('notify', [
            'type' => 'success',
            'message' => 'Profile deleted',
        ]);

        $this->redirectRoute('home-page');
    }

    public function render()
    {
        return view('livewire.auth.profile-page');
    }
}
