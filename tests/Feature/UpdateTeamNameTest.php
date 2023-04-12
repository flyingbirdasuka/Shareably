<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class UpdateTeamNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_names_can_be_updated_by_admin(): void
    {
        $user = User::where('is_admin', 1)->first();

        $this->actingAs($user);
        // $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(UpdateTeamNameForm::class, ['team' => $user->currentTeam])
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('updateTeamName');

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->currentTeam->fresh()->name);
    }

    public function test_team_names_can_be_updated_by_non_admin(): void
    {
        $user = User::create([
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
        // $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(UpdateTeamNameForm::class, ['team' => $user->currentTeam])
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('updateTeamName');

        $this->assertCount(0, $user->fresh()->ownedTeams);
        $this->assertNotEquals('Test Team', $user->currentTeam->fresh()->name);
    }
}
