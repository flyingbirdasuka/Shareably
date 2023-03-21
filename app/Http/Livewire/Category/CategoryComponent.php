<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $category;
    public $is_admin;

    public function mount($category, $is_admin)
    {
        $this->category = $category;
        $this->is_admin = $is_admin;
    }

    public function render()
    {
        return view('livewire.category.category-component');
    }

}
