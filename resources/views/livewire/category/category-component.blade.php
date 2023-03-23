<x-table-row>
        <x-table-data><b><a href="categories/{{$category->id}}">{{ $category->title }}</a></b></x-table-data>
        <x-table-data><a href="categories/{{$category->id}}">{{ \Illuminate\Support\Str::limit($category->description, 20, $end='...') }}</a></x-table-data>
    @if($is_admin)
        <x-table-data>
            <button wire:click.prevent="$emit('openModal', 'category.category-edit',{{ json_encode(['category_id' => $category->id, 'title' => $category->title, 'description' => $category->description ]) }})" class="w-8"><i class="fa-regular fa-pen-to-square"></i></button>
            <button wire:click.prevent="$emit('openModal', 'category.category-remove',{{ json_encode(['category_id' => $category->id])}})" class="w-8"><i class="fa-solid fa-trash"></i></button>
        </x-table-data>
    @endif
</x-table-row>