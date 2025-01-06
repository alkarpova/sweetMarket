<article class="flex flex-col bg-white rounded-lg p-3 space-y-4" wire:key="{{ $product->id }}">
    <a href="{{ route('product-page', ['id' => $product->id]) }}">
        @if($product->image)
            <div style="background-image: url('{{ Storage::url($product->image) }}');" class="bg-center bg-cover h-[300px] w-full"></div>
        @else
            <div style="background-image: url('https://placehold.co/500x320/000000/333');" class="bg-center bg-cover h-[300px] w-full"></div>
        @endif
    </a>
    <div class="flex flex-wrap items-center gap-2 text-xs">
        @foreach($product->themes->take(2) as $theme)
            <span class="bg-gray-100 px-2 py-1 rounded-lg">{{ $theme->name }}</span>
        @endforeach
        @if($product->themes->count() > 2)
            <span class="text-xs">and others...</span>
        @endif
    </div>
    <div class="flex-1 space-y-4">
        <div class="flex flex-wrap justify-between items-start gap-4">
            <a class="font-bold hover:text-green-900" href="{{ route('product-page', ['id' => $product->id]) }}">{{ $product->name }}</a>
        </div>
        <p>{{ $product->short_description }}</p>
        <div class="inline-flex gap-x-2 text-neutral-600">
            <div class="font-semibold">Weight:</div>
            <div>{{ $product->weight }} kg</div>
        </div>
    </div>

    <div class="flex items-center space-x-2 mb-4">
    @php
        $rating = (float) $product->reviews()->avg('rating');
    @endphp
    @if($rating > 0)
        <!-- Product Rating -->
        <div class="flex items-center text-yellow-500">
            @for ($i = 1; $i <= 5; $i++)
                @if ($rating >= $i)
                    <!-- Full star -->
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path>
                    </svg>
                @elseif (is_float($rating) && round($rating) == $i)
                    <!-- Half star -->
                    <svg class="w-5 h-5">
                        <path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z" fill="currentColor" stroke="currentColor;" stroke-width="2" style="clip-path: inset(0 50% 0 0);" viewBox="0 0 20 20"></path>
                        <path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z" fill="grey" style="clip-path: inset(0 0 0 50%);"/>
                    </svg>
                @else
                    <!-- Empty star -->
                    <svg class="w-5 h-5" fill="grey" viewBox="0 0 21 21">
                        <path d="M9.049 2.927C9.432 2.119 10.568 2.119 10.951 2.927L12.9 7.015L17.506 7.634C18.356 7.758 18.699 8.802 18.1 9.363L14.648 12.576L15.405 17.185C15.535 18.041 14.585 18.665 13.868 18.168L10 15.866L6.132 18.168C5.415 18.665 4.465 18.041 4.595 17.185L5.352 12.576L1.9 9.363C1.301 8.802 1.644 7.758 2.494 7.634L7.1 7.015L9.049 2.927Z"></path>
                    </svg>
                @endif
            @endfor
        </div>
        <span class="text-gray-600">{{ round($rating, 1) }}/5</span>
    @endif
    </div>
    <div class="flex items-center justify-between">
        <div class="font-bold text-lg">{{ $product->price }}€</div>
        <a class="bg-green-900 text-white px-3 py-2 rounded-lg font-semibold text-sm hover:bg-black" href="{{ route('product-page', ['id' => $product->id]) }}">Show</a>
    </div>
</article>
