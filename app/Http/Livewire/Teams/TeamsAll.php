<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\Team;

class TeamsAll extends Component
{
    public $teams;

    public function mount()
    {
        $this->teams = Team::all();
    }
    public function render()
    {
        return view('livewire.teams.teams-all');
    }
}
