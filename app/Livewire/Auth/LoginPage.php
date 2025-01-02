<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => 'required|email|min:4|max:64',
        'password' => 'required|min:8|max:255',
    ];

    /**
     * Authenticate the user.
     */
    public function authenticate()
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->reset('password');
            $this->dispatch('alert', 'Invalid email or password', 'error');

            return false;
        }

        return redirect()->intended(route('home-page'));
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
