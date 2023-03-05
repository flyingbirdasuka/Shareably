<form wire:submit.prevent="add">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        Title:
        <input type="text" wire:model.delay.500ms="title" />
        @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label>
        Description:
        <textarea wire:model.delay.500ms="description"></textarea>
    </label>
    @foreach($all_categories as $category)
        <label>
            <input wire:model="add_categories" value="{{ $category->id }}" type="checkbox" />
            {{$category->id}}{{ $category->title }}
        </label>
    @endforeach
    <input type="file" wire:model="file">
    @error('file.*') <span class="error">{{ $message }}</span> @enderror
    <button type="submit" class="border-solid border-2 border-indigo-600 py-4">Add Practice</button>
    @if ($file)
        Files Preview:
        <iframe src="{{ $file->temporaryUrl() }}" width="60%" height="600px;">
    @endif
</form>