<form wire:submit.prevent="add">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        {{ __('categorypage.title') }}:
        <input type="text" wire:model.delay.500ms="title" />
        @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label>
        {{ __('categorypage.description') }}:
        <textarea wire:model.delay.500ms="description"></textarea>
    </label>
    <button type="submit" class="border-solid border-2 border-indigo-600 py-4">{{ __('categorypage.add_category') }}</button>
    <button wire:click="$emit('closeModal')">{{ __('categorypage.close') }}</button>
</form>