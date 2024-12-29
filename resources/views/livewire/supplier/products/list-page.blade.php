<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6 items-start">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h1 class="font-bold text-xl xl:text-2xl">List Products</h1>
                    <div class="flex flex-col items-end gap-2">
                        @if(auth()->user()->country_id && auth()->user()->city_id && auth()->user()->region_id)
                            <a href="{{ route('supplier-products-create-page') }}" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg">Add Product</a>
                        @else
                            <p class="text-red-500">Please complete your profile to add products</p>
                            <a href="{{ route('profile-page') }}" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg">Complete Profile</a>
                        @endif
                    </div>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Product name</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Minimum</th>
                                <th class="px-6 py-3">Quantity</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Modified</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->products as $product)
                                <tr class="odd:bg-white even:bg-gray-50 border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        @if($product->status === \App\Enums\ProductStatus::Published)
                                            <a wire:navigate href="{{ route('product-page', $product->id) }}" class="text-blue-500">{!! $product->name !!}</a>
                                        @else
                                            {{ $product->name }}
                                        @endif
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $product->price }}€
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->minimum }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->status->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->updated_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a wire:navigate href="{{ route('supplier-products-edit-page', ['product' => $product->id]) }}" class="text-blue-500">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4" colspan="7">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $this->products->links() }}
                </div>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
