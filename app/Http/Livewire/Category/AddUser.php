<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;
use Google\Client;
use Google\Service\Drive;

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
        foreach($this->users as $user){
            if(!in_array(intval($user), $original_users)){
                // attatch the user to the category
                // Category::where('id',$this->category_id)->first()->users()->attach($user);

                // loop through the related video's and add the permission to the google drive
                // 1. get all the practices which is realated to this category and loop through the practices and check if the related video is from google drive (video_type is 1)
                $practices = Category::where('id',$this->category_id)->first()->practices()->get()->where('video_type',2);

                // 2. if it is then add the user to the google drive video (id of the video and user email)
                $user_email = User::find($user)->email;

                $this->addToGoogleDrive($user_email);

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

    public function addToGoogleDrive($email){
        // $fs = Storage::disk('google');

        // $contents = $fs->listContents('Others', true /* is_recursive */);
        // $ids = ['1pTz-_-WPMnGrmAKQbAug326xSgu9b0v6ylXDgl8cbbs'];
        // foreach ($contents as $item) {
        //     // check if the file id is in the practices id of the category
        //     if(in_array($item['extraMetadata']['id'], $ids )){
        //         dd($item['extraMetadata']['id'], $item);
        //     }
        //     // dd($item->path(), $item['type'], $item['extraMetadata']['id'] );
        // }

        // dd($contents);

        // Load Composer's autoloader
        // require 'vendor/autoload.php';

        // Set up the Google API client
        $client = new Client();
        $client->setAuthConfig(config_path('googleaccess.json'));
        $client->setAccessType('offline'); // This ensures we get a refresh token for long-term access
        $client->setApprovalPrompt('force');
        $client->refreshToken('1//04TdkVOdO6XhkCgYIARAAGAQSNwF-L9IrsQga6sKpUryF6Reorg9pSTSGSASCfy_OJzCdizz7i-KyYvCCBFgawdvgfDrFfYyCIfA');
        $client->setAccessToken('ya29.a0AbVbY6NhtJs350crwQITsQLs4xu2DDtwcntWhXJuJ2czm-nrivUyRmZTymoPdedDv9ZcpYjy5Gnhbz0OQt8jYFVQEG50bj__X3ZUKahmfyHh-Xqq8yzyAtkcQapdieqoovppwRX7Bg1T4kOziEZ4VWVapUmmhhIkaCgYKAYQSARISFQFWKvPl2dkCw2PJmZ-A6ODizv63XQ0167');

        // If the access token has expired, refresh it
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken('1//04TdkVOdO6XhkCgYIARAAGAQSNwF-L9IrsQga6sKpUryF6Reorg9pSTSGSASCfy_OJzCdizz7i-KyYvCCBFgawdvgfDrFfYyCIfA');
            file_put_contents('ya29.a0AbVbY6NhtJs350crwQITsQLs4xu2DDtwcntWhXJuJ2czm-nrivUyRmZTymoPdedDv9ZcpYjy5Gnhbz0OQt8jYFVQEG50bj__X3ZUKahmfyHh-Xqq8yzyAtkcQapdieqoovppwRX7Bg1T4kOziEZ4VWVapUmmhhIkaCgYKAYQSARISFQFWKvPl2dkCw2PJmZ-A6ODizv63XQ0167', json_encode($client->getAccessToken()));
        }

        // Create the Drive service
        $driveService = new Drive($client);

        // Replace 'your_file_id' with the actual ID of the file for which you want to change permissions
        $fileId = '1pTz-_-WPMnGrmAKQbAug326xSgu9b0v6ylXDgl8cbbs';

        // Set up the new permission settings
        $permission = new Drive\Permission([
            'type' => 'user',
            'role' => 'reader', // Choose the appropriate role (reader, writer, etc.)
            'emailAddress' => 'tomshaddock@googlemail.com', // Replace with the email address of the user
        ]);

        
        // Send the request to update the file permission
        try {
            $driveService->permissions->create($fileId, $permission);
            dd('worked', $permission);
            // Permission changed successfully
        } catch (\Exception $e) {
            dd('not worked', $permission);
            // An error occurred
            // Handle the error as needed
        }
        foreach($practices as $practice){
            $video_id = $practice->video_id;
            // attach to the google drive via a post request

        }
    }

    public function render()
    {
        return view('livewire.category.add-user');
    }
}