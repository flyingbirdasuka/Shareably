<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;
use App\Traits\GoogleSetup;

class RemovePractice extends ModalComponent
{

    use GoogleSetup;
    public $practice_id;
    public $category_id;

    public function mount($practice_id, $category_id)
    {
        $this->practice_id = $practice_id;
        $this->category_id = $category_id;
    }

    public function delete()
    {
        // if the practice has a google drive video
        $practice = Practice::find($this->practice_id);
        if($practice->video_type == 1){
            $driveService = $this->googleSetup();
            // get the users from the google drive permission and when the user is not the admin then remove them 
            $users = Category::find($this->category_id)->users()->where('is_admin', 0)->get();
            foreach($users as $user){
                $this->removeFromGoogleDrive($user->id, $practice->video_id, $this->category_id);
            }
        }
        Category::where('id',$this->category_id)->first()->practices()->detach($this->practice_id);
        return redirect('categories/'.$this->category_id);
    }
    public function render()
    {
        return view('livewire.category.remove-practice');
    }
}
