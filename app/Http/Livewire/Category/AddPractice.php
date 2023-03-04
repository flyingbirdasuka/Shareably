<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class AddPractice extends ModalComponent
{
    public $practices;
    public $category_id;
    public $add_practice = [];

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->all_practices = Practice::all();
    }
   
    public function add_practice()
    {
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