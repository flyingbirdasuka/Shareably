<div>
    <input type="text" wire:model.delay.500ms="search" placeholder="Search" >
    @foreach ($practices as $practice)
        <livewire:practice.practice-component :practice="$practice" :is_admin="$is_admin" :key="now() . $practice->id">
    @endforeach
</div>