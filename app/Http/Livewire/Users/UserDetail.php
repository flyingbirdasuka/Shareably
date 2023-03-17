<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UserDetail extends Component
{
    public $user;
    public $teams = [];
    public $categories = [];
    public $practices = [];
    

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->teams = $this->user->teams()->get();
        $this->categories = $this->user->categories()->get();
        $this->practices = $this->user->practices()->get();

    }
    public function render()
    {
        return view('livewire.users.user-detail');
    }
}
