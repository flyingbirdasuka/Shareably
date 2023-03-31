<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UsersAll extends Component
{
    public $users;
    public $search;

    public function mount()
    {
        $this->users = User::all();
    }

    public function updatedSearch()
    {
        $this->users = User::search('name', $this->search)->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.users.users-all');
    }
}
