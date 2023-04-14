<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_as_admin()
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

        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);

        $response = $this->actingAs($user)->get('/logout');

    }

    public function test_logout_as_non_admin()
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

        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $this->actingAs($user)->get('/login');
        $response = $this->get('/logout');
        $this->assertNotEmpty(Session::get('data')); // check the session data 
    }
}
