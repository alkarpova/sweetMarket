<div class="max-w-6xl mx-auto my-10 bg-white shadow-lg rounded-lg">
    <div class="p-6 border-b">
        <h1 class="text-3xl font-bold text-gray-800">Order placement</h1>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row">
        <!-- Customer Details -->
        <div class="w-full md:w-2/3 p-6">
            <h2 class="text-xl font-semibold mb-4">Customer information</h2>
            <form>
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">First and last name</label>
                    <input wire:model="name" type="text" id="name" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your first and last name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input wire:model="email" type="email" id="email" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your email">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input wire:model="phone" type="tel" id="phone" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your phone">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Delivery address</label>
                    <textarea wire:model="address" id="address" rows="3" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your address"></textarea>
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea wire:model="notes" id="notes" rows="3" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your notes"></textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <h2 class="text-xl font-semibold mb-4 mt-6">Method of payment</h2>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input id="cash" wire:model="paymentMethod" value="cash" name="payment_method" type="radio" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <label for="cash" class="ml-3 text-sm font-medium text-gray-700">Cash on delivery</label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="w-full md:w-1/3 bg-gray-50 p-6 rounded-r-lg">
            <h2 class="text-xl font-semibold mb-4">Your order</h2>
            <div class="space-y-4">
                @foreach($this->cartItems as $item)
                    <!-- Order Item -->
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800">{!! $item['name'] !!}</h3>
                            <p class="text-sm text-gray-600">{{ $item['quantity'] }} x {{ $item['price'] }}€</p>
                        </div>
                        <p class="text-sm font-medium text-gray-800">{{ $item['price'] * $item['quantity'] }}€</p>
                    </div>
                @endforeach
                <!-- Total -->
                <div class="border-t pt-4">
                    <div class="flex justify-between">
                        <p class="text-lg font-semibold">Total</p>
                        <p class="text-lg font-semibold">{{ $this->cartTotal }}€</p>
                    </div>
                </div>
            </div>

            <button wire:click="createOrder" class="mt-6 w-full bg-blue-600 text-white text-lg font-medium py-2 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300">
                Place an order
            </button>
        </div>
    </div>
</div>
