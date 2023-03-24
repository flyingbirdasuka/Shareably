<x-table-row>
        <x-table-data><b><a href="practices/{{$practice->id}}">{{ $practice->title }}</a></b></x-table-data>
        <x-table-data><a href="practices/{{$practice->id}}">{{ \Illuminate\Support\Str::limit($practice->description, 20, $end='...') }}</a></x-table-data>

    @if($is_admin)
        <x-table-data>
            <button wire:click.prevent="edit({{$practice->id}})" :key="now() . $category->id" class="w-8"><i class="fa-regular fa-pen-to-square"></i></button>
            <button wire:click.prevent="$emit('openModal', 'practice.practice-remove', {{ json_encode(['practice_id' => $practice->id ]) }})" class="w-8"><i class="fa-solid fa-trash"></i></button>
        </x-table-data>
    @endif
</x-table-row>