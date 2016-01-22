<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UsersCards;
use App\Models\Rides;
use App\BikeCraft\UserXP;
use Illuminate\Support\Facades\DB;

/**
 * Class ActivityFeed
 * @package App\Models
 */
class ActivityFeed extends Model
{

    /**
     * @var string
     */
    protected $table = 'activity_feed';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'file_id', 'type', 'icon', 'earned', 'name'];


    /**
     * @param $where
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
            ->get();
    }

    public static function getUserFeed($user_id, $file_id = 0)
    {
        $feed = ActivityFeed::where('user_id', '=', $user_id)->orderBy('created_at','desc');
        if ($file_id) {
            $feed->where('file_id', '=', $file_id);
        }
        $user = User::find($user_id);
        //Efford
        $userXP = new UserXP(new Levels());
        $userXP->calculateFTP($user);
        $ftp = $userXP->getFtp();

        $cardicon = UsersCards::getCardsIcon2($user->cards_id);
        $feed = $feed->get()->toArray();
        $allFeed = [];
        foreach ($feed as $row) {
            if (!isset($allFeed[$row['file_id']])) {
                $allFeed[$row['file_id']] = [
                    'data' => [],
                    'cardicon' => $cardicon,
                    'ftp' => $ftp,
                    'ride_info' =>  Rides::getRideByUserId($user_id, $row['file_id']),
                    'feed_time'=>$row['start']
                ];
            }
            $allFeed[$row['file_id']]['data'][] = $row;
        }

        if ($file_id) $allFeed = current($allFeed);
        return $allFeed;
    }
    public static function getUserAsideFeed($user_id,$file_id=0)
    {
        $user = User::find($user_id);
        //Efford
        $userXP = new UserXP(new Levels());
        $userXP->calculateFTP($user);
        $ftp = $userXP->getFtp();

        $cardicon = UsersCards::getCardsIcon2($user->cards_id);
        $allFeed = [];
        if ($file_id==0) {
            $rides = Rides::select(
                'files.start',
                'lap.moving_time',
                'rides.file_id',
                DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed'),
                DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp'),
                DB::RAW('ROUND(lap.total_elapsed_time,0) as time'),
                DB::RAW('ROUND(lap.avg_power,0) as avg_power'),
                DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
            )
                ->leftJoin('files', 'files.id', '=', 'rides.file_id')
                ->leftJoin('lap', 'lap.file_id', '=', 'rides.file_id')
                ->leftJoin('users', 'users.id', '=', 'rides.user_id')
                ->where('users.id', '=', $user_id)
                ->where('files.start', '!=', 'null')
                ->orderBy('files.start', 'desc')
                ->get()->toArray();
        }else{
            $rides = Rides::select(
                'files.start',
                'lap.moving_time',
                'rides.file_id',
                DB::RAW('ROUND(avg_speed * 2.23693629, 2) as avg_speed'),
                DB::RAW('(zone_1 + zone_2 + zone_3 + zone_4 + zone_5) as total_xp'),
                DB::RAW('ROUND(lap.total_elapsed_time,0) as time'),
                DB::RAW('ROUND(lap.avg_power,0) as avg_power'),
                DB::RAW('ROUND(lap.total_distance*0.000621371192,2) as total_distance')
            )
                ->leftJoin('files', 'files.id', '=', 'rides.file_id')
                ->leftJoin('lap', 'lap.file_id', '=', 'rides.file_id')
                ->leftJoin('users', 'users.id', '=', 'rides.user_id')
                ->where('users.id', '=', $user_id)
                ->where('files.id', '=', $file_id)
                ->where('files.start', '!=', 'null')
                ->orderBy('files.start', 'desc')
                ->get()->toArray();
        }

        foreach($rides as $ride){
            $feed = ActivityFeed::where('user_id', '=', $user_id)
                ->where('file_id','=',$ride['file_id'])
                ->orderBy('created_at','desc');

            $feed = $feed->get()->toArray();
            $allFeed[$ride['file_id']] =[
                'data' => [],
                'cardicon' => $cardicon,
                'ftp' => $ftp,
                'ride_info' =>$ride,
                'feed_time'=>$ride['start']
            ];
            foreach ($feed as $row) {

                if (!isset($allFeed[$ride['file_id']])) {
                    $allFeed[$row['file_id']] = [
                        'data' => [],
                        'cardicon' => $cardicon,
                        'ftp' => $ftp,
                        'ride_info' => $ride,
                        'feed_time'=>$ride['start']
                    ];
                }

                $allFeed[$row['file_id']]['data'][] = $row;
            }

        }
        if ($file_id) $allFeed = current($allFeed);

        return $allFeed;
    }
    public static function getTypes($flip = false)
    {
        $data = [
            1 => 'level',
            2 => 'card',
            3 => 'award',
            4 => 'achievement',
            5 => 'objective',
        ];
        return ($flip) ? array_flip($data) : $data;
    }


} 