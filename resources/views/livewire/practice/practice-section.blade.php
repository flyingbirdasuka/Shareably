<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.practicepage_title') }}
        </h2>
</x-slot>
<div>
    <input type="text" wire:model="search" placeholder="Search" >
    @foreach ($practices as $practice)
        <livewire:practice.practice-component :practice="$practice" :is_admin="$is_admin" :key="now() . $practice->id">
    @endforeach
</div>