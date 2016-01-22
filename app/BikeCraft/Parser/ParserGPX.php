<?php namespace App\BikeCraft\Parser;

use App\BikeCraft\Data;
use App\BikeCraft\VPower;
use App\Models\Lap;
use App\Models\Record;
use App\Models\UploadParsing;
use Illuminate\Support\Facades\Auth;
use stdClass;


/**
 * Class ParserGPX
 * @package App\BikeCraft\Parser
 */
class ParserGPX extends abstractParser {

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $lastTrackPoint;

    /**
     * @var VPower
     */
    private $VPower;


    public function __construct(VPower $VPower)
    {
        $this->user     = Auth::client()->user();
        $this->VPower   = $VPower;
    }

    /**
     * @param $fileName
     * @return array
     */
    public function doUpload($fileName)
    {
        $gpx = simplexml_load_file(public_path('/uploads/rides/'.$fileName));
        try {
            if (!$gpx )
                return FALSE;
        }
        catch (Exception $e) {
            Log::debug('Exception thrown while reading tcxFile: ' . $e);
            return FALSE;
        }

        $uploadParsing = UploadParsing::create([
            'total_count'       => 0,
            'completed_count'   => 0,
            'user_id'           => Auth::client()->user()->id
        ]);

        $activityCount    = 0;
        $StartTime        = 0;
        $EndTime          = 0;
        $TotalTimeSeconds = 0;
        $StartLat         = 0;
        $StartLng         = 0;
        foreach ($gpx->trk->trkseg as $segment )
        {
            foreach ($segment->trkpt as $val) {
                $activityCount++;
                if($activityCount == 1) {
                    $StartTime = Data::timeToGarmin(strtotime($val->time));
                    $StartLat = (float)$val->attributes()->lat;
                    $StartLng = (float)$val->attributes()->lon;
                }
                $EndTime = Data::timeToGarmin(strtotime($val->time));
            }
        }
        $TotalTimeSeconds = $EndTime-$StartTime;

        $uploadParsing->total_count = $activityCount;
        $uploadParsing->save();

        return [
            'timestamp'             => $StartTime,
            'start'                 => date('Y-m-d H:i:s',(Data::timeToUnix($StartTime ))),
            'end'                   => date('Y-m-d H:i:s',(Data::timeToUnix($EndTime ))),
            'total_elapsed_time'    => $TotalTimeSeconds, //run times
            'uploadParsing'         => $uploadParsing,
            'lat'                   => $StartLat,
            'lng'                   => $StartLng,
        ];

    }


    /**
     * @return bool
     */
    public function parserActivity($file)
    {
        $gpx = simplexml_load_file(public_path('/uploads/rides/'.$file->filename.'.gpx'));
        $data = implode("", file(public_path('/uploads/rides/'.$file->filename.'.gpx')));
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $values, $tags);
        xml_parser_free($parser);
        $calories = 0;
        if($values[2]['tag']=='st:activity'){
            if(!empty($values[2]['attributes']['calories'])){
                $calories = trim($values[2]['attributes']['calories']);
            };
        }

        try {
            if (!$gpx )
                return FALSE;
        }
        catch (Exception $e)
        {
            Log::debug('Exception thrown while reading tcxFile: ' . $e);
            return FALSE;
        }


        $activityCount = 0;

        if (empty($gpx->trk->trkseg))
            return FALSE;
        $this->parser($gpx->trk->trkseg, $file, $calories);

        return TRUE;


    }


    /**
     * @param $activityXML
     * @param $file
     */
    private function parser($trkseg, $file, $calories=0)
    {
        //set config
        $this->VPower->setRiderWeight($this->user->weight_kg);
        $this->VPower->setTotalWeight();

        $activityCount      = 0;
        $totalPower         = 0;
        $elevation          = 0;
        $elevation_gained   = 0;
        $speed              = 0;
        $grade              = 0;
        $uploadPprogress    = UploadParsing::where('file_id',$file->id)->first();
        $total              = $uploadPprogress->total_count;
        $StartTime          = 0;
        $EndTime            = 0;
        $DistanceMeters     = 0;
        $MaximumSpeed       = 0;
        $Calories           = $calories;
        $Cadence            = 0;
        $lastTrackPoint     = "";

        $moving_time        = 0;
        $idle_time          = 0;
        $inc                = 1;

        foreach ($trkseg as $segment)
        {
            foreach($segment as $val ) {

                $seconds = 0;
                $speed   = 0;

                $trackpoint = new stdClass;
                $trackpoint->AltitudeMeters   = (float)$val->ele;
                $trackpoint->LatitudeDegrees  = (float)$val->attributes()->lat;
                $trackpoint->LongitudeDegrees = (float)$val->attributes()->lon;
                $trackpoint->Time             = Data::timeToGarmin(strtotime($val->time));

                $trackpoint->DistanceMeters   = 0;

                if($activityCount == 0) {
                    $StartTime           = $trackpoint->Time;
                    $start_position_lat  = $trackpoint->LatitudeDegrees;
                    $start_position_long = $trackpoint->LongitudeDegrees;
                }

                $EndTime = $trackpoint->Time;

                if ( !empty($lastTrackPoint) && $lastTrackPoint->LatitudeDegrees != $trackpoint->LatitudeDegrees ) {

                    $calcDistanceMeters = distanceTwoPoints($trackpoint->LatitudeDegrees,$trackpoint->LongitudeDegrees,$lastTrackPoint->LatitudeDegrees,$lastTrackPoint->LongitudeDegrees,'m');
                    $trackpoint->DistanceMeters = number_format($calcDistanceMeters,2)+$lastTrackPoint->DistanceMeters;

                    $DistanceMeters = $trackpoint->DistanceMeters;

                    $distance   = $calcDistanceMeters;
                    $seconds    = $trackpoint->Time - $lastTrackPoint->Time;

                    if($seconds>0 && $distance>0) {
                        $speed      = $distance / $seconds;
                    }

                    if($speed>$MaximumSpeed) {
                        $MaximumSpeed = $speed;
                    }

                    $grade      = $this->calculateGrade($trackpoint->AltitudeMeters, $lastTrackPoint->AltitudeMeters,$distance);
                    //calculate elevation gained
                    if ( floatval($trackpoint->AltitudeMeters) >  floatval($lastTrackPoint->AltitudeMeters)  ) {
                        $elevation_gained +=  floatval($trackpoint->AltitudeMeters) - floatval($lastTrackPoint->AltitudeMeters) ;
                    }

                }

                if ( empty($lastTrackPoint) || $lastTrackPoint->LatitudeDegrees != $trackpoint->LatitudeDegrees ) {

                    $record                = new Record();
                    $record->timestamp     = $trackpoint->Time;
                    $record->distance      = $trackpoint->DistanceMeters;
                    $record->altitude      = $trackpoint->AltitudeMeters;
                    $record->position_lat  = $trackpoint->LatitudeDegrees;
                    $record->position_long = $trackpoint->LongitudeDegrees;
                    $record->user_id       = $this->user->id;
                    $record->speed         = $speed;
                    $record->file_id       = $file->id;

                    $power = 0;

                    if ( $speed > config('bike.moving_speed') ) {
                        $moving_time += $seconds;
                    } else {
                        $idle_time += $seconds;
                    }

                    if ( $speed > config('bike.moving_speed') ) {

                        $this->VPower->setGrade($grade);
                        $power  = $this->VPower->power($speed);

                        $record->power         = $power;

                        $inc++;
                    }

                    $totalPower            += $power;
                    $lastTrackPoint  = $trackpoint;

                    $record->save();

                }

                if ( $activityCount % 500 == 0  ) {
                    $uploadPprogress->completed_count = $activityCount;
                    $uploadPprogress->save();
                }

                if ( $activityCount+1 == $total   ) {
                    $uploadPprogress->completed_count   = $total;
                    $uploadPprogress->completed_all     = 'Y';
                    $uploadPprogress->save();

                    $file->completed_all = 'Y';
                    $file->save();
                }

                $activityCount ++;
            }
        }
        // INSERT TO LAP          
        $TotalTimeSeconds = $EndTime-$StartTime;
        $lap = new Lap();
        $lap->timestamp             = $StartTime;
        $lap->start_time            = $StartTime;
        $lap->total_elapsed_time    = $TotalTimeSeconds;
        $lap->total_distance        = $DistanceMeters;

        $lap->avg_speed             = ($DistanceMeters / $TotalTimeSeconds) * 1.15;
        $lap->max_speed             = $MaximumSpeed;
        $lap->total_calories        = $Calories;

        $lap->avg_cadence           = $Cadence;
        $lap->max_cadence           = $Cadence;

        $lap->start_position_lat    = $start_position_lat;
        $lap->start_position_long   = $start_position_long;

        $lap->user_id               = $this->user->id;
        $lap->file_id               = $file->id;
        $lap->save();

        // INSERT TO RECORD
        $total_power                = round($totalPower/$inc,2);
        $lap->end_position_lat      = $trackpoint->LatitudeDegrees;
        $lap->end_position_long     = $trackpoint->LongitudeDegrees;

        $record = Record::getMaxPower($file->id);
        $lap->avg_power             = $total_power;
        $lap->max_power             = $record->power;
        $lap->estimated_power       = $total_power;

        $lap->elevation      = $elevation_gained;

        $lap->moving_time   = $moving_time;
        $lap->idle_time     = $idle_time;

        $lap->save();
    }



} 