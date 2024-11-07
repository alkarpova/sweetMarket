<a class="flex flex-col bg-white rounded-lg p-3 space-y-4" href="{{ route('product-page', ['id' => $product->id]) }}">
    <div class="bg-neutral-200 rounded-lg h-[200px]"></div>
    <div class="flex-1 space-y-4">
        <div class="font-bold">{{ $product->name }}</div>
        <div>{{ $product->user->name }}</div>
        <p>{{ $product->short_description }}</p>
    </div>
    <div class="flex items-center justify-between">
        <div class="font-bold text-lg">{{ $product->price }}€</div>
        <button class="bg-blue-700 text-white px-3 py-1 rounded-lg">Add to cart</button>
    </div>
</a>
