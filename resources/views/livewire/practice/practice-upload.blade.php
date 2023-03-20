<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.uploadpage_title') }}
        </h2>
</x-slot>


<form wire:submit.prevent="add" class="flex flex-col lg:flex-row px-4 mb-4">
    <div class="flex flex-start w-full lg:w-1/2 flex-col lg:mb-6">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <x-label for="title" value="{{ __('Title') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="title" type="text" class="border-gray-300" wire:model.delay.500ms="title"  />
            <x-input-error for="title" class="mt-2" />

        <x-label for="description" value="{{ __('Description') }}" class="my-4 mr-8 flex flex-col"/>
            <textarea class="border-gray-300 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.delay.500ms="description"></textarea>

            <div class="mt-4">
                <button wire:click.prevent="$toggle('showDropdown')" class="w-1/3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 my-6 rounded items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.add_category') }}</button>

            @if($showDropdown)
                <div class="h-48 overflow-auto w-1/2">
                    <table class="text-sm text-left text-gray-500">
                        <tbody>
                            @foreach($all_categories as $category)
                                <tr class="bg-white border-b hover:bg-gray-50 ">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                        <input wire:model="add_categories" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" value="{{ $category->id }}" >
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $category->title }}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            @endif
        </div>

        <input type="file" accept="application/pdf"  wire:model="file" class="my-4" />
        @error('file.*') <span class="error">{{ $message }}</span> @enderror
        <button type="submit" class="w-1/3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.add_practice') }}</button>
    </div>
    @if($file)
        <iframe class="flex flex-end mb-px ml-8" src="{{ $file->temporaryUrl() }}#view=Fit" height="600" width="90%"></iframe>
    @else
        <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.preview') }}</p>
    @endif
</form>