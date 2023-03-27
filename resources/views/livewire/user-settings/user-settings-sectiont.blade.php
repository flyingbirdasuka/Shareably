<x-form-section submit="submit">
    <x-slot name="title">
        {{ __('profilepage.settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('description comes here') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email_subscription" value="{{ __('profilepage.email_subscription') }}" />
            <label class="mx-1">
                <input type="radio" wire:model="email_subscription" value="0">
                {{ __('profilepage.off') }}
            </label>
            <label class="mx-1">
                <input type="radio" wire:model="email_subscription" value="1">
                {{ __('profilepage.on') }}
            </label>
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('profilepage.saved') }}
        </x-action-message>

        <x-button>
            {{ __('profilepage.save') }}
        </x-button>
    </x-slot>
</x-form-section>