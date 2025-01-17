<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">List Orders</h1>
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr class="text-left">
                            <th class="px-4 py-2 border">Number</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Created At</th>
                            <th class="px-4 py-2 border"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($this->orders as $item)
                        <tr>
                            <td class="px-4 py-2 border">
                                <a wire:navigate href="{{ route('customer-orders-view-page', $item->id) }}" class="text-blue-500"> {{ $item->number }}</a>
                            </td>
                            <td class="px-4 py-2 border">{{ $item->total }}€</td>
                            <td class="px-4 py-2 border">{{ $item->status->name }}</td>
                            <td class="px-4 py-2 border">{{ $item->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-2 border">
                                <a wire:navigate href="{{ route('customer-orders-view-page', $item->id) }}" class="text-blue-500">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-2 border" colspan="6">No data available</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $this->orders->links() }}
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
