<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Practice;

class CategoryDetails extends Component
{
    public $category;
    public $practices;
    public $users;

    public function mount($id)
    {
        $this->category = Category::find($id);
        $this->practices = $this->category->practices()->get();
        $this->users = $this->category->users()->get();
    }

    public function render()
    {
        return view('livewire.category.category-details');
    }
}
