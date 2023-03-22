<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class ShowUsers extends ModalComponent
{
    public $category_id;
    public $category;
    public $users;
    public $user_id;
    public $delete_id;

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->category = Category::find($category_id);
        $this->users = $this->category->users()->orderBy('name')->get();
    }

    public function updatedUserId()
    {
        Category::where('id',$this->category->id)->first()->users()->detach($this->user_id);
        return redirect('categories/'.$this->category->id);
    }

    public function render()
    {
        return view('livewire.category.show-users');
    }

}