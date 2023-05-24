<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryComponent extends Component
{
    public $category;
    public $is_admin;
    public $description;

    public function mount($category, $is_admin)
    {
        $this->category = $category;
        $this->is_admin = $is_admin;
        $this->description = $this->getLimitedStringProperty($this->category->description);
    }

    public function getLimitedStringProperty($string)
    {
        return Str::limit($string, 20, $end='...');
    }

    public function render()
    {
        return view('livewire.category.category-component');
    }

}
