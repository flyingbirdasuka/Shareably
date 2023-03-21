<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use LivewireUI\Modal\ModalComponent;

class PracticeRemove extends ModalComponent
{

    public $practice_id; 

    public function mount($practice_id)
    {
        $this->practice_id = $practice_id;
    }

    public function delete()
    {
        Practice::where('id', $this->practice_id)->delete();
        return redirect()->to('/practices');
    }

    public function render()
    {
        return view('livewire.practice.practice-remove');
    }
}
