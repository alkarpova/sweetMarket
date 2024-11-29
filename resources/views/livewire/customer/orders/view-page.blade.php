<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg space-y-4">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">View Order</h1>
                <div>
                    <ul>
                        <li>Number: {{ $order->number }}</li>
                        <li>Shipping address: {{ $order->shipping_address }}</li>
                        <li>Shipping Method: {{ $order->shipping_method->name }}</li>
                        <li>PaymentMethod: {{ $order->payment_method->name }}</li>
                        <li>Total: {{ $order->total }}€</li>
                        <li>Status: {{ $order->status->name }}</li>
                        <li>Created: {{ $order->created_at->format('d.m.Y H:i')}}</li>
                    </ul>
                </div>
                @if ($order->status === \App\Enums\OrderItemStatus::Completed)

                @endif
                <div class="flex items-center flex-wrap justify-between gap-4">
                    <button
                        wire:click="$dispatch('openModal', { component: 'customer.modal.add-review', arguments: { order: '{{ $order->id}}' } })"
                        class="inline-block px-4 py-2 bg-green-500 text-white rounded"
                    >
                        Review
                    </button>
                    <button
                        wire:click="$dispatch('openModal', { component: 'customer.modal.add-complaint', arguments: { order: '{{ $order->id }}' } })"
                        class="inline-block px-4 py-2 bg-red-500 text-white rounded"
                    >
                        Complaint
                    </button>
                </div>
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Supplier</th>
                            <th class="px-4 py-2 border">Product</th>
                            <th class="px-4 py-2 border">Quantity</th>
                            <th class="px-4 py-2 border">Price</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Status</th>
                            @if($order->status === \App\Enums\OrderStatus::Delivered)
                                <th class="px-4 py-2 border">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->order->items as $item)
                            <tr>
                                <td class="px-4 py-2 border">{{ $item->supplier->name }}</td>
                                <td class="px-4 py-2 border">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 border">{{ $item->price }}€</td>
                                <td class="px-4 py-2 border">{{ $item->total }}€</td>
                                <td class="px-4 py-2 border">{{ $item->status->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-2 border" colspan="6">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <ul class="list-disc ps-5 space-y-2">
                <li><a href="{{ route('customer-profile-page') }}">Profile</a></li>
                <li><a href="{{ route('customer-orders-page') }}">List Orders</a></li>
            </ul>
        </aside>
    </div>
</div>
