<?php namespace App\Services;

use App\Models\Activity;
use App\Models\DeviceInfo;
use App\Models\Event;
use App\Models\Files;
use App\Models\UploadParsing;
use App\Models\Lap;
use App\Models\SessionDevice;
use App\Models\Record;
use Illuminate\Http\Request;
use Response;
use League\Csv\Reader;
use Carbon\Carbon;
use App\BikeCraft\Data;
use Session;

class UploadRide {

    protected $event_rows   = [4,16];

    protected $records_rows = [4,25];

    protected $device_rows  = [4,22];

    protected $lap_rows     = [4,82];

    protected $session_rows = [4,82];

    protected $activity_rows= [4,19];

    /**
     * @param Request $request
     * @return mixed
     */
    public function doUploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $ext            = $file->getClientOriginalExtension();
            $orginalName    = $file->getClientOriginalName();

            $getFile        = Files::getFirst(['original_filename'=>$orginalName]);

            if ( !empty($getFile) ) {
                return Response::json([
                    'success'   => false,
                    'type'      => 'danger',
                    'message'   => 'File exit'
                ]);
            }

            $fileName       = time();
            $newFileName    = $fileName.'.'.$ext;

            $request->file('file')->move(public_path() . '/uploads/rides/', $newFileName);

            if ( strtolower($ext) == 'fit' ) {
                exec('java -jar '.APPLICATION_PATH.'/resources/sdk/java/FitCSVTool.jar -b '.APPLICATION_PATH.'/public/uploads/rides/' . $newFileName.' '.APPLICATION_PATH.'/public/uploads/rides/' .$fileName.'.csv' );
            }

            $path   =   public_path().'/uploads/rides/'.$fileName.'_data.csv';
            $csv    =   Reader::createFromPath($path);
            $data   =   $csv->fetchAll();
            unset($data[0]);
            $total_rows = count($data);


            $model = Files::add([
                'user_id'           => Session::get('user_id'),
                'filename'          => $fileName,
                'original_filename' => $orginalName,
                'path'              => '/rides/'.$newFileName,
                'ext'               => $ext,
                'session_timestamp' => $data[$total_rows-2][54],
                'total_elapsed_time'=> $data[$total_rows-2][57],
                'start'             => Carbon::createFromTimeStamp( Data::timeToUnix($data[$total_rows-2][54]))->toDateTimeString(),
                'end'               => Carbon::createFromTimeStamp( Data::timeToUnix($data[$total_rows-2][54] + $data[$total_rows-2][57]))->toDateTimeString(),
            ]);

            UploadParsing::add(['file_id'   => $model->id,'total_count'=>$total_rows]);

            return Response::json([
                'id'        => $model->id,
                'status'    => 'NEW',
                'date'      => date('d.m.y',strtotime($model->start)),
                'time'      => date('H:i',strtotime($model->start)).'-'.date('H:i',strtotime($model->end))
            ],200);



        }
    }

    /**
     * Processing Parse
     * @param Request $request
     */
    public function processing(Request $request)
    {

        foreach ($request->input('cc') as $fileId) {

            $file = Files::getDetails($fileId);

            if (  !empty($file) || $file->completed_all == 'N' ) {
                switch($file->ext)
                {
                    case 'fit':
                        $this->parseFit($file);
                        break;
                }
            }
        }
    }

    /**
     * Parse Fit File
     * @param $file
     */
    public function parseFit($file)
    {
        $path   =   public_path().'/uploads/rides/'.$file->filename.'.csv';
        $csv    =   Reader::createFromPath($path);
        $data   =   $csv->fetchAll();
        $header =   $data[0];
        unset($data[0]);

        $uploadPprogress = UploadParsing::where('file_id',$file->id)->first();
        $total           = $uploadPprogress->total_count;

        $i = 1;
            foreach ($data as $lineIndex => $row) {

                $data_insert = [];

                if ( $row[0] == 'Data' ) {

                    if ( $row[2] == 'event') {
                        $data_insert = $this->getFields($this->event_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
                        Event::create($data_insert);
                    }

                    if ( $row[2] == 'record') {
                        $data_insert = $this->getFields($this->records_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
                        Record::add($data_insert);
                    }

                    if ( $row[2] == 'device_info') {
                        $data_insert = $this->getFields($this->device_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
                        DeviceInfo::create($data_insert);
                    }

                    if ( $row[2] == 'lap') {
                        $data_insert = $this->getFields($this->lap_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
                        Lap::add($data_insert);
                    }

                    if ( $row[2] == 'session' ) {
                        $data_insert = $this->getFields($this->session_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
                        SessionDevice::add($data_insert);
                    }

                    if ($row[2] == 'activity') {
                        $data_insert = $this->getFields($this->activity_rows, $row);
                        $data_insert['file_id'] = $file->id;
                        $data_insert['user_id'] = Session::get('user_id');
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
                }

                $i++;
            }

    }

    protected function parseGpx()
    {

    }

    protected function parseTcx()
    {

    }

    protected function parseCsv()
    {

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
