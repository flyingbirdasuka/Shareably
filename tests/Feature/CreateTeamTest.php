<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;
use Carbon\Carbon;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_created_by_admin(): void
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
        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('createTeam');
        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
    public function test_teams_can_be_created_by_non_admin(): void
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
        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('createTeam');
        $this->assertCount(0, $user->fresh()->ownedTeams);
    }
}
