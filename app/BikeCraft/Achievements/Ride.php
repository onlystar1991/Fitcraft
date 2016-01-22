<?php namespace App\BikeCraft\Achievements;


use App\Models\Lap;
use App\Models\Record;
use App\Models\Rides;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Class Ride
 * @package App\BikeCraft\Achievements
 */
class Ride extends Achievements {

    public function doProcessing($achievement)
    {
        switch($achievement->criteria_id){
            //NO CATEGORY
            case 21 :
                $this->completeXridersLeast30min($achievement);
                break;
            case 22 :
                $this->completeXridersLeast30minWeek($achievement);
                break;
            case 23 :
                $this->completeRideLeast30minEntireMonth($achievement);
                break;
            case 24 :
                $this->completeRiderAtDay($achievement);
                break;
            case 25 :
                $this->completeRiderAtDay($achievement);
                break;
            case 26 :
                $this->completeRiderAtDay($achievement);
                break;
            case 27 :
                $this->uploadRides($achievement);
                break;
            case 28 :
                $this->completeAllRides($achievement);
                break;
            case 84 :
                $this->completeRiderAtDay($achievement);
                break;

            //ELEVATION
            case 39 :
                $this->climbTotalElelvation($achievement);
                break;
            case 40 :
                $this->climbElelvationInSingleRide($achievement);
                break;
            case 43 :
                $this->completeAllRides($achievement);
                break;
            case 53 :
                $this->climbElelvationInSingleMonth($achievement);
                break;
            case 54 :
                $this->climbElelvationInXMonth($achievement);
                break;
            case 62 :
                $this->completeOtherAchievements($achievement);
                break;

            //HEART RATE
            case 75 :
                $this->completeOtherAchievements($achievement);
                break;
            case 77 :
                $this->getAVGHeartZoneXLeast30min($achievement);
                break;
            case 78 :
                $this->getAVGHeartZone3Least60min($achievement);
                break;
            case 79 :
                $this->getAVGHeartZone3Least60min10rides($achievement);
                break;
            case 80 :
                $this->getAVGHeartZone4Xtimes($achievement);
                break;
            case 81 :
                $this->getAVGHeartZone5Xtimes($achievement);
                break;

            //TIME
            case 35 :
                $this->rideTotalHours($achievement);
                break;
            case 36 :
                $this->rideXminSingle($achievement);
                break;
            case 41 :
                $this->getMaxConsecutiveDays($achievement);
                break;
            case 42 :
                $this->rideTotalHoursTwiceWeekend($achievement);
                break;
            case 55 :
                $this->getHoursDuringMonthX($achievement);
                break;
            case 56 :
                $this->getHoursDuring2ndWeekOfJune($achievement);
                break;
            case 57 :
                $this->getHours3rdWeekMarch($achievement);
                break;
            case 58 :
                $this->getHours1stWeekApril($achievement);
                break;
            case 59 :
                $this->getHours2ndWeekApril($achievement);
                break;
            case 60 :
                $this->getHours4thWeekApril($achievement);
                break;
            case 61 :
                $this->getHours4thWeekSeptember($achievement);
                break;
            //DISTANCE
            case 29 :
                $this->rideTotalMiles($achievement);
                break;
            case 30 :
                $this->rideTotalMilesRide($achievement);
                break;
            case 31 :
                $this->rideTotalTwiceMilesWeekend($achievement);
                break;
            case 32 :
                $this->rideTotalMilesWeek($achievement);
                break;
            case 33 :
                $this->rideTotalMilesMonth($achievement);
                break;
            case 48 :
                $this->completeAllRides($achievement);
                break;
            case 66 :
                $this->getMiles3rdWeekMarch($achievement);
                break;
            case 67 :
                $this->getMiles1stWeekApril($achievement);
                break;
            case 68 :
                $this->getMiles2ndWeekApril($achievement);
                break;
            case 69 :
                $this->getMiles4thWeekApril($achievement);
                break;
            case 70 :
                $this->getMiles4thWeekSeptember($achievement);
                break;
            case 71 :
                $this->getMilesDuring2ndWeekOfJune($achievement);
                break;
            case 85 :
                $this->milesDuringInMayMonth($achievement);
                break;
            case 86 :
                $this->milesDuringInJulyMonth($achievement);
                break;
            case 87 :
                $this->milesDuringInSeptemberMonth($achievement);
                break;
            //POWER
            case 45 :
                $this->completeAllRides($achievement);
                break;
            case 49 :
                $this->avgWatts30minRide($achievement);
                break;
            case 50 :
                $this->avgWatts60minRide($achievement);
                break;
            case 63 :
                $this->completeOtherAchievements($achievement);
                break;
            case 76 :
                $this->getLeast15SecAboveXPower($achievement);
                break;
            case 82 :
                $this->getAVGPowerZoneXLeast30min($achievement);
                break;
            case 83 :
                $this->getAVGPowerZoneXLeast120min($achievement);
                break;
            //SPEED
            case 37 :
                $this->avgSpeedMore30Min($achievement);
                break;
            case 38 :
                $this->least10SecAboveMPH($achievement);
                break;
            case 47 :
                $this->completeAllRides($achievement);
                break;
            case 51 :
                $this->topSpeedRideMPH($achievement);
                break;
            case 64 :
                $this->completeOtherAchievements($achievement);
                break;
            case 65 :
                $this->completeOtherAchievements($achievement);
                break;
            case 72 :
                $this->getAvgXMPH3consecRides($achievement);
                break;
            case 73 :
                $this->getAvgXMPH5consecRides($achievement);
                break;
            case 74 :
                $this->getAvgXMPH10consecRides($achievement);
                break;

        }
    }



    /**
     * UPLOAD X RIDES
     * @param $achievement
     */
    public function uploadRides($achievement)
    {
        $count_rides = Rides::where('user_id',Auth::client()->user()->id)->count();
        if ( $count_rides >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE ALL RIDE ACHIEVEMENTS
    public function completeAllRides($achievement)
    {
        $user_id = Auth::client()->user()->id;
        $achivements = DB::select("select `achievements`.`id` from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = $user_id) and achievements.category_id = $achievement->category_id and achievements.subcategory_id = $achievement->subcategory_id and achievements.criteria_id <> $achievement->criteria_id");
        if(count($achivements)==0){
            $this->createAchievement($achievement);
        }
    }

    //Complete Other Achievements
    public function completeOtherAchievements($achievement)
    {
        $user_id = Auth::client()->user()->id;
        $count_achiv = explode(',',$achievement->criteria_value);
        $count_achiv = count($count_achiv);
        $achivements = DB::select("select COUNT(`id`) as itogo_completed from `achievements_users` where achievement_id  IN ($achievement->criteria_value) and user_id = {$user_id} having itogo_completed={$count_achiv} ");
        if(count($achivements)>0){
            $this->createAchievement($achievement);
        }
    }


    //RIDE A TOTAL OF X MILES
    public function rideTotalMiles($achievement)
    {
        $lap = Lap::getSumDistance(Auth::client()->user()->id);
        if ( $lap->total_distance >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //RECORD A TOP SPEED OVER X MPH
    public function topSpeedRideMPH($achievement)
    {
        $lap = Record::topSpeedRideMPH(Auth::client()->user()->id,$achievement->criteria_value);
        if($lap);
        if (!empty($lap->top_speed)) {
            $this->createAchievement($achievement);
        }
    }

    //AVG ABOVE X WATTS IN A RIDE OF 30 MINUTES OR MORE
    public function avgWatts30minRide($achievement)
    {
        $watts = Lap::getAvgWatts30minRide(Auth::client()->user()->id,$achievement->criteria_value);
        if ( !empty($watts->avg_power)) {
            $this->createAchievement($achievement);
        }
    }

    //AVG ABOVE X WATTS IN A RIDE OF 60 MINUTES OR MORE
    public function avgWatts60minRide($achievement)
    {
        $watts = Lap::getAvgWatts60minRide(Auth::client()->user()->id,$achievement->criteria_value);
        if ( !empty($watts->avg_power)) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE DAY
    public function completeXridersLeast30min($achievement)
    {
        $rides = Rides::completeXridersLeast30min(Auth::client()->user()->id,$achievement->criteria_value);
        if(count($rides)>0){
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE ON X day
    public function completeRiderAtDay($achievement)
    {
        $rides = Rides::completeRideOnDay(Auth::client()->user()->id, $achievement->criteria_value);
        if(count($rides)>0){
            $this->createAchievement($achievement);
        }
    }

    //RIDE 1000 MILES DURING THE MONTH OF X MONTH
    public function milesDuringXmonth($achievement)
    {
        $rides = Rides::milesDuringXmonth(Auth::client()->user()->id, $achievement->criteria_value);
        if(count($rides)>0){
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE WEEK
    public function completeXridersLeast30minWeek($achievement)
    {
        $rides = Rides::completeXridersLeast30minWeek(Auth::client()->user()->id,$achievement->criteria_value);
        if(count($rides)>0)
        if ( $rides[0]["CountOfRides"] >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE A DAY OF AT LEAST 30 MINUTES FOR AN ENTIRE CALENDER MONTH
    public function completeRideLeast30minEntireMonth($achievement)
    {
        $rides = Rides::completeRideLeast30minEntireMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if ( count($rides)>0) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AT LEAST X MILES IN A SINGLE RIDE
    public function rideTotalMilesRide($achievement)
    {
        $lap = Lap::getMaxDistance(Auth::client()->user()->id);
        if(isset($lap))
        if ( $lap->total_distance >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }


//    //RIDE AT LEAST X MILES, TWICE IN A SINGLE WEEKEND
    public function rideTotalTwiceMilesWeekend($achievement)
    {
        $lap = Lap::getMaxDistanceTwiceInWeekend(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0 ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AT LEAST X MILES IN ONE WEEK
    public function rideTotalMilesWeek($achievement)
    {
        $lap = Lap::getTotalDistanceWeek(Auth::client()->user()->id);

        if ( !empty($lap) && $lap[0]["total_distance"] >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AT LEAST X MILES IN ONE MONTH
    public function rideTotalMilesMonth($achievement)
    {
        $lap = Lap::getTotalDistanceMonth(Auth::client()->user()->id);

        if ( !empty($lap) && $lap[0]["total_distance"] >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE A TOTAL OF X HOURS
    public function rideTotalHours($achievement)
    {
        $lap = Lap::getTotalHours(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE FOR AT LEAST X MINUTES IN A SINGLE RIDE --ION
    public function rideSingle30Min($achievement)
    {
        $lap = Lap::getMinutesSingleRide(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE FOR AT LEAST X MINUTES IN A SINGLE RIDE
    public function rideXminSingle($achievement)
    {
        $lap = Lap::getMinutesSingleRide(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 3RD WEEK OF MARCH
    public function getHours3rdWeekMarch($achievement)
    {
        $lap = Lap::getHours3rdWeekMarch(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 3RD WEEK OF MARCH
    public function getMiles3rdWeekMarch($achievement)
    {
        $lap = Lap::getMiles3rdWeekMarch(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 1ST WEEK OF APRIL
    public function getHours1stWeekApril($achievement)
    {
        $lap = Lap::getHours1stWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 1ST WEEK OF APRIL
    public function getMiles1stWeekApril($achievement)
    {
        $lap = Lap::getMiles1stWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 2ND WEEK OF APRIL
    public function getHours2ndWeekApril($achievement)
    {
        $lap = Lap::getHours2ndWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 2ND WEEK OF APRIL
    public function getMiles2ndWeekApril($achievement)
    {
        $lap = Lap::getMiles2ndWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF APRIL
    public function getHours4thWeekApril($achievement)
    {
        $lap = Lap::getHours4thWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF APRIL
    public function getMiles4thWeekApril($achievement)
    {
        $lap = Lap::getMiles4thWeekApril(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF SEPTEMBER
    public function getHours4thWeekSeptember($achievement)
    {
        $lap = Lap::getHours4thWeekSeptember(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF SEPTEMBER
    public function getMiles4thWeekSeptember($achievement)
    {
        $lap = Lap::getMiles4thWeekSeptember(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE 50 HOURS OR MORE DURING THE MONTH OF X
    public function getHoursDuringMonthX($achievement)
    {
        $lap = Lap::getHoursDuringMonthX(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE X HOURS DURING THE 2ND WEEK OF JUNE
    public function getHoursDuring2ndWeekOfJune($achievement)
    {
        $lap = Lap::getHoursDuring2ndWeekOfJune(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) and $lap->total_hours>=$achievement->criteria_value) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE X MILES DURING THE 2ND WEEK OF JUNE
    public function getMilesDuring2ndWeekOfJune($achievement)
    {
        $lap = Lap::getMilesDuring2ndWeekOfJune(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap)  and $lap->total_distance>=$achievement->criteria_value) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AN AVG SPEED OF X MPH OR HIGHER ON A RIDE OF 30 MIN OR MORE
    public function avgSpeedMore30Min($achievement)
    {
        $lap = Lap::getAvgSpeed30Min(Auth::client()->user()->id, $achievement->criteria_value);
        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AN AVG OF X MPH OR HIGHER FOR 3 CONSECUTIVE RIDES
    public function getAvgXMPH3consecRides($achievement)
    {
        $rides = DB::select('CALL getMaxConsecutiveRides(?,?,?)',[Auth::client()->user()->id, 3,$achievement->criteria_value]);
        if ( !empty($rides[0]) && $rides[0]->vsego >= 3 ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AN AVG OF X MPH OR HIGHER FOR 5 CONSECUTIVE RIDES
    public function getAvgXMPH5consecRides($achievement)
    {
        $rides = DB::select('CALL getMaxConsecutiveRides(?,?,?)',[Auth::client()->user()->id, 5,$achievement->criteria_value]);
        if ( !empty($rides[0]) && $rides[0]->vsego >= 5 ) {
            $this->createAchievement($achievement);
        }
    }
    //RIDE AN AVG OF X MPH OR HIGHER FOR 10 CONSECUTIVE RIDES
    public function getAvgXMPH10consecRides($achievement)
    {
        $rides = DB::select('CALL getMaxConsecutiveRides(?,?,?)',[Auth::client()->user()->id, 10,$achievement->criteria_value]);
        if ( !empty($rides[0]) && $rides[0]->vsego >= 10 ) {
            $this->createAchievement($achievement);
        }
    }

    /**
     * //RIDE FOR AT LEAST 10 SECONDS ABOVE X MPH
     * @param $achievement
     */

    public function least10SecAboveMPH($achievement)
    {
        $seconds = DB::select('CALL getLeast10SecAboveMPH(?, ?)',[Auth::client()->user()->id, $achievement->criteria_value]);
        $sec = $seconds[0]->sec;
        if ($sec>=10) {
            $this->createAchievement($achievement);
        }
    }

    // CLIMB A TOTAL OF X FT IN ELEVATION
    public function climbTotalElelvation($achievement)
    {
        $lap = Lap::getSumElevation(Auth::client()->user()->id);
        if ( $lap->elevation >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }


    // CLIMB A MORE THAN X FT IN A SINGLE RIDE
    public function climbElelvationInSingleRide($achievement)
    {
        $lap = Lap::getMaxElevationByRide(Auth::client()->user()->id);

        if ( $lap->elevation >= $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    // CLIMB MORE THAN X FT IN A SINGLE MONTH
    public function climbElelvationInSingleMonth($achievement)
    {
        $lap = Lap::getMaxElevationByMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0) {
            $this->createAchievement($achievement);
        }
    }

    // CLIMB MORE THAN X FT IN A SINGLE MONTH
    public function climbElelvationInXMonth($achievement)
    {
        $lap = Lap::getMaxElevationByXMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0) {
            $this->createAchievement($achievement);
        }
    }

    // RIDE X MILES DURING THE MONTH MAY
    public function milesDuringInMayMonth($achievement)
    {
        $lap = Lap::milesDuringInMayMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0) {
            $this->createAchievement($achievement);
        }
    }
    // RIDE X MILES DURING THE MONTH JULY
    public function milesDuringInJulyMonth($achievement)
    {
        $lap = Lap::milesDuringInJulyMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0) {
            $this->createAchievement($achievement);
        }
    }
    // RIDE X MILES DURING THE MONTH SEPTEMBER
    public function milesDuringInSeptemberMonth($achievement)
    {
        $lap = Lap::milesDuringInSeptemberMonth(Auth::client()->user()->id,$achievement->criteria_value);
        if (count($lap)>0) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AT LEAST X CONSECUTIVE DAYS IN A ROW FOR A MINIMUM OF 30 MIN PER RIDE
    public function getMaxConsecutiveDays($achievement)
    {
        $days = DB::select('CALL getMaxConsecutiveDays(?)',[Auth::client()->user()->id]);
        if ( !empty($days[0]) && $days[0]->maxDays >= $achievement->criteria_value  ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE AT LEAST X HOURS, TWICE IN A SINGLE WEEKEND
    public function rideTotalHoursTwiceWeekend($achievement)
    {
        $lap = Lap::getHoursTwiceByWeekend(Auth::client()->user()->id, $achievement->criteria_value);

        if ( !empty($lap) ) {
            $this->createAchievement($achievement);
        }
    }

    //RIDE FOR AT LEAST 10 SECONDS ABOVE X WATTS
    public function getLeast10SecAbovePower($achievement)
    {
         $seconds = DB::select('CALL getLeast10SecAbovePower(?, ?)',[$this->user->id, $achievement->criteria_value]);
         if ( !empty($seconds[0]) ) {
             $this->createAchievement($achievement);
         }
    }

    //RIDE FOR AT LEAST 15 SECONDS WITH AN AVG POWER OF X WATTS OR MORE
    public function getLeast15SecAboveXPower($achievement)
    {
        $seconds = Record::getLeast15SecAboveAVGPower(Auth::client()->user()->id, $achievement->criteria_value);
        if ( $seconds>=15 ) {
             $this->createAchievement($achievement);
         }
    }

    //RIDE WITH AN AVG POWER IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE
    public function getAVGPowerZoneXLeast30min($achievement)
    {
        $seconds = Rides::getAVGPowerZoneXLeast30min(Auth::client()->user()->id, $achievement->criteria_value);
        if (count($seconds)>0) {
             $this->createAchievement($achievement);
         }
    }

    //RIDE WITH AN AVG HEART RATE IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE
    public function getAVGHeartZoneXLeast30min($achievement)
    {
        $seconds = Rides::getAVGHeartZoneXLeast30min(Auth::client()->user()->id, $achievement->criteria_value);
        if (count($seconds)>0) {
             $this->createAchievement($achievement);
        }
    }

    //RIDE WITH AN AVG HEART RATE IN YOUR ZONE 3 FOR AT LEAST 60 MINUTES
    public function getAVGHeartZone3Least60min($achievement)
    {
        $seconds = Rides::getAVGHeartZone3Least60min(Auth::client()->user()->id, $achievement->criteria_value);
        if (count($seconds)>0) {
             $this->createAchievement($achievement);
         }
    }

    //RECORD AN AVG HEART RATE IN ZONE 4 FOR AT LEAST 5 MINUTES AT LEAST X TIMES IN ONE RIDE
    public function getAVGHeartZone4Xtimes($achievement)
    {
        $seconds = Rides::getAVGHeartZone4Xtimes(Auth::client()->user(), 5, $achievement->criteria_value);
        if ($seconds) {
             $this->createAchievement($achievement);
         }
    }

    //RECORD AN AVG HEART RATE IN ZONE 5 FOR AT LEAST 20 SECONDS AT LEAST X TIMES IN ONE RIDE
    public function getAVGHeartZone5Xtimes($achievement)
    {
        $seconds = Rides::getAVGHeartZone5Xtimes(Auth::client()->user(), 20, $achievement->criteria_value);
        if ($seconds) {
             $this->createAchievement($achievement);
         }
    }

    //RIDE WITH AN AVG HEART RATE IN ZONE 3 FOR AT LEAST 60 MINUTES ON 10 RIDES
    public function getAVGHeartZone3Least60min10rides($achievement)
    {
        $seconds = Rides::getAVGHeartZone3Least60min10rides(Auth::client()->user()->id, $achievement->criteria_value);
        if (count($seconds)>0) {
            if($seconds[0]["count_rides"]>=10)
             $this->createAchievement($achievement);
         }
    }

    //RIDE WITH AN AVG POWER IN YOUR ZONE 3 FOR AT LEAST 120 MINUTES
    public function getAVGPowerZoneXLeast120min($achievement)
    {
        $seconds = Rides::getAVGPowerZoneXLeast120min(Auth::client()->user()->id, $achievement->criteria_value);
        if (count($seconds)>0) {
             $this->createAchievement($achievement);
         }
    }




}