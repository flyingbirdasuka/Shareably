@if($all_practices)
    <form wire:submit.prevent="update_practice">
        <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_practice') }}</p>
        @foreach($all_practices as $practice)
            <div class="flex flex-col px-6 py-2 bg-gray-50">
                <div>
                    <label>
                        <input wire:model="add_practice" value="{{ $practice->id }}" type="checkbox" />
                        @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
                        {{$practice->id}} : {{ $practice->title }}
                    </label>
                </div>
            </div>
        @endforeach
        <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-blue-500 rounded">{{ __('categorypage.add') }}
        </button>
    </div>
    </form>



@endif