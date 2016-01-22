# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.26-74.0)
# Database: fitcraft
# Generation Time: 2015-10-15 11:56:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;



--
-- Dumping routines (PROCEDURE) for database 'fitcraft'
--
DELIMITER ;;

# Dump of PROCEDURE getAchievementsSortByUser
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getAchievementsSortByUser` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getAchievementsSortByUser`(IN `user` INT, IN `category` INT, IN `category_parent` INT)
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
			achievements.icon_grey,
			achievements.difficulty,
			achievements.created_at,

			achievements.criteria_text,
			 cards.icon as icon_player_card,
			 cards.icon_grey as icon_player_card_grey,
			 awards.icon_grey as icon_gear_grey,
			 awards.icon as icon_gear,
			achievements.criteria_show,
			 IF((SELECT user_id FROM achievements_users WHERE user_id = user AND achievement_id = achievements.id ),1,0) as completed,
			-- SELECT user_id FROM achievements_users WHERE user_id = user AND achievement_id = achievements.parent_achievement
			-- (SELECT count(user_id) FROM achievements_users WHERE user_id = user AND achievement_id = achievements.parent_achievement )
			 IF((achievements.parent_achievement!=0), (IF((SELECT count(user_id) FROM achievements_users WHERE user_id = user AND achievement_id = achievements.parent_achievement)>=1,1,0)),1) as is_show,

			 (SELECT DATE_FORMAT(files.start, '%m.%d.%Y') FROM achievements_users LEFT JOIN files ON files.id = achievements_users.file_id WHERE achievements_users.user_id = user AND achievements_users.achievement_id = achievements.id ) as complete_date,
			 CASE IF((SELECT user_id FROM achievements_users WHERE user_id = user AND achievement_id = achievements.id ),1,0) WHEN 1 THEN  IF(achievements.criteria_show IS NOT NULL, achievements.criteria_show,  achievements.criteria_value)
			 ELSE
				 CASE  achievements.criteria_id

				 -- EXPLORATION --DONE
				 -- //RIDE X MILES WITHIN YOUR HOME ZIP CODE -- DONE
				 WHEN 1 THEN
					 (SELECT SUM(ROUND(lap.total_distance*0.000621371192,2)) FROM rides LEFT JOIN lap ON lap.file_id = rides.file_id LEFT JOIN users  ON users.id = lap.user_id  WHERE rides.user_id = user AND rides.postal_code = users.zip GROUP BY rides.postal_code)

				 -- //RIDE X MILES WITHIN YOUR HOME COUNTRY -- DONE
				 WHEN 2 THEN
					 (SELECT SUM(ROUND(lap.total_distance*0.000621371192,2)) FROM rides LEFT JOIN lap ON lap.file_id = rides.file_id LEFT JOIN users  ON users.id = lap.user_id  WHERE rides.user_id = user AND rides.country = users.country GROUP BY rides.country)

				 -- //RIDE X MILES OUTSIDE YOUR COUNTRY -- DONE
				 WHEN 3 THEN
					 (SELECT SUM(ROUND(lap.total_distance*0.000621371192,2)) FROM rides LEFT JOIN lap ON lap.file_id = rides.file_id LEFT JOIN users  ON users.id = lap.user_id  WHERE rides.user_id = user AND rides.country <> users.country GROUP BY rides.country)

				 -- //RIDE AT LEAST X MILES IN AND OUT OF YOUR COUNTRY IN A SINGLE MONTH -- DONE
				 WHEN 4 THEN
					 (SELECT SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance from `rides` LEFT JOIN `lap` on `lap`.`file_id` = `rides`.`file_id` left join `files` on `files`.`id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where `rides`.`user_id` = user and `rides`.`country` != users.country and users.country IS NOT NULL group by `rides`.`country`, MONTH(files.end) ORDER BY total_distance DESC LIMIT 1)

				 -- //COMPLETE X RIDES IN X COUNTRIES OF AT LEAST 30 MINUTES -- DONE
				 WHEN 5 THEN
					 (SELECT COUNT(DISTINCT rides.country) AS CountOfcountries FROM rides LEFT JOIN lap ON lap.file_id = rides.file_id LEFT JOIN users  ON users.id = lap.user_id  WHERE rides.user_id = user AND lap.total_elapsed_time>=1800 GROUP BY rides.country)

				 -- //CLIMB AT LEAST X FT OUTSIDE YOUR HOME COUNTRY -- DONE
				 WHEN 6 THEN
					 (SELECT ROUND(SUM(lap.elevation) * 3.2808399,0) as total_ft FROM rides LEFT JOIN lap ON lap.file_id = rides.file_id LEFT JOIN users  ON users.id = lap.user_id  WHERE rides.user_id = user AND rides.country <> users.country GROUP BY rides.country)

				 -- //CLIMB AT LEAST X FT AND RIDE 100 MILES OUTSIDE OF YOUR HOME COUNTRY --DONE
				 WHEN 7 THEN
					 (SELECT ROUND(SUM(lap.elevation) * 3.2808399,0) as total_ft from rides  left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where `rides`.`user_id` = user and `rides`.`country` != users.country and users.country IS NOT NULL group by `rides`.`country` having SUM(ROUND(lap.total_distance*0.000621371192,2))>=100)

				 -- //COMPLETE ALL EXPLORATION ACHIEVEMENTS --DONE
				 WHEN 8 THEN
					 (SELECT count(`achievements`.`id`) from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 10)


				 -- LEGACY
				 WHEN 88 THEN  (SELECT count(au.achievement_id)  FROM achievements_users au WHERE au.user_id = user and au.achievement_id=176)

				 -- CAREER
				 -- //EARN CATEGORY X --DONE
				 WHEN 13 THEN (SELECT race_categories.nr  FROM users LEFT JOIN race_categories ON race_categories.id = users.category_id WHERE users.id = user)

				 -- //EARN CATEGORY ELITE -- DONE
				 WHEN 14 THEN (SELECT COUNT(race_categories.nr)  FROM users LEFT JOIN race_categories ON race_categories.id = users.category_id WHERE users.id = user AND race_categories.nr='ELITE')

				 -- //COMPLETE YOUR N SEASON -- DONE
				 WHEN 15 THEN (SELECT count(id) FROM users_season WHERE user_id = user AND active = 0)

				 -- //START YOUR FIRST SEASON -- DONE
				 WHEN 16 THEN (SELECT count(id) FROM users_season WHERE user_id = user AND active = 1)

				 -- //COMPLETE ALL CAREER ACHIEVEMENTS -- DONE
				 WHEN 20 THEN (SELECT count(`achievements`.`id`) from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 11)

				 -- EXPERIENCE //DONE

				 -- //EARN LEVEL N -- DONE
				 WHEN 9 THEN (SELECT users.level from users WHERE id=user)

				 -- //EARN MORE THAN N EXPERIENCE POINTS IN A SINGLE RIDE -- DONE
				 WHEN 10 THEN (SELECT ROUND(MAX(zone_1 + zone_2 + zone_3 + zone_4 + zone_5),0) as total_xp from rides WHERE user_id=user LIMIT 1)

				 -- //EARN MORE THAN X EXPERIENCE POINTS IN A SINGLE MONTH --DONE
				 WHEN 11 THEN (SELECT SUM((zone_1 + zone_2 + zone_3 + zone_4 + zone_5)) as total_xp from rides LEFT JOIN lap ON lap.file_id=rides.file_id LEFT JOIN files ON files.id = rides.file_id LEFT JOIN users ON users.id = lap.user_id WHERE rides.user_id=user GROUP BY MONTH(files.start) ORDER BY total_xp DESC LIMIT 1 )

				 -- //COMPLETE ALL EXPERIENCE ACHIEVEMENTS -- DONE
				 WHEN 12 THEN (SELECT count(`achievements`.`id`) from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 8)
				 -- /////////////////////////////////////////////////////////////////////////

				 -- RIDE
				 -- RIDE NO CATEGORY

				 -- //COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE DAY
				 WHEN 21 THEN (select COUNT(DISTINCT rides.id) AS CountOfRides from `rides` left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where `lap`.`total_elapsed_time` >= 1800 and `rides`.`user_id` = user  LIMIT 1)

				 -- //COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE WEEK
				 WHEN 22 THEN (select COUNT(DISTINCT rides.id) AS CountOfRides from `rides` left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `files` on `files`.`id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where `lap`.`total_elapsed_time` >= 1800 and `rides`.`user_id` = user group by WEEK(files.end)  LIMIT 1)

				 -- //COMPLETE A RIDE A DAY OF AT LEAST 30 MINUTES FOR AN ENTIRE CALENDER MONTH  !!!!Need check
				 WHEN 23 THEN 0
				 -- (select count(files.start) as totalrides from `rides` left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `files` on `files`.`id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where `rides`.`user_id` = user and ROUND(lap.total_elapsed_time/60,2)>=30 group by YEAR(files.`start`), MONTH(files.`start`) order by totalrides DESC  LIMIT 1)

				 -- COMPLETE A RIDE ON X day
				 WHEN 24  THEN 0

				 -- COMPLETE A RIDE ON X day
				 WHEN 25  THEN 0

				 -- COMPLETE A RIDE ON X day
				 WHEN 26  THEN 0

				 -- COMPLETE A RIDE ON X day
				 WHEN 84  THEN 0

				 -- UPLOAD X RIDES
				 WHEN 27  THEN (select count(id) from `rides` where `user_id` = user)

				 -- COMPLETE ALL RIDE ACHIEVEMENTS
				 WHEN 28  THEN (SELECT count(`achievements`.`id`) from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1  AND achievements.subcategory_id = 0)

				 --  RIDE SPEED
				 -- //RIDE AN AVG SPEED OF X MPH OR HIGHER ON A RIDE OF 30 MIN OR MORE
				 WHEN 37  THEN (select MAX(ROUND(lap.avg_speed * 2.23693629205442920544,2)) from `lap` where `total_elapsed_time` >= 1800 and `user_id` = user)

				 -- //RIDE FOR AT LEAST 10 SECONDS ABOVE X MPH
				 WHEN 38  THEN 0

				 -- //COMPLETE ALL SPEED ACHIEVEMENTS
				 WHEN 47  THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 2)

				 -- //RECORD A TOP SPEED OVER X MPH
				 WHEN 51  THEN (select ROUND(MAX(record.speed * 2.23693629), 2) as top_speed from `rides` left join `record` on `record`.`file_id` = `rides`.`file_id` where `rides`.`user_id` = user group by `record`.`file_id` LIMIT 1)

				 -- //Complete Other Achievements
				 WHEN 64  THEN (select COUNT(achievements_users.id) as itogo_completed from `achievements_users` left join achievements ON achievements_users.achievement_id = achievements.id where achievements_users.achievement_id IN (achievements.criteria_value) and achievements_users.user_id = user)

				 -- //Complete Other Achievements
				 WHEN 65  THEN (select COUNT(achievements_users.id) as itogo_completed from `achievements_users` left join achievements ON achievements_users.achievement_id = achievements.id where achievements_users.achievement_id IN (achievements.criteria_value) and achievements_users.user_id = user)

				 -- //RIDE AN AVG OF X MPH OR HIGHER FOR 3 CONSECUTIVE RIDES
				 WHEN 72  THEN 0

				 -- //RIDE AN AVG OF X MPH OR HIGHER FOR 5 CONSECUTIVE RIDES
				 WHEN 73  THEN 0

				 -- //RIDE AN AVG OF X MPH OR HIGHER FOR 10 CONSECUTIVE RIDES
				 WHEN 74  THEN 0

				 --  RIDE ELEVATION  --DONE

				 -- //CLIMB A TOTAL OF X FT IN ELEVATION --DONE
				 WHEN 39 THEN (SELECT ROUND(SUM(lap.elevation) * 3.2808399,0) as elevation from lap WHERE lap.user_id=user)

				 -- //CLIMB A MORE THAN X FT IN A SINGLE RIDE --DONE
				 WHEN 40 THEN (SELECT ROUND(MAX(lap.elevation) * 3.2808399,0) as elevation from lap WHERE lap.user_id=user)

				 -- //COMPLETE ALL ELEVATION ACHIEVEMENTS --DONE
				 WHEN 43 THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 7)

				 -- // CLIMB MORE THAN X FT IN A SINGLE MONTH --DONE
				 WHEN 53 THEN (SELECT SUM(ROUND(lap.elevation * 3.2808399,2)) as total_ft from lap left join files ON files.id = lap.file_id WHERE files.user_id = user GROUP BY MONTH(files.start)  ORDER BY total_ft DESC LIMIT 1)

				 -- //CLIMB 30,000 FT DURING THE MONTH OF X MONTH --DONE
				 WHEN 54 THEN
					 (select SUM(ROUND(lap.elevation * 3.2808399,2)) as total_ft from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=achievements.criteria_value group by YEAR(files.start) order by `total_ft` desc LIMIT 1)

				 -- //Complete Other Achievements --DONE
				 WHEN 62 THEN (select COUNT(achievements_users.id) as itogo_completed from `achievements_users` left join achievements ON achievements_users.achievement_id = achievements.id where achievements_users.achievement_id IN (achievements.criteria_value) and achievements_users.user_id = user)


				 --  RIDE DISTANCE
				 -- //RIDE A TOTAL OF X MILES --DONE
				 WHEN 29 THEN (select ROUND(SUM(total_distance)* 0.000621371192, 2) as total_distance   from `lap` where `user_id` = user)

				 -- //RIDE AT LEAST X MILES IN A SINGLE RIDE --DONE
				 WHEN 30 THEN (select  ROUND(MAX(total_distance)* 0.000621371192, 2) as total_distance  from `lap` where `user_id` = user)

				 -- //Get Max Distance Twice in week --DONE
				 WHEN 31 THEN (select count(files.id) as total_files from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and DAYOFWEEK(files.start) IN (1,7) and ROUND(lap.total_distance*0.000621371192,2) >= achievements.criteria_value group by DAYOFWEEK(files.start) order by total_files DESC LIMIT 1)

				 -- //Get total Distance by Week
				 WHEN 32 THEN (select SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user group by WEEK(files.end) order by `total_distance` desc LIMIT 1)

				 -- //RIDE AT LEAST X MILES IN ONE MONTH
				 WHEN 33 THEN (select SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user group by MONTH(files.end) order by `total_distance` desc LIMIT 1)

				 -- //COMPLETE ALL DISTANCE ACHIEVEMENTS
				 WHEN 48 THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 4)

				 -- //COMPLETE A RIDE OF X MILES OR MORE DURING THE 3RD WEEK OF MARCH
				 WHEN 66 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=3 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=3 order by `total_distance` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X MILES OR MORE DURING THE 1ST WEEK OF APRIL
				 WHEN 67 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=1 order by `total_distance` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X MILES OR MORE DURING THE 2ND WEEK OF APRIL
				 WHEN 68 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2 order by `total_distance` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF APRIL
				 WHEN 69 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4 order by `total_distance` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF SEPTEMBER
				 WHEN 70 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=9 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4 order by `total_distance` desc LIMIT 1)

				 -- //RIDE X MILES DURING THE 2ND WEEK OF JUNE
				 WHEN 71 THEN (select ROUND(lap.total_distance*0.000621371192,2) as total_distance from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=6 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4 order by `total_distance` desc LIMIT 1)

				 -- // RIDE X MILES DURING THE MONTH MAY
				 WHEN 85 THEN (select SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=5 group by MONTH(files.end) order by `total_miles` desc LIMIT 1)

				 -- // RIDE X MILES DURING THE MONTH JUNE
				 WHEN 86 THEN (select SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=7 group by MONTH(files.end) order by `total_miles` desc LIMIT 1)

				 -- // RIDE X MILES DURING THE MONTH SEPTEMBER
				 WHEN 87 THEN (select SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=9 group by MONTH(files.end) order by `total_miles` desc LIMIT 1)

				 --  RIDE TIME

				 -- // RIDE A TOTAL OF X HOURS
				 WHEN 35 THEN (select SUM(lap.total_elapsed_time) / 3600 from `lap` where `user_id` = user)

				 -- // RIDE FOR AT LEAST X MINUTES IN A SINGLE RIDE --ION
				 WHEN 36 THEN (select MAX(total_elapsed_time / 60) from `lap` where `user_id` = user)

				 -- // RIDE AT LEAST X CONSECUTIVE DAYS IN A ROW FOR A MINIMUM OF 30 MIN PER RIDE
				 WHEN 41 THEN 0

				 -- // RIDE AT LEAST X HOURS, TWICE IN A SINGLE WEEKEND
				 WHEN 42 THEN (select count(files.id) as total_files from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and DAYOFWEEK(files.start) IN (1,7) and lap.total_elapsed_time / 3600 >= achievements.criteria_value group by DAYOFWEEK(files.start) order by total_files DESC LIMIT 1)

				 -- //COMPLETE ALL TIME ACHIEVEMENTS
				 WHEN 46 THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 5)

				 -- //RIDE 50 HOURS OR MORE DURING THE MONTH OF X
				 WHEN 55 THEN (select SUM(ROUND(lap.total_elapsed_time/3600,2)) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=9 group by `files`.`user_id` order by `total_hours` desc LIMIT 1)

				 -- //RIDE X HOURS DURING THE 2ND WEEK OF JUNE
				 WHEN 56 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=6 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2 order by `total_hours` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 3RD WEEK OF MARCH
				 WHEN 57 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=3 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=3 order by `total_hours` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 1ST WEEK OF APRIL
				 WHEN 58 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=1 order by `total_hours` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 2ND WEEK OF APRIL
				 WHEN 59 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2 order by `total_hours` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF APRIL
				 WHEN 60 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=4 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4 order by `total_hours` desc LIMIT 1)

				 -- //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF SEPTEMBER
				 WHEN 61 THEN (select ROUND(lap.total_elapsed_time/3600,2) as total_hours from `lap` left join `files` on `files`.`id` = `lap`.`file_id` where `files`.`user_id` = user and MONTH(files.end)=9 and WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4 order by `total_hours` desc LIMIT 1)

				 --  RIDE HEART RATE

				 -- //COMPLETE ALL HEART RATE ACHIEVEMENTS
				 WHEN 44 THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 6)

				 -- //Complete Other Achievements
				 WHEN 75 THEN (select COUNT(achievements_users.id) as itogo_completed from `achievements_users` left join achievements ON achievements_users.achievement_id = achievements.id where achievements_users.achievement_id IN (achievements.criteria_value) and achievements_users.user_id = user)

				 -- //RIDE WITH AN AVG HEART RATE IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE
				 WHEN 77 THEN
					 CASE  achievements.criteria_value
					 WHEN 1 THEN (select ROUND(rides.zone_1_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_heart_rate` > 0 and (lap.max_power = 0 OR lap.max_power IS NULL) and `rides`.`user_id` = user order by totalsec DESC LIMIT 1)
					 WHEN 2 THEN (select ROUND(rides.zone_2_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_heart_rate` > 0 and (lap.max_power = 0 OR lap.max_power IS NULL) and `rides`.`user_id` = user order by totalsec DESC LIMIT 1)
					 WHEN 3 THEN (select ROUND(rides.zone_3_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_heart_rate` > 0 and (lap.max_power = 0 OR lap.max_power IS NULL) and `rides`.`user_id` = user order by totalsec DESC LIMIT 1)

					 END

				 -- //RIDE WITH AN AVG HEART RATE IN YOUR ZONE 3 FOR AT LEAST 60 MINUTES
				 WHEN 78 THEN (select ROUND(rides.zone_3_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_heart_rate` > 0 and (lap.max_power = 0 OR lap.max_power IS NULL) and `rides`.`user_id` = user order by totalsec DESC LIMIT 1)

				 -- //RIDE WITH AN AVG HEART RATE IN ZONE 3 FOR AT LEAST 60 MINUTES ON 10 RIDES
				 WHEN 79 THEN (select count(files.start) as count_rides from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_heart_rate` > 0 and (lap.max_power = 0 OR lap.max_power IS NULL)  and rides.zone_3_time/60>=60  and `rides`.`user_id` = user LIMIT 1)

				 -- //RECORD AN AVG HEART RATE IN ZONE 4 FOR AT LEAST 5 MINUTES AT LEAST X TIMES IN ONE RIDE
				 WHEN 80 THEN 0

				 -- //RECORD AN AVG HEART RATE IN ZONE 5 FOR AT LEAST 20 SECONDS AT LEAST X TIMES IN ONE RIDE
				 WHEN 81 THEN 0

				 -- RIDE POWER

				 -- // COMPLETE ALL RIDE ACHIEVEMENTS
				 WHEN 45 THEN (SELECT count(`achievements`.`id`) from `achievements` where achievements.id IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = user) and achievements.category_id = 1 and achievements.subcategory_id = 3)

				 -- // AVG ABOVE X WATTS IN A RIDE OF 30 MINUTES OR MORE
				 WHEN 49 THEN (select ROUND(MAX(lap.avg_power),1) as avg_power from `rides` left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where total_elapsed_time /60  >=30 and `rides`.`user_id` = user Order by avg_power LIMIT 1)

				 -- //AVG ABOVE X WATTS IN A RIDE OF 60 MINUTES OR MORE
				 WHEN 50 THEN (select ROUND(MAX(lap.avg_power),1) as avg_power from `rides` left join `lap` on `lap`.`file_id` = `rides`.`file_id` left join `users` on `users`.`id` = `lap`.`user_id` where total_elapsed_time /60  >=60 and `rides`.`user_id` = user Order by avg_power LIMIT 1)

				 -- //Complete Other Achievements
				 WHEN 63 THEN (select COUNT(achievements_users.id) as itogo_completed from `achievements_users` left join achievements ON achievements_users.achievement_id = achievements.id where achievements_users.achievement_id IN (achievements.criteria_value) and achievements_users.user_id = user)

				 -- // RIDE FOR AT LEAST 15 SECONDS WITH AN AVG POWER OF X WATTS OR MORE
				 WHEN 76 THEN 0

				 -- // RIDE WITH AN AVG POWER IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE
				 WHEN 82 THEN
					 CASE  achievements.criteria_value
					 WHEN 1 THEN (select ROUND(rides.zone_1_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_power` > 0 and `rides`.`user_id` = user Order by totalsec LIMIT 1)
					 WHEN 2 THEN (select ROUND(rides.zone_2_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_power` > 0 and `rides`.`user_id` = user Order by totalsec LIMIT 1)
					 WHEN 3 THEN (select ROUND(rides.zone_3_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_power` > 0 and `rides`.`user_id` = user Order by totalsec LIMIT 1)
					 END

				 -- //Complete Other Achievements
				 WHEN 83 THEN (select ROUND(rides.zone_3_time/60,0) as totalsec from `rides` left join `files` on `files`.`id` = `rides`.`file_id` left join `lap` on `lap`.`file_id` = `rides`.`file_id` where `lap`.`max_power` > 0 and rides.zone_3_time/60>=120 and `rides`.`user_id` = user order by totalsec desc LIMIT 1)

				 -- ELSE NO CONDITON
				 ELSE 0
				 END
			 END AS result


		FROM
			achievements
			LEFT JOIN cards on cards.achievement_id = achievements.id
			LEFT JOIN awards on awards.achievement_id = achievements.id
			LEFT JOIN achievements_users on achievements_users.achievement_id = achievements.id
			LEFT JOIN achievements_categories on achievements_categories.id = achievements.category_id
			LEFT JOIN achievements_criteria on achievements_criteria.id = achievements.criteria_id
		WHERE
			achievements.category_id = category
			AND achievements.subcategory_id = category_parent
		--  AND achievements.criteria_id = 2
		-- achievements.criteria_id = 28
		GROUP BY achievements.id
		ORDER BY CAST(completed AS UNSIGNED) desc,`achievements`.`title` ASC

 ;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getLeast10SecAboveMPH
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getLeast10SecAboveMPH` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getLeast10SecAboveMPH`(IN `user` INT, IN `speed` INT)
BEGIN
	 SET @user  = user;
	 SET @speed = speed;
    SELECT getLeast10SecAboveMPH_func(@user,@speed);
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getLeast10SecAbovePower
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getLeast10SecAbovePower` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getLeast10SecAbovePower`(IN `user` INT, IN `power` INT)
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
	END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getMaxConsecutiveDays
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getMaxConsecutiveDays` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getMaxConsecutiveDays`(IN `user` INT)
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
	END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getRightStatisticUser
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getRightStatisticUser` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getRightStatisticUser`(IN `user` INT, IN `days` INT, IN `type` VARCHAR(50))
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
      WHEN @type='power' THEN getPowerPosition(power,@days)
      WHEN @type='speed' THEN getSpeedPosition(speed,@days)
      WHEN @type='stamina' THEN getStaminaPosition(stamina,@days)
      WHEN @type='tenacity' THEN getTenacityPosition(tenacity,@days)
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
            LEFT JOIN files on files.id = lap.file_id
            LEFT JOIN users on users.id = lap.user_id
          WHERE
            IF
            (
                @days = 365
                , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                ,
                IF
                (
                    @days = 0,
                    lap.user_id >0,
                    DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                )
            )
            AND `users`.`id` > '0'
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
            LEFT JOIN files on files.id = lap.file_id
            LEFT JOIN users on users.id = lap.user_id
          WHERE
            IF
            (
                @days = 365
                , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                ,
                IF
                (
                    @days = 0,
                    lap.user_id >0,
                    DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                )
            )
            AND `users`.`id` > '0'
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
            LEFT JOIN files on files.id = lap.file_id
            LEFT JOIN users on users.id = lap.user_id
          WHERE
            IF
            (
                @days = 365
                , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                ,
                IF
                (
                    @days = 0,
                    lap.user_id >0,
                    DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                )
            )
            AND `users`.`id` > '0'
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
            LEFT JOIN files on files.id = lap.file_id
            LEFT JOIN users on users.id = lap.user_id
          WHERE
            IF
            (
                @days = 365
                , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                ,
                IF
                (
                    @days = 0,
                    lap.user_id >0,
                    DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                )
            )
            AND `users`.`id` > '0'

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
                    LEFT JOIN files on files.id = lap.file_id
                    LEFT JOIN `users` on `users`.`id` = `lap`.`user_id`
                  WHERE
                    IF
                    (
                        @days = 365
                        , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                        ,
                        IF
                        (
                            @days = 0,
                            lap.user_id >0,
                            DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                        )
                    )
                    AND `users`.`id` > '0'
                  GROUP BY lap.user_id
                ) as psst
           ORDER BY
             CASE
             WHEN @type='power' THEN power
             WHEN @type='speed' THEN speed
             WHEN @type='stamina' THEN stamina
             WHEN @type='tenacity' THEN tenacity
             END
           ASC
           --  END select by type and order

         ) as users_statistic
    WHERE user_id = user

    ;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getSpeedPowerStaminaTenacityListByUser
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getSpeedPowerStaminaTenacityListByUser` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getSpeedPowerStaminaTenacityListByUser`(IN `user` INT, IN `days` INT, IN `type_order` VARCHAR(50))
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
			LEFT JOIN files on files.id = lap.file_id
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
							DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
					)
			)
			AND lap.user_id = @user


		ORDER BY
			CASE
			WHEN type_order='power' THEN power
			-- WHEN type_order='speed' THEN speed
			WHEN type_order='stamina' THEN stamina
			WHEN type_order='tenacity' THEN tenacity
			END
		ASC




		;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getSpeedPowerStaminaTenacityUsers
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getSpeedPowerStaminaTenacityUsers` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getSpeedPowerStaminaTenacityUsers`(IN `days` INT, IN `type_order` VARCHAR(50))
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
             LEFT JOIN files on files.id = lap.file_id
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
                     DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                 )
             )
             AND `users`.`id` > 0
           --  AND lap.user_id = user
           GROUP BY users.id
           -- ORDER BY type_order
         ) as psst
    ORDER BY
      CASE
      WHEN type_order='power' THEN power
      WHEN type_order='speed' THEN speed
      WHEN type_order='stamina' THEN stamina
      WHEN type_order='tenacity' THEN tenacity
      END
    DESC




    ;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getSpeedUser
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getSpeedUser` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getSpeedUser`(IN `user` INT, IN `days` INT)
BEGIN

    DECLARE s VARCHAR(50);
    IF s THEN SET s = 'equals';
    END IF;

    SELECT
      COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2),0 )  as speed
    FROM lap
      LEFT JOIN files on files.id = lap.file_id
      LEFT JOIN users on users.id = lap.user_id
    WHERE
      lap.user_id = user
      AND DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= days

;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getStaminaPositionProced
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getStaminaPositionProced` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getStaminaPositionProced`(IN `sum` VARCHAR(50), IN `days` INT)
  BEGIN
    SET @i = -1;
    SET @position = NULL;
    SET @p = 0;
    SET @sum = sum;
    SET @days = days;


    SELECT
      *
      ,IF(stamina_user = @sum ,'Y','N') as sum_position
      ,@i := @i+1 as nr
    FROM
      (
        SELECT
          lap.user_id,
          COALESCE( ROUND( (SUM(total_distance)* 0.000621371192 /count(*)) ,2) ,0 )  as stamina_user
        -- end stamina_user
        FROM lap
          LEFT JOIN files on files.id = lap.file_id
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
                  DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
              )
          )
          AND `users`.`id` > '0'
        GROUP BY  lap.user_id
        ORDER BY stamina_user ASC
      ) as stamina_list
    ORDER BY stamina_user ASC


    ;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE getTenacityPositionProced
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `getTenacityPositionProced` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 PROCEDURE `getTenacityPositionProced`(IN `sum` VARCHAR(50), IN `days` INT)
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
            ,IF(tenacity_user = @sum ,'Y','N') as sum_position
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
                LEFT JOIN files on files.id = lap.file_id
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
                        DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                    )
                )
                AND `users`.`id` > 0
              GROUP BY users.id
              ORDER BY tenacity_user ASC
            ) as tenacity_list
          ORDER BY tenacity_user DESC
        ) as nr_position



      ;END


    ;END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

--
-- Dumping routines (FUNCTION) for database 'fitcraft'
--
DELIMITER ;;

# Dump of FUNCTION getAvgSpeed30Min
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getAvgSpeed30Min` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getAvgSpeed30Min`(`user` INT) RETURNS varchar(250) CHARSET latin1
BEGIN 
 	 RETURN  (
			SELECT MAX(ROUND(lap.avg_speed * 2.23693629205442920544,2)) as speed FROM lap
			 WHERE moving_time >= 1800
			  AND user_id  = user
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getHoursByWeekend
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getHoursByWeekend` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getHoursByWeekend`(`user` INT) RETURNS int(11)
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
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getLeast10SecAboveMPH_func
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getLeast10SecAboveMPH_func` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getLeast10SecAboveMPH_func`(`user` INT, `speed` INT) RETURNS int(11)
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
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getMaxDistanceWeekend
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getMaxDistanceWeekend` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getMaxDistanceWeekend`(`user` INT) RETURNS varchar(250) CHARSET latin1
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
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getMaxElevationByRide
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getMaxElevationByRide` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getMaxElevationByRide`(`user` INT) RETURNS int(11)
BEGIN
  
 	 RETURN  (	  
		  SELECT 
		   	ROUND(MAX(lap.elevation) * 3.2808399,0) as elevation
		  FROM 
		  	lap 		  
		  WHERE lap.user_id = user  		 
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getMinutesSingleRide
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getMinutesSingleRide` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getMinutesSingleRide`(`user` INT) RETURNS int(11)
BEGIN 
 	 RETURN  (
		  SELECT 
		  	MAX(ROUND( (moving_time / 60) ,0 ) ) as total_elapsed_time 
		  FROM 
		  	lap 
		  WHERE user_id = user     
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getPercents
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getPercents` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getPercents`(`val1` INT, `val2` INT) RETURNS int(11)
BEGIN 
 	 RETURN  (
 			IF(
			 	val1>0,
			 		IF ( CAST( ROUND( (val1 * 100) /val2 , 0 ) AS UNSIGNED) >100 ,100 , CAST( ROUND( (val1 * 100) /val2 , 0 ) AS UNSIGNED)  )
				,0
			)
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getPowerPosition
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getPowerPosition` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getPowerPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
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
            ,IF(power_user = @sum ,'Y','N') as sum_position
            ,@i := @i+1 as nr
          FROM
            (
              SELECT
                lap.user_id,
                -- power_user
                ROUND(SUM(lap.avg_power)/count(lap.id),2)  as power_user
              -- end power_user
              FROM lap
                LEFT JOIN files on files.id = lap.file_id
                LEFT JOIN users on users.id = lap.user_id
              WHERE
                IF
                (
                    @days = 365
                    , files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY)
                    ,
                    IF
                    (
                        @days = 0,
                        lap.user_id >0,
                        DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                    )
                )
                AND `users`.`id` > 0
              GROUP BY users.id
              ORDER BY power_user ASC
            ) as power_list
          ORDER BY power_user ASC
        ) as nr_position
      WHERE sum_position = 'Y'
      LIMIT 1
    );
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getPowerUser
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getPowerUser` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getPowerUser`(`user` INT, `days` INT) RETURNS int(11)
  BEGIN

    DECLARE s VARCHAR(50);
    IF s THEN SET s = 'equals';
    END IF;

    RETURN  (
      SELECT
        ROUND(
            (SUM(lap.avg_power)/count(lap.id))
            ,2
        )
          as power
      FROM lap
        LEFT JOIN files on files.id = lap.file_id
        LEFT JOIN users on users.id = lap.user_id
      WHERE
        lap.user_id = user
        AND DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= days
    );
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getSpeedPosition
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getSpeedPosition` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getSpeedPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
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
                -- ,COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed_user
                COALESCE( ROUND( ((SUM(avg_speed) * 2.2369362920544)/COUNT(*)),2) ,0)  as speed_user
              -- end speed_user
              FROM lap
                LEFT JOIN files on files.id = lap.file_id
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
                        DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                    )
                )
                AND `users`.`id` > 0
              GROUP BY users.id
              ORDER BY speed_user ASC
            ) as speed_list
          ORDER BY speed_user ASC
        ) as nr_position
      WHERE sum_position = 'Y'
      LIMIT 1
    );
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getStaminaPosition
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getStaminaPosition` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getStaminaPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
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
            ,IF(stamina_user = @sum ,'Y','N') as sum_position
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
                LEFT JOIN files on files.id = lap.file_id
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
                        DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                    )
                )
                AND `users`.`id` > 0
              GROUP BY  lap.user_id
              ORDER BY stamina_user ASC
            ) as stamina_list
          ORDER BY stamina_user ASC
        ) as nr_position
      WHERE sum_position = 'Y'
      LIMIT 1
    );
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getSumElevation
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getSumElevation` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getSumElevation`(`user` INT) RETURNS int(11)
BEGIN
  
 	 RETURN  (	  
		  SELECT 
		   	ROUND(SUM(lap.elevation) * 3.2808399,0) as elevation
		  FROM 
		  	lap 		  
		  WHERE lap.user_id = user  		 
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getTenacityPosition
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getTenacityPosition` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getTenacityPosition`(`sum` VARCHAR(50), `days` INT) RETURNS int(11)
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
            ,IF(tenacity_user = @sum ,'Y','N') as sum_position
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
                LEFT JOIN files on files.id = lap.file_id
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
                        DATEDIFF(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(files.start,'%Y-%m-%d')) <= @days
                    )
                )
                AND `users`.`id` > 0
              GROUP BY users.id
              ORDER BY tenacity_user ASC
            ) as tenacity_list
          ORDER BY tenacity_user ASC
        ) as nr_position
      WHERE sum_position = 'Y'
      LIMIT 1
    );
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getTotalHours
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getTotalHours` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getTotalHours`(`user` INT) RETURNS int(11)
BEGIN 
 	 RETURN  (
			  SELECT 
			  	ROUND( (SUM(lap.moving_time) / 3600),0) as total_elapsed_time 
			  FROM 
			  	lap 
			  WHERE user_id = user   
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of FUNCTION getTotalXP
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `getTotalXP` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`fitcraft`@`%`*/ /*!50003 FUNCTION `getTotalXP`(`user` INT) RETURNS int(11)
BEGIN
  
 	 RETURN  (	  
		  SELECT 
		  	 MAX(ROUND((zone_1 + zone_2 + zone_3 + zone_4 + zone_5),0)) as total_xp
		  FROM 
		  	rides 		  
		  WHERE user_id = user 
		  HAVING total_xp > 0
	  );
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
