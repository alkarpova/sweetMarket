<?php

namespace App\Livewire\Supplier\Orders;

use App\Enums\OrderItemStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ViewPage extends Component
{
    public Order $order;

    public $statuses;

    public function mount($order): void
    {
        $query = Order::where('id', $order)->whereHas('items', function ($query) {
            $query->where('supplier_id', auth()->user()->id);
        })->firstOrFail();

        $this->order = $query;

        $this->statuses = OrderItemStatus::cases();
    }

    public function updateStatus(OrderItem $item, $newStatus): void
    {
        $data = ['item_id' => $item->id, 'status' => $newStatus];

        $validate = Validator::make($data, [
            'item_id' => ['required', 'exists:order_items,id'],
            'status' => ['required', ['required', Rule::in(OrderItemStatus::cases())]],
        ]);

        if ($validate->fails()) {
            // Handle validation errors

            return;
        }

        $item->update(['status' => $newStatus]);
    }

    public function render()
    {
        return view('livewire.supplier.orders.view-page');
    }
}
