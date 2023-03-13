<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.practicepage_title') }}
        </h2>
</x-slot>
<div>
    <input type="text" wire:model="search" placeholder="Search">
</div>

<x-table>
    <x-table-head>
        <x-table-heading>ID</x-table-heading>
        <x-table-heading>Title</x-table-heading>
        <x-table-heading>Description</x-table-heading>
        @if($is_admin)
            <x-table-heading>Edit</x-table-heading>
        @endif
    </x-table-head>
    <x-table-body>
        @foreach ($practices as $practice)
            <livewire:practice.practice-component :practice="$practice" :is_admin="$is_admin" :key="now() . $practice->id">
        @endforeach
    </x-table-body>
</x-table>