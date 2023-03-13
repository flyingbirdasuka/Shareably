<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('profilepage.profile') }}
        </h2>
</x-slot>
<div>
    <b>{{ $category->title }}</b> <br>
    @if($is_admin)
        <button wire:click="$emit('openModal', 'category.add-practice', {{ json_encode(['category_id' => $category->id ]) }})">Add Practice</button>
    @endif
    @if($practices)
        @foreach($practices as $practice)
            {{ $practice->id }} : {{ $practice->title }} : {{ $practice->description }}
            @if($is_admin)
                <button wire:click="edit_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $practice->id">EDIT</button>
                <button wire:click.prevent="delete_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button> <br>
            @else
                @if(in_array($practice->id, $user_practices))
                    <label>
                        <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                        <i class="fa-solid fa-heart" style="color:red;"></i>
                    </label><br>
                @else
                    <label>
                        <input wire:model="user_practices" value="{{ $practice->id }}" type="checkbox" style="display:none;"/>
                        <i class="fa-regular fa-heart"></i>
                    </label><br>
                @endif
            @endif
        @endforeach
    @endif    
    <br><br><br>
    @if($is_admin)
        @if($users)
            @foreach($users as $user)
                {{ $user->id }} : {{ $user->name }}<br>
                <button wire:click.prevent="delete_user({{$user->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button><br>
            @endforeach
        @endif
        <button wire:click="$emit('openModal', 'category.add-user', {{ json_encode(['users' => $users, 'category_id' => $category->id ]) }})">Add User</button>
    @endif
</div>