<?php

namespace App\Livewire\Contact\Modal;

use App\Enums\ContactTopic;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Computed;
use LivewireUI\Modal\ModalComponent;

class AddRecord extends ModalComponent
{
    public ?User $user = null;

    public string $topic = '';

    public string $name = '';

    public string $email = '';

    public string $comment = '';

    public function mount(): void
    {
        $this->topic = ContactTopic::Feedback->value;

        if (auth()->check()) {
            $this->user = auth()->user();
            $this->name = $this->user->name;
            $this->email = $this->user->email;
        }
    }

    #[Computed]
    public function topics(): array
    {
        return ContactTopic::cases();
    }

    public function send(): void
    {
        // Validate form fields
        $this->validate([
            'topic' => [
                'required',
                new Enum(ContactTopic::class),
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        // Create a new contact record
        Contact::create([
            'user_id' => $this->user?->id,
            'topic' => $this->topic,
            'full_name' => $this->name,
            'email' => $this->email,
            'comment' => $this->comment,
        ]);

        // Close the modal and show a success alert
        $this->forceClose()->closeModal();
        $this->dispatch('alert', 'Your message has been sent.', 'success');
    }

    public function render()
    {
        return view('livewire.contact.modal.add-record');
    }
}
