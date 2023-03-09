<form wire:submit.prevent="edit">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        {{ __('categorypage.title') }}:
        <input type="text" wire:model.delay.500ms="title" value="$title" />
    </label>
    <label>
        {{ __('categorypage.description') }}:
        <textarea wire:model.delay.500ms="description"></textarea>
    </label>
    <button type="submit">{{ __('categorypage.update') }}</button>
    <button wire:click="$emit('closeModal')">{{ __('categorypage.close') }}</button>
</form>
