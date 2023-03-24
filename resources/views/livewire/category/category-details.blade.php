<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->title }}
        </h2>
        <p class="mt-4">{{ $category->description }}</p>
</x-slot>
<div class="mt-4">
    @if($is_admin)
        <div class="flex my-4 mx-4 text-sm">
            <button wire:click="$emit('openModal', 'category.add-practice', {{ json_encode(['category_id' => $category->id ]) }})" class=" bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">Add Practice</button>
            <button wire:click.prevent="$emit('openModal', 'category.add-user', {{ json_encode(['category_id' => $category->id ]) }})" class="mx-4 ml-4 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">{{ __('categorypage.add_user') }}</button>
            <button wire:click.prevent="$emit('openModal', 'category.show-users', {{ json_encode(['category_id' => $category->id ]) }})" class=" bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150">{{ __('categorypage.show_users') }}</button>
        </div>
    @endif
    <x-table>
        <x-table-head>
            <x-table-heading>Title</x-table-heading>
            <x-table-heading>Description</x-table-heading>
            @if($is_admin)
                <x-table-heading>Edit</x-table-heading>
            @else
                <x-table-heading></x-table-heading>
            @endif
        </x-table-head>
        <x-table-body>
                @forelse($practices as $practice)
                <x-table-row>
                    <x-table-data><b><a href="/practices/{{$practice->id}}">{{ $practice->title }}</a></b></x-table-data>
                    <x-table-data><a href="/practices/{{$practice->id}}">{{ $practice->description }}</a></x-table-data>
                    @if($is_admin)
                        <x-table-data>
                            <button wire:click.prevent="edit_practice({{$practice->id}})" class="w-8" :key="now() . $practice->id"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button wire:click.prevent="$emit('openModal', 'category.remove-practice',{{ json_encode(['practice_id' => $practice->id, 'category_id' => $category->id])}})" class="w-8"><i class="fa-solid fa-trash"></i></button>
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
                @empty
                <x-table-row>
                    <td colspan="4" class="px-6 py-4 text-center"><b>{{ __('categorypage.no_practice') }}</b></td>
                </x-table-row>
                @endforelse
        </x-table-body>
    </x-table>
</div>

