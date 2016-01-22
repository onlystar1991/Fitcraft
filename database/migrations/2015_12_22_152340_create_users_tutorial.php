<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTutorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tutorial', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->boolean('player_card_btn');
            $table->boolean('choose_card_btn');
            $table->boolean('upload_ride_btn');
            $table->boolean('browse_file__btn');
            $table->boolean('upload_file_btn');
            $table->boolean('upload_complete_next');
            $table->boolean('activity_feed_next');
            $table->boolean('athlete_profile_next');
            $table->boolean('leaderboard_next');
            $table->boolean('ride_library_btn');
            $table->boolean('ride_library_next');
            $table->boolean('finish_tooltips_btn');
            $table->boolean('exit_achievements_btn');
            $table->boolean('exit_objectives_btn');
            $table->boolean('exit_gear_btn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_tutorial');
    }
}
