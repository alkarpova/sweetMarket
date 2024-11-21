<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6 items-start">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h1 class="font-bold text-xl xl:text-2xl">List Products</h1>
                    <a href="{{ route('supplier-products-create-page') }}" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg">Add Product</a>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Product name</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Minimum</th>
                                <th scope="col" class="px-6 py-3">Maximum</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this->products as $product)
                                <tr class="odd:bg-white even:bg-gray-50 border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {!! $product->name !!}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $product->price }}€
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->minimum }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->maximum }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('supplier-products-edit-page', ['product' => $product->id]) }}" class="text-blue-500">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $this->products->links() }}
                </div>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <ul class="list-disc ps-5 space-y-2">
                <li><a href="{{ route('supplier-profile-page') }}">Profile</a></li>
                <li><a href="{{ route('supplier-orders-page') }}">List Orders</a></li>
                <li><a href="{{ route('supplier-products-page') }}">List Products</a></li>
            </ul>
        </aside>
    </div>
</div>
