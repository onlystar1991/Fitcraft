<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\BikeCraft\Data;
use App\BikeCraft\UserXP;

class Lap extends Model {

	protected $table = 'lap';

    /**
     * @param $fields
     * @return Files
     */
    public static function add($fields)
    {
        $model = new Lap();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }
    /**
     * @param $wherephp artisan ide-helper:models
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
                        ->get();
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFirst($where)
    {
        return parent::where($where)
                        ->first();
    }

    public function getActivity($user,$page = 0)
    {
        $limit = 20;
        $page = $page*$limit;
        $result = self::getByQuery()
            ->where('lap.user_id',$user->id)
            ->orderBy('lap.updated_at', 'desc')
            ->skip($page)
            ->take($limit)->get();

        //Efford
        $userXP = new UserXP(new Levels());
        $userXP->calculateFTP($user);
        $ftp = $userXP->getFtp();

        //Achievements
        $achievements_table = new AchievementsUsers();


        foreach ($result as $num=>$lap) {
            $result[$num] = [
                'time'          => timeRide($lap->moving_time),
                'distance'      => $lap->distance,
                'avg_speed'     => $lap->avg_speed,
                'avg_effort'    => round($lap->avg_power / $ftp * 100),
                'avg_power'     => $lap->avg_power,
                'elevation'     => $lap->elevation,
                'calories'      => $lap->total_calories,
                'bonus_rolls'   => BonusXP::where('ride_id',$lap->ride_id)->count(),
                'xp'            => round($lap->total_xp),
                'achievements'  => $achievements_table->getByFile($lap->file_id)
            ];
        }

        return $result;
    }

    public static function getStatistics($user_id,$days,$ftp)
    {
        $query =  parent::select('lap.user_id',
                    DB::RAW('ROUND(SUM(lap.total_elapsed_time),0) as time'),
                    DB::RAW('ROUND((SUM(lap.total_elapsed_time))/COUNT(*),2) as avg_time_per_ride'),
                    DB::RAW('ROUND(MAX(lap.max_speed*2.2369362920544), 2) as top_speed'),
                    DB::RAW('ROUND( ((SUM(lap.avg_speed) * 2.2369362920544)/COUNT(*)),2) as avg_speed'),
                    DB::RAW('ROUND((SUM(lap.total_distance)/COUNT(*))* 0.000621371192, 2) as avg_dist_per_ride'),
                    DB::RAW('ROUND(SUM(lap.avg_cadence)/COUNT(*),2) as avg_cadence'),
                    DB::RAW('ROUND(SUM(lap.avg_heart_rate)/COUNT(*),2) as avg_heart_rate'),
                    DB::RAW('SUM(lap.total_calories) as calories_burned'),
                    DB::RAW('ROUND(SUM(lap.total_calories)/COUNT(*),0) as avg_calories_per_ride'),
                    DB::RAW("(SUM(lap.avg_power)/COUNT(*)) as avg_effort"),
                    DB::RAW("COUNT(files.id) as total_rides")
                    )->where('lap.user_id',$user_id)
                    ->leftJoin('files','files.id','=','lap.file_id');
                    if(is_numeric($days)) {
                        if($days == 1) {
                            $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(files.start,'%Y-%m-%d')) = 0");
                        } elseif($days == 365) {
                            $query->leftJoin('users','users.id','=','lap.user_id')
                                    ->whereRAW(" files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY) ");
                        } else {
                            $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(files.start,'%Y-%m-%d')) <= $days");
                        }
                    }

        $statistics1  = $query->get()->first()->toArray();
        if($statistics1['user_id']) {
            $statistics1['time']              = timeStatistic($statistics1['time']);
            $statistics1['top_speed']         = $statistics1['top_speed'].' MPH';
            $statistics1['avg_speed']         = $statistics1['avg_speed'].' MPH';
            $statistics1['avg_effort']        = round($statistics1['avg_effort']/$ftp * 100).' %';
            // $statistics1['avg_effort']        = floor($statistics1['avg_effort']/$ftp * 100).' %';
            $statistics1['avg_time_per_ride'] = timeStatistic($statistics1['avg_time_per_ride']);
            $statistics1['days_ridden']       = self::getDaysRidden($user_id,$days);
            $statistics2                      = self::getStatisticsRight($user_id,(int)$days);
            return array_merge($statistics1,$statistics2);
        } else {
            $statistics = [
                'power'                 => 0,
                'power_percent'         => 0,
                'speed'                 => 0,
                'speed_percent'         => 0,
                'stamina'               => 0,
                'stamina_percent'       => 0,
                'tenacity'              => 0,
                'tenacity_percent'      => 0,
                'distance'              => 0,
                'distance_percent'      => 0,
                'time_percent'          => 0,
                'time'                  => 0,
                'avg_time_per_ride'     => 0,
                'top_speed'             => 0,
                'avg_speed'             => 0,
                'avg_dist_per_ride'     => 0,
                'peak_power'            => 0,
                'avg_power'             => 0,
                'avg_cadence'           => 0,
                'avg_heart_rate'        => 0,
                'calories_burned'       => 0,
                'avg_calories_per_ride' => 0,
                'avg_effort'            => 0,
                'days_ridden'           => 0,
                'total_rides'           => 0,
                'elev_gained'           => 0,
                'largest_climb'         => 0,
            ];
            return $statistics;
        }
    }
    public static function getStatisticsRight($user_id,$days)
    {
        if(!is_numeric($days)) {
            $days = '';
        }
        $power    = DB::select('CALL getRightStatisticUser(?,?,?)',[$user_id,$days,'power']);
        $speed    = DB::select('CALL getRightStatisticUser(?,?,?)',[$user_id,$days,'speed']);
        $distance  = DB::select('CALL getRightStatisticUser(?,?,?)',[$user_id,$days,'distance']);
        $time = DB::select('CALL getRightStatisticUser(?,?,?)',[$user_id,$days,'times']);

        if($power) {
            $statistics = [
                'distance'              => $distance[0]->distance,
                'distance_percent'      => $distance[0]->distance_percent,

                'times'                 => $time[0]->times,
                'time_percent'          => $time[0]->time_percent,

                'power'                 => number_format($power[0]->power,0).' W',
                'peak_power'            => number_format($power[0]->peak_power,0).' W',
                'power_percent'         => $power[0]->power_percent,

                'speed'                 => $speed[0]->speed,
                'speed_percent'         => $speed[0]->speed_percent,

                'elev_gained'           => round($power[0]->elev_gained*3.2808399,2),
                'largest_climb'         => round($power[0]->largest_climb*3.2808399,2)
            ];

        } else {
            $statistics = [
                'distance'              => 0,
                'distance_percent'      => 0,
                'times'                 => 0,
                'time_percent'          => 0,
                'power'                 => 0,
                'peak_power'            => 0,
                'power_percent'         => 0,
                'speed'                 => 0,
                'speed_percent'         => 0,
                'elev_gained'           => 0,
                'largest_climb'         => 0
            ];            
        }
           
        return $statistics;
    }



    /**
     * Get Days Ridden
     * @param $user_id
     * @return mixed
     */
    public static function getDaysRidden($user_id,$days)
    {
        $query = parent::select("files.id") 
                            ->leftJoin('files','files.id','=','lap.file_id')                          
                            ->leftJoin('users','users.id','=','lap.user_id')
                            ->where('lap.user_id',$user_id)
                            ->where('files.completed_all','Y');
                            if(is_numeric($days)) {
                                if($days == 1) {
                                    $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(lap.created_at,'%Y-%m-%d')) = 0");
                                } elseif($days == 365) {
                                    $query->whereRAW(" files.start <= DATE_ADD(users.season_start, INTERVAL 365 DAY) ");
                                } else {
                                    $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(files.start,'%Y-%m-%d')) <= $days");
                                }
                            }                            
                            $query->groupBy(DB::raw("DATE_FORMAT(files.start,'%Y-%m-%d')"));

        return $query->get()->count();
    }     


    public static function search($array,$val){
        $i=0;
        do
        if($array[$i]['avg'] == $val)
            return $i;
        while(++$i<count($array));
    }
    /**
     * @param get Rankings
     * @return mixed
     */
    public static function getRankings($filter,$user)
    {
        $query =  parent::addSelect(
                    'users.id',
                    'users.nickname as name',
                    'users.level',
                    'race_categories.nr as category',
                    'cards.icon as path'
                );
                // AVG MAX
                // power WATTS
                // speed Mile
                // time on db second , on front H:i
                $criteria = '';
                $with      = $filter->get('avg_max_with');
                if ($filter->get('avg_max')) {
                    $avg_max    = $filter->get('avg_max');
                    //AVG
                    if($avg_max=='avg') {
                        switch ($with) {
                            case 'power':
                                $query->addSelect(
                                         DB::RAW('
                                            ROUND(
                                                (SUM(
                                                    lap.avg_power
                                                )/count(lap.id))
                                                ,2
                                            ) 
                                            as avg                                     
                                        ')
                                );
                                $criteria = ' W';
                                break;
                            case'speed':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND( (SUM(avg_'.$with.')/count(*)) * 2.2369362920544 ,2)  as avg
                                        ')
                                );
                                $criteria = ' MPH';
                                break;
                           case'cadence':case'heart_rate':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND(SUM(avg_'.$with.')/count(*),0)  as avg
                                        ')
                                );
                                if($with == 'cadence') {
                                    $criteria = ' RPM';
                                } else {
                                    $criteria = ' BPM';
                                }
                                break;
                            case 'time':
                                $query->addSelect(
                                         DB::RAW('
                                          SUM(moving_time)/count(*)  as avg
                                        ')
                                );
                                break;
                            case 'distance':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND( (SUM(total_'.$with.') * 0.000621371192 /count(*) ) ,2)  as avg
                                        ')
                                );
                                $criteria = ' MI';
                                break;
                            case 'calories':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND(SUM(total_'.$with.')/count(*),0)  as avg
                                        ')
                                );
                                $criteria = ' CAL';
                                break;
                        }
                    }
                    //MAX maby rong  need max nod sum
                    elseif($avg_max=='max') {
                        switch ($with) {
                            case 'power':
                                $query->addSelect(
                                         DB::RAW('
                                            ROUND(
                                                (MAX(
                                                    lap.max_power 
                                                ))
                                                ,2
                                            ) 
                                            as avg 
                                        ')
                                );
                                $criteria = ' W';
                                break;
                            case'speed':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND( (MAX(max_'.$with.')) * 2.2369362920544 ,2)  as avg
                                        ')
                                );
                                $criteria = ' MPH';
                                break;
                            case'cadence':case'heart_rate':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND(MAX(max_'.$with.'),0)  as avg
                                        ')
                                );
                                if($with == 'candence') {
                                    $criteria = ' RPM';
                                } else {
                                    $criteria = ' BPM';
                                }
                                break;
                            case 'time':
                                $query->addSelect(
                                         DB::RAW('
                                         MAX(moving_time)  as avg
                                        ')
                                );
                                break;
                            case 'distance':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND(MAX(total_'.$with.'* 0.000621371192),2)  as avg
                                        ')
                                );
                                 $criteria = ' MI';
                                break;
                            case 'calories':
                                $query->addSelect(
                                         DB::RAW('
                                         ROUND(MAX(total_'.$with.'),0)  as avg
                                        ')
                                );
                                 $criteria = ' CAL';
                                break;
                        }
                    }
                    // TOTAL
                    else {
                        switch ($with) {
                            case 'power':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND( SUM(max_'.$with.'),2)  as avg
                                        ')
                                );                                
                                $criteria = ' W';
                                break;

                            case'speed':
                                $query->addSelect(
                                         DB::RAW('
                                          ROUND( SUM(max_'.$with.') * 2.2369362920544 ,2)  as avg
                                        ')
                                );
                                $criteria = ' MPH';
                                break;

                            case'cadence':case'heart_rate':
                                $query->addSelect(
                                         DB::RAW('
                                         ROUND(SUM(max_'.$with.'),0)  as avg
                                        ')
                                );
                                if($with == 'candence') {
                                    $criteria = ' RPM';
                                } else {
                                    $criteria = ' BPM';
                                }
                                break;

                            case 'time':
                                $query->addSelect(
                                         DB::RAW('
                                         ROUND(SUM(lap.total_elapsed_time),2)  as avg
                                        ')
                                );
                                break;
                            case 'distance':
                                $query->addSelect(
                                         DB::RAW('
                                         ROUND(SUM(total_'.$with.')*0.000621371192,2)  as avg
                                        ')
                                );
                                $criteria = ' MI';
                                break;
                            case 'calories':
                                $query->addSelect(
                                         DB::RAW('
                                         ROUND(SUM(total_'.$with.'),0)  as avg
                                        ')
                                );
                                $criteria = ' CAL';
                                break;
                        }
                    }
                }


                $query->leftJoin('users','users.id','=','lap.user_id')
                        ->leftJoin('cards','cards.id','=','users.cards_id')
                         ->leftJoin('race_categories','race_categories.id','=','users.category_id')
                          ->leftJoin('files','files.id','=','lap.file_id');
                if ($name = $filter->get('name')) {
                    $query->where('users.nickname','like',$name.'%');
                }

                // LAST 30 DAYS
                $days = $filter->get('days');
                if ($days && is_numeric($days)) {

                    if($days == 1) {
                        $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(files.start,'%Y-%m-%d')) = 0");
                    } else {
                        $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(files.start,'%Y-%m-%d')) <= $days");
                    }
                }
                // GENDER
                if ($filter->get('gender')) {
                    $query->where("users.gender",$filter->get('gender'));
                }
                // CATEGORY
                if ($filter->get('cat')) {
                     if($filter->get('cat') == 'no_cat') {
                        $query->where("users.category_id",0);
                     } else {
                        $query->where("users.category_id",$filter->get('cat'));
                     }
                }
                // ZIPCODE
                if ($filter->get('zip')) {
                    if($filter->get('zip')=='zip') {
                        $query->where("users.zip",$user->zip);
                    }
                }
                // AGE
                if ($filter->get('age')) {
                    $age = $filter->get('age');
                    switch ($age) {
                        case '1':
                            $query->where("users.age",$user->age);
                            break;
                        case '2':
                            $query->where("users.age",'<=',15);
                            break;
                        case '14':
                            $query->where("users.age",'>=',70);
                            break;
                        default:
                            $age_interval =explode('-',$age);
                            if(isset($age_interval[0]) &&is_numeric($age_interval[0])) $query->where("users.age",'>=',$age_interval[0]);
                            if(isset($age_interval[1]) && is_numeric($age_interval[1])) $query->where("users.age",'<=',$age_interval[1]);
                            break;
                    }
                }
                // HEIGHT
                if ($filter->get('height')) {
                    $height = $filter->get('height');
                    switch ($height) {
                        case '1':
                            $query->where("users.height_ft",$user->height_ft);
                            break;
                        case '2':
                            $query->where("users.height_ft",'<=',4);
                            break;
                        case '3':
                            $query->where("users.height_ft",'=',4);
                            $query->where("users.height_inc",'>=',1);
                            $query->where("users.height_inc",'<=',6);
                            break;
                        case '4':
                            $query->where("users.height_ft",'=',4);
                            $query->where("users.height_inc",'>=',7);
                            $query->where("users.height_inc",'<=',11);
                            break;
                        case '5':
                            $query->where("users.height_ft",'=',5);
                            $query->where("users.height_inc",'>=',0);
                            $query->where("users.height_inc",'<=',3);
                            break;
                        case '6':
                            $query->where("users.height_ft",'=',5);
                            $query->where("users.height_inc",'>=',4);
                            $query->where("users.height_inc",'<=',7);
                            break;
                        case '7':
                            $query->where("users.height_ft",'=',5);
                            $query->where("users.height_inc",'>=',8);
                            $query->where("users.height_inc",'<=',11);
                            break;
                        case '8':
                            $query->where("users.height_ft",'=',6);
                            $query->where("users.height_inc",'>=',0);
                            $query->where("users.height_inc",'<=',3);
                            break;
                        case '9':
                            $query->where("users.height_ft",'=',6);
                            $query->where("users.height_inc",'>=',4);
                            $query->where("users.height_inc",'<=',7);
                            break;
                        case '10':
                            $query->where("users.height_ft",'=',6);
                            $query->where("users.height_inc",'>=',8);
                            $query->where("users.height_ft",'<=',7);
                            break;
                        case '11':
                            $query->where("users.height_ft",'>=',7);
                            break;
                    }
                }

                // WEIGHT
                if ($filter->get('weight')) {
                    $weight = $filter->get('weight');
                    switch ($weight) {
                        case '1':
                            $query->where("users.weight",$user->weight);
                            break;
                        case '2':
                            $query->where("users.weight",'<=',100);
                            break;
                        case '3':
                            $query->where("users.weight",'>=',250);
                            break;
                        default:
                            $weight_interval =explode('-',$weight);
                            if(isset($weight_interval[0]) &&is_numeric($weight_interval[0])) $query->where("users.weight",'>=',$weight_interval[0]);
                            if(isset($weight_interval[1]) && is_numeric($weight_interval[1])) $query->where("users.weight",'<=',$weight_interval[1]);
                            break;
                    }
                }
                // LEVEL
                if ($filter->get('level')) {
                    $level_interval = explode('-',$filter->get('level'));
                    if(isset($level_interval[0]) &&is_numeric($level_interval[0])) $query->where("users.level",'>=',$level_interval[0]);
                    if(isset($level_interval[1]) && is_numeric($level_interval[1])) $query->where("users.level",'<=',$level_interval[1]);
                }
                $query->where("users.id",'>',0);
                $query->orderBy('avg','desc')
                      ->groupBy('lap.user_id')->get();

                if($query) {
                    $result            =  $query->get()->toArray();

                    $rank = 1;
                    $result_reverse = array_reverse($result);

                    $N = count($result);

                    foreach ($result as $key => $value) {
                        $r = 0;
                        foreach ($result as $key_r=>$value_r) {
                            if((float)$value_r['avg'] == (float)$value['avg']) {
                               $r++;
                                if(empty($result[$key_r]['rank'])){
                                    $result[$key_r]['rank'] = $rank;
                                }
                            }
                        }

                        $result[$key]['count'] = $r;

                        /////////////////////////
                        $psst                       = self::getStatisticsRight($value['id'],$days);

                        $result[$key]['power']      = $psst['power_percent'];
                        $result[$key]['speed']      = $psst['speed_percent'];
                        $result[$key]['distance']   = $psst['distance_percent'];
                        $result[$key]['times']      = $psst['time_percent'];


                        /* calc percentile */

                        $E = $r;//количество одинаковых
                        $B = 0;

                        ///////////////
                        $B = self::search($result_reverse,$result[$key]['avg']);
                        //////////////

                        $percentile =(($B+(0.5*$E))/$N)*100;

                        $result[$key]['percentile'] = round($percentile);//.'th';
                        /* end calc percentile */

                        if($with=='time') {
                            // $result[$key]['criteria']   = date('H:i',Data::timeToUnix($value['avg']));
                            $result[$key]['criteria']   = timeRide($value['avg'],'no_hours');
                        } else {
                            $result[$key]['criteria']  = $value['avg'].$criteria;
                        }

                        // set default picture
                        if($value['path']) {
                            $result[$key]['path'] = iconPath($value['path']);
                        } else {
                            $result[$key]['path'] = '/assets/img/user_1.png';
                        }
                        $result[$key]['awards'] = Awards::getTopUserAwards($value['id']);
                        ////////////////////////

                        if(!empty($result[$key+1])){
                            if(empty($result[$key+1]['rank'])){
                                $rank++;
                            }
                        }

                    }

                    return $result;
                }

    }

    public static function getPercentile($value, $result,$days){
        $rank = 1;
        $result_reverse = array_reverse($result);

        $N = count($result);

        foreach ($result as $key => $value) {
            $r = 0;
            /////////////////////////
            $psst                       = self::getStatisticsRight($value['id'],$days);

            $result[$key]['power']      = $psst['power_percent'];
            $result[$key]['speed']      = $psst['speed_percent'];
            $result[$key]['distance']   = $psst['distance_percent'];
            $result[$key]['times']       = $psst['time_percent'];

            foreach ($result as $key_r=>$value_r) {
                if((float)$value_r['avg'] == (float)$value['avg']) {
                    $r++;
                    if(empty($result[$key_r]['rank'])){
                        $result[$key_r]['rank'] = $rank;
                    }
                }
            }

            $result[$key]['count'] = $r;




            /* calc percentile */

            $E = $r;//количество одинаковых
            $B = 0;

            ///////////////
            $B = self::search($result_reverse,$result[$key]['avg']);
            //////////////

            $percentile =(($B+(0.5*$E))/$N)*100;

            $result[$key]['percentile'] = round($percentile);//.'th';

            if(!empty($result[$key+1])){
                if(empty($result[$key+1]['rank'])){
                    $rank++;
                }
            }

        }
        return $result;
    }
    /**
     * @param POWER,SPEED,STAMINA,TENACITY
     * @return mixed
     */
    public static function getPSST($user_id,$days = null)
    {
        $list = '';
        $query = parent::select(
            DB::RAW('0  as power
                    ,COALESCE(ROUND((ROUND(SUM(avg_speed) * 2.2369362920544,2)/count(*)),0),0)  as speed
                    ,COALESCE(ROUND((ROUND(SUM(total_distance) * 0.000621371192,2)/count(*)),0),0)  as stamina
                    ,COALESCE(ROUND((SUM(moving_time))/COUNT(*),0),0)  as tenacity
                    ')
        );
        if(is_numeric($days)) {
            if($days == 1) {
                $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(created_at,'%Y-%m-%d')) = 0 ");
            } else {
                $query->whereRAW("DATEDIFF('".date('Y-m-d')."',DATE_FORMAT(created_at,'%Y-%m-%d')) <= $days");
            }
        }

        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }

    }

    /**
     * CLIMB A TOTAL OF X FT IN ELEVATION
     * @param $user_id
     * @return mixed | in ft
     */
    public static function getSumElevation($user_id)
    {
        return parent::select(
                        DB::RAW('ROUND(SUM(lap.elevation) * 3.2808399,0) as elevation')
                        )
                        ->where('user_id',$user_id)->first();
    }

    /**
     * CLIMB A TOTAL OF X FT IN ELEVATION
     * @param $user_id
     * @return mixed | in ft
     */
    public static function getMaxElevationByRide($user_id)
    {
        return parent::select(
                        DB::RAW('ROUND(MAX(lap.elevation) * 3.2808399,0) as elevation')
                        )
                        ->where('user_id',$user_id)->first();
    }

    /**
     * CLIMB A TOTAL OF X FT IN ELEVATION
     * @param $user_id
     * @return mixed | in ft
     */
    public static function getMaxElevationByMonth($user_id, $criteria)
    {

        $query = parent::select(
            DB::RAW('SUM(ROUND(lap.elevation * 3.2808399,2)) as total_ft')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->orderBy('total_ft','DESC')
            ->groupBy(DB::raw('MONTH(files.start)'))
            ->having('total_ft','>=',$criteria);

        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }
    }

    /**
     * CLIMB 30,000 FT DURING THE MONTH OF X MONTH
     * @param $user_id
     * @return mixed | in ft
     */
    public static function getMaxElevationByXMonth($user_id, $criteria)
    {

        $query = parent::select(
            DB::RAW('SUM(ROUND(lap.elevation * 3.2808399,2)) as total_ft')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=$criteria")
            ->groupBy(DB::raw('YEAR(files.start)'))
            ->orderBy('total_ft','DESC')
            ->having('total_ft','>=',30000);

        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }
    }

    /**
     * RIDE X MILES DURING THE MONTH X
     * @param $user_id
     * @return mixed | in ft
     */
    public static function milesDuringInMayMonth($user_id, $criteria)
    {

        $query = parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=5")
            ->groupBy(DB::raw('MONTH(files.end)'))
            ->orderBy('total_miles','DESC')
            ->having('total_miles','>=',$criteria);
        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }
    }

    /**
     * RIDE X MILES DURING THE MONTH X
     * @param $user_id
     * @return mixed | in ft
     */
    public static function milesDuringInJulyMonth($user_id, $criteria)
    {

        $query = parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=7")
            ->groupBy(DB::raw('MONTH(files.end)'))
            ->orderBy('total_miles','DESC')
            ->having('total_miles','>=',$criteria);
        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }
    }

    /**
     * RIDE X MILES DURING THE MONTH X
     * @param $user_id
     * @return mixed | in ft
     */
    public static function milesDuringInSeptemberMonth($user_id, $criteria)
    {

        $query = parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_miles')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=9")
            ->groupBy(DB::raw('MONTH(files.end)'))
            ->orderBy('total_miles','DESC')
            ->having('total_miles','>=',$criteria);
        if(!is_null($query->first()))
            return $query->first()->toArray();
        else{
            return [];
        }
    }
    /**
     * Get total distance
     * @param $user_id
     * @return mixed | in miles
     */
    public static function getSumDistance($user_id)
    {
        return parent::select(
                        DB::RAW(' ROUND(SUM(total_distance)* 0.000621371192, 2) as total_distance  ')
                        )
                        ->where('user_id',$user_id)->first();
    }

    /**
     * Get Max Distance
     * @param $user_id
     * @return mixed  | in miles
     */
    public static function getMaxDistance($user_id)
    {
        return parent::select(
                        DB::RAW(' ROUND(MAX(total_distance)* 0.000621371192, 2) as total_distance ')
                        )
                        ->where('user_id',$user_id)
                        ->first();
    }

    /**
     * Get Max Distance by Week
     * @param $user_id
     * @return mixed
     */
    public static function getMaxDistanceWeekend($user_id)
    {
        return DB::select(
            "SELECT MAX(max_distance) as total_distance
            FROM (
                SELECT
		          MAX(total_distance) as max_distance
		        FROM
		          lap
		        WHERE user_id = ?
		        GROUP BY
    	        WEEK(created_at)
    	    ) as subquery
            ",[$user_id]
        );
    }

    /**
     * Get total Distance by Week
     * @param $user_id
     * @return mixed
     */
    public static function getTotalDistanceWeek($user_id)
    {
        parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->groupBy(DB::raw('WEEK(files.end)'))
            ->orderBy('total_distance','DESC')
            ->get()->toArray();
    }

    /**
     * Get total Distance by MONTH
     * @param $user_id
     * @return mixed
     */
    public static function getTotalDistanceMonth($user_id)
    {
        return parent::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->groupBy(DB::raw('MONTH(files.end)'))
            ->orderBy('total_distance','DESC')
            ->get()->toArray();
    }

    /**
     * Get Max Distance Twice in week
     * @param $user_id
     * @return mixed
     */
    public static function getMaxDistanceTwiceInWeekend($user_id, $miles)
    {
        return parent::select(
                DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance'),
                DB::RAW('count(files.id) as total_files')
            )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW('DAYOFWEEK(files.start) IN (1,7)')
            ->whereRAW('ROUND(lap.total_distance*0.000621371192,2) >= ?',[$miles])
            ->groupBy(DB::raw('DAYOFWEEK(files.start)'))
            ->having('total_files','>=',2)
            ->get()->toArray();

    }

    /**
     * Get Max Distance by Week
     * @param $user_id
     * @return mixed
     */
    public static function getMaxDistanceMonth($user_id)
    {
        return DB::select(
            "SELECT MAX(max_distance) as total_distance
            FROM (
                SELECT
		          MAX(total_distance) as max_distance
		        FROM
		          lap
		        WHERE user_id = ?
		        GROUP BY
    	        MONTH(created_at)
    	    ) as subquery
            ",[$user_id]
        );
    }

    /**
     * Criteria
     * RIDE AN AVG SPEED OF X MPH OR HIGHER ON A RIDE OF 30 MIN OR MORE
     *
     * @param $user_id
     * @param $speed
     * @return mixed
     */
    public static function getAvgSpeed30Min($user_id, $speed)
    {
        parent::where('total_elapsed_time','>=',1800)
                        ->whereRAW('ROUND(lap.avg_speed * 2.23693629205442920544,2) >= ?',[$speed])
                        ->where('user_id',$user_id)
                        ->first();
    }


    /**
     * Get total hours
     *
     * @param $user_id
     * @param $hours
     * @return mixed
     */
    public static function getTotalHours($user_id, $hours)
    {
        return parent::havingRAW(" (SUM(lap.total_elapsed_time) / 3600) >= ? ",[$hours])
                       ->where("user_id",$user_id)
                       ->first();
    }

    //RIDE FOR AT LEAST X MINUTES IN A SINGLE RIDE
    public static function getMinutesSingleRide($user_id, $minutes)
    {
        $query = parent::select(
            DB::RAW('(total_elapsed_time / 60) as total_minutes')
        )
        ->whereRAW('(total_elapsed_time / 60)  >= ?', [$minutes])
                        ->where('user_id',$user_id);
        return $query->first();
    }

    //RIDE 50 HOURS OR MORE DURING THE MONTH OF X
    public static function getHoursDuringMonthX($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('SUM(ROUND(lap.total_elapsed_time/3600,2)) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=$criteria")
            ->orderBy('total_hours','DESC')
            ->groupBy('files.user_id')
            ->having('total_hours','>=',50);
            return $query->first();
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 3RD WEEK OF MARCH
    public static function getHours3rdWeekMarch($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_elapsed_time/3600,2) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=3")
            ->whereRAW("ROUND(lap.total_elapsed_time/3600,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=3")
            ->orderBy('total_hours','DESC');
        return $query->first();
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 3RD WEEK OF MARCH
    public static function getMiles3rdWeekMarch($user_id, $criteria)
    {
        $query = Lap::select(
             DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=3")
            ->whereRAW("ROUND(lap.total_distance*0.000621371192,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=3")
            ->orderBy('total_distance','DESC');
        return $query->first();
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 1ST WEEK OF APRIL
    public static function getHours1stWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_elapsed_time/3600,2) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_elapsed_time/3600,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=1")
            ->orderBy('total_hours','DESC');

        return $query->first();
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 1ST WEEK OF APRIL
    public static function getMiles1stWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_distance*0.000621371192,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=1")
            ->orderBy('total_distance','DESC');

        return $query->first();
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 2ND WEEK OF APRIL
    public static function getHours2ndWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_elapsed_time/3600,2) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_elapsed_time/3600,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2")
            ->orderBy('total_hours','DESC');
        return $query->first();
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 2ND WEEK OF APRIL
    public static function getMiles2ndWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_distance*0.000621371192,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2")
            ->orderBy('total_distance','DESC');

        return $query->first();
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF APRIL
    public static function getHours4thWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_elapsed_time/3600,2) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_elapsed_time/3600,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4")
            ->orderBy('total_hours','DESC');
        return $query->first();
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF APRIL
    public static function getMiles4thWeekApril($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=4")
            ->whereRAW("ROUND(lap.total_distance*0.000621371192,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4")
            ->orderBy('total_distance','DESC');

        return $query->first();
    }

    //COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF SEPTEMBER
    public static function getHours4thWeekSeptember($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_elapsed_time/3600,2) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=9")
            ->whereRAW("ROUND(lap.total_elapsed_time/3600,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4")
            ->orderBy('total_hours','DESC');
        return $query->first();
    }

    //COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF SEPTEMBER
    public static function getMiles4thWeekSeptember($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=9")
            ->whereRAW("ROUND(lap.total_distance*0.000621371192,2)>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=4")
            ->orderBy('total_distance','DESC');

        return $query->first();
    }

    //RIDE X HOURS DURING THE 2ND WEEK OF JUNE
    public static function getHoursDuring2ndWeekOfJune($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('SUM(lap.total_elapsed_time/3600) as total_hours')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=6")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2")
            ->orderBy('total_hours','DESC');
        return $query->first();
    }

    //RIDE X MILES DURING THE 2ND WEEK OF JUNE
    public static function getMilesDuring2ndWeekOfJune($user_id, $criteria)
    {
        $query = Lap::select(
            DB::RAW('SUM(ROUND(lap.total_distance*0.000621371192,2)) as total_distance')
        )
            ->leftJoin('files','files.id','=','lap.file_id')
            ->where('files.user_id',$user_id)
            ->whereRAW("MONTH(files.end)=6")
//            ->whereRAW("SUM(ROUND(lap.total_distance*0.000621371192,2))>=$criteria")
            ->whereRAW("WEEK(files.end,5) - WEEK(DATE_SUB(files.end, INTERVAL DAYOFMONTH(files.end)-1 DAY),5)+1=2")
            ->orderBy('total_distance','DESC');
        return $query->first();
    }

    /**
     * @param $user_id
     * @param $hours
     * @return mixed
     */
    public static function getHoursByWeekend($user_id, $hours)
    {
        return parent::leftJoin('files','files.id','=','lap.file_id')
                        ->where('files.user_id',$user_id)
                        ->whereRAW('DAYOFWEEK(files.start) IN (1,7)')
                        ->whereRAW('lap.total_elapsed_time / 3600 >= ?',[$hours])
                        ->first();
    }

    /**
     * @param $user_id
     * @param $hours
     * @return mixed
     */
    public static function getHoursTwiceByWeekend($user_id, $hours)
    {
        return parent::select(
                DB::RAW('count(files.id) as total_files')
            )
            ->leftJoin('files','files.id','=','lap.file_id')
                        ->where('files.user_id',$user_id)
                        ->whereRAW('DAYOFWEEK(files.start) IN (1,7)')
                        ->whereRAW('lap.total_elapsed_time / 3600 >= ?',[$hours])
                        ->groupBy(DB::raw('DAYOFWEEK(files.start)'))
                        ->having('total_files','>=',2)
                        ->get()->toArray();

    }


    /**
     * @param $user_id
     * @param $power
     * @return mixed
     */
    public static function getAvgPowerPowerZone($user_id, $power)
    {
        return parent::where('user_id',$user_id)
                    ->whereRAW('total_elapsed_time /60  >=30')
                    ->where('avg_power','>=',$power)
                   ->first();


    }


    /**
     * @param $user_id
     * @param $power
     * @return mixed
     */
    public static function getAvgWatts30minRide($user_id, $power)
    {
        $query =  Rides::select(
            DB::RAW('ROUND(MAX(lap.avg_power),1) as avg_power')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->whereRAW('total_elapsed_time /60  >=30')
            ->where('rides.user_id',$user_id)
            ->whereRAW("ROUND(lap.avg_power,1) >= $power");

        return $query->first();
    }

    /**
     * @param $user_id
     * @param $power
     * @return mixed
     */
    public static function getAvgWatts60minRide($user_id, $power)
    {
        $query =  Rides::select(
            DB::RAW('ROUND(MAX(lap.avg_power),1) as avg_power')
        )
            ->leftJoin('lap','lap.file_id','=','rides.file_id')
            ->leftJoin('users','users.id','=','lap.user_id')
            ->whereRAW('total_elapsed_time /60  >=60')
            ->where('rides.user_id',$user_id)
            ->whereRAW("ROUND(lap.avg_power,1) >= $power");

        return $query->first();
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getByFileId($file_id)
    {
        return self::getByQuery()
            ->where('lap.file_id',$file_id)
            ->first();
    }

    public static function getByQuery()
    {
        return parent::select(
            'rides.id as ride_id',
            DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed'),
            DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp'),
            'lap.avg_power',
            'lap.total_calories',
            'lap.total_elapsed_time',
            'lap.moving_time',
            'lap.start_time',
            'lap.file_id',
            'lap.created_at',
            DB::RAW('ROUND(lap.total_distance*0.000621371192,0) as distance'),
            DB::RAW('ROUND(lap.elevation * 3.2808399,0) as elevation')
        )->leftJoin('rides','rides.file_id','=','lap.file_id');
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getAvgLap($file_id)
    {
        return parent::select(
            DB::RAW('SUM(total_elapsed_time) as total_elapsed_time'),
            DB::RAW('SUM(total_timer_time) as total_timer_time'),
            DB::RAW('SUM(total_distance) as total_distance'),
            DB::RAW('SUM(total_cycles) as total_cycles'),
            DB::RAW('SUM(total_calories) as total_calories'),
            DB::RAW('AVG(avg_speed) as avg_speed'),
            DB::RAW('AVG(max_speed) as max_speed'),
            DB::RAW('AVG(avg_heart_rate) as avg_heart_rate'),
            DB::RAW('AVG(max_heart_rate) as max_heart_rate')
            )
            ->where('file_id',$file_id)
            ->first();


    }




}
