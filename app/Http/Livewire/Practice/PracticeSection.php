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
    public $user_practices = [];

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->practices = $this->user->is_admin ? Practice::orderBy('title')->get() : $this->user->practices()->orderBy('title')->get();
        $this->is_admin = $this->user->is_admin;
        $this->user_practices = $this->user->practices()->pluck('practices.id')->all();
        session()->push('data.page', 'practice');
    }

    public function updatedSearch()
    {
        if($this->is_admin){
            $this->practices = Practice::search('title', $this->search)->orderBy('title')->get();
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
                $this->practices = $this->user->practices()->orderBy('title')->get();
            }
            session()->push('data.search', 'practice_'.$this->search);
        }
    }

    public function render()
    {
        return view('livewire.practice.practice-section');
    }
}