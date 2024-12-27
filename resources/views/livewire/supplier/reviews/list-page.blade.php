<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">Reviews</h1>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-left rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Order</th>
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->reviews as $review)
                                <tr class="odd:bg-white even:bg-gray-50 border-b">
                                    <td class="px-6 py-4">{{ $review->order->number }}</td>
                                    <td class="px-6 py-4">
                                        @if($review->product)
                                            @if($review->product->status === \App\Enums\ProductStatus::Published)
                                                <a wire:navigate href="{{ route('product-page', $review->product->id) }}" class="text-blue-600">{{ $review->product->name }}</a>
                                            @else
                                                {{ $review->product->name }}
                                            @endif
                                        @else
                                            <span class="text-gray-500">Product not available</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $review->user->name }}</td>
                                    <td class="px-6 py-4">{{ $review->rating }}</td>
                                    <td class="px-6 py-4">{{ $review->comment }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $this->reviews->links() }}
                </div>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
