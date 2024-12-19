<div>
    <div class="border-b py-3 px-5 font-bold text-xl">Add Review</div>
    <form wire:submit.prevent="send">
        <div class="border-b py-5 px-5 space-y-4">
            <div class="space-y-2">
                <label for="supplier" class="font-bold">
                    Supplier
                </label>
                <div>
                    {{ $this->supplier->name }}
                </div>
            </div>
            <div class="space-y-2">
                <label for="rating" class="font-bold">
                    Rating
                    <span class="text-red-600">*</span>
                </label>
                <select wire:model="rating" id="rating" class="block w-full border" required>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <div class="text-red-500">@error('rating') {{ $message }} @enderror</div>
            </div>
            <div class="space-y-2">
                <label for="comment" class="font-bold">Comment</label>
                <textarea wire:model="comment" id="comment" class="block w-full h-32 border"></textarea>
                <div class="text-red-500">@error('comment') {{ $message }} @enderror</div>
            </div>
        </div>
        <div class="py-3 px-5 flex items-center justify-between flex-wrap gap-4">
            <button type="submit" class="inline-block rounded-md py-2 px-5 bg-green-500 text-white">Send</button>
        </div>
    </form>
</div>
