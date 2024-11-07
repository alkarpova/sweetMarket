<nav class="container mx-auto px-5">
    <div class="grid grid-cols-4 gap-4">
        @foreach($categories as $category)
            <a
                class="flex items-center gap-4 px-5 py-3 bg-white rounded-lg"
                href="{{ route('category-page', ['slug' => $category->slug]) }}"
                wire:navigate
            >
                <div class="bg-neutral-200 rounded-lg size-14"></div>
                <div>
                    <div class="font-bold">{{ $category->name }}</div>
                </div>
            </a>
        @endforeach
    </div>
</nav>
