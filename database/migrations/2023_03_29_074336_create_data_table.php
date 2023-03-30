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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_count');
            $table->integer('user_signup_this_week');
            $table->integer('user_signup_this_month');
            $table->integer('email_subscription_rate');
            $table->integer('category_count');
            $table->integer('practice_count');
            $table->integer('practice_this_week');
            $table->integer('practice_this_month');
            $table->integer('practice_favorited');
            $table->integer('practice_most_favorited');
            $table->integer('total_session_time');
            $table->string('most_used_user');
            $table->integer('most_used_user_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
};
