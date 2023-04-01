<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersAll extends Component
{
    use WithPagination;

    public $users;
    public $search = '';

    public function mount()
    {
        $this->users = User::all();
    }

    public function updatedSearch()
    {
        $this->users = User::search('name', $this->search)->orderBy('name')->get();
    }

    // Reset the pagination after search is run
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.users.users-all', [
            'users_list' => User::where('name', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }
}
