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
        $user = auth()->user();
        $this->practices = $user->is_admin ? Practice::all() : User::find($user)->first()->practices()->get();
        $this->is_admin = $user->is_admin;
    }

    public function updatedSearch()
    {
        if($this->is_admin){
            $this->practices = Practice::search('title', $this->search)->get();
        } else {
            if($this->search !=''){
                foreach($this->practices as $key => $practice){
                    if(!str_contains(strtolower($practice->title), strtolower($this->search))){
                        // If the search query is not found in the practices then remove the false results
                        $this->practices->forget($key);
                    }
                }
                dd($this->practices);
            } else {
                $this->practices = User::find(auth()->user())->first()->practices()->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.practice.practice-section');
    }
}