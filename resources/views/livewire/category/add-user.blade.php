<form wire:submit.prevent="add">
    <div>
        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        Email:
        <input type="email" wire:model.delay.500ms="email" />
        @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <button type="submit" class="border-solid border-2 border-indigo-600 py-4">Add Member</button>
</form>