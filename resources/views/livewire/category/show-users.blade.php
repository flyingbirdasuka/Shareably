@if($users)
    <div class="flex flex-col">
        <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_practice') }}</p>
        @foreach($users as $user)
            <div class="flex px-6 py-2 bg-gray-50 justify-between border-b items-center">
                    <p class=>{{ $user->name }}</p>
                    <button wire:click.prevent="delete_user({{$user->id}})" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.remove') }}</button>
            </div>
        @endforeach
        <button wire:click="$emit('closeModal')" class="py-4">{{ __('categorypage.close') }}</button>
    </div>
@endif