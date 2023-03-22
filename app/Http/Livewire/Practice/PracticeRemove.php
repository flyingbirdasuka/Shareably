<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use LivewireUI\Modal\ModalComponent;

class PracticeRemove extends ModalComponent
{

    public $practice_id; 

    public function mount($practice_id)
    {
        $this->practice_id = $practice_id;
    }

    public function delete()
    {
        $practice = Practice::where('id', $this->practice_id);

        // remove the music_practice relationship and remove the music
        // $musics = $practice->first()->musics()->get();
        // foreach($musics as $music){
        //     $practice->first()->musics()->detach($music);
        //      $music->delete();
        // }

        // remove the musicsheet_practice relationship and remove the musicsheet
        $musicsheets = $practice->first()->musicsheets()->get();
        foreach($musicsheets as $musicsheet){
            $practice->first()->musicsheets()->detach($musicsheet);
            $musicsheet->delete();
        }

        // remove the practice_category relationship (many)
        $categories = $practice->first()->categories()->get();
        foreach($categories as $category){
            $practice->first()->categories()->detach($category);
        }

        // remove the user_practice (favorite) relationship (many)
        $users = $category->first()->users()->get();
        foreach($users as $user){
            $category->first()->users()->detach($user);
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
