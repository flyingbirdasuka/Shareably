<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategorySection extends Component
{
    public $categories;
    public $editable=false;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];
    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.category-section');
    }


}
