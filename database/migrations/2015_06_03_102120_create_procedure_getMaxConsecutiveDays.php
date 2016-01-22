<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureGetMaxConsecutiveDays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{


                  DB::unprepared("
                    DROP PROCEDURE IF EXISTS getMaxConsecutiveDays;
                    CREATE DEFINER=`homestead`@`%` PROCEDURE `getMaxConsecutiveDays`(IN `user` INT)
                        LANGUAGE SQL
                        NOT DETERMINISTIC
                        CONTAINS SQL
                        SQL SECURITY DEFINER
                        COMMENT ''
                    BEGIN
                    SET @i = 1;
                    SET @last_dt = NULL;
                    SET @last_user = NULL;
                    SET @maxD = 1;
                    SELECT MAX(v.maxD) as maxDays
                    FROM
                      (SELECT @maxD as maxD,
                            @i :=  IF((DATE(start) - INTERVAL 1 DAY) = DATE(@last_dt), @i + 1, 1) AS days,
                            @last_dt := DATE(start),
                            @maxD := IF ( (@i > @maxD) , @i, @maxD )

                       FROM
                         files
                         LEFT JOIN lap ON lap.file_id = files.id
                         WHERE files.user_id = user
                         AND lap.total_elapsed_time / 60 >=30
                       ORDER BY
                         files.user_id, start
                      ) v;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS getMaxConsecutiveDays');
	}

}
