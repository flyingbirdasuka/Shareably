<?php

namespace App\Traits;

use Google\Client;
use Google\Service\Drive;
use App\Models\User;
use DB;

trait GoogleSetup {

    public function googleSetup(){
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
        return $driveService;
    }

    function getPermissionId($permissions, $emailAddress)
    {
        foreach ($permissions as $permission) {
            if ($permission->emailAddress === $emailAddress) {
                return $permission->id;
            }
        }
        return null;
    }

    function getPermissionExpirationDate($permissions, $emailAddress)
    {
        foreach ($permissions as $permission) {
            if ($permission->emailAddress === $emailAddress) {
                return $permission->expirationTime;
            }
        }
        return null;
    }

    function setExpirationDate($driveService, $overwrapped_categories, $practice_id, $emailAddress, $expirationDate){
        $expirationDate;
        foreach($overwrapped_categories as $category){
            // check if the category has a same practice
            $overwrapped_practice = $category->practices()->where('video_id', $practice_id)->get();
            // if a same practice is in the category, then check the expiration date
            if(count($overwrapped_practice) != 0 ){ // if it exists then it should be 1
                // check the expiration date of the permission
                $parameters = array();
                $parameters['fields'] = "permissions(*)";
                // get the list of the permissions of this file
                $permissions = $driveService->permissions->listPermissions($practice_id, $parameters);
                // Get the permission ID for the specific user (if it exists)
                $permission_id = $this->getPermissionId($permissions, $emailAddress);
                // check the expiration date 
                $original_expiration_date = $this->getPermissionExpirationDate($permissions, $emailAddress);
                if($expirationDate == null){
                    $expirationDate = $expirationDate;
                } else if(strtotime($original_expiration_date) <= strtotime($expirationDate)){
                    $expirationDate = $expirationDate;
                } else {
                    $expirationDate = $original_expiration_date;
                }
            }

        }
        return $expirationDate;
    }

    public function createPermission($emailAddress, $user_id, $expirationDate){
        // Set up the new permission settings
        $permission = new Drive\Permission([
            'type' => 'user',
            'role' => 'reader', // Choose the appropriate role (reader, writer, etc.)
            'emailAddress' => $emailAddress,
        ]);

        // If an expiration date is specified, set it
        if ($expirationDate) {
            $permission->setExpirationTime(date('c', strtotime($expirationDate)));
            // save to the database
            DB::table('user_categories')->where('user_id', $user_id)->update(['expiration_date' => date('c', strtotime($expirationDate))]);
        }
        return $permission;
    }
    
    public function addToGoogleDrive($user_id, $practice_id, $expirationDate = null, $category_id){
        $driveService = $this->googleSetup(); 
        $emailAddress = User::find($user_id)->email;
        // check if the user is related to another category to give the longest expiration date
        $overwrapped_categories = User::find($user_id)->categories()->where('category_id','!=', $category_id)->get();
        // Send the request to update the file permission
        // try {
        if(is_array($practice_id)){
            foreach ($practice_id as $id) {
                if(count($overwrapped_categories)!= 0){
                    $expirationDate = $this->setExpirationDate($driveService,$overwrapped_categories,$id,$emailAddress, $expirationDate);
                }
                $permission = $this->createPermission($emailAddress, $user_id, $expirationDate);
                $driveService->permissions->create($id, $permission);
            }
        } else {
            if(count($overwrapped_categories)!= 0){
                $expirationDate = $this->setExpirationDate($driveService,$overwrapped_categories,$practice_id,$emailAddress, $expirationDate);
            }
            $permission = $this->createPermission($emailAddress, $user_id, $expirationDate);
            $driveService->permissions->create($practice_id, $permission);
        }
        // dd('created', $permission);
            // Permission changed successfully
            // dd('worked', $permission);
        // } catch (\Exception $e) {
        //     // An error occurred
        //     dd('not worked', $permission, $e);
        // }

    }

    public function removeFromGoogleDrive($user_id, $practice_id){
        $driveService = $this->googleSetup();

        if(is_array($practice_id)){
            foreach ($practice_id as $id) {
                $parameters = array();
                $parameters['fields'] = "permissions(*)";
                // get the list of the permissions of this file
                $permissions = $driveService->permissions->listPermissions($id, $parameters);
                $emailAddress = User::find($user_id)->email;
                // Get the permission ID for the specific user (if it exists)
                $permission_id = $this->getPermissionId($permissions, $emailAddress);
                // remove the user from the google drive file
                if($permission_id){
                    $driveService->permissions->delete($id, $permission_id);
                }
            }
        } else {
            $parameters = array();
            $parameters['fields'] = "permissions(*)";
            // get the list of the permissions of this file
            $permissions = $driveService->permissions->listPermissions($practice_id, $parameters);
            $emailAddress = User::find($user_id)->email;
            // Get the permission ID for the specific user (if it exists)
            $permission_id = $this->getPermissionId($permissions, $emailAddress);
            // remove the user from the google drive file
            if($permission_id){
                $driveService->permissions->delete($practice_id, $permission_id);
            }
        }

    }


}