<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        foreach(User::where('current_team_id', $team->id)->get() as $user){
            User::where('id', $user->id)->update([
                'current_team_id' => 1
            ]);
        }
        $team->purge();
    }
}
