<ul class="list-disc ps-5 space-y-2">
    <li><a wire:navigate href="{{ route('profile-page') }}">My Account</a></li>
    @if(auth()->user()->isSupplier())
        <li><a wire:navigate href="{{ route('supplier-orders-page') }}">Customer orders</a></li>
        <li><a wire:navigate href="{{ route('supplier-products-page') }}">List Products</a></li>
        <li><a wire:navigate href="{{ route('supplier-reviews-page') }}">Reviews</a></li>
    @endif
    <li><a wire:navigate href="{{ route('customer-orders-page') }}">Order History</a></li>
</ul>
