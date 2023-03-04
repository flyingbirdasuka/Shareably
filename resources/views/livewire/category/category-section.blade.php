<div>
    @if($is_admin)
        <button wire:click="$emit('openModal', 'category.category-add')">Add Category</button>
    @endif
    @foreach ($categories as $category)
        <livewire:category.category-component :category="$category" :is_admin="$is_admin" :key="now() . $category->id">
    @endforeach
</div>