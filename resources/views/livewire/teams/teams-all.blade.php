<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('teamspage.title') }}
        </h2>
</x-slot>
<div class="pb-10">
    <div class="mt-4 pb-3 flex justify-between z-1 px-2">
        <div class="relative w-1/2">
            <div class="flex absolute inset-y-0 items-center pl-3">
                <i class="fa-solid fa-magnifying-glass" style="color:gray;"></i>
            </div>
            <input wire:model.delay.500ms="search" type="search" class="p-4 pl-10 w-full text-sm bg-gray-50 rounded-lg  border-gray-300 focus:border-indigo-500" placeholder="{{ __('teamspage.search') }}">
        </div>
    </div>
<x-table>
    <x-table-head>
        <x-table-heading>{{ __('teamspage.name') }}</x-table-heading>
        <x-table-heading>{{ __('teamspage.users') }}</x-table-heading>
    </x-table-head>
    <x-table-body>
        @foreach($teams as $team)
            <x-table-row>
                <x-table-data><a href="/teams/{{ $team->id }}">{{ $team->name }}</a></x-table-data>
                <x-table-data><button wire:click.prevent="$emit('openModal', 'teams.show-users', {{ json_encode(['team_id' => $team->id ]) }})" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('teamspage.show_users')}}</button></x-table-data>
            </x-table-row>
        @endforeach
    </x-table-body>
</x-table>

</div>