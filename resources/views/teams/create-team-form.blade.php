<x-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('teamsettingspage.team_details_title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('teamsettingspage.team_details_description') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-label value="{{ __('teamsettingspage.team_owner') }}" />

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">

                <div class="ml-4 leading-tight">
                    <div class="text-gray-900">{{ $this->user->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('teamsettingspage.team_name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('teamsettingspage.create') }}
        </x-button>
    </x-slot>
</x-form-section>
<x-slot name="footer">
        @livewire('footer')
</x-slot>
