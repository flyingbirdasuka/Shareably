@if($users)
    <div class="flex flex-col">
        <p class="font-semibold text-gray-800 p-6">{{ __('teamspage.show_users') }}</p>
        @foreach($users as $user)
            <div class="flex px-6 py-2 bg-gray-50 justify-between border-b items-center">
                    <p class=>{{ $user->id }}</p>
                    <p class=>{{ $user->name }}</p>
                    <button class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded"><a href="/users/{{$user->id}}">{{ __('teamspage.detail') }}</a></button>
            </div>
        @endforeach
        <button wire:click="$emit('closeModal')" class="py-4">{{ __('teamspage.close') }}</button>
    </div>
@endif