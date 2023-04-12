<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_category()
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
        
        Category::create([
            'title' => 'Test Title',
            'description'  => 'Test Description',
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        $categories = Category::all();
        $this->assertCount(1, $categories);
        $this->assertEquals('Test Title', $categories->first()->title);
        
    }

    public function test_update_category()
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
        
        Category::create([
            'title' => 'Test Title',
            'description'  => 'Test Description',
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        Category::first()->update([
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

        $categories = Category::all();
        $this->assertCount(1, $categories);
        $this->assertEquals('Updated Title', $categories->first()->title);
        
    }
}
