<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;
use App\Traits\GoogleSetup;

class CategoryRemove extends ModalComponent
{
    use GoogleSetup;
    public $category_id;

    public function mount($category_id)
    {
        
        $this->category_id = $category_id;
    }

    public function delete()
    {
        $category = Category::where('id', $this->category_id);
        $practices = $category->first()->practices()->get();
        $users = $category->first()->users()->get();

        // remove the practice_category relationship
        foreach($practices as $practice){
            if($practice->video_type == 1){ // if the practice contains a google drive video
                foreach($users as $user){
                    if($user->is_admin == 0){ // if the user is not admin, remove the google drive permission
                        $driveService = $this->googleSetup();
                        $this->removeFromGoogleDrive($user->id, $practice->video_id, $this->category_id);
                    }
                }
            }
            $category->first()->practices()->detach($practice);
        }
        
        // remove the user_category relationship
        foreach($users as $user){
            $category->first()->users()->detach($user);
        }

        // remove the category
        $category->delete();

        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.category-remove');
    }
}