<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.editpage_title') }}
        </h2>
</x-slot>

<form wire:submit.prevent="update_practice" class="flex px-4">
    <div class="flex flex-start w-1/2 flex-col">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <x-label for="title" value="{{ __('Title') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="title" type="text" class="w-3/4" wire:model.delay.500ms="title" value="{{$title}}" />
            <x-input-error for="title" class="mt-2" />

        <x-label for="description" value="{{ __('Description') }}" class="my-4 mr-8 flex flex-col"/>
            <textarea class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.delay.500ms="description">{{ $description }}</textarea>

        <div class="mt-4">
                <button wire:click.prevent="$toggle('showDropdown')" class="w-1/3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.category') }}</button>

            @if($showDropdown)
                <table class="w-1/2 text-sm text-left text-gray-500 border-gray-300">
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
            @endif
        </div>

        <x-label for="file" value="{{ __('File') }}" class="my-4 mr-8 flex flex-col"/>
        <input type="file" wire:model="new_file">
        @error('new_file.*') <span class="error">{{ $message }}</span> @enderror
        <p class="text-sm text-gray-700 font-medium my-4">{{ __('practicepage.current_filename') }}: {{ $original_file_name }} </p>
        <button type="submit" class="w-1/3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.update_practice') }}</button>
    </div>
    @if($new_file)
        <div class="flex flex-col">
            <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.new_file') }} : </p>
            <iframe class="flex flex-end mb-px ml-8" src="{{ $new_file->temporaryUrl() }}#view=Fit" width="500" style="height:70vh;"></iframe>
        </div>
    @else
        <div class="flex flex-col">
            <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.current_file') }} : </p>
            <iframe src="{{$original_file}}#view=Fit" width="500" style="height:70vh;"></iframe>
        </div>
    @endif
</form>