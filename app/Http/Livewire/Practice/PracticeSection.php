<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use App\Models\User;

class PracticeSection extends Component
{
    public $practices=[];
    public $user;
    public $is_admin;
    public $search;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->practices = $this->user->is_admin ? Practice::orderBy('title')->get() : User::find($this->user)->first()->practices()->orderBy('title')->get();
        $this->is_admin = $this->user->is_admin;
    }

    public function updatedSearch()
    {
        if($this->is_admin){
            $practices = Practice::search('title', $this->search)->orderBy('title')->get();
            // dd($practices);
        } else {
            if(strlen($this->search) >= 2){
                foreach($this->practices as $key => $practice){
                    if(!str_contains(strtolower($practice->title), strtolower($this->search))){
                        // If the search query is not found in the practices then remove the false results
                        $this->practices->forget($key);
                    }
                }

                // Arrange the final results by alphabetical order
                $this->practices->sortBy('title');

            } else {
                $this->practices = User::find($this->user)->first()->practices()->orderBy('title')->get();
            }
        }
  }

    public function render()
    {
        return view('livewire.practice.practice-section');
    }
}