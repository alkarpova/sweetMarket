<nav x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false" class="flex items-center justify-between bg-white border-b border-neutral-300 px-6 py-4" aria-label="sweetMarket menu">
    <!-- Brand Logo -->
    <a href="{{ route('home-page') }}" class="text-2xl font-bold text-neutral-900">
        <span>SweetMarket</span>
    </a>
    <!-- Desktop Menu -->
    <ul class="hidden items-center gap-4 md:flex">
        <li><a wire:navigate href="{{ route('home-page') }}" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Home</a></li>
        <li>
            <button @click="$dispatch('openModal', { component: 'contact.modal.add-record' })" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Contact</button>
        </li>
        <li class="relative">
            <livewire:components.cart />
        </li>
        @auth
            <li><a wire:navigate href="{{ route('profile-page') }}" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">My Account</a></li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <li><button type="submit" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Logout</button></li>
            </form>
        @else
            <li><a wire:navigate href="{{ route('login-page') }}" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Login</a></li>
            <li><a wire:navigate href="{{ route('register-page') }}" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Register</a></li>
        @endauth
    </ul>
    <!-- Mobile Menu Button -->
    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen" :class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button" class="flex text-neutral-600 md:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
        <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <!-- Mobile Menu -->
    <ul
        x-cloak
        x-show="mobileMenuIsOpen"
        x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:enter-start="-translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="-translate-y-full"
        id="mobileMenu"
        class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col divide-y divide-neutral-300 rounded-b-md border-b border-neutral-300 bg-neutral-50 px-6 pb-6 pt-20 md:hidden"
    >
        <li class="py-4"><a wire:navigate href="{{ route('home-page') }}" class="w-full text-lg font-medium text-neutral-600 focus:underline">Home</a></li>
        <li>
            <button @click="$dispatch('openModal', { component: 'contact.modal.add-record' })" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Contact</button>
        </li>
        <li class="relative">
            <livewire:components.cart />
        </li>
        @auth
            <li><a wire:navigate href="{{ route('profile-page') }}" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">My Account</a></li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <li><button type="submit" class="font-medium text-neutral-600 underline-offset-2 hover:text-black focus:outline-none focus:underline">Logout</button></li>
            </form>
        @else
            <li class="py-4"><a wire:navigate href="{{ route('login-page') }}" class="w-full text-lg font-medium text-neutral-600 focus:underline" wire:navigate>Login</a></li>
            <li class="py-4"><a wire:navigate href="{{ route('register-page') }}" class="w-full text-lg font-medium text-neutral-600 focus:underline" wire:navigate>Register</a></li>
        @endauth
    </ul>
</nav>
