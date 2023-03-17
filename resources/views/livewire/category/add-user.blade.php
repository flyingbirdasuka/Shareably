<form wire:submit.prevent="add">
    <div>
        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_user') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50">
        <div>
            <x-label for="email" value="{{ __('Email') }}" class="my-4 mr-8 flex flex-col"/>
                <x-input id="email" type="email" class="w-3/4" wire:model.delay.500ms="email" value="{{$email}}" />
                <x-input-error for="email" class="mt-2" />

        </div>
    </div>
   <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.add_user') }}
        </button>
    </div>
</form>