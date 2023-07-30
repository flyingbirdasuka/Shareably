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
            if(is_array($practice_id)){
                foreach ($practice_id as $id) {
                    $driveService->permissions->create($id, $permission);
                }
            } else {
                $driveService->permissions->create($practice_id, $permission);
            }

            // Permission changed successfully
            // dd('worked', $permission);
        } catch (\Exception $e) {
            // An error occurred
            // dd('not worked', $permission, $e);
        }

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