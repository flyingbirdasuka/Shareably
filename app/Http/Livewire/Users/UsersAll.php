<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Team;

class UsersAll extends Component
{
    use WithPagination;

    public $users;
    public $search = '';
    public $default_team_owner;

    public function mount()
    {
        $this->users = User::all();
        // only allow to change the role when the user is not the default team owner
        $this->default_team_owner = Team::where('id',1)->first()->user_id;

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

    // public function changeRole($userId)
    // {
    //     $user = User::where('id',$userId)->first();
    //     User::where('id',$userId)->update([
    //         'is_admin' => $user->is_admin == 1? 0 : 1,
    //     ]);
    //     return redirect()->to('/users-all');
    // }

    public function render()
    {
        return view('livewire.users.users-all', [
            'users_list' => User::where('name', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }
}
