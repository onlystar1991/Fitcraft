<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteNotUsed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('records');
        Schema::drop('session_devices');
        Schema::drop('sessions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('session_devices', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('sessions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
        });
    }
}
