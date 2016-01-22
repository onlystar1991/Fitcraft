<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureGetLeast10SecAbovePower extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        DB::unprepared("
                    DROP PROCEDURE IF EXISTS getLeast10SecAbovePower;
                    CREATE DEFINER=`homestead`@`%` PROCEDURE `getLeast10SecAbovePower`(IN `user` INT, IN `power` INT)
                    LANGUAGE SQL
                    NOT DETERMINISTIC
                    CONTAINS SQL
                    SQL SECURITY DEFINER
                    COMMENT ''
                    BEGIN
                    SET @i = 0;
                    SET @last_dt = NULL;
                    SELECT  SUM(v.seconds) as seconds
                    FROM
                    (
                        SELECT
                            record.file_id,
                            @i :=  COALESCE( IF( (ROUND(record.power, 2) >= power && record.file_id = @last_file ), (record.timestamp - @last_dt), 0),0 ) AS seconds,
                            @last_dt := record.timestamp,
                            @last_file := record.file_id
                        FROM
                            record
                        WHERE
                            user_id = user
                        ORDER BY
                            record.id ASC
                    ) v
                    GROUP BY v.file_id
                    HAVING seconds >=10
                    LIMIT 1;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS getLeast10SecAbovePower');
    }

}
