<?php

namespace App\Http\Livewire\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

// use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use App\Models\Team;


class GoogleLogin extends Auth
{
    /**
     * Redirect the user to the authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        try {
            //create a user using socialite driver google
            $user = Socialite::driver('google')->user();

            // if the user exits, use that user and login
            $finduser = User::where('email', $user->email)->first();

            if($finduser){
                //if the user exists via email check, login and show dashboard
                Auth::login($finduser);
                return redirect('/dashboard');
            }
            /* -- Code was for new users who are creatd via SSO, this is no longer needed and has been commented out for now.
            else {
                //user is not yet created, so create first
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('')
                ]);
                //every user needs a team for dashboard/jetstream to work.
                // Add the user to the default team so it works

                dd($newUser);
                
                //create a personal team for the user
                $newTeam = Team::forceCreate([
                    'user_id' => $newUser->id,
                    'name' => explode(' ', $user->name, 2)[0]."'s Team",
                    'personal_team' => true,
                ]);
                // save the team and add the team to the user.
                $newTeam->save();
                $newUser->current_team_id = $newTeam->id;
                $newUser->save();
                //login as the new user
                Auth::login($newUser);
                // go to the dashboard
                return redirect('/dashboard');
            }
            */
            //catch exceptions
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
