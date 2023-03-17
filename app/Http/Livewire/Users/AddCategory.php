<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\Category;

class AddCategory extends ModalComponent
{
    public $user_id;
    public $categories;
    public $all_categories = [];

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->categories = User::find($this->user_id)->categories()->pluck('categories.id')->all();
        $this->all_categories = Category::orderBy('title')->get();
    }

    public function update_categories()
    {
        // refresh the previous relationship
        // dd($this->categories);
        foreach($this->all_categories as $category){
            User::find($this->user_id)->categories()->detach($category);
        }

        // add the new relationship
        foreach ($this->categories as $category){
            User::find($this->user_id)->categories()->attach($category);
        }
        return redirect('users/'.$this->user_id);

    }

    public function render()
    {
        return view('livewire.users.add-category');
    }
}
