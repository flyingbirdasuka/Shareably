<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class AddPractice extends ModalComponent
{
    public $all_practices;
    public $category_id;
    public $category;
    public $add_practice = [];

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->all_practices = Practice::all();
        $this->category = Category::find($category_id);
        $this->add_practice = $this->category->practices()->pluck('practices.id')->all();
    }
   
    public function update_practice()
    {
        // refresh the previous relationship
        foreach($this->category->practices()->get() as $original_category){
            $this->category->practices()->detach($original_category);
        }

        // add the new relationship
        foreach ($this->add_practice as $practice_id){
            Category::where('id',$this->category_id)->first()->practices()->attach($practice_id);
        }
        return redirect('categories/'.$this->category_id);
    }

    public function render()
    {
        return view('livewire.category.add-practice');
    }
}