<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('files', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('path');
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
        Schema::table('files', function(Blueprint $table)
        {
            Schema::drop('files');
        });
	}

}
