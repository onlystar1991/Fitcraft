<?php namespace App\Http\Controllers\Users;

use App\BikeCraft\Data;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Files;
use App\Models\StravaActivities;
use Illuminate\Support\Facades\Auth;
use Session;
use Response;
use Iamstuartwilson\StravaApi;
use Carbon\Carbon;

class FilesController extends Controller {

    public function __construct()
    {

    }

    /**
     * Get List of files Modal Popup Upload
     * @return mixed
     */
    public function index()
	{
        //StravaAPI connect
        $strava = new StravaApi(
                    config('strava.clientId'),
                    config('strava.clientSecret')
                );


        $files = Files::getListWithStatus(Auth::client()->user()->id);

        if ( !empty($files) ) {
            foreach ($files as $file) {
                $file->completed    = $file->status == 'Y' ? true : false;
                $file->status       = ($file->status == 'Y') ? 'UPLOADED' : 'NEW';
                $file->date         = Data::showDate($file->start);
                $file->time         = Data::sessionTimeStartEnd($file->start, $file->end);
            }
        }

        $upload_strava = [];

        if ( Session::get('stravaToken') ) {
            $strava->setAccessToken(Session::get('stravaToken'));
            $activities = $strava->get('athlete/activities');

            if ( !empty($activities) ) {
                foreach($activities as $activity) {
                    $end_date = strtotime($activity->start_date) + $activity->elapsed_time;
                    $end_date = Carbon::createFromTimeStamp($end_date)->toDateTimeString();
                    $status = StravaActivities::where(['activities_id'=>$activity->id,'completed_all'=>'Y'])->first();
                    $upload_strava[] = [
                        'id'        => $activity->id,
                        'completed' => !isset($status) ?  false : true,
                        'status'    => !isset($status) ? 'NEW' : 'UPLOADED',
                        'date'      => Data::showDate($activity->start_date),
                        'time'      => Data::sessionTimeStartEnd($activity->start_date, $end_date)
                    ];
                }
            }

        }
//        Carbon::createFromTimeStamp( Data::timeToUnix($data[$total_rows-2][54] + $data[$total_rows-2][57]))->toDateTimeString()


			return Response::json([
                'files' => $files,
                'strava'=> $upload_strava
            ],200);
	}

}
