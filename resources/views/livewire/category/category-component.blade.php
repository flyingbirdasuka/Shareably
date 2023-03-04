<div class="border-solid border-2 border-indigo-600 py-4">
    @if ($editable)
        @if ($edit_category)
            <livewire:category.category-edit :category="$category" :key="now() . $category->id" :edit_category="$edit_category" >
        @else
            {{ $category->id }}
            
            <b>{{ $category->title }}</b>
            {{ $category->description }}

            <button wire:click.prevent="$set('edit_category', true)" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $category->id">EDIT</button>
            <button wire:click.prevent="delete()" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button>
        @endif
    @else
        {{ $category->id }}
        <a href="categories/{{$category->id}}">
            <b>{{ $category->title }}</b>
            {{ $category->description }}
        </a>
    @endif
</div>