<?php

namespace App\Livewire\Customer\Modal;

use App\Models\Complaint;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;

class AddComplaint extends ModalComponent
{
    public Order $order;
    public string $comment = '';
    public Collection $suppliers;
    public string $supplier;

    public function mount(): void
    {
        // Find users and set them to the suppliers
        // Get the suppliers from the order items
        $this->suppliers = User::whereIn('id', $this->order->items->pluck('supplier_id')->unique())->get();

        // if supplier one set default
        $this->supplier = $this->suppliers->containsOneItem()
            ? $this->suppliers->first()->id
            : '';
    }

    public function send(): void
    {
        // Validate the comment
        $this->validate([
            'supplier' => 'required|exists:users,id', // required and exists in the users table
            'comment' => 'required|max:65535', // required and max 65535 characters
        ], [
            'supplier.required' => 'Please select a supplier.',
            'supplier.exists' => 'The selected supplier is invalid.',
            'comment.required' => 'Please provide a comment.',
            'comment.max' => 'Your comment exceeds the maximum allowed length.',
        ]);

        // Create the complaint
        Complaint::create([
            'user_id' => auth()->user()->id, // who is complaining
            'order_id' => $this->order->id, // which order
            'supplier_id' => $this->supplier, // who is being complained about
            'comment' => $this->comment, // the complaint
        ]);

        // Close the modal
        $this->forceClose()->closeModal();
    }

    public function render()
    {
        return view('livewire.customer.modal.add-complaint');
    }
}
