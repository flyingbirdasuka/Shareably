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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->boolean('notification_setting')->default(0);
            $table->boolean('sound_setting')->default(0);
            $table->boolean('email_subscription')->default(1);
            $table->timestamps();
        });

        // Add default values
        DB::table('user_settings')->insert(
            array(
                'user_id' => 1,
                'notification_setting' => 1,
                'sound_setting' => 1,
                'email_subscription' => 1,
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
        Schema::dropIfExists('user_settings');
    }
};
