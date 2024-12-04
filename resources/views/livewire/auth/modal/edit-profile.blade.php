<div>
    <div class="border-b py-3 px-5 font-bold text-xl">Update Profile</div>
    <form wire:submit.prevent="update">
        <div class="border-b p-5 space-y-4">
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Name
                    <span class="text-red-600">*</span>
                </label>
                <input wire:model="name" id="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                    <span class="text-red-600">*</span>
                </label>
                <input wire:model="email" id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">
                    Phone
                    <span class="text-red-600">*</span>
                </label>
                <input wire:model="phone" id="phone" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Country Select --}}
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">
                    Country
                    <span class="text-red-600">*</span>
                </label>
                <select wire:model="country" id="country" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Region select --}}
            <div>
                <label for="region" class="block text-sm font-medium text-gray-700">
                    Region
                    <span class="text-red-600">*</span>
                </label>
                <select wire:model="region" id="region" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                @error('region')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- City Select --}}
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">
                    City
                    <span class="text-red-600">*</span>
                </label>
                <select wire:model="city" id="city" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">
                    Address
                    <span class="text-red-600">*</span>
                </label>
                <textarea wire:model="address" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                @error('address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="py-3 px-5 flex items-center justify-between flex-wrap gap-4">
            <button type="submit" class="inline-block rounded-md py-2 px-5 bg-green-500 text-white">Update</button>
        </div>
    </form>
</div>
