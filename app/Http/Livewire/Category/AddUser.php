<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use App\Models\UserCategories;
use LivewireUI\Modal\ModalComponent;
use Google\Client;
use Google\Service\Drive;
use DB;

class AddUser extends ModalComponent
{

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

        // if the user is added new then attatch to the category
        foreach($this->users as $user_id){
            if(!in_array(intval($user_id), $original_users)){
                // attatch the user to the category
                Category::where('id',$this->category_id)->first()->users()->attach($user_id);

                // loop through the related video's and add the permission to the google drive
                // 1. get all the practices which is realated to this category and loop through the practices and check if the related video is from google drive (video_type is 1)
                $practiceIds = Category::where('id',$this->category_id)->first()->practices()->get()->where('video_type',2)->pluck('video_id')->toArray();

                // 2. if it is then add the user to the google drive video (id of the video and user email)
                $this->addToGoogleDrive($user_id, $practiceIds, '+3 days');

            }
        }

        // if the user was removed then detach from the category
        foreach($original_users as $original_user){
            if(!in_array(intval($original_user), $this->users )){
                Category::find($this->category_id)->users()->detach($original_user);
            }
        }

        return redirect('categories/'.$this->category_id);
    }

    public function addToGoogleDrive($user_id, $practiceIds, $expirationDate = null){

        // Set up the Google API client
        $client = new Client();
        $client->setAuthConfig(config_path('googleaccess.json'));
        $client->setAccessType('offline'); // This ensures we get a refresh token for long-term access
        $client->setApprovalPrompt('force');
        $client->setAccessToken($client->fetchAccessTokenWithRefreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN')));

        // If the access token has expired, refresh it
        if ($client->isAccessTokenExpired()) {
            $client->setAccessToken($client->fetchAccessTokenWithRefreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN')));
        }

        // Create the Drive service
        $driveService = new Drive($client);

        // Set up the new permission settings
        $permission = new Drive\Permission([
            'type' => 'user',
            'role' => 'reader', // Choose the appropriate role (reader, writer, etc.)
            'emailAddress' => User::find($user_id)->email, // Replace with the email address of the user
        ]);

        // If an expiration date is specified, set it
        if ($expirationDate) {
            $permission->setExpirationTime(date('c', strtotime($expirationDate)));
            // save to the database
            // dd($user_id, DB::table('user_categories')->where('user_id', $user_id)->first());
            DB::table('user_categories')->where('user_id', $user_id)->update(['expiration_date' => date('c', strtotime($expirationDate))]);
        }

        // Send the request to update the file permission
        try {
            foreach ($practiceIds as $id) {                 
                $driveService->permissions->create($id, $permission);
            }
            // Permission changed successfully
            // dd('worked', $permission);
        } catch (\Exception $e) {
            // An error occurred
            // dd('not worked', $permission, $e);
        }

    }

    public function render()
    {
        return view('livewire.category.add-user');
    }
}