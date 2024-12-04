<div class="container mx-auto px-4">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-10">
            <div class="px-4 py-8 bg-white shadow rounded-lg">
                <h1 class="mb-4 font-bold text-xl xl:text-2xl">Profile</h1>
                <ul class="ps-4 list-disc">
                    <li>Name: {{ $user->name }}</li>
                    <li>Email: {{ $user->email }}</li>
                    <li>Phone: {{ $user->phone }}</li>
                    <li>Address: {{ $user->address }}</li>
                </ul>
                <button @click="$dispatch('openModal', { component: 'auth.modal.edit-profile' })" class="inline-block mt-4 rounded-md py-2 px-5 bg-green-500 text-white">Edit</button>
            </div>
        </div>
        <aside class="col-span-2 px-4 py-8 bg-white shadow rounded-lg">
            <x-sidebar />
        </aside>
    </div>
</div>
