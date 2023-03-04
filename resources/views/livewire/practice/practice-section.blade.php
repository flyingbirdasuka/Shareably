<div>
    @foreach ($practices as $practice)
        <a href="practices/{{$practice->id}}">
            <livewire:practice.practice-component :practice="$practice" :key="now() . $practice->id">
        </a>
    @endforeach
</div>