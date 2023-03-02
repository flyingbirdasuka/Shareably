<div>
    <b>{{ $category->title }}</b> <br>
    @foreach($practices as $practice)
        {{ $practice->id }} : {{ $practice->title }} : {{ $practice->description }} <br>
    @endforeach
    <br><br><br>

    @foreach($users as $user)
        {{ $user->id }} : {{ $user->name }} <br>
    @endforeach

    <livewire:category.add-user :category_id="$category->id" :users="$users">
</div>
