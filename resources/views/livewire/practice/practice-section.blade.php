<div>
    @foreach ($practices as $practice)
        <livewire:practice.practice-component :practice="$practice" :is_admin="$is_admin" :key="now() . $practice->id">
    @endforeach
</div>