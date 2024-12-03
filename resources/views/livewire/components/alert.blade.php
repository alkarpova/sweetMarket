<div
    x-data="{ visible: @entangle('visible') }"
    x-show="visible"
    x-init="setTimeout(() => visible = false, 3000)"
    x-transition
    class="fixed top-20 right-5 z-50"
    style="display: none;"
>
    <div class="p-4 rounded-lg shadow-lg {{ $this->alertClasses }}">
        <p>{{ $message }}</p>
    </div>
</div>
