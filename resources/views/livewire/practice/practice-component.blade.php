<x-table-row>
        <x-table-data>{{ $practice->id }}</x-table-data>
        <x-table-data><b><a href="practices/{{$practice->id}}">{{ $practice->title }}</a></b></x-table-data>
        <x-table-data><a href="practices/{{$practice->id}}">{{ $practice->description }}</a></x-table-data>

    @if($is_admin)
        <x-table-data>
            <button wire:click.prevent="edit({{$practice->id}})" :key="now() . $category->id"><i class="fa-regular fa-pen-to-square"></i></button>
            <button wire:click.prevent="delete({{$practice->id}})"><i class="fa-solid fa-trash"></i></button>
        </x-table-data>
    @endif
</x-table-row>