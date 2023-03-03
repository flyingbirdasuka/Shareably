<div>
    <label>
        <input type="checkbox" wire:model="editable"/>
    </label>
    <b>{{ $category->title }}</b> <br>
    @if($editable)
        <button wire:click="show_practices()" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $practice->id">Add Practice</button> <br>
    @endif

    @foreach($practices as $practice)
        {{ $practice->id }} : {{ $practice->title }} : {{ $practice->description }} <br>
        @if($editable)
            <button wire:click="edit_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $practice->id">EDIT</button>
            <button wire:click.prevent="delete_practice({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button> <br>
        @endif
    @endforeach
    <br><br><br>

    @foreach($users as $user)
        {{ $user->id }} : {{ $user->name }}<br>
        @if($editable)
            <button wire:click.prevent="delete_user({{$user->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button><br>
        @endif
    @endforeach

    <livewire:category.add-user :category_id="$category->id" :users="$users">
    @if($editable)
        @if($all_practices)
        <form wire:submit.prevent="add_practice">
            @foreach($all_practices as $practice)
                <label>
                    <input wire:model="add_practice" value="{{ $practice->id }}" type="checkbox" />
                    {{$practice->id}}{{ $practice->title }}
                </label>
            @endforeach
            <button type="submit">Add</button>
        </form>
        @endif
    @endif
</div>