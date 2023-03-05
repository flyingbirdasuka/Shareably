<form wire:submit.prevent="update_practice">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
        Title:
        <input type="text" wire:model.delay.500ms="title" value="{{$title}}"/>
        @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label>
        Description:
        <textarea wire:model.delay.500ms="description">{{ $description }}</textarea>
    </label>
    @foreach($all_categories as $category)
        <label>
            <input wire:model="add_categories" value="{{ $category->id }}" type="checkbox"/>
            {{$category->id}}{{ $category->title }}
        </label>
    @endforeach
    <button type="submit" class="border-solid border-2 border-indigo-600 py-4">Update Practice</button>
</form>