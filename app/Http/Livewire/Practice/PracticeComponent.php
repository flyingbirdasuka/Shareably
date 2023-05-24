<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Support\Str;

class PracticeComponent extends Component
{
    public $practice;
    public $is_admin;
    public $user_practices=[];
    public $description;

    public function mount($practice, $is_admin,$user_practices)
    {
        $this->practice = $practice;
        $this->is_admin = $is_admin;
        $this->user_practices = $user_practices;
        $this->description = $this->getLimitedStringProperty($this->practice->description);
    }

    public function getLimitedStringProperty($string)
    {
        return Str::limit($string, 20, $end='...');
    }

    public function updatedUserPractices(){
        // refresh the previous relationship
        foreach(auth()->user()->practices()->get() as $practice){
            auth()->user()->practices()->detach($practice);
        }

        // add the new relationship
        foreach ($this->user_practices as $practice_id){
            auth()->user()->practices()->attach($practice_id);
        }
        return redirect('/practices');
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
