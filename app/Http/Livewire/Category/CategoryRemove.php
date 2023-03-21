<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class CategoryRemove extends ModalComponent
{
    public $category_id;

    public function mount($category_id)
    {
        
        $this->category_id = $category_id;
    }

    public function delete()
    {
        
        Category::where('id', $this->category_id)->delete();
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.category-remove');
    }
}
