<div class="max-w-4xl mx-auto my-8 bg-white shadow-lg rounded-lg">
    <!-- Product Header -->
    <div class="p-6 space-y-4">
        <a
            href="{{ route('category-page', ['slug' => $this->record->category->slug]) }}"
            wire:navigate
        >
            Category: {{ $this->record->category->name }}
        </a>
        <h1 class="text-3xl font-bold text-gray-800">{{ $this->record->name }}</h1>
        <div class="flex flex-wrap items-center gap-2">
            @foreach($this->record->themes as $theme)
                <span class="bg-gray-100 px-2 py-1 rounded-lg">{{ $theme->name }}</span>
            @endforeach
        </div>
    </div>

    <!-- Product Image and Details -->
    <div class="flex flex-col md:flex-row p-6">
        <!-- Product Image -->
        <div class="flex-shrink-0 w-full md:w-1/2">
            <img
                src="https://placehold.co/700x420/000000/333"
                alt="{{ $this->record->name }}"
                class="object-cover w-full h-full rounded"
            >
        </div>

        <!-- Product Details -->
        <div class="w-full p-6 md:w-1/2">
            <div class="mb-4 text-gray-600">
                {!! $this->record->description !!}
            </div>
            <div class="flex items-center space-x-2 mb-4">
                <!-- Product Rating -->
                <div class="flex items-center text-yellow-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path></svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path></svg>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.049 2.927C11.432 2.119 12.568 2.119 12.951 2.927L14.9 7.015L19.506 7.634C20.356 7.758 20.699 8.802 20.1 9.363L16.648 12.576L17.405 17.185C17.535 18.041 16.585 18.665 15.868 18.168L12 15.866L8.132 18.168C7.415 18.665 6.465 18.041 6.595 17.185L7.352 12.576L3.9 9.363C3.301 8.802 3.644 7.758 4.494 7.634L9.1 7.015L11.049 2.927Z"></path></svg>
                </div>
                <span class="text-gray-600">4.5/5</span>
            </div>
            <div class="font-bold text-xl">
                {{ $this->record->price }}€
            </div>
            <a class="inline-block bg-green-900 text-white px-3 py-2 rounded-lg font-semibold hover:bg-black" href="{{ route('checkout-page') }}">Checkout</a>
        </div>
    </div>

    <!-- Comments Section -->
{{--    <div class="p-6">--}}
{{--        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Comments</h2>--}}
{{--        <div class="space-y-4">--}}
{{--            <div class="p-4 bg-gray-50 rounded-lg">--}}
{{--                <p><span class="font-medium">User123</span>: Очень полезный товар, рекомендую!</p>--}}
{{--            </div>--}}
{{--            <div class="p-4 bg-gray-50 rounded-lg">--}}
{{--                <p><span class="font-medium">AnotherUser</span>: Качество хорошее, но доставка была долгой.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
