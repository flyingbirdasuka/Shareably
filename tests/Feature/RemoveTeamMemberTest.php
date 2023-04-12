<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class RemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_can_be_removed_from_teams(): void
    {
        // get the default admin user
        $user = User::first();

        // create a new non admin user
        $non_admin_user = User::create([
            'name' => 'Asuka Method Non Admin',
            'email' => 'non_admin@non_admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
            // vLe064h$0PdN
            'is_admin' => 0,
            'current_team_id' => 1, // default all user team
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        $this->actingAs($user);

        // attacht the non admin user into the team
        $user->currentTeam->users()->attach(
            $otherUser = $non_admin_user, ['role' => 'admin']
        );

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->set('teamMemberIdBeingRemoved', $otherUser->id)
                        ->call('removeTeamMember');

        $this->assertCount(1, $user->currentTeam->fresh()->users);
    }

    // public function test_only_team_owner_can_remove_team_members(): void
    // {
    //     $user = User::factory()->withPersonalTeam()->create();

    //     $user->currentTeam->users()->attach(
    //         $otherUser = User::factory()->create(), ['role' => 'admin']
    //     );

    //     $this->actingAs($otherUser);

    //     $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
    //                     ->set('teamMemberIdBeingRemoved', $user->id)
    //                     ->call('removeTeamMember')
    //                     ->assertStatus(403);
    // }
}
