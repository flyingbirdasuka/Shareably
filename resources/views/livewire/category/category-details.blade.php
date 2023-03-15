<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->title }}
        </h2>
</x-slot>
<div>
    <div class="flex">
        @if($is_admin)
            <button wire:click="$emit('openModal', 'category.add-practice', {{ json_encode(['category_id' => $category->id ]) }})" class="mx-1.5 my-1.5 border-2 h-8">Add Practice</button>
            <button wire:click.prevent="$emit('openModal', 'category.add-user', {{ json_encode(['users' => $users, 'category_id' => $category->id ]) }})" class="mx-1.5 my-1.5 border-2 h-8">{{ __('categorypage.add_user') }}</button>
            <div class="flex flex-col">
                @if($users)
                    @foreach($users as $user)
                        <div class="flex">
                            <p class=w-full>{{ $user->name }}</p>
                            <button wire:click.prevent="delete_user({{$user->id}})" class="border-2 my-px mx-2">{{ __('categorypage.remove') }}</button>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
    <x-table>
        <x-table-head>
            <x-table-heading>ID</x-table-heading>
            <x-table-heading>Title</x-table-heading>
            <x-table-heading>Description</x-table-heading>
            @if($is_admin)
                <x-table-heading>Edit</x-table-heading>
            @else
                <x-table-heading></x-table-heading>
            @endif
        </x-table-head>
        <x-table-body>
            @if($practices)
                @foreach($practices as $practice)
                <x-table-row>
                    <x-table-data>{{ $practice->id }}</x-table-data>
                    <x-table-data><b><a href="../practices/{{$practice->id}}">{{ $practice->title }}</a></b></x-table-data>
                    <x-table-data><a href="../practices/{{$practice->id}}">{{ $practice->description }}</a></x-table-data>
                    @if($is_admin)
                        <x-table-data>
                            <button wire:click.prevent="edit_practice({{$practice->id}})" class="w-8" :key="now() . $practice->id"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button wire:click.prevent="delete_practice({{$practice->id}})"  class="w-8"><i class="fa-solid fa-trash"></i></button>
                        </x-table-data>
                    @else
                        @if(in_array($practice->id, $user_practices))
                            <label>
                                <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                                <i class="fa-solid fa-heart" style="color:red;"></i>
                            </label>
                        @else
                            <label>
                                <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                                <i class="fa-regular fa-heart"></i>
                            </label>
                        @endif
                    @endif
                </x-table-row>
                @endforeach
            @endif
        </x-table-body>
    </x-table>
</div>

