<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use DB;
use Storage;

class RemoveUser extends ModalComponent
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id; 
    }

    static function delete($user_id)
    {
        $user = User::where('id', $user_id);

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

        // remove user_settings
        $user->first()->user_settings()->delete();

        // remove from teams
        $teams = $user->first()->teams()->get();
        foreach($teams as $team){
            $user->first()->teams()->detach($team);
        }

        // remove the profile picture
        Storage::delete('public/'.$user->first()->profile_photo_path);

        // remove user
        $user->delete();

        return redirect()->to('/users-all');
    }

    public function render()
    {
        return view('livewire.users.remove-user');
    }
}
