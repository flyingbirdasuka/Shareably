@if($all_practices)
    <form wire:submit.prevent="update_practice">
        @foreach($all_practices as $practice)
            <label>
                <input wire:model="add_practice" value="{{ $practice->id }}" type="checkbox" />
                {{$practice->id}}{{ $practice->title }}
            </label>
        @endforeach
        <button type="submit">Add</button>
    </form>
@endif