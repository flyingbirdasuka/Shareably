<form wire:submit.prevent="edit">
    <label>
        Title:
        <input type="text" wire:model.delay.500ms="title" value="$title" />
    </label>
    <label>
        Description:
        <textarea wire:model.delay.500ms="description"></textarea>
    </label>
    <button type="submit">Update</button>
</form>
<button wire:click="$set('edit_category', false)" class="border-solid border-2 border-indigo-600 py-4">Cancel</button>