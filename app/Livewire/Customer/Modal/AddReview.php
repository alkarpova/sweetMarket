<?php

namespace App\Livewire\Customer\Modal;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;

class AddReview extends ModalComponent
{
    public Order $order;

    public OrderItem $orderItem;

    public Collection $suppliers;

    public User $supplier;

    public int $rating = 5;

    public ?string $comment = null;

    public function mount(): void
    {
        $this->supplier = User::find($this->orderItem->supplier_id);
    }

    public function send(): void
    {
        // Check if the user is trying to review themselves
        if (auth()->user()->id === $this->supplier) {
            $this->dispatch('alert', 'You cannot review about yourself.', 'error');
            $this->forceClose()->closeModal();

            return;
        }

        // Check if the user has already reviewed the product
        if (Review::where('user_id', auth()->user()->id)
            ->where('order_id', $this->order->id)
            ->where('order_item_id', $this->orderItem->id)
            ->exists()) {
            $this->dispatch('alert', 'You have already reviewed this product.', 'error');
            $this->forceClose()->closeModal();

            return;
        }

        // Validate the input
        $this->validate([
            'rating' => 'required|integer|min:1|max:5', // required and integer between 1 and 5
            'comment' => 'nullable|max:65535', // required and max 65535 characters
        ]);

        // Create the review
        Review::create([
            'user_id' => auth()->user()->id,
            'order_id' => $this->order->id,
            'order_item_id' => $this->orderItem->id,
            'supplier_id' => $this->supplier->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        // Close the modal
        $this->forceClose()->closeModal();

        $this->dispatch('alert', 'Review added successfully.', 'success');
    }

    public function render()
    {
        return view('livewire.customer.modal.add-review');
    }
}
