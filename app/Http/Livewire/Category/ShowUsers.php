<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use App\Traits\GoogleSetup;

class ShowUsers extends ModalComponent
{
    use GoogleSetup;
    public $category_id;
    public $category;
    public $users;
    public $user_id;
    public $delete_id;

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->category = Category::find($category_id);
        $this->users = $this->category->users()->orderBy('name')->get();
    }

    public function updatedUserId()
    {
        $practices = Category::find($this->category_id)->practices()->get();
        foreach($practices as $practice){
            if($practice->video_type == 1){ // if the practice has a google drive video then remove the user's permission
                $this->removeFromGoogleDrive($this->user_id, $practice->video_id, $this->category_id);
            }
        }
        Category::where('id',$this->category->id)->first()->users()->detach($this->user_id);
        return redirect('categories/'.$this->category->id);
    }

    public function render()
    {
        return view('livewire.category.show-users');
    }

}