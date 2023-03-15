<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('categorypage.categorypage_title') }}
        </h2>
</x-slot>
<div>
    <input type="text" wire:model.delay.500ms="search" placeholder="Search" >
    @if($is_admin)
        <button wire:click="$emit('openModal', 'category.category-add')">{{ __('categorypage.add_category') }}</button>
    @endif
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
            @forelse ($categories as $category)
                <livewire:category.category-component :category="$category" :is_admin="$is_admin" :key="now() . $category->id">
            @empty
            <x-table-row>
                <td colspan="4" class="px-6 py-4 text-center"><b>Not found</b></td>
            </x-table-row>
            @endforelse
        </x-table-body>
    </x-table>
</div>

