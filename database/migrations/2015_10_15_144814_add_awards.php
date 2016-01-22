<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('achievement_id')->unsigned();
            $table->string('title');
            $table->string('source');
            $table->string('difficulty');
            $table->string('path');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('users_awards', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('awards_id')->unsigned();
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
        Schema::drop('awards');
        Schema::drop('users_awards');
    }
}
