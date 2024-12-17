<div class="max-w-5xl mx-auto my-10 bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Product Header -->
    <div class="p-8 border-b border-gray-200">
        <div class="flex flex-col gap-4">
            <a
                href="{{ route('category-page', ['id' => $this->record->category->id]) }}"
                class="text-sm font-medium text-blue-600 hover:underline"
                wire:navigate
            >
                Category: {{ $this->record->category->name }}
            </a>
            <span class="text-sm text-gray-500">Supplier: {{ $this->record->user->name }}</span>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mt-4">{!! $this->record->name !!}</h1>
        <div class="flex flex-wrap items-center gap-2 mt-3">
            @foreach($this->record->themes as $theme)
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">{{ $theme->name }}</span>
            @endforeach
        </div>
    </div>

    <!-- Product Image and Details -->
    <div class="flex flex-col md:flex-row p-8 gap-6">
        <!-- Product Image -->
        <div class="flex-shrink-0 w-full md:w-1/2">
            @if($this->record->image)
                <img class="w-full h-auto rounded-lg" src="{{ Storage::disk('public')->url($this->record->image) }}" alt="{{ $this->record->name }}">
            @else
                <img
                    src="https://placehold.co/700x420/000000/333"
                    alt="{{ $this->record->name }}"
                    class="w-full h-auto rounded-lg"
                />
            @endif
        </div>

        <!-- Product Details -->
        <div class="w-full md:w-1/2 space-y-6">
            <div class="text-gray-600 leading-relaxed">
                {!! $this->record->description !!}
            </div>
            <div class="flex flex-col">
                @if($this->record->weight)
                    <div class="inline-flex gap-x-2 text-neutral-600">
                        <div class="font-semibold">Weight:</div>
                        <div>{{ $this->record->weight }} kg</div>
                    </div>
                @endif
                <div class="inline-flex gap-x-2 text-neutral-600">
                    <div class="font-semibold">
                        Minimum order:
                    </div>
                    <div>{{ $this->record->minimum }}</div>
                </div>
                <div class="inline-flex gap-x-2 text-neutral-600">
                    <div class="font-semibold">
                        Quantity:
                    </div>
                    <div>{{ $this->record->quantity }}</div>
                </div>
            </div>
            <div class="flex flex-wrap gap-x-12">
                <!-- Product ingredients -->
                <div>
                    <h2 class="font-semibold text-lg text-gray-800">Ingredients</h2>
                    <ul class="list-disc list-inside text-gray-600 mt-2">
                        @foreach($this->record->ingredients as $ingredient)
                            <li>{{ $ingredient->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- Product allergens -->
                <div>
                    <h2 class="font-semibold text-lg text-gray-800">Allergens</h2>
                    <ul class="list-disc list-inside text-gray-600 mt-2">
                        @foreach($this->record->allergens as $allergen)
                            <li>{{ $allergen->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <!-- Product Rating -->
            <div class="flex items-center gap-2">
                @php
                    $rating = (int) $this->record->reviews()->avg('rating');
                @endphp

                @if($rating > 0)
                    <div class="flex items-center text-yellow-500">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.049 2.927C11.432 2.119 12.568 2.119 12.951 2.927L14.9 7.015L19.506 7.634C20.356 7.758 20.699 8.802 20.1 9.363L16.648 12.576L17.405 17.185C17.535 18.041 16.585 18.665 15.868 18.168L12 15.866L8.132 18.168C7.415 18.665 6.465 18.041 6.595 17.185L7.352 12.576L3.9 9.363C3.301 8.802 3.644 7.758 4.494 7.634L9.1 7.015L11.049 2.927Z"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">{{ $rating }}/5</span>
                @endif
            </div>

            <!-- Product Price -->
            <div class="text-2xl font-bold text-green-900">
                {!! $this->record->price !!}€
            </div>
            <!-- Add to Cart -->
            @if($this->canAddToCart)
                <div class="flex items-center gap-4">
                    <input
                        type="number"
                        wire:model="quantity"
                        class="w-20 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-300"
                    >
                    <button
                        wire:click="addToCart"
                        class="px-6 py-2 bg-green-700 text-white font-semibold rounded-lg hover:bg-green-800 focus:outline-none focus:ring focus:ring-green-300"
                    >
                        Add To Cart
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
