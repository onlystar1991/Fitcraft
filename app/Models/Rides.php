<?php namespace app\Models;

use App\BikeCraft\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Rides extends Model  {

    protected $table = 'rides';

    protected $fillable = ['user_id','file_id','elevation','name','locality','country','postal_code','administrative_area_level_1'];


    /**
     * @param $user_id
     * @param $filter
     * @return mixed
     */
    public static function getByUserId($user_id, $filter)
    {
        $user_request = Auth::client()->user()->id;
        $query =  parent::select(
                    'rides.id',
                    'rides.name',
                    DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed'),
                    DB::RAW('ROUND(max_speed * 2.23693629, 2) as max_speed'),
                    DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp'),
                    'zone_1', 'zone_2', 'zone_3', 'zone_4', 'zone_5',
                    'zone_0_time', 'zone_1_time', 'zone_2_time', 'zone_3_time', 'zone_4_time', 'zone_5_time',
                    'lap.avg_heart_rate',
                    'lap.max_heart_rate',
                    'lap.avg_cadence',
                    'lap.max_cadence',
                    'lap.moving_time',
                    DB::RAW('ROUND(lap.avg_power,0) as avg_power'),
                    'lap.max_power',
                    DB::RAW('
                        ROUND(
                            (MAX(
                                IF(
                                    lap.max_power>0,    
                                    lap.max_power,
                                    users.power
                                    )   
                            ))
                            ,0
                        ) 
                        as peak_power                            
                    '),
                    'lap.total_calories',
                    'lap.total_elapsed_time',
                    'lap.start_time',
                    DB::RAW('ROUND(lap.total_elapsed_time,0) as time'),
                    DB::RAW("IF(rides.user_id = $user_request, 0, 1) as report_enable"),
                    DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance'),
                    DB::RAW('ROUND(lap.elevation * 3.2808399,0) as elevation')
                    )
                    ->leftJoin('lap','lap.file_id','=','rides.file_id')
                    ->leftJoin('files','files.id','=','rides.file_id')
                    ->leftJoin('users','users.id','=','lap.user_id')
                    ->where('rides.user_id',$user_id);
                if (is_numeric($filter->get('time'))) {
                    $query->having('time', $filter->get('time_filter'), $filter->get('time')*60);
                }
                
                if (is_numeric($filter->get('distance'))) {    
                    $query->whereRAW("lap.total_distance ".$filter->get('distance_filter')." ".$filter->get('distance')." ");
                }

                if ( $filter->get('avg_speed') ) {
                    $query->having('avg_speed', $filter->get('avg_speed_filter'), $filter->get('avg_speed'));
                }

                if ( $filter->get('max_speed') ) {
                    $query->having('max_speed', $filter->get('max_speed_filter'), $filter->get('max_speed'));
                }

                if (is_numeric($filter->get('avg_power'))) {
                    $query->whereRAW("lap.avg_power ".$filter->get('avg_power_filter')." ".$filter->get('avg_power')." ");
                }

                if (is_numeric($filter->get('max_power'))) {                                   
                    $query->whereRAW("lap.max_power ".$filter->get('max_power_filter').$filter->get('max_power')." ");
                }

                if ( $filter->get('avg_heart_rate') ) {
                    $query->where('avg_heart_rate', $filter->get('avg_heart_rate_filter'), $filter->get('avg_heart_rate'));
                }

                if ( $filter->get('elv_gain') ) {
                    $query->having('elevation', $filter->get('elv_gain_filter'), $filter->get('elv_gain'));
                }

                if ( $filter->get('ride_name') ) {
                    $query->where('name', 'like', '%'.$filter->get('ride_name').'%');
                }

                if ( $filter->get('zip_code') ) {
                    $query->where('postal_code', '=', $filter->get('zip_code'));
                }

                if ( $filter->get('date_start') ) {
                    $garmin_start = Data::timeToGarmin(strtotime($filter->get('date_start')));
                    $query->where('lap.start_time','>=',$garmin_start);
                }

                if ( $filter->get('date_end') ) {
                    $garmin_end = Data::timeToGarmin(strtotime($filter->get('date_end')));
                    $query->where('lap.start_time','<=',$garmin_end);
                }

                if (is_numeric($filter->get('effort_lvl'))) {    
                    $query->whereRAW("rides.max_effort ".$filter->get('effort_lvl_filter')." ".$filter->get('effort_lvl')." ");
                }

                return $query->orderBy('rides.created_at','desc')->groupBy('rides.id')->get();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function completeXridersLeast30min($user_id, $criteria)
    {
        $query =  parent::select(
            DB::RAW('COUNT(DISTINCT rides.id) AS CountOfRides')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('lap.total_elapsed_time','>=',1800)
            ->where('rides.user_id', $user_id)
            ->having('CountOfRides', '>=', $criteria);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function completeRideOnDay($user_id, $date)
    {
        $query =  parent::select(
            DB::RAW('COUNT(DISTINCT rides.id) AS CountOfRides'),
            DB::RAW('DAYOFYEAR(files.end)')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->where('rides.user_id', $user_id)
            ->where(DB::RAW('DAYOFYEAR(files.end)'), '=', $date)
            ->having('CountOfRides', '>=', 1);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function completeXridersLeast30minWeek($user_id, $criteria)
    {
        $query =  parent::select(
            DB::RAW('COUNT(DISTINCT rides.id) AS CountOfRides')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('lap.total_elapsed_time','>=',1800)
            ->where('rides.user_id', $user_id)
            ->groupBy(DB::raw('WEEK(files.end)'))
            ->having('CountOfRides', '>=', $criteria);

        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function milesDuringXmonth($user_id, $criteria) //!!!!!!!!
    {
        $query =  parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')

        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->whereRAW("FROM_UNIXTIME(files.end, '%m')=$criteria")
            ->having('total_distance','>=',1000);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function completeRideLeast30minEntireMonth($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('count(files.start) as totalrides'),
            DB::raw('DAYOFMONTH(DATE_SUB(DATE_ADD(DATE_SUB(files.`start`,INTERVAL DAYOFMONTH(files.`start`)-1 DAY),INTERVAL 1 MONTH),INTERVAL 1 DAY)) AS coldays')
        )
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('users','users.id','=','lap.user_id')
        ->where('rides.user_id',$user_id)
        ->whereRAW("ROUND(lap.total_elapsed_time/60,2)>=$criteria")
        ->groupBy(DB::raw('YEAR(files.`start`), MONTH(files.`start`)'))
        ->having('coldays','<=', 'totalrides');
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGPowerZoneXLeast30min($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('ROUND(rides.zone_'.$criteria.'_time/60,0) as totalsec')
        )
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->where('lap.max_power','>',0)
        ->whereRAW('rides.zone_'.$criteria.'_time/60>=30')
        ->where('rides.user_id',$user_id);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGPowerZoneXLeast120min($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('ROUND(rides.zone_'.$criteria.'_time/60,0) as totalsec')
        )
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->where('lap.max_power','>',0)
        ->whereRAW('rides.zone_'.$criteria.'_time/60>=120')
        ->where('rides.user_id',$user_id);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGHeartZoneXLeast30min($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('ROUND(rides.zone_'.$criteria.'_time/60,0) as totalsec')
        )
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->where('lap.max_heart_rate','>',0)
        ->whereRAW('(lap.max_power = 0 OR lap.max_power IS NULL)')
        ->whereRAW('rides.zone_'.$criteria.'_time/60>=30')
        ->where('rides.user_id',$user_id);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGHeartZone3Least60min($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('ROUND(rides.zone_'.$criteria.'_time/60,0) as totalsec')
        )
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->where('lap.max_heart_rate','>',0)
        ->whereRAW('(lap.max_power = 0 OR lap.max_power IS NULL)')
        ->whereRAW('rides.zone_3_time/60>=60')
        ->where('rides.user_id',$user_id);
        return $query->get()->toArray();
    }

    /**
 * @param $user_id
 * @param  $minutes
 * @param $criteria
 * @return mixed
 */

    public static function getAVGHeartZone4Xtimes($user, $minutes, $criteria)
    {

        $query = parent::select(
            'files.id',
            'lap.max_heart_rate'
        )
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->where('lap.max_heart_rate','>',0)
            ->whereRAW('(lap.max_power = 0 OR lap.max_power IS NULL)')
            ->where('rides.user_id',$user->id);
        $files = $query->get()->toArray();
        if(count($files)>0){
            foreach ( $files as $file_key=> $file ) {
                if(is_null($file["id"])) continue;

                $lthr = $file['max_heart_rate'] * 0.75;
                $percentsHeart = [0.01, 0.79, 0.90, 1.0, 1.05, 100];

                $zones = $percentsHeart;
                if (array_walk($zones, function (&$zones, $key, $lthr) {$zones = $zones * $lthr;}, $lthr))

                $totalZones = count($zones);
                $result             = array_fill(0, $totalZones, 0);
                $zonesTime    = array_fill(0, $totalZones, 0);
                $criteria_sec = 0;
                $criteria_times=0;
                $records = Record::where('file_id', $file["id"])->orderBy('timestamp', 'ASC')->get();

                foreach ( $records as $record_key=> $record ) {

                    if ( $record->speed > config('bike.moving_speed') ) {

                        for( $key = 0; $key < $totalZones; ++$key ) {

                            if( $record->heart_rate <= $zones[$key] ) {

                                $seconds = 0;

                                if ( isset($records[$record_key+ 1])  ) {
                                    $startDate  = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key]->timestamp));
                                    $endDate    = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key+1]->timestamp));
                                    $seconds    = $endDate->diffInSeconds($startDate);
                                }
                                if($key==4){
                                    $criteria_sec += $seconds;
                                    if($criteria_sec/60>=$minutes){
                                        $criteria_times += round(($criteria_sec/60)%$minutes);
                                        if($criteria_times>=$criteria){
                                            return true;
                                        }
                                    }
                                    $criteria_sec = 0;
                                }else{
                                    if($criteria_sec/60>=$minutes){
                                        $criteria_times += round(($criteria_sec/60)%$minutes);
                                        if($criteria_times>=$criteria){
                                            return true;
                                        }
                                    }
                                    $criteria_sec = 0;
                                }

                                $result[$key]   += $seconds;

                                $zonesTime[$key]  += $seconds;


                                goto loop_end;
                            }
                        }
                    }
                    loop_end:
                }
                if($criteria_times>=$criteria){
                    return true;
                }
            }
        }

        return false;

    }

    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGHeartZone5Xtimes($user, $sec, $criteria)
    {
        $query = parent::select(
            'files.id',
            'lap.max_heart_rate'
        )
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->where('lap.max_heart_rate','>',0)
            ->whereRAW('(lap.max_power = 0 OR lap.max_power IS NULL)')
            ->where('rides.user_id',$user->id);

        $files = $query->get()->toArray();
        if(count($files)>0){
            foreach ( $files as $file_key=> $file ) {
                if(is_null($file["id"])) continue;

                $lthr = $file['max_heart_rate'] * 0.75;
                $percentsHeart = [0.5, 0.8, 0.91, 1.01, 1.06, 100];

                $zones = $percentsHeart;
                if (array_walk($zones, function (&$zones, $key, $lthr) {$zones = $zones * $lthr;}, $lthr))

                    $totalZones = count($zones);
                $result             = array_fill(0, $totalZones, 0);
                $zonesTime    = array_fill(0, $totalZones, 0);
                $criteria_sec = 0;
                $criteria_times=0;
                $records = Record::where('file_id', $file["id"])->orderBy('timestamp', 'ASC')->get();

                foreach ( $records as $record_key=> $record ) {

                    if ( $record->speed > config('bike.moving_speed') ) {

                        for( $key = 0; $key < $totalZones; ++$key ) {

                            if( $record->heart_rate <= $zones[$key] ) {

                                $seconds = 0;

                                if ( isset($records[$record_key+ 1])  ) {
                                    $startDate  = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key]->timestamp));
                                    $endDate    = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key+1]->timestamp));
                                    $seconds    = $endDate->diffInSeconds($startDate);
                                }
                                if($key==5){
                                    $criteria_sec += $seconds;
                                    if($criteria_sec>=$sec){
                                        $criteria_times += round(($criteria_sec)%$sec);
                                        if($criteria_times>=$criteria){
                                            return true;
                                        }
                                    }
                                    $criteria_sec = 0;
                                }else{
                                    if($criteria_sec>=$sec){
                                        $criteria_times += round(($criteria_sec)%$sec);
                                        if($criteria_times>=$criteria){
                                            return true;
                                        }
                                    }
                                    $criteria_sec = 0;
                                }

                                $result[$key]   += $seconds;

                                $zonesTime[$key]  += $seconds;


                                goto loop_end;
                            }
                        }
                    }
                    loop_end:
                }
                if($criteria_times>=$criteria){
                    return true;
                }
            }
        }

        return false;
    }
    /**
     * @param $user_id
     * @param $criteria
     * @return mixed
     */

    public static function getAVGHeartZone3Least60min10rides($user_id, $criteria)
    {
        $query = parent::select(
            'files.start',
            DB::raw('ROUND(rides.zone_'.$criteria.'_time/60,0) as totalsec'),
            DB::raw('count(files.start) as count_rides')
        )
        ->leftJoin('files','files.id','=','rides.file_id')
        ->leftJoin('lap','lap.file_id','=','rides.file_id')
        ->where('lap.max_heart_rate','>',0)
        ->whereRAW('(lap.max_power = 0 OR lap.max_power IS NULL)')
        ->whereRAW('rides.zone_3_time/60>=60')
        ->where('rides.user_id',$user_id);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $filter
     * @return mixed
     */
    public static function getRideByUserId($user_id, $ride_id=0)
    {
        if($ride_id==0) return [];

        $query =  parent::select(
            'rides.created_at',
            'lap.moving_time',
            DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed'),
            DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp'),
            DB::RAW('ROUND(lap.total_elapsed_time,0) as time'),
            DB::RAW('ROUND(lap.avg_power,0) as avg_power'),
            DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.file_id',$ride_id)
            ->groupBy('rides.file_id');


        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $zip
     * @return mixed
     */
    public static function getMilesZip($user_id, $zip=0, $miles)
    {
        if($zip==0) return [];

        $query =  parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.postal_code',$zip)
            ->groupBy('rides.postal_code')
            ->having('total_distance','>=',$miles);

        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $country
     * @return mixed
     */
    public static function getMilesHomeCountry($user_id, $country, $miles)
    {

        $query =  parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.country',$country)
            ->groupBy('rides.country')
            ->having('total_distance','>=',$miles);

        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $country
     * @param $miles
     * @return mixed
     */
    public static function getMilesOutHomeCountryMonth($user_id, $country, $miles)
    {
        $query =  parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.country', '!=', $country)
            ->whereRAW('users.country IS NOT NULL')
            ->groupBy('rides.country')
            ->groupBy(DB::raw('MONTH(files.end)'))
            ->having('total_distance','>=',$miles);
        return $query->get()->toArray();

    }

    /**
     * @param $user_id
     * @param $country
     * @return mixed
     */
    public static function getMilesOutsideCountry($user_id, $country, $miles)
    {

        $query =  parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.country', '<>',$country)
            ->groupBy('rides.country')
            ->having('total_distance','>=',$miles);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $country
     * @param $ft
     * @return mixed
     */
    public static function getTotalFtOutsideCountry($user_id, $country, $ft)
    {
        $query =  parent::select(
            DB::RAW('ROUND(SUM(lap.elevation) * 3.2808399,0) as total_ft')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.country', '<>',$country)
            ->groupBy('rides.country')
            ->having('total_ft','>=',$ft);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $country
     * @param $ft
     * @return mixed
     */
    public static function getTotalFtOutsideCountryRide100m($user_id,$country,$ft)
    {
        $query =  parent::select(
            DB::RAW('ROUND(SUM(lap.elevation) * 3.2808399,0) as total_ft'),
            DB::RAW('ROUND(SUM(lap.total_distance) * 0.000621371192,2) as total_distances')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id', $user_id)
            ->where('rides.country', '!=', $country)
            ->whereRAW('users.country IS NOT NULL')
            ->groupBy('rides.country')
            ->having('total_ft','>=', $ft)
            ->having('total_distances', '>=', 100);
        return $query->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $country
     * @param $ft
     * @return mixed
     */

    public static function completeXridersXcountryLeast30min($user_id, $criteria)
    {
        $query =  parent::select(
            DB::RAW('COUNT(DISTINCT rides.country)
AS CountOfcountries')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('lap.total_elapsed_time','>=',1800)
            ->where('rides.user_id', $user_id)
            ->having('CountOfcountries', '>=', $criteria);
        return $query->get()->toArray();
    }


    /**
     * Get Total Elevation
     * @param $user_id
     * @return mixed
     */
    public static function getTotalElevation($user_id)
    {
        return parent::select(
                            DB::RAW('SUM(ROUND((rides.elevation - rides.start_elevation)*3.2808399, 2)) as total_elevation')
                            )
                            ->where('user_id',$user_id)
                            ->first();
    }

    /**
     * Get Elevation By Ride
     * @param $user_id
     * @param $elevation
     * @return mixed
     */
    public static function getTotalElevationByRide($user_id, $elevation)
    {
        return parent::select(
                        DB::RAW('ROUND((rides.elevation - rides.start_elevation)*3.2808399, 2) as total_elevation')
                    )
                    ->where('user_id',$user_id)
                    ->having('total_elevation','>=',$elevation)
                    ->first();

    }


    /**
     * @param $user_id
     * @return mixed
     */
    public static function getTotalXP($user_id)
    {
        return parent::select(
                            DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp')
                        )
                        ->where('user_id',$user_id)
                        ->having('total_xp','>',0)
                        ->first();
    }

    /**
     * @param $user_id
     * @param $xp
     * @return mixed
     */
    public static function haveXP($user_id, $xp)
    {
        return parent::select(
                            DB::RAW('MAX(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp')
                        )
                        ->where('user_id',$user_id)
                        ->having('total_xp','>=',$xp)
                        ->first();
    }

    /**
     * @param $user_id
     * @param $xp
     * @return mixed
     */
    public static function haveMonthXP($user_id, $xp)
    {
        return parent::select(
            DB::RAW('SUM((zone_1 + zone_2 + zone_3 + zone_4 + zone_5)) as total_xp')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->groupBy(DB::RAW('MONTH(files.start)'))
            ->having('total_xp','>=',$xp)
            ->get()->toArray();
    }

    /**
     * @param $user_id
     * @param $ride_id
     * @return mixed
     */
    public static function getTotalRideXP($user_id,$ride_id)
    {
        return parent::select(
                            DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp')
                        )
                        ->where('user_id',$user_id)
                        ->where('file_id',$ride_id)
                        ->first();
    }

    /**
     * @param $user_id
     * @param $ride_id
     * @return mixed
     */
    public static function getAvgSpeed($user_id,$ride_id)
    {
        return parent::select(
            DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('files','files.id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->where('rides.user_id',$user_id)
            ->where('rides.file_id',$ride_id)
            ->first();
    }



}