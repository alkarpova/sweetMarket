<?php

namespace App\Livewire\Supplier\Orders;

use App\Enums\OrderItemStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class ViewPage extends Component
{
    public Order $order;

    public $statuses;

    public function mount(Order $order): void
    {
        $this->order = $order->with([
            'items' => function ($query) {
                $query->where('supplier_id', auth()->user()->id);
            },
        ])->whereHas('items', function ($query) {
            $query->where('supplier_id', auth()->user()->id);
        })->firstOrFail();

        $this->statuses = OrderItemStatus::cases();
    }

    /**
     * Update the status of the order item
     */
    public function updateStatus(OrderItem $item, $newStatus): void
    {
        if ($item->supplier_id !== auth()->user()->id) {
            $this->addError('status', 'You are not allowed to change the status of this item.');
            return;
        }

        $data = [
            'item_id' => $item->id,
            'status' => $newStatus
        ];

        $validator = Validator::make($data, [
            'item_id' => ['required', 'exists:order_items,id'],
            'status' => ['required', new Enum(OrderItemStatus::class)],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $field => $messages) {
                $this->addError($field, implode(', ', $messages));
            }

            // Reload the order to reflect the changes
            $this->order->load([
                'items' => fn ($query) => $query->where('supplier_id', auth()->user()->id),
            ]);

            return;
        }

        // Update the status of the item
        $item->update(['status' => $newStatus]);

        // If status is 'delivered', email the customer
        if ($newStatus === OrderItemStatus::Completed) {
            //
        }

        // Reload the order to reflect the changes
        $this->order->load([
            'items' => fn ($query) => $query->where('supplier_id', auth()->user()->id),
        ]);
    }

    public function render()
    {
        return view('livewire.supplier.orders.view-page');
    }
}
