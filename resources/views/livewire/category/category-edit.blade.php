<form wire:submit.prevent="edit">
    <div>
        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.update') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50">
            <x-label for="title" value="{{ __('Title') }}" class="my-4 mr-8 flex flex-col"/>
                <x-input id="title" type="text" class="w-3/4" wire:model.delay.500ms="title" value="{{$title}}" />
                <x-input-error for="title" class="mt-2" />
            <x-label for="description" value="{{ __('Description') }}" class="my-4 mr-8 flex flex-col"/>
                <textarea class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.delay.500ms="description">{{ $description }}</textarea>
                <x-input-error for="description" class="mt-2" />
    </div>
   <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.update') }}
        </button>
    </div>
</form>