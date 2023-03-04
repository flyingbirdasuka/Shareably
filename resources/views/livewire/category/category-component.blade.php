<div class="border-solid border-2 border-indigo-600 py-4">
    <a href="categories/{{$category->id}}">
        {{ $category->id }}
        <b>{{ $category->title }}</b>
        {{ $category->description }}
    </a>
    @if($is_admin)
        <button wire:click.prevent="$emit('openModal', 'category.category-edit',{{ json_encode(['category_id' => $category->id, 'title' => $category->title, 'description' => $category->description ]) }})">Edit</button>
        <button wire:click.prevent="delete()" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button>
    @endif
</div>