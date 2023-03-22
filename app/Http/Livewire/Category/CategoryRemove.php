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
        $category = Category::where('id', $this->category_id);

        // remove the practice_category relationship
        $practices = $category->first()->practices()->get();
        foreach($practices as $practice){
            $category->first()->practices()->detach($practice);
        }
        
        // remove the user_category relationship
        $users = $category->first()->users()->get();
        foreach($users as $user){
            $category->first()->users()->detach($user);
        }

        // remove the category
        $category->delete();

        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.category-remove');
    }
}