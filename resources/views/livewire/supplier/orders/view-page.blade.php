<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">View Order</h1>

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
