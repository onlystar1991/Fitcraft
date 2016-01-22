<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('event', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('timestamp');
            $table->string('timer_trigger');
            $table->string('event');
            $table->string('event_type');
            $table->string('event_group');
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
        Schema::drop('event');
	}

}
