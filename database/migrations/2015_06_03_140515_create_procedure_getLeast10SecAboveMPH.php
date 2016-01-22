\<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureGetLeast10SecAboveMPH extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::unprepared("
                    DROP PROCEDURE IF EXISTS getLeast10SecAboveMPH;
                    CREATE DEFINER=`homestead`@`%` PROCEDURE `getLeast10SecAboveMPH`(IN `user` INT, IN `speed` INT)
                    LANGUAGE SQL
                    NOT DETERMINISTIC
                    CONTAINS SQL
                    SQL SECURITY DEFINER
                    COMMENT ''
                    BEGIN
                    SET @i = 0;
                    SET @last_dt = NULL;
                    SELECT  file_id, v.*, SUM(v.seconds) as seconds
                        FROM
                        (SELECT record.file_id, @i, @last_file as last_file,
                             @i :=  COALESCE( IF( (ROUND(record.power, 2) >= speed && record.file_id = @last_file ), (record.timestamp - @last_dt), 0),0 ) AS seconds,
                             @last_dt := record.timestamp,
                             @last_file := record.file_id
                        FROM
                          record
                          WHERE user_id = user
                        ORDER BY
                          record.id ASC
                        ) v

                    GROUP BY v.file_id
                    HAVING seconds >=10
                    LIMIT 1
                     ;
                    END
                  ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::unprepared('DROP PROCEDURE IF EXISTS getLeast10SecAboveMPH');
	}

}
