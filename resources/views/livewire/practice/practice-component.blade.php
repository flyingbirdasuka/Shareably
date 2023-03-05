<div class="border-solid border-2 border-indigo-600 py-4">
    <a href="practices/{{$practice->id}}">
        {{ $practice->id }}
        <b>{{ $practice->title }}</b>
        {{ $practice->description }}
    </a>
    @if($is_admin)
        <button wire:click.prevent="edit({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $category->id">EDIT</button>
        <button wire:click.prevent="delete({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button>
    @endif
</div>