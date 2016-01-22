<?php namespace App\BikeCraft\Parser;

use App\BikeCraft\Data;
use App\BikeCraft\VPower;
use App\Models\Activity;
use App\Models\DeviceInfo;
use App\Models\Event;
use App\Models\Lap;
use App\Models\Record;
use App\Models\SessionDevice;
use App\Models\UploadParsing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;

/**
 * Class ParserFIT
 * @package App\BikeCraft\Parser
 */
class ParserFIT extends abstractParser  {

    /**
     * @var
     */
    private $user;


    /**
     * @var array
     */
    protected $event_rows   = [4,16];

    /**
     * @var array
     */
    protected $records_rows = [4,25];

    /**
     * @var array
     */
    protected $device_rows  = [4,22];

    /**
     * @var array
     */
    protected $lap_rows     = [4,82];

    /**
     * @var array
     */
    protected $session_rows = [4,82];

    /**
     * @var array
     */
    protected $activity_rows= [4,19];
    /**
     * @var VPower
     */
    private $VPower;


    public function __construct(VPower $VPower)
    {
        $this->user = Auth::client()->user();
        $this->VPower = $VPower;
    }


    /**
     * @param $fileName
     * @return array
     */
    public function doUpload($fileName)
    {
        $path   =   public_path().'/uploads/rides/'.$fileName.'.csv';

        $csv    =   Reader::createFromPath($path);
        $data   =   $csv->fetchAll();
        unset($data[0]);

        $total_rows = count($data);

        $uploadParsing = UploadParsing::create([
            'total_count'       => $total_rows,
            'completed_count'   => 0,
            'user_id'           => $this->user->id
        ]);

        foreach ($data as $row) {
            if ( $row[0] == 'Data' ) {
                if ( $row[2] == 'lap') {
                    $data_insert = $this->getFields($this->lap_rows, $row);
                    break;
                }
            }
        }


        return [
            'timestamp'             => $data_insert['timestamp'],
            'start'                 => Carbon::createFromTimeStamp( Data::timeToUnix($data_insert['start_time']) )->toDateTimeString(),
            'end'                   => Carbon::createFromTimeStamp( Data::timeToUnix( $data_insert['start_time'] + $data_insert['total_elapsed_time']))->toDateTimeString(),
            'total_elapsed_time'    => $data_insert['total_elapsed_time'],
            'uploadParsing'         => $uploadParsing,
            'lat'                   => round( floatval($data_insert['start_position_lat']) * (180.0 / pow(2,31)), 5),
            'lng'                   => round( floatval($data_insert['start_position_long']) * (180.0 / pow(2,31)), 5),
        ];
    }


    /**
     * @param $file
     */
    public function parserActivity($file)
    {

        $path   =   public_path().'/uploads/rides/'.$file->filename.'.csv';
        $csv    =   Reader::createFromPath($path);
        $data   =   $csv->fetchAll();
        $header =   $data[0];
        unset($data[0]);

        $uploadPprogress = UploadParsing::where('file_id',$file->id)->first();
        $total           = $uploadPprogress->total_count;

        $this->VPower->setRiderWeight($this->user->weight_kg);
        $this->VPower->setTotalWeight();

        $i = 1;

        $grade = 0;

        $totalPower = 0;
        $recordItem = 1;
        $elevation_gained = 0;

        $moving_time    = 0;
        $idle_time      = 0;
        $inc = 1;

        foreach ($data as $lineIndex => $row) {

            $data_insert = [];

            if ( $row[0] == 'Data' ) {

                if ( $row[2] == 'event') {
                    $data_insert = $this->getFields($this->event_rows, $row);
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    Event::create($data_insert);
                }

                if ( $row[2] == 'record') {

                    $data_insert = $this->getFields($this->records_rows, $row);
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    $record  = Record::add($data_insert);

                        $seconds = 0;

                        if ( isset($lastRecord) && isset($record->distance) && isset($lastRecord->distance) ) {

                            $seconds    = $record->timestamp - $lastRecord->timestamp;
                            $distance   = $record->distance  - $lastRecord->distance ;

                            $grade = $this->calculateGrade($record->altitude, $lastRecord->altitude, $distance);

                            if ( $record->speed > config('bike.moving_speed') ) {

                                $this->VPower->setGrade($grade);

                                $power = $this->VPower->power($record->speed);

                                $record->power  = $power;
                                $record->save();

                                $totalPower += $power;
                                $inc++;
                            }
                        }

                        if (  isset($record->speed) && $record->speed > config('bike.moving_speed')  ) {
                            $moving_time += $seconds;
                        } else {
                            $idle_time += $seconds;
                        }



                    if ( isset($lastRecord) ) {
                        //calculate elevation gained
                        if ( floatval($record->altitude) >  floatval($lastRecord->altitude)  ) {
                            $elevation_gained +=  floatval($record->altitude) - floatval($lastRecord->altitude) ;
                        }
                    }

                    $lastRecord = $record;

                }

                if ( $row[2] == 'device_info') {
                    $data_insert = $this->getFields($this->device_rows, $row);
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    DeviceInfo::create($data_insert);
                }

                if ( $row[2] == 'lap') {
                    $data_insert = $this->getFields($this->lap_rows, $row);
                    unset($data_insert['sub_sport']);
                    if ( isset($data_insert['intensity']) ) {
                        unset($data_insert['intensity']);
                    }
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    $lap = Lap::add($data_insert);
                }

                if ( $row[2] == 'session' ) {
                    $data_insert = $this->getFields($this->session_rows, $row);
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    SessionDevice::add($data_insert);
                }

                if ($row[2] == 'activity') {
                    $data_insert = $this->getFields($this->activity_rows, $row);
                    $data_insert['file_id'] = $file->id;
                    $data_insert['user_id'] = $this->user->id;
                    Activity::create($data_insert);
                }

            }

            if ( $i % 500 == 0  ) {
                $uploadPprogress->completed_count = $i;
                $uploadPprogress->save();
            }

            if ( $i == $total   ) {
                $uploadPprogress->completed_count   = $i;
                $uploadPprogress->completed_all     = 'Y';
                $uploadPprogress->save();

                $file->completed_all = 'Y';
                $file->save();
            }

            $i++;


        }

        if ( $totalPower > 0 ) {

            $avg_power = round($totalPower/$inc);
            $lap->avg_power = $avg_power;
            $record = Record::where('file_id',$file->id)->orderBy('power','DESC')->first();
            $lap->max_power = $record->power;
            $lap->estimated_power = $avg_power;

        }

        $lap->elevation     = $elevation_gained;
        $lap->moving_time   = $moving_time;
        $lap->idle_time     = $idle_time;
        $lap->save();

        $getLaps = Lap::where('file_id',$file->id)->orderBy('id','DESC')->get();

        if ( count($getLaps) > 1 ) {

            $lapDetails = Lap::getAvgLap($file->id);

            $lap = Lap::where('file_id',$file->id)->orderBy('id','DESC')->first();
            $firstLap = Lap::where('file_id',$file->id)->orderBy('id','ASC')->first();

            $lap->total_elapsed_time = $lapDetails->total_elapsed_time;
            $lap->total_timer_time = $lapDetails->total_timer_time;
            $lap->total_distance = $lapDetails->total_distance;
            $lap->total_cycles = $lapDetails->total_cycles;
            $lap->total_calories = $lapDetails->total_calories;
            $lap->avg_speed = $lapDetails->avg_speed;
            $lap->max_speed = $lapDetails->max_speed;
            $lap->timestamp = $firstLap->timestamp;
            $lap->start_time = $firstLap->start_time;
            $lap->start_position_lat = $firstLap->start_position_lat;
            $lap->start_position_long = $firstLap->start_position_long;
            $lap->save();

            Lap::where('file_id',$file->id)
                        ->where('id','!=',$lap->id)
                        ->delete();

        }



    }


    /**
     * Get total activities Fit file
     * @param $file
     * @return int
     */
    protected function getTotalFit($file)
    {
        $path   =   public_path().'/uploads/rides/'.$file->filename.'_data.csv';
        $csv    =   Reader::createFromPath($path);
        $data   =   $csv->fetchAll();
        unset($data[0]);
        $total = count($data);
        return $total;
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

} 