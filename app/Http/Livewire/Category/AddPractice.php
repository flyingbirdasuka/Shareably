<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use Google\Service\Drive;
use App\Traits\GoogleSetup;
use DB;

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
                        $this->addToGoogleDrive($user->id, $practice->video_id, '+3 days');
                        // $this->addToGoogleDrive($user_id, $practiceIds);
                    }
                }

            }
        }

        // if the practice was removed then detach from the category
        foreach($original_practices as $original_practice){
            if(!in_array(intval($original_practice), $this->add_practice )){
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

    public function addToGoogleDrive($user_id, $practice_id, $expirationDate = null){

        $driveService = $this->googleSetup();

        // Set up the new permission settings
        $permission = new Drive\Permission([
            'type' => 'user',
            'role' => 'reader', // Choose the appropriate role (reader, writer, etc.)
            'emailAddress' => User::find($user_id)->email,
        ]);

        // If an expiration date is specified, set it
        if ($expirationDate) {
            $permission->setExpirationTime(date('c', strtotime($expirationDate)));
            // save to the database
            DB::table('user_categories')->where('user_id', $user_id)->update(['expiration_date' => date('c', strtotime($expirationDate))]);
        }

        // Send the request to update the file permission
        try {
            $driveService->permissions->create($practice_id, $permission);
            // Permission changed successfully
            // dd('worked', $permission);
        } catch (\Exception $e) {
            // An error occurred
            // dd('not worked', $permission, $e);
        }

    }

    public function removeFromGoogleDrive($user_id, $practice_id){
        $driveService = $this->googleSetup();

        $parameters = array();
        $parameters['fields'] = "permissions(*)";
        // get the list of the permissions of this file
        $permissions = $driveService->permissions->listPermissions($practice_id, $parameters);
        $emailAddress = User::find($user_id)->email;
        // Get the permission ID for the specific user (if it exists)
        $permissionId = $this->getPermissionId($permissions, $emailAddress);
        // remove the user from the google drive file
        if($permissionId){
            $driveService->permissions->delete($practice_id, $permissionId);
        }
    }

    public function render()
    {
        return view('livewire.category.add-practice');
    }
}