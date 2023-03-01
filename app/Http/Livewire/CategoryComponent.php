<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $category;
    public $editable;
    public $edit_category;

    public function mount($category, $editable)
    {
        $this->category = $category;
        $this->editable = $editable;
        $this->edit_category = false;
    }

    public function render()
    {
        return view('livewire.category-component');
    }

    public function delete()
    {
        Category::where('id',$this->category->id)->delete();
        $this->emitUp('refreshParent');
    }

}
