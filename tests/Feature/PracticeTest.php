<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Practice;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPractice;
use Illuminate\Http\UploadedFile;

class PracticeTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_practice()
    {
        $user = User::create([
            'name' => 'Asuka Method2',
            'email' => 'admin2@admin2.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$3jAFcCj6Gkeigpf.UCEzUuA.xXhIIrrxjYK7xtciBI4bXCAp.cI4.',
            // vLe064h$0PdN
            'is_admin' => 1,
            'current_team_id' => 1, // default all user team
        ]);

        $this->actingAs($user);
        
        $practice  = Practice::create([
            'title' => 'Test Title',
            'description'  => 'Test Description',
            'video_id' => 'ABCDEFG12345',
        ]);

        // PDF file
        $file = UploadedFile::fake()->create('file.pdf');
        $filename = $file->getClientOriginalName();
        $unique_name = uniqid().'-'.$filename;
        $practice->musicsheets()->create([
            'title' => 'Test Title',
            'filename' => $unique_name
        ]);

        $file->storeAs('/', $unique_name, $disk = 'practice');

        // music file
        $music_file = UploadedFile::fake()->create('music.mp3');
        $music_name = $music_file->getClientOriginalName();
        $music_unique_name = uniqid().'-'.$music_name;
        $practice->musics()->create([
            'title' => 'Test Title',
            'filename' => $music_unique_name
        ]);

        $music_file->storeAs('/', $music_unique_name, $disk = 'practice');


        // to attach to the new practice upload notification email
        $url = url("/practices/{$practice->id}");

        $all_users = []; // get all the users which are subscribed to the attatched categories
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

        foreach ([1,2,3] as $category_id){
            $practice->categories()->attach($category_id); // practice_categories relationship
           
            array_push($all_users,['id'=> $non_admin_user->id, 'email'=> $non_admin_user->email,'name' => $non_admin_user->name]);
        }

        // to avoid sending multiple times to the same user (when user are subscribed to the multiple categories)
        $unique_users = array_map("unserialize",array_unique(array_map("serialize", $all_users)));
        foreach(array_unique($unique_users) as $user){
            $name = $user['name'];
            $unsubscribe = url("/email-setting/{$user['id']}");
            Mail::to($user['email'])->send(new NewPractice($practice, $url, $name, $unsubscribe));
        }

        $practices = Practice::all();
        $this->assertCount(1, $practices);
        $this->assertEquals('Test Title', $practices->first()->title);
        
    }
}
