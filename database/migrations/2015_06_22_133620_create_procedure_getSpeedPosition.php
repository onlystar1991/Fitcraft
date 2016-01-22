<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureGetSpeedPosition extends Migration {

	public function up()
	{
	  // definer digitalkrikits@%
      DB::unprepared("
        DROP PROCEDURE IF EXISTS getSpeedPosition;
        CREATE DEFINER=`homestead`@`%` PROCEDURE `getSpeedPosition`(IN `user` INT)
            LANGUAGE SQL
            NOT DETERMINISTIC
            CONTAINS SQL
            SQL SECURITY DEFINER
            COMMENT ''
			BEGIN
				SET @i = -1;
				SET @position = NULL; 
				SET @p = 0;
				SET @sum = sum;
				SET @days = days;
				-- IF @days =1  THEN SET @days = 0;END IF;
			 	RETURN ( 	
					 SELECT 
					 	nr as position 
						 FROM	
						 (	
						 	SELECT 
								 *
								 ,IF(speed_user = @sum ,'Y','N') as sum_position
						 		 ,@i := @i+1 as nr				
										FROM 
										(
											SELECT
												lap.user_id,
												-- speed_user 			
												COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed_user
												-- end speed_user
											FROM lap 
											LEFT JOIN users on users.id = lap.user_id 								
											WHERE
												IF
												(
													@days = 365
													, lap.created_at <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
													, 
													IF
													(	
														@days = 0,
														lap.user_id >0,			
														DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(lap.created_at,'%Y-%m-%d')) <= @days
													)	
												)
												 
									      GROUP BY  lap.user_id 
									      ORDER BY speed_user ASC
								      ) as speed_list
						     ORDER BY speed_user ASC   
						) as nr_position	 
						WHERE sum_position = 'Y'
						LIMIT 1   	
				 );
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
        DB::unprepared('DROP PROCEDURE IF EXISTS getSpeedPosition');
	}


}
