<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6 items-start">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h1 class="font-bold text-xl xl:text-2xl">Create Product</h1>
                </div>
                <form wire:submit.prevent="createProduct">
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select wire:model.lazy="category" id="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category') border-red-300 text-red-900 @enderror">
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
                        <label for="themes" class="block text-sm font-medium text-gray-700">Themes</label>
                        <select wire:model.lazy="selectedThemes" id="themes" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category') border-red-300 text-red-900 @enderror">
                            <option value="">Select a themes</option>
                            @foreach($this->themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                        @error('themes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="allergens" class="block text-sm font-medium text-gray-700">Allergens</label>
                        <select wire:model.lazy="selectedAllergens" id="allergens" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category') border-red-300 text-red-900 @enderror">
                            <option value="">Select a allergens</option>
                            @foreach($this->allergens as $allergen)
                                <option value="{{ $allergen->id }}">{{ $allergen->name }}</option>
                            @endforeach
                        </select>
                        @error('allergens')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredients</label>
                        <select wire:model.lazy="selectedIngredients" multiple id="ingredients" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('category') border-red-300 text-red-900 @enderror">
                            <option value="">Select a allergens</option>
                            @foreach($this->ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                        @error('ingredients')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input wire:model.lazy="name" id="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model.lazy="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 @enderror"></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input wire:model.lazy="price" id="price" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('price') border-red-300 text-red-900 @enderror">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="minimum" class="block text-sm font-medium text-gray-700">Minimum</label>
                        <input wire:model.lazy="minimum" id="minimum" type="number" value="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('minimum') border-red-300 text-red-900 @enderror">
                        @error('minimum')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="maximum" class="block text-sm font-medium text-gray-700">Maximum</label>
                        <input wire:model.lazy="maximum" id="maximum" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('maximum') border-red-300 text-red-900 @enderror">
                        @error('maximum')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input wire:model.lazy="quantity" id="quantity" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('quantity') border-red-300 text-red-900 @enderror">
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input wire:model.lazy="image" id="image" type="file" class="mt-1 block
                        w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('image') border-red-300 text-red-900 @enderror">
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg">Create Product</button>
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
