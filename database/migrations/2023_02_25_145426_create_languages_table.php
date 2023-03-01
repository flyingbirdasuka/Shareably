<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('language_code');
            $table->string('language');
            $table->timestamps();
        });

        // Load some default languages
        DB::table('languages')->insert(
            array(
                'language_code' => 'en',
                'language' => 'English',
                'created_at' => now(),
                'updated_at' => now(),
            )
        );
        DB::table('languages')->insert(
            array(
                'language_code' => 'jp',
                'language' => 'Japanese',
                'created_at' => now(),
                'updated_at' => now(),
            )
        );
        DB::table('languages')->insert(
            array(
                'language_code' => 'nl',
                'language' => 'Dutch',
                'created_at' => now(),
                'updated_at' => now(),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
