<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class AddUser extends ModalComponent
{

    public $user_id;
    public $category_id;
    public $users =[];
    public $all_users = [];

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->users = Category::find($this->category_id)->users()->get()->pluck('id');
        $this->all_users = User::all()->where('is_admin', 0)->sortBy('name');
    }

    public function add()
    {

        // refresh the previous relationship
        foreach($this->all_users as $user){
            Category::find($this->category_id)->users()->detach($user);
        }

        // add the new relationship
        foreach ($this->users as $user){
            Category::where('id',$this->category_id)->first()->users()->attach($user);
        }

        return redirect('categories/'.$this->category_id);
    }

    public function render()
    {
        return view('livewire.category.add-user');
    }
}