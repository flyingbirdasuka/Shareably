<?php

namespace App\Traits;

use Google\Client;
use Google\Service\Drive;

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

}