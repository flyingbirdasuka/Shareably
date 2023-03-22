<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UsersAll extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    // public function delete($user_id)
    // {
    //     $user = User::where('id', $user_id);

    //     // remove the user_category relationship
    //     $categories = $user->first()->categories()->get();
    //     foreach($categories as $category){
    //         $user->first()->categories()->detach($category);
    //     }

    //     // remove the user_practice (favorite) relationship
    //     $practices = $user->first()->practices()->get();
    //     foreach($practices as $practice){
    //         $user->first()->practices()->detach($practice);
    //     }

    //     // remove user_settings_language relationship
    //     $user_setting = $user->first()->user_settings()->first();
    //     DB::table('user_settings_language')->where('user_settings_id', $user_setting->id)->delete();

    //     // remove user_settings
    //     $user_setting->delete();

    //     // remove from teams
    //     $teams = $user->first()->teams()->get();
    //     foreach($teams as $team){
    //         $user->first()->teams()->detach($team);
    //     }
        
    //     // remove user
    //     $user->delete();

    // }

    public function render()
    {
        return view('livewire.users.users-all');
    }
}
