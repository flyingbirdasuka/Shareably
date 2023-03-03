<div class="border-solid border-2 border-indigo-600 py-4">
    {{ $practice->id }}
    <b>{{ $practice->title }}</b>
    {{ $practice->description }}
    @if ($editable)
        <button wire:click="edit({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-green-400" :key="now() . $category->id">EDIT</button>
        <button wire:click.prevent="delete({{$practice->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button>
    @endif
</div>