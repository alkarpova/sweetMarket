<main class="container mx-auto px-5 my-5">
    <div class="grid lg:grid-cols-12 gap-12">
        <aside class="col-span-3 space-y-4">
            @if($this->regions)
                <div>
                    <label for="regions" class="font-semibold">Regions</label>
                    <select id="region" wire:model.live="selectedRegion" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                        <option value="" selected>All regions</option>
                        @foreach($this->regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if($this->cities)
                <div>
                    <label for="cities" class="font-semibold">Cities</label>
                    <select id="city" wire:model.live="selectedCity" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                        <option value="" selected>All cities</option>
                        @foreach($this->cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if($this->themes)
                <div>
                    <label for="themes" class="font-semibold">Themes</label>
                    <select id="theme" wire:model.live="selectedThemes" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                        <option value="" selected>All themes</option>
                        @foreach($this->themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if($this->suppliers)
                <div>
                    <label for="suppliers" class="font-semibold">Suppliers</label>
                    <select id="supplier" wire:model.live="selectedSupplier" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                        <option value="" selected>All suppliers</option>
                        @foreach($this->suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div>
                <label for="priceRange" class="font-semibold">Price range</label>
                <select wire:model.live="selectedPriceRange" id="priceRange" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                    <option value="">All</option>
                    @foreach($this->priceRanges() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="weightRange" class="font-semibold">Weight range</label>
                <select wire:model.live="selectedWeightRange" id="weightRange" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300">
                    <option value="">All</option>
                    @foreach($this->weightRanges() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </aside>
        <div class="col-span-9 space-y-6">
            <header>
                <h1 class="font-bold text-2xl lg:text-3xl">{{ $this->record->name }}</h1>
            </header>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($this->products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div>
            {{ $this->products->links() }}
        </div>
    </div>
</main>
