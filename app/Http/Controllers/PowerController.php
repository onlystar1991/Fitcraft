<?php namespace App\Http\Controllers;

use App\BikeCraft\Achievements\AchievementsAnalysis;
use App\BikeCraft\Analysis;
use App\BikeCraft\Data;
use App\BikeCraft\Parser\ParserTCX;
use App\BikeCraft\Processing;
use App\BikeCraft\VPower;
use App\Http\Requests;

use App\Models\Files;
use App\Models\Record;
use App\Models\Rides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PowerController extends Controller {

    /**
     * @var VPower
     */
    private $VPower;

    public function __construct(VPower $VPower)
    {

        $this->VPower = $VPower;
    }

    /**
     * @param $rows
     * @param $item
     * @return array
     */
    private function getFields($rows, $item)
    {
        $array = [];
        for($i=$rows[0]; $i<=$rows[1]; $i+=3) {
            if ( !empty($item[$i-1]) ) {
                $array[$item[$i-1]] = $item[$i];
            }
        }
        return $array;
    }

    public function index(Analysis $analysis, Processing $processing)
    {
        
        $gpx = simplexml_load_file(public_path('/uploads/rides/mondayRide.gpx'));

        $trkseg_count = 0;
        $trkpt_count = 0;
        $i = 0;
        $record = [];
        $activityCount = 0;
        $StartTime = 0;
        $EndTime = 0;
        foreach ($gpx->trk->trkseg as $segment )
        {
                foreach ($segment->trkpt as $val) {
                        $activityCount++;
                        if($activityCount == 1) {
                            $StartTime = Data::timeToGarmin(strtotime($val->time)); 
                        }
                        $record[] = [
                            'timestamp' => Data::timeToGarmin(strtotime($val->time)),
                            'altitude' => (float)$val->ele,
                            'position_lat' => (float)$val->attributes()->lat, 
                            'distance' => 0, 
                            'position_long' =>(float)$val->attributes()->lon
                        ];   
                        $EndTime = Data::timeToGarmin(strtotime($val->time));                      
                        // dd($val);
                        // $timestamp = date( 'd.m.Y',(Data::timeToUnix($timestamp )) );
                        // echo "<br />ele =".$val->ele;  
                        // echo "<br />lat =".$val->attributes()->lat;  
                        // echo "<br />lng =".$val->attributes()->lon;  
                        // echo "<br />timestamp =".Data::timeToGarmin(strtotime($val->time)); 
                        // echo "<br />timestamp =".Data::timeToGarmin(strtotime($val->time)); 
                        // echo "<br />";
            }  
            // echo "<br />ele =".$segment->trkpt->ele;
        }
        // start = 2015-06-15T23:55:17Z
        // end = 2015-06-16T00:25:24Z
        // echo "<BR />StartTime=".date('d.m.Y',(Data::timeToUnix($StartTime)));
        // echo "<BR />EndTime=".date('d.m.Y',(Data::timeToUnix($EndTime)));

        // $TotalTimeSeconds = $EndTime-$StartTime; 
        // echo "<BR />TotalTimeSeconds=".$TotalTimeSeconds;

        $lastTrack = [];$dist = 0;
        foreach ($record as $key => $value) {
            if (!empty($lastTrack)) {                
                //calculate and insert 
                $distance = distanceTwoPoints($value['position_lat'],$value['position_long'],$lastTrack['position_lat'],$lastTrack['position_long'],'m');    
                // $record[$key]['distance'] = number_format($distance,2);  
                // dd( $lastTrack);

                $record[$key]['distance'] =  $lastTrack['distance']+ number_format($distance,2);
                // echo "string".$lastTrack['distance'];
                // if($record[$key]['distance'] =='53.76') {
                //     echo "<br />lat1= ".$value['position_lat'];
                //     echo "<br />lon1= ".$value['position_long'];
                //     echo "<br />lat2= ".$lastTrack['position_lat'];
                //     echo "<br />lon2= ".$lastTrack['position_long'];                    
                // }
                $record[$key]['speed'] = 0;
                $record[$key]['power'] = 0;

                echo "<br />dist=".number_format($distance,2);
                echo "<br />l=".$lastTrack['distance'];
                echo "<br />total=".$record[$key]['distance'];

                $dist = $dist+ $record[$key]['distance'];

                // set curent to LastTrak
                $lastTrack                = $value;
                $lastTrack[$key]['distance'] = $record[$key]['distance'];
            } else {
                //insert 
                $lastTrack = $value;

                $record[$key]['speed'] = 0;
                $record[$key]['power'] = 0;
                // $record[$key]['distance'] = 0;
            } 



        }    
        echo "t=".$dist;    
        // dd($record);
        // $lap_final = [];        
        // $ns = $gpx->getNamespaces(true);
        // foreach ($gpx->extensions as $exten) {
        //     $abvio = $exten->children($ns["abvio"]);
        //     $lap_final['distance'] = $abvio->distance;
        //     $lap_final['avg_power'] = (int)$abvio->avgPower;
        // }
        // dd($lap_final);
        // echo "<br />trkseg_count=".$trkseg_count;
        // echo "<br />trkpt_count=".$trkpt_count;
        exit();









        echo date('Y-m-d H:i:s', Data::timeToUnix(795023711));
        return 'X';
        echo timeAgo(6770);

        echo timeAgo(324000);

        //echo  740809163 -740802399;
        return 'X';

        echo '<br/>';
        echo date('Y-m-d H:i:s', Data::timeToUnix(740802399));
        echo '<br/>';
        echo date('Y-m-d H:i:s', Data::timeToUnix(740802402));


        $diff = 740802402 - 740802399;
        echo '<br/>';
        // echo $diff;

        echo '<br/>';
        return '--';

        return view('maptest');

        $records = Record::where(['file_id'=>16])->get();
        foreach($records as $record) {
            echo round( $record->position_lat * (180.0 / pow(2,31)), 5).' --- '.round( $record->position_long * (180.0 / pow(2,31)), 5);
            echo '<br/>';
        }

        return '-X-';
        $lat = round( -381356420 * (180.0 / pow(2,31)), 5);
        $lng = round(1385226349 * (180.0 / pow(2,31)), 5);

        $param      = array("latlng"=>"$lat,$lng");
        $reponse    = json_decode(\Geocoder::geocode('json', $param),true);

        foreach($reponse['results'][0]['address_components'] as $key=>$value) {
            if ( $value['types'][0] == 'locality' ) {
                $locality = $value['long_name'];
            }
            if ( $value['types'][0] == 'country' ) {
                $country = $value['long_name'];
            }
            if ( $value['types'][0] == 'postal_code' ) {
                $postal_code = $value['long_name'];
            }
            if ( $value['types'][0] == 'administrative_area_level_1' ) {
                $administrative_area_level_1 = $value['long_name'];
            }

        }
        echo $locality;
        echo '<br/>';
        echo $country;
        echo '<br/>';
        echo $administrative_area_level_1;
        echo '<br/>';


        return ' - ';


        echo date('Y-m-d H:i:s',Data::timeToUnix(740802399));
        echo '<br/>';
        echo date('Y-m-d H:i:s',Data::timeToUnix(740802399 + 6770.675 ));
//        echo Carbon::createFromTimeStamp( Data::timeToUnix(740814551) )->toDateTimeString();
//        echo Carbon::createFromTimeStamp( Data::timeToUnix(740814551) )->toDateTimeString();
        //echo gmdate("H:i",663503.542);
        echo '<br/>';
        return '-';



        $file = Files::where(['id'=>6])->first();

//        $processing->doProcessing($file);

        $analysis->partitionData($file);


    }

    public function map(Request $request)
    {

        $ride = Rides::find($request->input('id'));
        $records = Record::where(['file_id'=>$ride->file_id])->get();
        $latLng = [];
        foreach($records as $record) {
            $latLng[] = [round( $record->position_lat * (180.0 / pow(2,31)), 5), round( $record->position_long * (180.0 / pow(2,31)), 5) ];
        }

        return Response::json($latLng);

    }

    public function achievement(AchievementsAnalysis $achievementsAnalysis, ParserTCX $parserTCX, VPower $VPower, Analysis $analysis)
    {

        if ( 93.50225830078125 > 93.49662017822266 ) {
            echo 's';
        }
        return 'x';

        $file = Files::find(1);
        $analysis->partitionData($file);

        return 'X';


//        $parserTCX->doProcessing();
//        return 'x';

        $records = Record::where('file_id',1)->get();
        $total_power = 0;
        $last = null;

        $grade = 0;
        foreach($records as $key=>$record) {

            if ( $key !=0 ) {
                $diff_distance = $record->distance - $last->distance;
                if ( $diff_distance > 0 ) {

                    $grade = ($record->altitude - $last->altitude) / ( $record->distance - $last->distance) * 100;
                    if ( $record->id == 82 ) {
                        echo $record->altitude ;
                        echo '<br>';
                        echo $last->altitude;
                        echo '<br>';
                        echo $grade;
                    }
                    $grade = $grade < 0 ? 0 : $grade;
                }
            }

            $VPower->setGrade($grade);
            $power = $VPower->power($record->speed);

            $total_power += $power;

            $last = $record;


        }


        echo round($total_power / $key,2);
        echo '<br/>';

        return '-';




    }





}
