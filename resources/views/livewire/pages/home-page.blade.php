<main>
    <div class="container mx-auto px-5 pb-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->products as $product)
                <x-product.card :product="$product" />
            @endforeach
        </div>
    </div>
</main>
