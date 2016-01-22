<?php

use Illuminate\Database\Migrations\Migration;

class AddProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("

            CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getAchievementsSortByUser`(IN `user` INT, IN `category` INT, IN `category_parent` INT)
            BEGIN
                SELECT
                        achievements.id as achievements_id
                        ,achievements.title
                        ,achievements.criteria_id
                        ,achievements.criteria_value
                        ,achievements.criteria_text
                        ,achievements_categories.title as categories_title,

                    achievements.title,
                    achievements.points,
                    achievements.icon,
                    achievements.difficulty,
                    achievements.criteria_text,
                    cards.icon as icon_player_card,
                    IF((SELECT user_id FROM achievements_users WHERE user_id = user AND achievement_id = achievements.id ),1,0) as completed,
                        CASE IF((SELECT user_id FROM achievements_users WHERE user_id = user AND achievement_id = achievements.id ),1,0) WHEN 1 THEN 100
                        ELSE
                         CASE  achievements.criteria_id
                         -- RIDE func
                           WHEN 10 THEN getPercents( (SELECT COUNT(id) FROM rides where user_id = user ) ,achievements.criteria_value)
                            WHEN 11 THEN getPercents( (SELECT ROUND(SUM(total_distance)* 0.000621371192, 2) as total_distance FROM lap where user_id = user ) ,achievements.criteria_value)
                          WHEN 12 THEN getPercents( (SELECT ROUND(MAX(total_distance)* 0.000621371192, 2) as total_distance FROM lap where user_id = user) ,achievements.criteria_value)
                          WHEN 13 THEN getPercents(getMaxDistanceWeekend(user),achievements.criteria_value)
                           WHEN 14 THEN getPercents(getAvgSpeed30Min(user),achievements.criteria_value)
                          -- WHEN 15 THEN getLeast10SecAboveMPH(user,achievements.criteria_value) -- de intrebat pe Ion daca lucreaza
                         -- //RIDE A TOTAL OF X HOURS
                            WHEN 16 THEN  getPercents(getTotalHours(user),achievements.criteria_value)
                            -- //RIDE FOR AT LEAST 30 MINUTES IN A SINGLE RIDE
                            WHEN 17 THEN getPercents(getMinutesSingleRide(user),achievements.criteria_value)
                            -- // RIDE AT LEAST X CONSECUTIVE DAYS IN A ROW FOR A MINIMUM OF 30 MIN PER RIDE
                            -- WHEN 18 THEN getPercents(getMaxConsecutiveDays(user),achievements.criteria_value)
                            -- //RIDE AT LEAST X HOURS, TWICE IN A SINGLE WEEKEND
                            WHEN 19 THEN getPercents(getHoursByWeekend(user),achievements.criteria_value)
                            -- // CLIMB A TOTAL OF X FT IN ELEVATION
                            WHEN 21 THEN getPercents(getSumElevation(user),achievements.criteria_value)
                            -- // CLIMB A MORE THAN X FT IN A SINGLE RIDE
                            WHEN 22 THEN getPercents(getMaxElevationByRide(user),achievements.criteria_value)
                            -- //RIDE WITH AN AVG POWER IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE
                            -- WHEN 22 -- no func
                            -- //RIDE FOR AT LEAST 10 SECONDS ABOVE X WATTS
                            -- WHEN 25 -- no func

                        -- EXPERIENCE func
                            -- //EARN EXPERIENCE POINTS
                            -- WHEN 1 -- this criteria have only one value
                            -- //EARN LEVEL N
                            WHEN 2 THEN getPercents( (SELECT level FROM users where id = user ) ,achievements.criteria_value)
                            -- //EARN XP FROM A BONUS ROLL
                            -- WHEN 3 -- this criteria have only one value
                            -- //EARN A BONUS ROLL FOR ZONE X
                            -- WHEN 4 -- only 100% if completed
                            -- //EARN 100 BONUS ROLLS FOR ZONE X
                            -- WHEN 6 -- only 100% if completed
                            -- //EARN CATEGORY X
                            -- WHEN 8 -- maybe only 100% if completed
                            -- //EARN A BONUS ROLL IN EACH ZONE
                            -- WHEN 9 -- only 100% if completed

                        -- CAREER func
                            -- //UPLOAD A RIDE
                            -- WHEN 26 -- this criteria have only one value
                            -- //START YOUR X SEASON
                            -- WHEN 27 -- no func
                            -- //COLLECT X PLAYER CARDS
                            WHEN 28 THEN getPercents( (SELECT count(id) FROM users_cards where user_id = user ) ,achievements.criteria_value)

                        -- ELSE NO CONDITON
                            ELSE 0
                         END
                       END AS percents
                FROM
                    achievements
                LEFT JOIN cards on cards.achievement_id = achievements.id
                LEFT JOIN achievements_users on achievements_users.achievement_id = achievements.id
                 LEFT JOIN achievements_categories on achievements_categories.id = achievements.category_id
                 LEFT JOIN achievements_criteria on achievements_criteria.id = achievements.criteria_id
                WHERE
                    achievements.category_id = category
                     AND achievements.subcategory_id = category_parent
                    --  AND achievements.criteria_id = 2
                    -- achievements.criteria_id = 28
                GROUP BY achievements.id
                ORDER BY CAST(percents AS UNSIGNED) desc,`achievements`.`title` ASC

             ;END;;

        ");

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getAvgSpeed30Min`(`user` INT) RETURNS varchar(250) CHARSET latin1
            BEGIN
                 RETURN  (
                        SELECT MAX(ROUND(lap.avg_speed * 2.23693629205442920544,2)) as speed FROM lap
                         WHERE moving_time >= 1800
                          AND user_id  = user
                  );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getHoursByWeekend`(`user` INT) RETURNS int(11)
            BEGIN
                 RETURN  (
                      SELECT
                        MAX( ROUND( (lap.moving_time / 3600) ,0 ) ) as total_elapsed_time
                      FROM
                        lap
                        LEFT JOIN files on files.id = lap.file_id
                      WHERE lap.user_id = user
                        AND DAYOFWEEK(files.start) IN (1,7)
                  );
            END;
        ');

        DB::unprepared('

            CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getLeast10SecAboveMPH`(IN `user` INT, IN `speed` INT)
            BEGIN
                 SET @user  = user;
                 SET @speed = speed;
                SELECT getLeast10SecAboveMPH_func(@user,@speed);

             -- SET @i = 0;
             -- SET @last_dt = NULL;
             -- SELECT  SUM(seconds) as seconds
             -- FROM
            -- (SELECT record.file_id,
                   -- @i :=  COALESCE( IF( (ROUND(record.speed * 2.23693629205442920544,2) >= speed && record.file_id = @last_file ), (record.timestamp - @last_dt), 0),0 ) AS seconds,
                   -- @last_dt := record.timestamp,
                   -- @last_file := record.file_id
            --   FROM
              --   record
                -- WHERE user_id = user
            --   ORDER BY
              --   record.id ASC
            --  ) v
              --    GROUP BY v.file_id
                -- HAVING seconds > 10
                  -- LIMIT 1
               -- ;
            END;;

        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getLeast10SecAboveMPH_func`(`user` INT, `speed` INT) RETURNS int(11)
            BEGIN
                 SET @i = 0;
                 SET @last_dt = NULL;
                 RETURN  (
                      SELECT  SUM(seconds) as seconds
                      FROM
                      (SELECT record.file_id,
                            @i :=  COALESCE( IF( (ROUND(record.speed * 2.23693629205442920544,2) >= speed && record.file_id = @last_file ), (record.timestamp - @last_dt), 0),0 ) AS seconds,
                            @last_dt := record.timestamp,
                            @last_file := record.file_id
                       FROM
                         record
                         WHERE user_id = user
                       ORDER BY
                         record.id ASC
                      ) v
                          GROUP BY v.file_id
                         HAVING seconds > 10
                          LIMIT 1
                  );
            END;
        ');

        DB::unprepared('

                CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getLeast10SecAbovePower`(IN `user` INT, IN `power` INT)
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
                                    END;;

        ');

        DB::unprepared('

            CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getMaxConsecutiveDays`(IN `user` INT)
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
                                     AND lap.moving_time / 60 >=30
                                   ORDER BY
                                     files.user_id, start
                                  ) v;
                                END;;

        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getMaxDistanceWeekend`(`user` INT) RETURNS varchar(250) CHARSET latin1
            BEGIN
                 RETURN  (
                             SELECT MAX(max_distance) as total_distance
                            FROM (
                                SELECT
                                  MAX(total_distance) as max_distance
                                FROM
                                  lap
                                WHERE user_id = user
                                GROUP BY
                                WEEK(created_at)
                            ) as subquery
                  );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getMaxElevationByRide`(`user` INT) RETURNS int(11)
            BEGIN

                 RETURN  (
                      SELECT
                        ROUND(MAX(lap.elevation) * 3.2808399,0) as elevation
                      FROM
                        lap
                      WHERE lap.user_id = user
                  );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getMinutesSingleRide`(`user` INT) RETURNS int(11)
            BEGIN
                 RETURN  (
                      SELECT
                        MAX(ROUND( (moving_time / 60) ,0 ) ) as total_elapsed_time
                      FROM
                        lap
                      WHERE user_id = user
                  );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getPercents`(`val1` INT, `val2` INT) RETURNS int(11)
            BEGIN
                 RETURN  (
                        IF(
                            val1>0,
                                IF ( CAST( ROUND( (val1 * 100) /val2 , 0 ) AS UNSIGNED) >100 ,100 , CAST( ROUND( (val1 * 100) /val2 , 0 ) AS UNSIGNED)  )
                            ,0
                        )
                  );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getPowerPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
            BEGIN
                SET @i = -1;
                SET @position = NULL;
                SET @p = 0;
                SET @sum = sum;
                SET @days = days;
                RETURN (
                     SELECT
                        nr as position
                         FROM
                         (
                            SELECT
                                 *
                                 ,IF(power_user = @sum ,\'Y\',\'N\') as sum_position
                                 ,@i := @i+1 as nr
                                        FROM
                                        (
                                            SELECT
                                                lap.user_id,
                                                -- power_user
                                                ROUND(SUM(lap.avg_power)/count(lap.id),2)  as power_user
                                                -- end power_user
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
                                                        DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                    )
                                                )
                                                AND `users`.`id` > 0
                                          GROUP BY users.id
                                          ORDER BY power_user ASC
                                      ) as power_list
                             ORDER BY power_user ASC
                        ) as nr_position
                        WHERE sum_position = \'Y\'
                        LIMIT 1
                 );
            END;
        ');

        DB::unprepared('
            CREATE DEFINER=`fitcraft`@`%` FUNCTION `getPowerUser`(`user` INT, `days` INT) RETURNS int(11)
            BEGIN

                 DECLARE s VARCHAR(50);
                 IF s THEN SET s = \'equals\';
                 END IF;

                  RETURN  (
                    SELECT
                         ROUND(
                            (SUM(lap.avg_power)/count(lap.id))
                            ,2
                        )
                        as power
                    FROM lap
                    LEFT JOIN users on users.id = lap.user_id
                    WHERE
                        lap.user_id = user
                          AND DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= days
                  );
            END;
        ');

        DB::unprepared('

            CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getRightStatisticUser`(IN `user` INT, IN `days` INT, IN `type` VARCHAR(50))
            BEGIN
                   SET @user  = user;
                   SET @days  = days;
                   SET @type  = type;
                   SET @i = 0;
                   SET @total_users = 0;
                    SET @power_repeat = 0;
                    SET @speed_repeat = 0;
                    SET @stamina_repeat = 0;
                    SET @tenacity_repeat = 0;
                    SET @position_user = 0;
                    -- IF @days =1  THEN SET @days = 0;END IF;

                   SELECT
                     -- *,
                     peak_power,elev_gained,largest_climb,
                     -- total users
                     @total_users := @i as total_users
                     -- E number of scores below
                     ,@position_user :=(
                                    CASE
                                         WHEN @type=\'power\' THEN getPowerPosition(power,@days)
                                         WHEN @type=\'speed\' THEN getSpeedPosition(speed,@days)
                                         WHEN @type=\'stamina\' THEN getStaminaPosition(stamina,@days)
                                         WHEN @type=\'tenacity\' THEN getTenacityPosition(tenacity,@days)
                                    END
                     )	as position_user
                     -- End E number of scores below

                     -- power user
                     ,power
                     -- calculate if other user have power
                     ,@power_repeat :=(
                            SELECT count(*)
                                FROM
                                (
                                    SELECT
                                        ROUND(SUM(lap.avg_power)/count(lap.id),2)
                                       as power_user
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
                                                DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                            )
                                        )
                                     AND `users`.`id` > \'0\'
                                  GROUP BY  lap.user_id
                              ) as power_list
                           WHERE power_user = power
                        ) as power_repeat
                        -- power percent
                        ,ROUND( (((@position_user+(0.5*@power_repeat)) / @total_users) * 100) ,0 ) as power_percent
                         -- speed user
                         ,speed
                        -- calculate if other user have speed
                        ,@speed_repeat :=(
                            SELECT count(*)
                                FROM
                                (
                                    SELECT
                                       -- COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed_user
                                        COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2) ,0)  as speed_user
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
                                                DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                            )
                                        )
                                     AND `users`.`id` > \'0\'
                                  GROUP BY  lap.user_id
                              ) as speed_list
                              WHERE speed_user = speed
                            )	as speed_repeat
                        -- speed percent
                        ,ROUND( (((@position_user+(0.5*@speed_repeat)) / @total_users) * 100) ,0 ) as speed_percent
                        -- stamina user
                        ,stamina
                        -- calculate if other user have stamina
                        ,@stamina_repeat :=(
                            SELECT count(*)
                                FROM
                                (
                                    SELECT
                                        -- COALESCE(ROUND((ROUND(SUM(total_distance) * 0.000621371192,2)/count(*)),0),0)  as stamina_user
                                        COALESCE( ROUND( (SUM(total_distance)* 0.000621371192 /count(*)) ,2) ,0 )  as stamina_user
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
                                                DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                            )
                                        )
                                     AND `users`.`id` > \'0\'
                                  GROUP BY  lap.user_id
                              ) as stamina_list
                              WHERE stamina_user = stamina
                            ) as stamina_repeat
                        -- stamina percent
                        ,ROUND( (((@position_user+(0.5*@stamina_repeat)) / @total_users) * 100) ,0 ) as stamina_percent
                        -- tenacity user
                        ,tenacity
                        -- calculate if other user have tenacity
                        ,@tenacity_repeat :=(
                            SELECT count(*)
                                FROM
                                (
                                    SELECT
                                        COALESCE( SUM(moving_time)/COUNT(*),0 )  as tenacity_user
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
                                                DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                            )
                                        )
                                        AND `users`.`id` > \'0\'

                                  GROUP BY  lap.user_id
                              ) as tenacity_list
                              WHERE tenacity_user = tenacity
                            ) as tenacity_repeat
                        -- tenacity percent
                        ,ROUND( (((@position_user+(0.5*@tenacity_repeat)) / @total_users) * 100) ,0 ) as tenacity_percent
                        FROM (
                                -- selec by type and order
                               SELECT *,@i := @i+1 as position,
                                         IF (
                                            user_id =  @user, 1,0
                                         ) as is_my
                                  FROM (

                                        SELECT
                                             lap.user_id as user_id,
                                             ROUND(
                                                (SUM(lap.avg_power)/count(lap.id))
                                                ,2
                                            )
                                            as power,
                                            ROUND(
                                                (MAX(lap.max_power))
                                                ,2
                                            )
                                            as peak_power,
                                            ROUND(
                                                SUM(COALESCE(elevation,0)),2
                                            ) as elev_gained,
                                            ROUND(
                                                MAX(COALESCE(elevation,0)),2
                                            ) as largest_climb
                                            -- ,COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed
                                            ,COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2),0)  as speed
                                            ,COALESCE( ROUND( (SUM(total_distance)* 0.000621371192 /count(*)) ,2) ,0 )  as stamina
                                            ,COALESCE( SUM(moving_time)/COUNT(*),0 ) as tenacity
                                        FROM `lap`
                                        LEFT JOIN `users` on `users`.`id` = `lap`.`user_id`
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
                                                        DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                    )
                                                )
                                           AND `users`.`id` > \'0\'
                                        GROUP BY lap.user_id
                                 ) as psst
                                 ORDER BY
                                    CASE
                                         WHEN @type=\'power\' THEN power
                                         WHEN @type=\'speed\' THEN speed
                                         WHEN @type=\'stamina\' THEN stamina
                                         WHEN @type=\'tenacity\' THEN tenacity
                                    END
                                 ASC
                            --  END select by type and order

                            ) as users_statistic
                        WHERE user_id = user

            ;END;;

        ');

        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getSpeedPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
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
                                 ,IF(speed_user = @sum ,\'Y\',\'N\') as sum_position
                                 ,@i := @i+1 as nr
                                        FROM
                                        (
                                            SELECT
                                                lap.user_id,
                                                -- speed_user
                                                -- ,COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed_user
                                                COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2) ,0)  as speed_user
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
                                                        DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                    )
                                                )
                                                AND `users`.`id` > 0
                                          GROUP BY users.id
                                          ORDER BY speed_user ASC
                                      ) as speed_list
                             ORDER BY speed_user ASC
                        ) as nr_position
                        WHERE sum_position = \'Y\'
                        LIMIT 1
                 );
            END;
        ');


        DB::unprepared('

        CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getSpeedPowerStaminaTenacityListByUser`(IN `user` INT, IN `days` INT, IN `type_order` VARCHAR(50))
        BEGIN
             SET @i = 0;
             SET @type_order = type_order;
             SET @days = days;
             SET @user = user;

                    SELECT
                         lap.user_id as user_id,
                         ROUND(
                            lap.avg_power
                            ,2
                        )
                        as power,
                        ROUND(
                                 lap.max_power
                            ,2
                        )
                        as peak_power,
                        ROUND(
                           COALESCE(elevation,0),2
                        ) as elev_gained,
                        ROUND(
                           COALESCE(elevation,0),2
                        ) as largest_climb
                        ,COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2) )  as speed
                        ,COALESCE(ROUND((ROUND(total_distance * 0.000621371192,2)),0),0)  as stamina
                        ,COALESCE(ROUND((moving_time),0),0)  as tenacity
                    FROM `lap`
                    LEFT JOIN `users` on `users`.`id` = `lap`.`user_id`
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
                                    DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                )
                            )
                         AND lap.user_id = @user


                     ORDER BY
                        CASE
                             WHEN type_order=\'power\' THEN power
                             -- WHEN type_order=\'speed\' THEN speed
                             WHEN type_order=\'stamina\' THEN stamina
                             WHEN type_order=\'tenacity\' THEN tenacity
                        END
                     ASC




        ;END;;

        ');

        DB::unprepared('

        CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getSpeedPowerStaminaTenacityUsers`(IN `days` INT, IN `type_order` VARCHAR(50))
        BEGIN
             SET @i = 0;
             SET @type_order = type_order;
             SET @days = days;


            SELECT *,@i := @i+1 as position
                FROM (
                    SELECT

                         lap.user_id as user_id,
                         ROUND(
                            (SUM(
                                lap.avg_power
                            )/count(lap.id))
                            ,2
                        )
                        as power,
                        ROUND(
                            (MAX(
                                lap.max_power
                            ))
                            ,2
                        )
                        as peak_power,
                        ROUND(
                            SUM(COALESCE(elevation,0)),2
                        ) as elev_gained,
                        ROUND(
                            MAX(COALESCE(elevation,0)),2
                        ) as largest_climb
                        ,COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2) )  as speed
                        ,COALESCE(ROUND((ROUND(SUM(total_distance) * 0.000621371192,2)/count(*)),0),0)  as stamina
                        ,COALESCE((SUM(moving_time))/COUNT(*),0)  as tenacity
                    FROM `lap`
                    LEFT JOIN `users` on `users`.`id` = `lap`.`user_id`
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
                                    DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                )
                            )
                         AND `users`.`id` > 0
                         --  AND lap.user_id = user
                    GROUP BY users.id
                     -- ORDER BY type_order
                 ) as psst
                 ORDER BY
                    CASE
                         WHEN type_order=\'power\' THEN power
                         WHEN type_order=\'speed\' THEN speed
                         WHEN type_order=\'stamina\' THEN stamina
                         WHEN type_order=\'tenacity\' THEN tenacity
                    END
                 DESC




        ;END;;

        ');
        DB::unprepared('

        CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getSpeedUser`(IN `user` INT, IN `days` INT)
        BEGIN

             DECLARE s VARCHAR(50);
             IF s THEN SET s = \'equals\';
             END IF;

                SELECT
                        COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2),0 )  as speed
                FROM lap
                LEFT JOIN users on users.id = lap.user_id
                WHERE
                    lap.user_id = user
                      AND DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= days

        ;END;;

        ');
        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getStaminaPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
        BEGIN
            SET @i = -1;
            SET @position = NULL;
            SET @p = 0;
            SET @sum = sum;
            SET @days = days;
            RETURN (
                 SELECT
                    nr as position
                     FROM
                     (
                        SELECT
                             *
                             ,IF(stamina_user = @sum ,\'Y\',\'N\') as sum_position
                             ,@i := @i+1 as nr
                                    FROM
                                    (
                                        SELECT
                                            lap.user_id,
                                            -- stamina_user
                                            -- COALESCE(ROUND((ROUND(SUM(total_distance) * 0.000621371192,2)/count(*)),0),0)  as stamina_user
                                            -- COALESCE( ROUND( (SUM(total_distance)/count(*)) * 0.000621371192,2) ,0 )  as stamina_user
                                            COALESCE( ROUND( (SUM(total_distance)* 0.000621371192 /count(*)) ,2) ,0 )  as stamina_user
                                            -- end stamina_user
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
                                                    DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                )
                                            )
                                            AND `users`.`id` > 0
                                      GROUP BY  lap.user_id
                                      ORDER BY stamina_user ASC
                                  ) as stamina_list
                         ORDER BY stamina_user ASC
                    ) as nr_position
                    WHERE sum_position = \'Y\'
                    LIMIT 1
             );
        END;
        ');
        DB::unprepared('

        CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getStaminaPositionProced`(IN `sum` VARCHAR(50), IN `days` INT)
        BEGIN
            SET @i = -1;
            SET @position = NULL;
            SET @p = 0;
            SET @sum = sum;
            SET @days = days;


                        SELECT
                             *
                             ,IF(stamina_user = @sum ,\'Y\',\'N\') as sum_position
                             ,@i := @i+1 as nr
                                    FROM
                                    (
                                        SELECT
                                            lap.user_id,
                                            -- stamina_user
                                            -- COALESCE(ROUND((ROUND(SUM(total_distance) * 0.000621371192,2)/count(*)),0),0)  as stamina_user
                                            -- COALESCE( ROUND( (SUM(total_distance)/count(*)) * 0.000621371192,2) ,0 )  as stamina_user
                                            COALESCE( ROUND( (SUM(total_distance)* 0.000621371192 /count(*)) ,2) ,0 )  as stamina_user
                                            -- end stamina_user
                                        FROM lap
                                        INNER JOIN users on users.id = lap.user_id
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
                                                    DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                )
                                            )
                                            AND `users`.`id` > \'0\'
                                      GROUP BY  lap.user_id
                                      ORDER BY stamina_user ASC
                                  ) as stamina_list
                         ORDER BY stamina_user ASC


        ;END;;

        ');
        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getSumElevation`(`user` INT) RETURNS int(11)
        BEGIN

             RETURN  (
                  SELECT
                    ROUND(SUM(lap.elevation) * 3.2808399,0) as elevation
                  FROM
                    lap
                  WHERE lap.user_id = user
              );
        END;
        ');
        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getTenacityPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
        BEGIN
            SET @i = -1;
            SET @position = NULL;
            SET @p = 0;
            SET @sum = sum;
            SET @days = days;
            RETURN (
                 SELECT
                    nr as position
                     FROM
                     (
                        SELECT
                             *
                             ,IF(tenacity_user = @sum ,\'Y\',\'N\') as sum_position
                             ,@i := @i+1 as nr
                                    FROM
                                    (
                                        SELECT
                                            lap.user_id,
                                            -- tenacity_user
                                            -- COALESCE(ROUND((SUM(moving_time))/COUNT(*),0),0)  as tenacity_user
                                            COALESCE( SUM(moving_time)/COUNT(*),0 ) as tenacity_user
                                            -- end tenacity_user
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
                                                    DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                )
                                            )
                                            AND `users`.`id` > 0
                                      GROUP BY users.id
                                      ORDER BY tenacity_user ASC
                                  ) as tenacity_list
                         ORDER BY tenacity_user ASC
                    ) as nr_position
                    WHERE sum_position = \'Y\'
                    LIMIT 1
             );
        END;
        ');
        DB::unprepared('

            CREATE DEFINER=`fitcraft`@`%` PROCEDURE `getTenacityPositionProced`(IN `sum` VARCHAR(50), IN `days` INT)
            BEGIN
                SET @i = -1;
                SET @position = NULL;
                SET @p = 0;
                SET @sum = sum;
                SET @days = days;

            BEGIN
                SET @i = -1;
                SET @position = NULL;
                SET @p = 0;
                SET @sum = sum;
                SET @days = days;

                     SELECT
                        *,nr as position
                         FROM
                         (
                            SELECT
                                 *
                                 ,IF(tenacity_user = @sum ,\'Y\',\'N\') as sum_position
                                 ,@i := @i+1 as nr
                                        FROM
                                        (
                                            SELECT
                                                lap.user_id,
                                                -- tenacity_user
                                                -- COALESCE(ROUND((SUM(moving_time))/COUNT(*),0),0)  as tenacity_user
                                                COALESCE( SUM(moving_time)/COUNT(*),0 ) as tenacity_user
                                                -- end tenacity_user
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
                                                        DATEDIFF(DATE_FORMAT(NOW(),\'%Y-%m-%d\'),DATE_FORMAT(lap.created_at,\'%Y-%m-%d\')) <= @days
                                                    )
                                                )
                                            AND `users`.`id` > 0
                                          GROUP BY users.id
                                          ORDER BY tenacity_user ASC
                                      ) as tenacity_list
                             ORDER BY tenacity_user DESC
                        ) as nr_position



            ;END


            ;END;;

        ');
        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getTotalHours`(`user` INT) RETURNS int(11)
        BEGIN
             RETURN  (
                      SELECT
                        ROUND( (SUM(lap.moving_time) / 3600),0) as total_elapsed_time
                      FROM
                        lap
                      WHERE user_id = user
              );
        END;
        ');
        DB::unprepared('
        CREATE DEFINER=`fitcraft`@`%` FUNCTION `getTotalXP`(`user` INT) RETURNS int(11)
        BEGIN

             RETURN  (
                  SELECT
                     MAX(ROUND((zone_1 + zone_2 + zone_3 + zone_4 + zone_5),0)) as total_xp
                  FROM
                    rides
                  WHERE user_id = user
                  HAVING total_xp > 0
              );
        END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getAchievementsSortByUser;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getAvgSpeed30Min;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getHoursByWeekend;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getLeast10SecAboveMPH;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getLeast10SecAboveMPH_func;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getLeast10SecAbovePower;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getMaxConsecutiveDays;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getMaxDistanceWeekend;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getMaxElevationByRide;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getMinutesSingleRide;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getPercents;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getPowerPosition;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getPowerUser;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getRightStatisticUser;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getSpeedPosition;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getSpeedPowerStaminaTenacityListByUser;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getSpeedPowerStaminaTenacityUsers;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getSpeedUser;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getStaminaPosition;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getStaminaPositionProced;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getSumElevation;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getTenacityPosition;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getTenacityPositionProced;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getTotalHours;
        ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS getTotalXP;
        ');
    }
}
