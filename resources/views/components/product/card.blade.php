<article class="flex flex-col bg-white rounded-lg p-3 space-y-4">
    <a href="{{ route('product-page', ['id' => $product->id]) }}">
        <img
            src="https://placehold.co/500x320/000000/333"
            alt="{{ $this->record->name }}"
            class="object-cover w-full h-full rounded"
        >
    </a>
    <div class="flex flex-wrap items-center gap-2 text-xs">
        @foreach($product->themes->take(2) as $theme)
            <span class="bg-gray-100 px-2 py-1 rounded-lg">{{ $theme->name }}</span>
        @endforeach
        @if($product->themes->count() > 2)
            <span class="text-xs">un citi...</span>
        @endif
    </div>
    <div class="flex-1 space-y-4">
        <div class="flex flex-wrap justify-between items-start gap-4">
            <a class="font-bold hover:text-green-900" href="{{ route('product-page', ['id' => $product->id]) }}">{{ $product->name }}</a>
        </div>
        <p>{{ $product->short_description }}</p>
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
    <div class="flex items-center justify-between">
        <div class="font-bold text-lg">{{ $product->price }}€</div>
        <a class="bg-green-900 text-white px-3 py-2 rounded-lg font-semibold text-sm hover:bg-black" href="{{ route('product-page', ['id' => $product->id]) }}">Skatit</a>
    </div>
</article>
