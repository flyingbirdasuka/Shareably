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
    public $user_id;
    public $editable = false;
    public $all_practices;
    public $add_practice = [];

    public function mount($id)
    {
        $this->category = Category::find($id);
        $this->practices = $this->category->practices()->get();
        $this->users = $this->category->users()->get();
    }

    public function show_practices()
    {
        $this->all_practices = Practice::all();
    }

    public function add_practice()
    {
        foreach ($this->add_practice as $practice_id){
            Category::where('id',$this->category->id)->first()->practices()->attach($practice_id);
        }
        return redirect('categories/'.$this->category->id);
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