<div>
    <b>{{ $category->title }}</b> <br>
    @foreach($practices as $practice)
        {{ $practice->id }} : {{ $practice->title }} : {{ $practice->description }} <br>
    @endforeach
    <br><br><br>

    @foreach($users as $user)
        {{ $user->id }} : {{ $user->name }}
        <button wire:click.prevent="delete({{$user->id}})" class="border-solid border-2 border-indigo-600 bg-red-600">REMOVE</button><br>
    @endforeach

    <livewire:category.add-user :category_id="$category->id" :users="$users">
</div>
