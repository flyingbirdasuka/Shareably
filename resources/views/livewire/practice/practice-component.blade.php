<x-table-row>
        <x-table-data><b><a href="practices/{{$practice->id}}">{{ $practice->title }}</a></b></x-table-data>
        <x-table-data><a href="practices/{{$practice->id}}">{!! $description !!}</a></x-table-data>

    @if($is_admin)
        <x-table-data>
            <button wire:click.prevent="edit({{$practice->id}})" :key="now() . $category->id" class="w-8"><i class="fa-regular fa-pen-to-square"></i></button>
            <button wire:click.prevent="$emit('openModal', 'practice.practice-remove', {{ json_encode(['practice_id' => $practice->id ]) }})" class="w-8"><i class="fa-solid fa-trash"></i></button>
        </x-table-data>
    @else
        @if(in_array($practice->id, $user_practices))
        <x-table-data>
            <label>
                <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                <i class="fa-solid fa-heart" style="color:red;"></i>
            </label>
        </x-table-data>
        @else
        <x-table-data>
            <label>
                <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                <i class="fa-regular fa-heart"></i>
            </label>
        </x-table-data>
        @endif
    @endif
</x-table-row>