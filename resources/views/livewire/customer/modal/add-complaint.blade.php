<div>
    <div class="border-b py-3 px-5 font-bold text-xl">Add Complaint</div>
    <form wire:submit.prevent="send">
        <div class="border-b py-5 px-5 space-y-4">
            <div class="space-y-2">
                <label for="supplier" class="font-bold">Supplier</label>
                <select wire:model="supplier" id="supplier" class="block w-full border" required>
                    <option value="">Select supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier['id'] }}">{{ $supplier['name'] }}</option>
                    @endforeach
                </select>
                <div class="text-red-500">@error('supplier') {{ $message }} @enderror</div>
            </div>
            <div class="space-y-2">
                <label for="comment" class="font-bold">Comment</label>
                <textarea wire:model="comment" id="comment" class="block w-full h-32 border" required></textarea>
                <div class="text-red-500">@error('comment') {{ $message }} @enderror</div>
            </div>
        </div>
        <div class="py-3 px-5 flex items-center justify-between flex-wrap gap-4">
            <button type="submit" class="inline-block rounded-md py-2 px-5 bg-green-500 text-white">Send</button>
        </div>
    </form>
</div>
