<?php namespace App\BikeCraft\Parser;

use App\BikeCraft\Data;
use App\BikeCraft\VPower;
use App\Models\Lap;
use App\Models\Record;
use App\Models\UploadParsing;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;
use XMLReader;


/**
 * Class ParserTCX
 * @package App\BikeCraft\Parser
 */
class ParserTCX extends abstractParser {

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
        $reader = new XMLReader();
        try {
            if (! $reader->open(public_path('/uploads/rides/'.$fileName)))
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

        $activityCount = 0;

        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT and $reader->name == 'Activity')
            {
                $activityCount ++;
                $activityXML = $reader->readOuterXML();
                if (empty($activityXML))
                    return FALSE;

                $activities = new SimpleXMLElement($activityXML);

                foreach( $activities->Lap as $lapItem ) {

                    $activityCount = 0;

                    foreach ($lapItem->Track as $track) {
                        foreach ($track->Trackpoint as $key=> $trackpoint) {
                            $activityCount ++;
                        }
                    }
                }
            }
        }

        $uploadParsing->total_count = $activityCount;
        $uploadParsing->save();

        return [
            'timestamp'             => $activities->Lap['StartTime'],
            'start'                 => date('Y-m-d H:i:s',strtotime($activities->Lap['StartTime'])),
            'end'                   => date('Y-m-d H:i:s',strtotime($activities->Lap['StartTime']) + $lapItem->TotalTimeSeconds ),
            'total_elapsed_time'    => $lapItem->TotalTimeSeconds,
            'uploadParsing'         => $uploadParsing,
            'lat'                   => floatval($activities->Lap->Track->Trackpoint->Position->LatitudeDegrees),
            'lng'                   => floatval($activities->Lap->Track->Trackpoint->Position->LongitudeDegrees),
        ];

    }


    /**
     * @return bool
     */
    public function parserActivity($file)
    {

        $reader = new XMLReader();
        try {
            if (! $reader->open(public_path('/uploads/rides/'.$file->filename.'.tcx')))
                return FALSE;
        }
        catch (Exception $e)
        {
            Log::debug('Exception thrown while reading tcxFile: ' . $e);
            return FALSE;
        }


        $activityCount = 0;
        while ($reader->read())
        {
            if ($reader->nodeType == XMLReader::ELEMENT and $reader->name == 'Activity')
            {
                $activityCount ++;
                $activityXML = $reader->readOuterXML();
                if (empty($activityXML))
                    return FALSE;

                $this->parser($activityXML, $file);
            }
        }

        return TRUE;


    }


    /**
     * @param $activityXML
     * @param $file
     */
    private function parser($activityXML, $file)
    {

        $activities = new SimpleXMLElement($activityXML);

        //set config
        $this->VPower->setRiderWeight($this->user->weight_kg);
        $this->VPower->setTotalWeight();

        foreach( $activities->Lap as $lapItem ) {

            $lap = new Lap();

            //start time
            $lap->timestamp             = Data::timeToGarmin(strtotime($activities->Lap['StartTime']));
            $lap->start_time            = Data::timeToGarmin(strtotime($activities->Lap['StartTime']));

            $lap->total_distance        = $lapItem->DistanceMeters;
            if($lapItem->TotalTimeSeconds>0){
                $lap->avg_speed             = $lapItem->DistanceMeters / $lapItem->TotalTimeSeconds;
            }else{
                $lap->avg_speed             = 0;
            }

            $lap->max_speed             = $lapItem->MaximumSpeed;
            $lap->total_calories        = $lapItem->Calories;

            $lap->avg_cadence           = $lapItem->Cadence;
            $lap->max_cadence           = $lapItem->Cadence;

            $lap->start_position_lat    = $lapItem->Track->Trackpoint->Position->LatitudeDegrees;
            $lap->start_position_long   = $lapItem->Track->Trackpoint->Position->LongitudeDegrees;

            $lap->user_id               = $this->user->id;
            $lap->file_id               = $file->id;


            //lap_trigger
            //sport

            $lap->save();

            $activityCount      = 0;
            $totalPower         = 0;
            $elevation_gained   = 0;
            $grade              = 0;
            $moving_time        = 0;
            $idle_time          = 0;
            $inc                = 1;


            $uploadPprogress = UploadParsing::where('file_id',$file->id)->first();
            $total           = $uploadPprogress->total_count;


            foreach ($lapItem->Track as $track) {

                foreach ($track->Trackpoint as $key=> $trackpoint) {
                    $seconds = 0;
                    $speed   = 0;
                    if ( !empty($this->lastTrackPoint) ) {

                        $distance   = $trackpoint->DistanceMeters -  $this->lastTrackPoint->DistanceMeters;
                        $seconds    = strtotime($trackpoint->Time) - strtotime($this->lastTrackPoint->Time);
                        if(isset($trackpoint->Speed)) {
                             $speed  = $trackpoint->Speed;
                        } else {
                             if( $distance > 0 && $seconds > 0 ) {
                                $speed  = $distance / $seconds;
                             }                                                  
                        }

                        $grade = $this->calculateGrade($trackpoint->AltitudeMeters, $this->lastTrackPoint->AltitudeMeters, $distance);

                        //calculate elevation gained
                        if ( floatval($trackpoint->AltitudeMeters) >  floatval($this->lastTrackPoint->AltitudeMeters)  ) {
                            $elevation_gained +=  floatval($trackpoint->AltitudeMeters) - floatval($this->lastTrackPoint->AltitudeMeters) ;
                        }

                    }


                    $record = new Record();

                    $record->timestamp      = Data::timeToGarmin(strtotime($trackpoint->Time));
                    $record->distance       = $trackpoint->DistanceMeters;
                    $record->altitude       = $trackpoint->AltitudeMeters;
                    $record->position_lat   = $trackpoint->Position->LatitudeDegrees;
                    $record->position_long  = $trackpoint->Position->LongitudeDegrees;
                    $record->user_id        = $this->user->id;
                    $record->speed          = $speed;
                    $record->file_id        = $file->id;

                    if ( $speed >= config('bike.moving_speed') ) {
                        $moving_time += $seconds;
                    } else {
                        $idle_time += $seconds;
                    }

                    $power                  = 0;

                    //estimated power;
                    if ( $speed > config('bike.moving_speed') ) {

                        $this->VPower->setGrade($grade);
                        $power  = $this->VPower->power($speed);
                        $record->power  = $power;

                        $inc++;
                    }

                    $record->save();

                    $totalPower += $power;

                    $this->lastTrackPoint = $trackpoint;

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

                $total_power                = round($totalPower / $inc,2);
                $lap->end_position_lat      = $trackpoint->Position->LatitudeDegrees;
                $lap->end_position_long     = $trackpoint->Position->LongitudeDegrees;

                $record = Record::getMaxPower($file->id);
                $lap->avg_power             = $total_power;
                $lap->max_power             = $record->power;
                $lap->estimated_power       = $total_power;

                $lap->elevation             = $elevation_gained;
                $lap->moving_time           = $moving_time;
                $lap->idle_time             = $idle_time;
                $lap->total_elapsed_time    = $moving_time + $idle_time;

                $lap->save();

            }


        }


    }



} 