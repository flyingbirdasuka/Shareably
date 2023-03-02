<div>
    <label>
        <input type="checkbox" wire:model="editable"/>
    </label>
    <livewire:category.category-add>
    @foreach ($categories as $category)
        <livewire:category.category-component :category="$category" :key="now() . $category->id" :editable="$editable">
    @endforeach
</div>