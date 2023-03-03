<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;

class PracticeComponent extends Component
{
    public $practice;
    public $editable = false;

    public function mount($practice, $editable)
    {
        $this->practice = $practice;
        $this->editable = $editable;
    }

    public function edit($practice_id)
    {
        return redirect('practices/'.$practice_id);
    }

    public function delete($practice_id)
    {
        Practice::where('id', $practice_id)->delete();
        $this->emitUp('refreshParent');
    }

    public function render()
    {
        return view('livewire.practice.practice-component');
    }
}
