<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('userspage.title') }}
        </h2>
</x-slot>
<div class="pb-10">
    <div class="mt-4 pb-3 flex justify-between z-1 px-2">
        <div class="relative w-1/2">
            <div class="flex absolute inset-y-0 items-center pl-3">
                <i class="fa-solid fa-magnifying-glass" style="color:gray;"></i>
            </div>
            <input wire:model.delay.500ms="search" type="search" class="p-4 pl-10 w-full text-sm bg-gray-50 rounded-lg  border-gray-300 focus:border-indigo-500" placeholder="Search">
        </div>
    </div>
    <x-table>
        <x-table-head>
            <x-table-heading></x-table-heading>
            <x-table-heading>Name</x-table-heading>
            <x-table-heading>Email</x-table-heading>
            <x-table-heading></x-table-heading>
        </x-table-head>
        <x-table-body>
        
        @forelse ($users as $user)
        <x-table-row>
            <x-table-data>
                <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
            </x-table-data>
            <x-table-data><b><a href="users/{{$user->id}}">{{ $user->name }}</a></b></x-table-data>
            <x-table-data><b><a href="users/{{$user->id}}"> {{ $user->email }}</a></b></x-table-data>
            <x-table-data>
                <button wire:click.prevent="$emit('openModal', 'users.remove-user', {{ json_encode(['user_id' => $user->id ]) }})" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('userspage.remove') }}</button>
            </x-table-data>
        </x-table-row>    
        @empty
            <x-table-row>
                <td colspan="4" class="px-6 py-4 text-center"><b>{{ __('userspage.no_user') }}</b></td>
            </x-table-row>
        @endforelse
        </x-table-body>
    </x-table>
</div>