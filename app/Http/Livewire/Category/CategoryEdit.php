<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class CategoryEdit extends Component
{
    public $category;
    public $title;
    public $description;
    public $edit_category;

    public function mount($category, $edit_category)
    {
        $this->category = $category;
        $this->edit_category = $edit_category;
        $this->title = $category->title;
        $this->description = $category->description;
    }

    public function render()
    {
        return view('livewire.category.category-edit',[
            'title', $this->title,
            'description', $this->description,
        ]);
    }
    public function edit()
    {
        Category::where('id', $this->category->id)->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);
        $this->emitUp('refreshParent');

    }
}
