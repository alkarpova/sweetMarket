<div>
    <div class="border-b py-3 px-5 font-bold text-xl">Send Message</div>
    <form wire:submit.prevent="send">
        <div class="border-b py-5 px-5 space-y-4">
            <div class="space-y-2">
                <label for="topic" class="font-bold">Topic</label>
                <select wire:model="topic" id="topic" class="block w-full border py-2 px-3">
                    @foreach($this->topics as $topic)
                        <option value="{{ $topic->value }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <div class="text-red-500">@error('topic') {{ $message }} @enderror</div>
            </div>
            <div class="space-y-2">
                <label for="name" class="font-bold">Name</label>
                <input wire:model="name" id="name" class="block w-full border py-2 px-3" />
                <div class="text-red-500">@error('name') {{ $message }} @enderror</div>
            </div>
            <div class="space-y-2">
                <label for="email" class="font-bold">Email</label>
                <input wire:model="email" id="email" class="block w-full border py-2 px-3" />
                <div class="text-red-500">@error('email') {{ $message }} @enderror</div>
            </div>
            <div class="space-y-2">
                <label for="comment" class="font-bold">Comment</label>
                <textarea wire:model="comment" id="comment" class="block w-full h-32 border py-2 px-3"></textarea>
                <div class="text-red-500">@error('comment') {{ $message }} @enderror</div>
            </div>
        </div>
        <div class="py-3 px-5 flex items-center justify-between flex-wrap gap-4">
            <button type="submit" class="inline-block rounded-md py-2 px-5 bg-green-500 text-white">Send</button>
        </div>
    </form>
</div>
