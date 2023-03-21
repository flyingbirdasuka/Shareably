<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\Category;

class RemovePractice extends ModalComponent
{

    public $practice_id;
    public $category_id;

    public function mount($practice_id, $category_id)
    {
        $this->practice_id = $practice_id;
        $this->category_id = $category_id;
    }

    public function delete()
    {
        Category::where('id',$this->category_id)->first()->practices()->detach($this->practice_id);
        return redirect('categories/'.$this->category_id);
    }
    public function render()
    {
        return view('livewire.category.remove-practice');
    }
}
