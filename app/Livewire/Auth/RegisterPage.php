<?php

namespace App\Livewire\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterPage extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public string $customerType = 'client';

    public function register(): RedirectResponse
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'customerType' => ['required'],
        ]);

        $user = new User;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->password = Hash::make($this->password);
        $user->role = $this->customerType === 'supplier' ? UserRole::Supplier : UserRole::Client;
        $user->save();

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home-page'));
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
