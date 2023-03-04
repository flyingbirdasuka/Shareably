<div>
    <button wire:click="$emit('openModal', 'category.category-add')">Add Category</button>
    @foreach ($categories as $category)
        <livewire:category.category-component :category="$category" :key="now() . $category->id">
    @endforeach
</div>