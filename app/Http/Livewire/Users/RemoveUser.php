<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use DB;

class RemoveUser extends ModalComponent
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id; 
    }
    public function delete()
    {
        $user = User::where('id', $this->user_id);

        // remove the user_category relationship
        $categories = $user->first()->categories()->get();
        foreach($categories as $category){
            $user->first()->categories()->detach($category);
        }

        // remove the user_practice (favorite) relationship
        $practices = $user->first()->practices()->get();
        foreach($practices as $practice){
            $user->first()->practices()->detach($practice);
        }

        // remove user_settings_language relationship
        $user_setting = $user->first()->user_settings()->first();
        DB::table('user_settings_language')->where('user_settings_id', $user_setting->id)->delete();

        // remove user_settings
        $user_setting->delete();

        // remove from teams
        $teams = $user->first()->teams()->get();
        foreach($teams as $team){
            $user->first()->teams()->detach($team);
        }
        
        // remove user
        $user->delete();

        return redirect()->to('/users-all');

    }
    public function render()
    {
        return view('livewire.users.remove-user');
    }
}
