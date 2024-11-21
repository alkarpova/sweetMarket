<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">Profile</h1>
                <form wire:submit.prevent="updateProfile">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input wire:model.lazy="name" id="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input wire:model.lazy="email" id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-300 text-red-900 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input wire:model.lazy="phone" id="phone" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('phone') border-red-300 text-red-900 @enderror">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-500">Update</button>
                </form>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <ul class="list-disc ps-5 space-y-2">
                <li><a href="{{ route('supplier-profile-page') }}">Profile</a></li>
                <li><a href="{{ route('supplier-orders-page') }}">List Orders</a></li>
                <li><a href="{{ route('supplier-products-page') }}">List Products</a></li>
            </ul>
        </aside>
    </div>
</div>
