<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\Team;

class ShowUsers extends ModalComponent
{
    public $team_id;
    public $users;

    public function mount($team_id)
    {
        $this->team_id = $team_id;
        $this->users = Team::find($team_id)->users()->get();
    }
    public function render()
    {
        return view('livewire.teams.show-users');
    }
}
