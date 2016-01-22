<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadParsingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('upload_parsings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('file_id');
            $table->integer('total_count');
            $table->integer('completed_count');
            $table->string('completed_all',5)->default('no');
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
		Schema::drop('upload_parsings');
	}

}
