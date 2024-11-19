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
                    <input type="text" id="name" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your first and last name">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your email">
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="phone" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your phone">
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Delivery address</label>
                    <textarea id="address" rows="3" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter your address"></textarea>
                </div>

                <!-- Payment Method -->
                <h2 class="text-xl font-semibold mb-4 mt-6">Method of payment</h2>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input id="cash" name="payment_method" type="radio" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <label for="cash" class="ml-3 text-sm font-medium text-gray-700">Cash on delivery</label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="w-full md:w-1/3 bg-gray-50 p-6 rounded-r-lg">
            <h2 class="text-xl font-semibold mb-4">Your order</h2>
            <div class="space-y-4">
                <!-- Order Item -->
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium text-gray-800">Product 1</h3>
                        <p class="text-sm text-gray-600">1 x $20.00</p>
                    </div>
                    <p class="text-sm font-medium text-gray-800">$20.00</p>
                </div>
                <!-- Order Item -->
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-medium text-gray-800">Product 2</h3>
                        <p class="text-sm text-gray-600">2 x $15.00</p>
                    </div>
                    <p class="text-sm font-medium text-gray-800">$30.00</p>
                </div>
                <!-- Total -->
                <div class="border-t pt-4">
                    <div class="flex justify-between">
                        <p class="text-lg font-semibold">Total</p>
                        <p class="text-lg font-semibold">$50.00</p>
                    </div>
                </div>
            </div>

            <button class="mt-6 w-full bg-blue-600 text-white text-lg font-medium py-2 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300">
                Place an order
            </button>
        </div>
    </div>
</div>
