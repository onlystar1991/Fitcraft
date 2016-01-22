<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_feed', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id',false,true);
            $table->integer('file_id',false,true);
            $table->integer('type',false,true);
            $table->string('icon',255);
            $table->integer('earned');
            $table->string('name',255);
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
        Schema::drop('activity_feed');
    }
}
