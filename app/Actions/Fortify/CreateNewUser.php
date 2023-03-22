<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\TeamInvitation;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public $invited_teams = '';
    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                // $this->createTeam($user);

                // when the user click on the email invitation, it makes sure that the user will be added to the invited team even from registration form and delete the invite.
                $pendingInvitations = TeamInvitation::where('email', '=', $user->email)->get();

                if($pendingInvitations && count($pendingInvitations) > 0){
                    $this->addToDefaultTeam($user);
                    $this->addDefaultUserSetting($user);

                    foreach ($pendingInvitations as $invitation) {
                        if($invitation->team->id != 1){
                            app(AddsTeamMembers::class)->add(
                                $invitation->team->owner,
                                $invitation->team,
                                $invitation->email,
                                $invitation->role
                            );
                        }

                        if(strlen($this->invited_teams)>0){
                            $this->invited_teams .= ', '. $invitation->team->name;
                        } else {
                            $this->invited_teams .= $invitation->team->name;
                        }
                        $invitation->delete();

                    }
                    return redirect(config('fortify.home'))->banner(
                        __('Great! You have accepted the invitation to join :team team.', ['team' => $this->invited_teams]),
                    );
                }

            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }

    /**
     * Add to default team
     */
    protected function addToDefaultTeam(User $user): void
    {
        // For now 1 is the hardcoded default team that comes from the migration
        $teamToAssign = Team::find(1);
        $teamToAssign->users()->attach($user, array('role' => 'reader'));

        $user->switchTeam($teamToAssign);

        $user->update();
    }

    /**
     * Add default user setting
     */
    protected function addDefaultUserSetting(User $user)
    {
        $user_settings = $user->user_settings()->create([
            'notification_setting' => 1,
            'sound_setting' => 1,
        ]);
    }
}