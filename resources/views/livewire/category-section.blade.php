<div>
    <label>
        <input type="checkbox" wire:model="editable"/>
    </label>
    <livewire:category-add>
    @foreach ($categories as $category)
        <livewire:category-component :category="$category" :key="now() . $category->id" :editable="$editable">
    @endforeach
</div>