<form wire:submit.prevent="edit">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        Title:
        <input type="text" wire:model.delay.500ms="title" value="$title" />
    </label>
    <label>
        Description:
        <textarea wire:model.delay.500ms="description"></textarea>
    </label>
    <button type="submit">Update</button>
    <button wire:click="$emit('closeModal')">Close</button>
</form>
