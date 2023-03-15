<form wire:submit.prevent="add">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_category') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50">
        <label class="flex-col flex w-full">
            {{ __('categorypage.title') }}:
                <input type="text" wire:model.delay.500ms="title" />
                @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
        </label>
        <label class="flex-col flex w-full">
            {{ __('categorypage.description') }}:
            <textarea wire:model.delay.500ms="description"></textarea>
                @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
        </label>
    </div>
    <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-blue-500 rounded">{{ __('categorypage.add_category') }}
        </button>
    </div>
</form>
