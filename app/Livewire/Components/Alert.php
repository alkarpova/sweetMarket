<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Alert extends Component
{
    public string $message = '';
    public string $type = 'info';
    public bool $visible = false;

    #[On('alert')]
    public function showAlert(string $message, string $type = 'info'): void
    {
        $this->message = $message;
        $this->type = $type;
        $this->visible = true;

        // Скрываем уведомление через 3 секунды
        $this->dispatch('hide-alert', ['timeout' => 3000]);
    }

    #[Computed]
    public function alertClasses(): string
    {
        return match ($this->type) {
            'success' => 'bg-green-500 text-white',
            'error' => 'bg-red-500 text-white',
            default => 'bg-blue-500 text-white',
        };
    }

    public function render()
    {
        return view('livewire.components.alert');
    }
}
