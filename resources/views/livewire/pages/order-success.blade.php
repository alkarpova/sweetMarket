<div class="container mx-auto px-4">
    <div class="px-4 py-8 bg-white shadow rounded-lg">
        <h1 class="mb-4 font-bold text-xl xl:text-2xl text-center">Order Success</h1>
        <div class="space-y-4">
            <div class="flex flex-col items-start gap-2 bg-white py-2 px-4 rounded-md">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Order Number: {{ $order->number }}
                    </h3>
                    <p class="text-sm text-gray-600">Total: {{ $order->total }}€</p>
                    <p class="text-sm font-bold text-gray-800">Status: {{ $order->status->name }}</p>
                    <div>
                        {{ $order->notes }}
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-start gap-2 bg-white py-2 px-4 rounded-md">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Shipping
                    </h3>
                    <p class="text-sm text-gray-600">{{ $order->shipping_method->name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                </div>
            </div>
            <div class="flex flex-col items-start gap-2 bg-white py-2 px-4 rounded-md">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Payment
                    </h3>
                    <p class="text-sm text-gray-600">{{ $order->payment_method->name }}</p>
                </div>
            </div>
            <div class="flex flex-col items-start gap-2 bg-white py-2 px-4 rounded-md">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Notes
                    </h3>
                    <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                </div>
            </div>
            <div class="flex flex-col items-start gap-2 bg-white py-2 px-4 rounded-md">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Products
                    </h3>
                    <div class="divide-y">
                        @foreach($order->items as $item)
                            <div class="flex flex-col items-start gap-2 bg-white py-2 rounded-md">
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-gray-800">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x {{ $item->price }}€</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $item->price * $item->quantity }}€</p>
                                    <p class="text-sm text-gray-600">Supplier: {{ $item->supplier->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

