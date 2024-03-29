<form wire:submit.prevent="edit">
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.update') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50">
            <x-label for="title" value="{{ __('categorypage.title') }}" class="my-4 mr-8 flex flex-col"/>
                <x-input id="title" type="text" class="w-3/4" wire:model="title" value="{{$title}}" />
                <x-input-error for="title" class="mt-2" />
            <x-label for="description" value="{{ __('categorypage.description') }}" class="my-4 mr-8 flex flex-col"/>
            <div wire:ignore>
                <textarea id="description" class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="description">{{ $description }}</textarea>
            </div>
                <x-input-error for="description" class="mt-2" />
    </div>
   <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">{{ __('categorypage.update') }}
        </button>
    </div>
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
</script>