<nav class="container mx-auto px-5 my-4">
    <div class="grid grid-cols-6 gap-4">
        @foreach($this->categories as $category)
            <a
                class="flex items-center justify-center gap-4 px-5 py-3 rounded-lg font-semibold hover:bg-green-900 hover:hover:text-white {{ $this->isActiveCategory($category->id) ? 'bg-green-900 text-white' : 'bg-white' }}"
                href="{{ route('category-page', ['id' => $category->id]) }}"
                wire:navigate
            >
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>
