<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use App\Traits\GoogleSetup;

class AddPractice extends ModalComponent
{
    use GoogleSetup;
    public $all_practices;
    public $category_id;
    public $category;
    public $users;
    public $add_practice = [];

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->all_practices = Practice::orderBy('title')->get();
        $this->category = Category::find($category_id);
        $this->add_practice = $this->category->practices()->pluck('practices.id')->all();
        $this->users = Category::find($category_id)->users()->get();

    }
   
    public function update_practice()
    {
        $original_practices = $this->category->practices()->get()->pluck('id')->toArray();

        // if the practice is added new then attatch to the category
        foreach($this->add_practice as $practice_id){
            if(!in_array(intval($practice_id), $original_practices)){
                // attatch the user to the category
                Category::where('id',$this->category_id)->first()->practices()->attach($practice_id);

                $practice = Practice::find($practice_id);
                // and if the practice has a google video then give the user a permission
                if($practice->video_type == 1){
                    foreach($this->users as $user){
                        $this->addToGoogleDrive($user->id, $practice->video_id, '+1 days', $this->category_id);
                        // $this->addToGoogleDrive($user->id, $practice->video_id );
                    }
                }

            }
        }

        // if the practice was removed then detach from the category
        foreach($original_practices as $original_practice){
            if(!in_array(intval($original_practice), $this->add_practice)){
                // and if the practice has a google video then remove a permission
                $practice = Practice::find($original_practice);
                foreach($this->users as $user){
                    $this->removeFromGoogleDrive($user->id, $practice->video_id);
                }
                Category::find($this->category_id)->practices()->detach($original_practice);
            }
        }
        return redirect('categories/'.$this->category_id);
    }

    public function render()
    {
        return view('livewire.category.add-practice');
    }
}