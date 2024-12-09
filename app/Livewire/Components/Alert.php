<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class Alert extends Component
{
    public array $notifications = [];

    #[On('alert')]
    public function addNotification($message, $type): void
    {
        $this->notifications[] = ['type' => $type, 'message' => $message];

        $this->dispatch('remove-notification', ['index' => count($this->notifications) - 1]);
    }

    #[On('removeNotification')]
    public function removeNotification($index): void
    {
        unset($this->notifications[$index]);
        $this->notifications = array_values($this->notifications);
    }

    public function render()
    {
        return view('livewire.components.alert');
    }
}
