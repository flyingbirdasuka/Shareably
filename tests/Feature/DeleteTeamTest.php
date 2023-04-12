<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_deleted(): void
    {
        $user = User::create([
            'name' => 'Asuka Method2',
            'email' => 'admin2@admin2.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
            // vLe064h$0PdN
            'is_admin' => 1,
            'current_team_id' => 1, // default all user team
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        $this->actingAs($user);
        // $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => false,
        ]));

        $team->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'test-role']
        );

        $component = Livewire::test(DeleteTeamForm::class, ['team' => $team->fresh()])
                                ->call('deleteTeam');

        $this->assertNull($team->fresh());
        $this->assertCount(0, $otherUser->fresh()->teams);
    }

    // public function test_personal_teams_cant_be_deleted(): void
    // {
    //     $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    //     $component = Livewire::test(DeleteTeamForm::class, ['team' => $user->currentTeam])
    //                             ->call('deleteTeam')
    //                             ->assertHasErrors(['team']);

    //     $this->assertNotNull($user->currentTeam->fresh());
    // }
}
