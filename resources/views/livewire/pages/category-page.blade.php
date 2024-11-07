<main class="container mx-auto px-5 my-5">
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-3">
            @if($themes)
                <select id="theme" wire:model.live="selectedThemes" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                    <option value="" selected>Все темы</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="col-span-9 space-y-4">
            <header>
                <h1 class="font-bold text-2xl">{{ $category->name }}</h1>
            </header>
            <div class="grid grid-cols-3 gap-4">
                @foreach($products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div>
            {{ $products->links() }}
        </div>
    </div>
</main>
