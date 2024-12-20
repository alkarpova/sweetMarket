<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">Profile</h1>
                <ul class="ps-4 list-disc">
                    <li>Name: {{ $user->name }}</li>
                    <li>Email: {{ $user->email }}</li>
                    @if($user->phone)
                        <li>Phone: {{ $user->phone }}</li>
                    @endif
                    @if($user->country)
                        <li>Country: {{ $user->country->name }}</li>
                    @endif
                    @if($user->region)
                        <li>Region: {{ $user->region->name }}</li>
                    @endif
                    @if($user->city)
                        <li>City: {{ $user->city->name }}</li>
                    @endif
                    @if($user->address)
                        <li>Address: {{ $user->address }}</li>
                    @endif
                </ul>
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <button @click="$dispatch('openModal', { component: 'auth.modal.edit-profile' })" class="inline-block mt-4 rounded-md py-2 px-5 bg-green-500 text-white">Edit</button>
                    <button wire:click.prevent="deleteProfile" type="button" class="px-4 py-2 font-semibold text-white bg-red-500 rounded-lg">Delete Profile</button>
                </div>
                @if(auth()->user()->isSupplier() && !auth()->user()->hasProfileFields())
                    <div class="mt-4 bg-gray-50 p-5 text-red-500">
                        <p class="font-bold">
                            If you want to add products, you need to fill these profile fields:
                        </p>
                        <ul class="list-disc ps-4">
                            <li>Country</li>
                            <li>Region</li>
                            <li>City</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
