<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDobToUsersTable extends Migration {

    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->date('dob');
            $table->string('gender', 1);
            $table->string('zip',10);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob');
            $table->enum('gender',array('m', 'f'));
            $table->string('zip',10);
        });
    }
}
