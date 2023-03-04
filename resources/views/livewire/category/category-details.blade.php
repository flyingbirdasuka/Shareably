<div>

    <b>{{ $category->title }}</b> <br>
    @if($is_admin)
        <button wire:click="$emit('openModal', 'category.add-practice', {{ json_encode(['category_id' => $category->id ]) }})">Add Practice</button>
    @endif
    @foreach($practices as $practice)
        {{ $practice->id }} : {{ $practice->title }} : {{ $practice->description }} <br>
        @if($is_admin)
            <button wire:click="edit_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $practice->id">EDIT</button>
            <button wire:click.prevent="delete_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button> <br>
        @endif
    @endforeach
    <br><br><br>
    @if($is_admin)
        @foreach($users as $user)
            {{ $user->id }} : {{ $user->name }}<br>

            <button wire:click.prevent="delete_user({{$user->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button><br>

        @endforeach
        <button wire:click="$emit('openModal', 'category.add-user', {{ json_encode(['users' => $users, 'category_id' => $category->id ]) }})">Add User</button>
    @endif
</div>