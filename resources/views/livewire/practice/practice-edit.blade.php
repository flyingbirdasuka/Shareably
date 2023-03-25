<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.editpage_title') }}
        </h2>
</x-slot>

<form wire:submit.prevent="update_practice" class="flex flex-col lg:flex-row px-4 mb-4">
    <div class="flex flex-start flex-col w-full lg:w-1/2 lg:mb-6">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <x-label for="title" value="{{ __('Title') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="title" type="text" class="border-gray-300" wire:model.delay.500ms="title" value="{{$title}}" />
            <x-input-error for="title" class="mt-2" />

        <x-label for="description" value="{{ __('Description') }}" class="my-4 mr-8 flex flex-col"/>
        <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.delay.500ms="description">{{ $description }}</textarea>

        <x-label for="video_id" value="{{ __('Video ID') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="video_id" type="text" class="border-gray-300" wire:model.delay.500ms="video_id"  />
            <x-input-error for="video_id" class="mt-2" />

        <div class="mt-4">
                <button wire:click.prevent="$toggle('showDropdown')" class="w-1/3 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.category') }}</button>

            @if($showDropdown)
                <div class="h-48 overflow-auto w-1/2">
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
                </div>
            @endif

            <x-input-error for="add_categories" class="mt-2" />

            <x-label for="new_music" value="{{ __('Music') }}" class="my-4 mr-8 flex flex-col"/>
                <input id="new_music" type="file" accept="audio/*" wire:model="new_music"/>
                <x-input-error for="new_music" class="mt-2" />
            @if($new_music)
                <audio controls controlslist="nodownload" src="{{ $new_music->temporaryUrl() }}" class="mt-4"></audio>
            @else
            <audio controls controlslist="nodownload" src="{{ $original_music }}" class="mt-4"></audio>
            @endif
        </div>


        <x-label for="file" value="{{ __('File') }}" class="my-4 mr-8 flex flex-col"/>
        <input type="file" accept="application/pdf" wire:model="new_file">
        @error('new_file.*') <span class="error">{{ $message }}</span> @enderror
        <p class="text-sm text-gray-700 font-medium my-4">{{ __('practicepage.current_filename') }}: {{ $original_file_name }} </p>
        <button type="submit" class="w-1/3 bg-indigo-500 hover:bgindigo-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.update_practice') }}</button>
    </div>
    @if($new_file)
        <div class="flex flex-col flex justify-center lg:flex-end">
            <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.new_file') }} : </p>
            <iframe class="flex flex-end mb-px ml-8" src="{{ $new_file->temporaryUrl() }}#view=Fit" height="100%" width="90%"></iframe>
        </div>
    @else
        <div class="flex flex-col justify-center lg:flex-end lg:items-center">
            <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.current_file') }} : </p>
            <iframe src="{{$original_file}}#view=Fit" height="600" width="90%"></iframe>
        </div>
    @endif
</form>