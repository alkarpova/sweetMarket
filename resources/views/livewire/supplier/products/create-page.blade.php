<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6 items-start">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h1 class="font-bold text-xl xl:text-2xl">Create Product</h1>
                </div>
                <form wire:submit.prevent="createProduct">
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-bold text-gray-700">
                            Category
                            <span class="text-red-600">*</span>
                        </label>
                        <select wire:model="category" id="category" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category') border-red-300 text-red-900 @enderror">
                            <option value="">Select a category</option>
                            @foreach($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="themes" class="block text-sm font-bold text-gray-700">Themes</label>
                        <select wire:model="selectedThemes" id="themes" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('selectedThemes.*') border-red-300 text-red-900 @enderror">
                            <option value="">Select a themes</option>
                            @foreach($this->themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedThemes.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="ingredients" class="block text-sm font-bold text-gray-700">Ingredients</label>
                        <select wire:model="selectedIngredients" multiple id="ingredients" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('selectedIngredients.*') border-red-300 text-red-900 @enderror">
                            <option value="">Select a allergens</option>
                            @foreach($this->ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedIngredients.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="allergens" class="block text-sm font-bold text-gray-700">Allergens</label>
                        <select wire:model="selectedAllergens" id="allergens" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('selectedAllergens.*') border-red-300 text-red-900 @enderror">
                            <option value="">Select a allergens</option>
                            @foreach($this->allergens as $allergen)
                                <option value="{{ $allergen->id }}">{{ $allergen->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedAllergens.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-gray-700">
                            Name
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="name" id="name" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-bold text-gray-700">
                            Description
                            <span class="text-red-600">*</span>
                        </label>
                        <textarea wire:model="description" id="description" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 @enderror"></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-bold text-gray-700">
                            Price
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="price" id="price" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('price') border-red-300 text-red-900 @enderror">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="minimum" class="block text-sm font-bold text-gray-700">
                            Minimum
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="minimum" id="minimum" type="number" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('minimum') border-red-300 text-red-900 @enderror">
                        @error('minimum')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-bold text-gray-700">
                            Quantity
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="quantity" id="quantity" type="number" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('quantity') border-red-300 text-red-900 @enderror">
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="weight" class="block text-sm font-bold text-gray-700">
                            Weight
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="weight" id="weight" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('weight') border-red-300 text-red-900 @enderror">
                        @error('weight')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-bold text-gray-700">
                            Photo
                            <span class="text-red-600">*</span>
                        </label>
                        <input wire:model="photo" id="photo" type="file" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('image') border-red-300 text-red-900 @enderror">
                        <div wire:loading wire:target="photo">Uploading...</div>
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg" alt="image">
                        @endif
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-bold text-gray-700">
                            Status
                            <span class="text-red-600">*</span>
                        </label>
                        <select wire:model="status" id="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-300 text-red-900 @enderror">
                            @foreach($this->statuses as $status)
                                <option value="{{ $status->value }}">{{ $status->getLabel() }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg">Create Product</button>
                        <a href="{{ route('supplier-products-page') }}" class="px-4 py-2 font-semibold text-white bg-gray-500 rounded-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
