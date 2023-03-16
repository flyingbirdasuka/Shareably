<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.uploadpage_title') }}
        </h2>
</x-slot>


<form wire:submit.prevent="add" class="flex">
    <div class="flex flex-start w-1/2 flex-col">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <x-label for="title" value="{{ __('Title') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="title" type="text" class="w-3/4" wire:model.delay.500ms="title"  />
            <x-input-error for="title" class="mt-2" />

        <x-label for="description" value="{{ __('Description') }}" class="my-4 mr-8 flex flex-col"/>
            <textarea class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.delay.500ms="description"></textarea>

        @foreach($all_categories as $category)
            <label>
                <input wire:model="add_categories" value="{{ $category->id }}" type="checkbox" />
                {{$category->id}}{{ $category->title }}
            </label>
        @endforeach

        <input type="file" wire:model="file" class="my-4" />
        @error('file.*') <span class="error">{{ $message }}</span> @enderror
        <button type="submit" class="w-1/3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.add_practice') }}</button>
    </div>
    @if($file)
        <iframe class="flex flex-end mb-px ml-8" src="{{ $file->temporaryUrl() }}#view=Fit" width="500" style="height:70vh;"></iframe>
    @else
        <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.preview') }}</p>
    @endif
</form>