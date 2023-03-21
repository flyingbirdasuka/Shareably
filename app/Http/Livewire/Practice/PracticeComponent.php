<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;

class PracticeComponent extends Component
{
    public $practice;
    public $is_admin;

    public function mount($practice, $is_admin)
    {
        $this->practice = $practice;
        $this->is_admin = $is_admin;
    }

    public function edit($practice_id)
    {
        return redirect('practices/'.$practice_id.'/edit');
    }

    public function render()
    {
        return view('livewire.practice.practice-component');
    }
}
