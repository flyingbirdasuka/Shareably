<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('practicepage.practicepage_title') }}
        </h2>
</x-slot>
<div class="pb-10">
    <div class="mt-4 pb-3 flex justify-between z-1 px-2">
        <div class="relative w-1/2">
            <div class="flex absolute inset-y-0 items-center pl-3">
                <i class="fa-solid fa-magnifying-glass" style="color:gray;"></i>
            </div>
            <input wire:model.delay.500ms="search" type="search" class="p-4 pl-10 w-full text-sm bg-gray-50 rounded-lg  border-gray-300 focus:border-indigo-500" placeholder="Search">
        </div>
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
        @forelse ($practices as $practice)
            <livewire:practice.practice-component :practice="$practice" :is_admin="$is_admin" :key="now() . $practice->id">
        @empty
            <x-table-row>
                <td colspan="4" class="px-6 py-4 text-center"><b>Not found</b></td>
            </x-table-row>
        @endforelse
        </x-table-body>
    </x-table>
</div>