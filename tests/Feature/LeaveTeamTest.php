<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_leave_teams(): void
    {
        // Create new admin user
        $user = User::create([
            'name' => 'Asuka Method Non Admin',
            'email' => 'non_admin@non_admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
            // vLe064h$0PdN
            'is_admin' => 1,
            'current_team_id' => 1, // default all user team
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Create a new team
        $this->actingAs($user);
        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('createTeam');

        // Check user is in the new team
        $this->assertCount(1, $user->fresh()->ownedTeams);

        // Check they can leave the team.
        $this->actingAs($user);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->call('leaveTeam');
        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team(): void
    {
        // Get first registered user
        $user = User::first();
        $this->actingAs($user);

        // Try to leave the team and pass if there's errors
        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->call('leaveTeam')
                        ->assertHasErrors(['team']);

        // Check they're actually in a team
        $this->assertNotNull($user->currentTeam->fresh());
    }
}
