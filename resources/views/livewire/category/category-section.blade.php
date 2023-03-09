<div>
    <input type="text" wire:model="search" placeholder="Search" >
    @if($is_admin)
        <button wire:click="$emit('openModal', 'category.category-add')">{{ __('categorypage.add_category') }}</button>
    @endif
    @foreach ($categories as $category)
        <livewire:category.category-component :category="$category" :is_admin="$is_admin" :key="now() . $category->id">
    @endforeach
</div>