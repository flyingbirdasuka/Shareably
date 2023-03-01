<?php

namespace Database\Seeders;

use DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Music;
use App\Models\MusicSheet;
use App\Models\Language;
use App\Models\Practice;
use App\Models\UserSettings;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // User::truncate(); // not to delete the default user
        Category::truncate();
        Music::truncate();
        MusicSheet::truncate();
        Practice::truncate();
        UserSettings::truncate();

        User::factory(20)->create();
        Category::factory(20)->create();
        Music::factory(20)->create();
        MusicSheet::factory(20)->create();
        Practice::factory(20)->create();
        UserSettings::factory(20)->create();

        //makes category_practice_table (just run once)
        // Practice::factory()->create()->each(
        //     function($practice){
        //         $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
        //         $practice->categories()->attach($categories);
        //     }
        // );

        //makes music_practice_table (just run once)
        // Practice::factory()->create()->each(
        //     function($practice){
        //         $music = Music::all()->random(mt_rand(1, 5))->pluck('id');
        //         $practice->musics()->attach($music);
        //     }
        // );

        //makes music_sheet_practice_table (just run once)
        // Practice::factory()->create()->each(
        //     function($practice){
        //         $music_sheet = MusicSheet::all()->random(mt_rand(1, 5))->pluck('id');
        //         $practice->musicsheets()->attach($music_sheet);
        //     }
        // );

        //makes user_settings_language_table (just run once)
        // UserSettings::factory()->create()->each(
        //     function($user_settings){
        //         $language = Language::all()->random(mt_rand(1, 3))->pluck('id');
        //         $user_settings->language()->attach($language);
        //     }
        // );

        //makes user_categories_table (just run once)
        // User::factory()->create()->each(
        //     function($user){
        //         $categories = Category::all()->random(mt_rand(1, 3))->pluck('id');
        //         $user->categories()->attach($categories);
        //     }
        // );
    }
}
