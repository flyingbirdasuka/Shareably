<?php

namespace App\Http\Livewire\Practice;

use Storage;
use Livewire\Component;
use App\Models\Practice;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use App\Traits\GoogleSetup;

class PracticeRemove extends ModalComponent
{

    use GoogleSetup;
    public $practice_id; 

    public function mount($practice_id)
    {
        $this->practice_id = $practice_id;
    }

    public function delete()
    {
        $practice = Practice::where('id', $this->practice_id);

        // remove the music_practice relationship and remove the music
        $musics = $practice->first()->musics()->get();
        foreach($musics as $music){
            $practice->first()->musics()->detach($music);
            Storage::delete('/practice/'.$music->filename); // delete the file
            $music->delete();
        }

        // remove the musicsheet_practice relationship and remove the musicsheet
        $musicsheets = $practice->first()->musicsheets()->get();
        foreach($musicsheets as $musicsheet){
            $practice->first()->musicsheets()->detach($musicsheet);
            Storage::delete('/practice/'.$musicsheet->filename); // delete the file
            $musicsheet->delete();
        }

        // remove the practice_category relationship (many)
        $categories = $practice->first()->categories()->get();
        foreach($categories as $category){
            $practice->first()->categories()->detach($category);
        }

        // remove the google drive permission
        if($practice->first()->video_type == 1){
            $driveService = $this->googleSetup();
            // get the users from the google drive permission and when the user is not the admin then remove them 
            $non_admin_users = User::where('is_admin', 0)->get();
            foreach($non_admin_users as $user){
                $this->removeFromGoogleDrive($user->id, $practice->first()->video_id);
            }
        }
        // remove the user_practice (favorite) relationship (many)
        $favorited_users = $practice->first()->users()->get();
        foreach($favorited_users as $user){
            $practice->first()->users()->detach($user);
        }

        // remove the practice
        $practice->delete();
        return redirect()->to('/practices');
    }

    public function render()
    {
        return view('livewire.practice.practice-remove');
    }
}