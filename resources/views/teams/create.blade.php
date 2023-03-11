<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('teamsettingspage.create_team') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.create-team-form')
        </div>
    </div>
    <x-slot name="footer">
        @livewire('footer')
    </x-slot>
</x-app-layout>
