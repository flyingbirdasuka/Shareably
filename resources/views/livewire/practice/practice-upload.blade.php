<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.uploadpage_title') }}
        </h2>
</x-slot>

<form wire:submit.prevent="add" class="flex flex-col lg:flex-row px-4 mb-4">
    <div class="flex flex-start flex-col w-full lg:w-1/2 lg:mb-6">
        <x-label for="title" value="{{ __('practicepage.title') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="title" type="text" class="border-gray-300" wire:model.defer="title" />
            <x-input-error for="title" class="mt-2" />

        <x-label for="description" value="{{ __('practicepage.description') }}" class="my-4 mr-8 flex flex-col"/>
            <div wire:ignore>
                <textarea id="description" class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="description">
                </textarea>
            </div>

        <x-label for="video_id" value="{{ __('practicepage.video_id') }}" class="my-4 mr-8 flex flex-col"/>
            <x-input id="video_id" type="text" class="border-gray-300" wire:model="video_id" />
            <x-input-error for="video_id" class="mt-2" />
            @if($video_id)
            <div class="col-span-6 sm:col-span-4">
                <x-label for="video_type" value="{{ __('practicepage.video_type') }}"/>
                <label class="mx-1">
                    <input type="radio" wire:model="video_type" value="1">
                    {{ __('practicepage.google_drive') }}
                </label>
                <label class="mx-1">
                    <input type="radio" wire:model="video_type" value="2">
                    {{ __('practicepage.youtube') }}
                </label>
                <x-input-error for="video_type" class="mt-2" />
            </div>
            @endif
            <div class="mt-4">
                <button wire:click.prevent="$toggle('showDropdown')" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 my-6 rounded items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.add_category') }}</button>

            @if($showDropdown)
                <div class="h-48 overflow-auto w-1/2">
                    <table class="text-sm text-left text-gray-500">
                        <tbody>
                            @foreach($all_categories as $category)
                                <tr class="bg-white border-b hover:bg-gray-50 ">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                        <input wire:model.defer="add_categories"  type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" value="{{ $category->id }}" >
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $category->title }}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <x-input-error for="add_categories" class="mt-2" />

            <x-label for="music" value="{{ __('practicepage.music') }}" class="my-4 mr-8 flex flex-col"/>
                <input id="music" type="file" accept="audio/*" wire:model.defer="music" />
                <x-input-error for="music" class="mt-2" />
            @if($music)
                <div class="flex">
                    <audio controls controlslist="nodownload" src="{{ $music->temporaryUrl() }}" class="mt-4"></audio>
                    <span style="cursor:pointer;color:red;" onclick="removeMusic()" x-on:click="$wire.set('music', '')" >X</span>
                </div>
            @endif
        </div>
        <x-label for="file" value="{{ __('practicepage.pdf_file') }}" class="my-2 mr-8 flex flex-col"/>
        <input type="file" accept="application/pdf" wire:model.defer="file" />
        <x-input-error for="file" class="mt-2" />
        <button type="submit" class="w-1/2 md:w-1/3 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 my-6 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('practicepage.add_practice') }}</button>
        <div wire:loading>
        {{ __('practicepage.uploading') }}
        </div>
    </div>
    @if($file)
        <div class="container flex flex-col justify-center items-center h-screen w-full mx-2 lg:w-1/2 lg:h-screen mb-4">
            <iframe class="flex mb-px ml-8" src="{{ $file->temporaryUrl() }}#view=Fit" style="height:100vh; width:90%;"></iframe>
        </div>
    @else
        <p class="text-sm text-gray-700 font-medium mt-4">{{ __('practicepage.preview') }}</p>
    @endif
</form>
<script>
    tinymce.init({
        selector: '#description',
        menubar: false,
        toolbar: [
            { name: 'styles', items: [ 'styles' ] },
        ],
        style_formats: [
            { title: 'Headers', items: [
                { title: 'Heading 2', block: 'h2' },
                { title: 'Heading 3', block: 'h3' },
                { title: 'Heading 4', block: 'h4' },
                { title: 'Heading 5', block: 'h5' },
                { title: 'Heading 6', block: 'h6' }
            ]
            },
            { title: 'Inline', items: [
                { title: 'Bold', block: 'b' },
                { title: 'Italic', block: 'i' },
                { title: 'Underline', block: 'u' },
                { title: 'Strikethrough', block: 's' }
            ]
            },
        ],
        setup: function (editor) {
            editor.on('change', function (e) {
                @this.set('description', editor.getContent());
            });
        }
    });

    function removeMusic(){
        music.value = music.defaultValue;
    }
</script>