<x-action-section>
    <x-slot name="title">
        {{ __('teamsettingspage.delete_team') }}
    </x-slot>

    <x-slot name="description">
        {{ __('teamsettingspage.delete_team_description') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('teamsettingspage.delete_team_explanation') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('teamsettingspage.delete_team') }}
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('teamsettingspage.delete_team') }}
            </x-slot>

            <x-slot name="content">
                {{ __('teamsettingspage.delete_team_last_check') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('teamsettingspage.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteTeam()" wire:loading.attr="disabled">
                    {{ __('teamsettingspage.delete_team') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>
