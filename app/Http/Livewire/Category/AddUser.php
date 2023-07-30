<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use App\Models\UserCategories;
use LivewireUI\Modal\ModalComponent;
use App\Traits\GoogleSetup;

class AddUser extends ModalComponent
{

    use GoogleSetup;
    public $user_id;
    public $category_id;
    public $users =[];
    public $all_users = [];

    public function mount($category_id)
    {
        $this->category_id = $category_id;
        $this->users = Category::find($this->category_id)->users()->get()->pluck('id');
        $this->all_users = User::all()->where('is_admin', 0)->sortBy('name');
    }

    public function add()
    {
        $original_users = Category::find($this->category_id)->users()->get()->pluck('id')->toArray();

        // get all the practices which is realated to this category and loop through the practices and check if the related video is from google drive (video_type is 1)
        $practiceIds = Category::where('id',$this->category_id)->first()->practices()->get()->where('video_type',1)->pluck('video_id')->toArray();

        // if the user is added new then attatch to the category
        foreach($this->users as $user_id){
            if(!in_array(intval($user_id), $original_users)){
                // attatch the user to the category
                Category::where('id',$this->category_id)->first()->users()->attach($user_id);

                // add the user to the google drive video (id of the video and user email)
                $this->addToGoogleDrive($user_id, $practiceIds, '+3 days');
                // $this->addToGoogleDrive($user_id, $practiceIds);

            }
        }

        // if the user was removed then detach from the category
        foreach($original_users as $original_user){
            if(!in_array(intval($original_user), $this->users)){
                // remove the user to the google drive video
                $this->removeFromGoogleDrive($original_user, $practiceIds);

                Category::find($this->category_id)->users()->detach($original_user);
            }
        }

        return redirect('categories/'.$this->category_id);
    }

    public function render()
    {
        return view('livewire.category.add-user');
    }
}