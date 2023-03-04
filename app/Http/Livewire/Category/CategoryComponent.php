<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $category;

    public function mount($category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.category.category-component');
    }

    public function delete()
    {
        Category::where('id', $this->category->id)->delete();
        $this->emitUp('refreshParent');
    }

}
