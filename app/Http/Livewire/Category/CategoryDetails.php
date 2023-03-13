<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;

class CategoryDetails extends Component
{
    public $category;
    public $practices;
    public $users;
    public $user_id;
    public $is_admin;
    public $user_practices = [];

    public function mount($id)
    {
        $this->category = Category::find($id);
        $this->practices = $this->category->practices()->orderBy('title')->get();
        $this->users = $this->category->users()->orderBy('name')->get();
        $this->is_admin = auth()->user()->is_admin;
        $this->user_practices = User::find(auth()->user())->first()->practices()->pluck('practices.id')->all();
    }

    public function updatedUserPractices(){
        // refresh the previous relationship
        foreach(User::find(auth()->user())->first()->practices()->get() as $practice){
            User::find(auth()->user())->first()->practices()->detach($practice);
        }

        // add the new relationship
        foreach ($this->user_practices as $practice_id){
            User::find(auth()->user())->first()->practices()->attach($practice_id);
        }
    }
    public function edit_practice($practice_id)
    {
        return redirect('practices/'.$practice_id);
    }

    public function delete_practice($practice_id)
    {
        Category::where('id',$this->category->id)->first()->practices()->detach($practice_id);
        return redirect('categories/'.$this->category->id);
    }

    public function delete_user($user_id)
    {
        Category::where('id',$this->category->id)->first()->users()->detach($user_id);
        return redirect('categories/'.$this->category->id);
    }

    public function render()
    {
        return view('livewire.category.category-details');
    }
}