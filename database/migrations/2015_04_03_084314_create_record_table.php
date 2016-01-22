<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('record', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('timestamp');
            $table->string('distance');
            $table->string('altitude');
            $table->string('speed');
            $table->string('cadence');
            $table->string('temperature');
            $table->string('position_lat');
            $table->string('position_long');
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
        Schema::drop('record');
	}

}
