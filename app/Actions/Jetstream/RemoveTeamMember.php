<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Users\RemoveUser;


class RemoveTeamMember implements RemovesTeamMembers
{
    /**
     * Remove the team member from the given team.
     */
    public function remove(User $user, Team $team, User $teamMember): void
    {

        if($user->is_admin){

            $this->ensureUserDoesNotOwnTeam($teamMember, $team);
            // check if the user belongs to multiple teams.
            $belongingTeams = $teamMember->allTeams();
            $switchableTeams = [];
            foreach ($belongingTeams as $belongingTeam) {
                $belongingTeam->id != $team->id && array_push($switchableTeams,$belongingTeam);
            }
            $team->removeUser($teamMember);
            TeamMemberRemoved::dispatch($team, $teamMember);
            if(count($switchableTeams) > 0){ // if the user belongs to multiple teams then switch the current team
                $this->switchTeam($teamMember, $switchableTeams);
            } else { // remove the user from the platform
                RemoveUser::delete($teamMember->id);
            }
        }

    }

    /**
     * Authorize that the user can remove the team member.
     */
    protected function authorize(User $user, Team $team, User $teamMember): void
    {
        if (! Gate::forUser($user)->check('removeTeamMember', $team) &&
            $user->id !== $teamMember->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     */
    protected function ensureUserDoesNotOwnTeam(User $teamMember, Team $team): void
    {
        if ($teamMember->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamMember');
        }
    }

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam($teamMember, $switchableTeams)
    {
        User::where('id', $teamMember->id)->update([
            'current_team_id' => $switchableTeams[0]->id
        ]);
    }

}
