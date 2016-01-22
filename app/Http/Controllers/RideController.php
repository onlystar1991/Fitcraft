<?php namespace App\Http\Controllers;


use App\BikeCraft\UserXP;
use App\Http\Requests;

use App\Models\ActivityFeed;
use App\Models\BonusXP;
use App\Models\Files;
use App\Models\Lap;
use App\Models\Record;
use App\Models\Rides;
use App\Models\User;
use App\Models\UsersCards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RideController extends Controller
{

    /**
     * @var
     */
    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

    public function index(Request $request)
    {

        $user_id = $request->get('user_id') > 0 ? $request->get('user_id') : $this->user->id;
        return Response::json(User::getUserProfileInfo($user_id,$request), 200);
    }

    /**
     *
     * @param $result
     * @return mixed
     */
    public function percentagesZones($result)
    {
        $total = array_sum($result);
        if ( $total != 0 ) {
           return array_walk($result, function (&$value, $key, $total) {
                $value = round($value / $total * 100, 1);
            }, $total);
        } else {

        }

    }

    /**
     * @param $id
     */
    public function chart( $id )
    {
        $ride       = Rides::find($id);
        $records    = Record::where(['file_id'=>$ride->file_id])->get();
        $lap        = Lap::where(['file_id'=>$ride->file_id])->first();
        $file       = Files::find($ride->file_id);
        $total_records = count($records);

        ///elevation
        $elevation = Record::select(DB::RAW('MAX(altitude) as max_altitude'))->first();
        $max_elevation  = $elevation->max_altitude;
        $max_speed      = $lap->max_speed;
        $max_cadence    = $lap->max_cadence;
        $max_heart_rate = ($lap->max_heart_rate > 0 ) ? $lap->max_heart_rate : 0 ;
        $max_power      = ($lap->max_power > 0 ) ? $lap->max_power : $this->user->power ;

        $max_distance   = $lap->total_distance;

        $step = 1;

//        if ( $total_records > 10000 ) {
//            $step = 20;
//        } elseif( $total_records > 5000 ) {
//            $step = 10;
//        }

        $charts = [];

        foreach ($records as $key=> $record) {

            if ( $key % $step == 0) {

                $charts['speed'][] = [
                    "x" => ($record->distance == (int)$record->distance) ? (int)$record->distance : (float)$record->distance,
                    "y" => ($record->speed == (int)$record->speed) ? (int)$record->speed : (float)$record->speed,
                    "bmp" => ($lap->max_heart_rate > 0) ? $record->heart_rate : 0,
                    "speed" => MpsToMph($record->speed),
                    'elevation' => round($record->altitude * 3.2808399, 0),
                    'time' => timeAgo($record->timestamp - $lap->start_time),
                    'power' => round($record->power, 0),
                    'cadence' => ($record->cadence == (int)$record->cadence) ? (int)$record->cadence : (float)$record->cadence,
                    'lat' => (strtolower($file->ext == 'fit')) ? round($record->position_lat * (180.0 / pow(2, 31)), 5) : round($record->position_lat, 5),
                    'lng' => (strtolower($file->ext == 'fit')) ? round($record->position_long * (180.0 / pow(2, 31)), 5) : round($record->position_long, 5)
                ];

                $charts['elevation'][] = [
                    "x" => ($record->distance == (int)$record->distance) ? (int)$record->distance : (float)$record->distance,
                    "y" => ($record->altitude == (int)$record->altitude) ? (int)$record->altitude : (float)$record->altitude,
                    "bmp" => ($lap->max_heart_rate > 0) ? $record->heart_rate : 0,
                    "speed" => MpsToMph($record->speed),
                    'elevation' => round($record->altitude * 3.2808399, 0),
                    'time' => timeAgo($record->timestamp - $lap->start_time),
                    'power' => round($record->power, 0),
                    'cadence' => ($record->cadence == (int)$record->cadence) ? (int)$record->cadence : (float)$record->cadence,
                    'lat' => (strtolower($file->ext == 'fit')) ? round($record->position_lat * (180.0 / pow(2, 31)), 5) : round($record->position_lat, 5),
                    'lng' => (strtolower($file->ext == 'fit')) ? round($record->position_long * (180.0 / pow(2, 31)), 5) : round($record->position_long, 5)
                ];

                $charts['heart'][] = [
                    "x" => ($record->distance == (int)$record->distance) ? (int)$record->distance : (float)$record->distance,
                    "y" => ($lap->max_heart_rate > 0) ? ($record->heart_rate == (int)$record->heart_rate) ? (int)$record->heart_rate : (float)$record->heart_rate : 0,
                    "bmp" => ($lap->max_heart_rate > 0) ? $record->heart_rate : 0,
                    "speed" => MpsToMph($record->speed),
                    'elevation' => round($record->altitude * 3.2808399, 0),
                    'time' => timeAgo($record->timestamp - $lap->start_time),
                    'power' => round($record->power, 0),
                    'cadence' => ($record->cadence == (int)$record->cadence) ? (int)$record->cadence : (float)$record->cadence,
                    'lat' => (strtolower($file->ext == 'fit')) ? round($record->position_lat * (180.0 / pow(2, 31)), 5) : round($record->position_lat, 5),
                    'lng' => (strtolower($file->ext == 'fit')) ? round($record->position_long * (180.0 / pow(2, 31)), 5) : round($record->position_long, 5)
                ];

                $charts['power'][] = [
                    "x" => ($record->distance == (int)$record->distance) ? (int)$record->distance : (float)$record->distance,
                    "y" => ($lap->max_power > 0) ? ($record->power == (int)$record->power) ? (int)$record->power : (float)$record->power : $this->user->power,
                    "bmp" => ($lap->max_heart_rate > 0) ? $record->heart_rate : 0,
                    "speed" => MpsToMph($record->speed),
                    'elevation' => round($record->altitude * 3.2808399, 0),
                    'time' => timeAgo($record->timestamp - $lap->start_time),
                    'power' => round($record->power, 0),
                    'cadence' => ($record->cadence == (int)$record->cadence) ? (int)$record->cadence : (float)$record->cadence,
                    'lat' => (strtolower($file->ext == 'fit')) ? round($record->position_lat * (180.0 / pow(2, 31)), 5) : round($record->position_lat, 5),
                    'lng' => (strtolower($file->ext == 'fit')) ? round($record->position_long * (180.0 / pow(2, 31)), 5) : round($record->position_long, 5)
                ];
            }

        }

        return Response::json([
                'charts'        => $charts,
                'max_speed'     => $max_speed,
                'max_distance'  => $max_distance,
                'max_elevation' => $max_elevation,
                'max_power'     => $max_power,
                'max_cadence'   => $max_cadence
            ]);

    }

    /**
     * Map details
     * @param Request $request
     * @return mixed
     */
    public function map(Request $request)
    {

        $ride       = Rides::find($request->input('id'));
        $records    = Record::where(['file_id'=>$ride->file_id])->get();
        $file       = Files::find($ride->file_id);
        $latLng = [];
        if($records) {
            foreach($records as $record) {
                if ( strtolower($file->ext) == 'fit' ) {
                    if ( $record->position_la != 0 || $record->position_long != 0  ) {
                        $latLng[] = [round( $record->position_lat * (180.0 / pow(2,31)), 5), round( $record->position_long * (180.0 / pow(2,31)), 5) ];
                    }
                } else {
                    $latLng[] = [round( $record->position_lat, 5), round( $record->position_long, 5) ];
                }

            }            
        }


        return Response::json($latLng);

    }


    /**
     * After ride upload
     * @param Request $request
     */
    public function details(Request $request, UserXP $userXP )
    {
        $file = Files::find($request->input('id'));
        $lap    =  Lap::getByFileId($file->id);

        $userXP->calculateFTP(Auth::client()->user());
        $ftp = $userXP->getFtp();
        $result = [
            'lap'   => [
                'time'          => timeRide($lap->total_elapsed_time),
                'distance'      => $lap->distance,
                'avg_speed'     => $lap->avg_speed,
                'avg_effort'    => round($lap->avg_power / $ftp * 100),
                'avg_power'     => $lap->avg_power,
                'elevation'     => $lap->elevation,
                'calories'      => $lap->total_calories,
                'bonus_rolls'   => BonusXP::where('ride_id',$lap->ride_id)->count(),
                'xp'            => round($lap->total_xp),
                'time_at'            => $lap->created_at,
            ]
        ];


        $result['feed'] = ActivityFeed::getUserAsideFeed(Auth::client()->user()->id,$file->id);


        $result['feed']['formate_date'] = date('m.d.y', strtotime($result['feed']['feed_time']));

        $user = User::find(Auth::client()->user()->id);
        $result['cardicon'] = UsersCards::getCardsIcon2($user->cards_id);
        $result['nickname'] =$user->nickname;

        return Response::json($result,200);
    }


}
