<form wire:submit.prevent="update_categories">
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_category') }}</p>
    @foreach($all_categories as $category)
        <div class="flex flex-col px-6 py-2 bg-gray-50">
            <div>
                <label>
                    <input wire:model="categories" value="{{ $category->id }}" type="checkbox" />
                    @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
                    {{$category->id}} : {{ $category->title }}
                </label>
            </div>
        </div>
    @endforeach
    <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.add') }}
        </button>
    </div>
</form>