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
        Schema::create('user_settings_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_settings_id');
            $table->foreignId('language_id');
            $table->timestamps();
        });


        // Add default values
        DB::table('user_settings_language')->insert(
            array(
                'user_settings_id' => 1,
                'language_id' => 1,
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
        Schema::dropIfExists('user_settings_language');
    }
};
