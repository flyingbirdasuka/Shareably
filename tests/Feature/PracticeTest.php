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
use Storage;

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

        $category_1  = Category::create([
            'title' => 'Category 1',
            'description' => 'Category Description',
        ]);

        $category_2  = Category::create([
            'title' => 'Category 2',
            'description' => 'Category Description',
        ]);

        foreach ([$category_1->id, $category_2->id] as $category_id){
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

    public function test_edit_practice()
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
    
        $new_practice = Practice::first();

        $new_practice->update([
            'title' => 'Updated Title',
        ]);

        $new_practice = Practice::first();
        // where a new PDF is uploaded
        Storage::delete('/practice/'.$unique_name); // delete the file
        $new_practice->musicsheets()->detach(); // detach the relationship
        $new_practice->musicsheets()->delete(); // delete the previous musicsheet in DB

        // add the new file
        $new_file = UploadedFile::fake()->create('new_file.pdf');
        $new_filename = $new_file->getClientOriginalName();
        $new_unique_name = uniqid().'-'.$new_filename;
        $new_practice->musicsheets()->create([
            'title' => 'Update Title',
            'filename' =>$new_unique_name,
        ]);
        $new_file->storeAs('/', $new_unique_name, $disk = 'practice');


        // update the attatched categories
        // remove the original category for this practice
        foreach($new_practice->categories()->get() as $original_category){
            $new_practice->categories()->detach($original_category);
        }
        $category_1  = Category::create([
            'title' => 'Category 1',
            'description' => 'Category Description',
        ]);

        $category_2  = Category::create([
            'title' => 'Category 2',
            'description' => 'Category Description',
        ]);

        // add the new categories into this practice
        foreach ([$category_1->id, $category_2->id] as $category_id){
            $new_practice->categories()->attach($category_id);
        }


        $practices = Practice::all();
        $this->assertCount(1, $practices);
        $this->assertEquals(2, $new_practice->categories()->count());
        $this->assertEquals('Updated Title', $new_practice->title);
    }

    public function test_delete_practice()
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

        // remove the musicsheet_practice relationship and remove the musicsheet
        $musicsheets = $practice->first()->musicsheets()->get();
        foreach($musicsheets as $musicsheet){
            $practice->first()->musicsheets()->detach($musicsheet);
            Storage::delete('/practice/'.$musicsheet->filename); // delete the file
            $musicsheet->delete();
        }

        // remove the practice_category relationship (many)
        $categories = $practice->first()->categories()->get();
        foreach($categories as $category){
            $practice->first()->categories()->detach($category);
        }

         // remove the user_practice (favorite) relationship (many)
         $users = $practice->first()->users()->get();
         foreach($users as $user){
             $practice->first()->users()->detach($user);
         }

        // remove the practice
        $practice->delete();

        $practices = Practice::all();

        $this->assertCount(0, $practices);

    }
}
