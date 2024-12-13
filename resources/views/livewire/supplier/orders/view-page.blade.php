<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">View Order</h1>
                <div class="mb-4">
                    <ul>
                        <li>Number: {{ $order->number }}</li>
                        <li>Created: {{ $order->created_at->format('d.m.Y H:i')}}</li>
                    </ul>
                </div>
                <div class="mb-4 space-y-1">
                    <div class="font-bold">Customer</div>
                    <div>{{ $order->name }}</div>
                    <div>{{ $order->phone }}</div>
                    <div>{{ $order->email }}</div>
                    <div>{{ $order->city->name }}</div>
                    <div>{{ $order->shipping_address }}</div>
                    <div><p>{{ $order->notes }}</p></div>
                </div>
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr class="text-left">
                            <th class="px-4 py-2 border">Product</th>
                            <th class="px-4 py-2 border">Quantity</th>
                            <th class="px-4 py-2 border">Price</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 border">
                                    <a wire:navigate href="{{ route('product-page', $item->product->id) }}" class="text-blue-600">{{ $item->product->name }}</a>
                                </td>
                                <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 border">{{ $item->price }}</td>
                                <td class="px-4 py-2 border">{{ $item->total }}</td>
                                <td class="px-4 py-2 border">
                                    <select wire:change="updateStatus('{{ $item->id }}', $event.target.value)"  class="w-full border">
                                        @foreach ($this->statuses as $status)
                                            <option value="{{ $status->value }}" {{ $item->status->value == $status->value ? 'selected' : '' }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
