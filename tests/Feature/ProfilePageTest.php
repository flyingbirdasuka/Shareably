<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Illuminate\Support\Facades\Response;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Practice;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_as_admin()
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
        $response =  $this->actingAs($user)->get('/user/profile');
        $response->assertSee('Asuka Method2');
        $response->assertSee('admin2@admin2.com');
    }

    // this only works when Features::emailVerification() is turned off on config fortify.php
    // public function test_profile_category_page_as_non_admin()
    // {
    //     $user = User::create([
    //         'name' => 'Asuka Method Non Admin',
    //         'email' => 'non_admin@non_admin.com',
    //         'email_verified_at' => Carbon::now(),
    //         'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
    //         // vLe064h$0PdN
    //         'is_admin' => 0,
    //         'current_team_id' => 1, // default all user team
    //         "created_at" =>  Carbon::now(),
    //         "updated_at" => Carbon::now(),
    //     ]);

    //     $hasUser = $user ? true : false;
    //     $this->assertTrue($hasUser);
    //     $category = DB::table('categories')->insert(
    //         array(
    //             'title' => 'Test Title',
    //             "created_at" =>  Carbon::now(),
    //             "updated_at" => Carbon::now(),
    //         )
    //     );
    //     DB::table('user_categories')->insert(
    //         array(
    //             'user_id' => $user->id,
    //             'category_id' => Category::first()->id,
    //             "created_at" =>  Carbon::now(),
    //             "updated_at" => Carbon::now(),
    //         )
    //     );
    //     $this->actingAs($user)->get('/login');
    //     $response =  $this->get('/categories');
    //     $response->assertSee('Test Title');
    // }

    // this only works when Features::emailVerification() is turned off on config fortify.php
//     public function test_favorite_practice_as_non_admin()
//     {
//         $user = User::create([
//             'name' => 'Asuka Method Non Admin',
//             'email' => 'non_admin@non_admin.com',
//             'email_verified_at' => Carbon::now(),
//             'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
//             // vLe064h$0PdN
//             'is_admin' => 0,
//             'current_team_id' => 1, // default all user team
//             "created_at" =>  Carbon::now(),
//             "updated_at" => Carbon::now(),
//         ]);

//         $hasUser = $user ? true : false;
//         $this->assertTrue($hasUser);
//         $practice = DB::table('practices')->insert(
//             array(
//                 'title' => 'Test Title',
//                 "created_at" =>  Carbon::now(),
//                 "updated_at" => Carbon::now(),
//             )
//         );
//         DB::table('favorites')->insert(
//             array(
//                 'user_id' => $user->id,
//                 'practice_id' => Practice::first()->id,
//                 "created_at" =>  Carbon::now(),
//                 "updated_at" => Carbon::now(),
//             )
//         );

//         $this->actingAs($user)->get('/login');
//         $response =  $this->get('/practices');
//         $response->assertSee('Test Title');
//     }
}