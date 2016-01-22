<?php namespace App\Http\Controllers;

use App\BikeCraft\Achievements;
use App\BikeCraft\Achievements\AchievementsAnalysis;
use App\BikeCraft\Analysis;
use App\BikeCraft\Processing;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Levels;
use app\Models\Rides;
use App\Models\StravaParsings;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Response;
use Session;

use App\Models\UploadParsing;

class UploadController extends Controller {

    /**
     * Upload File
     * @param Request $request
     * @param Processing $processing
     * @return mixed
     */
    public function file(Request $request, Processing $processing)
    {
        return $processing->doUpload($request);
    }

    /**
     * Processing Data
     * @param Request $request
     * @param Processing $processing
     * @param Analysis $analysis
     * @param AchievementsAnalysis $achievementsAnalysis
     * @return mixed
     */
    public function processing(
                                Request $request,
                                Processing $processing,
                                Analysis $analysis,
                                AchievementsAnalysis $achievementsAnalysis)
    {
            $indoor = $request->input('indoor',false);

            $user = Auth::client()->user();

            if ( empty($user->weight ) || empty($user->age) || empty($user->heart_rate) || empty($user->power) ) {
                return Response::json([
                    'message'   => 'Please fill your Advanced Options from the Account Setup menu.'
                ],400);
            }

            $file = Files::find($request->input('id'));

            if (  !empty($file) || $file->completed_all == 'N' ) {
                //insert in db
                $processing->doProcessing($file);
                //calculate xp, bonus...
                $analysis->partitionData($file);

                //achievements
                $achievementsAnalysis->doProcessing($file);

                $ride       = Rides::where('file_id',$file->id)->first();
                $ride->name = $request->input('title');
                $ride->save();
            }

            $user       = User::find($user->id);
            $levels     = Levels::where('level',$user->level)->first();

            return Response::json([
                'user'  => [
                    'level'     => $user->level,
                    'progress'  => $user->xp / $levels->xp_required * 100
                ]
            ],200);


    }

    /**
     * Get progress
     * @param Request $request
     * @return float
     */
    public function progress(Request $request)
    {
        $total_count        = 0;
        $completed_count    = 0;

//        if ($request->input('type') == 'strava' ) {
//            foreach ($request->input('cc') as $fileId) {
//                $stravaParsings      = StravaParsings::where('activities_id','=',$fileId)->first();
//                $total_count        += isset($stravaParsings->total_count) ? $stravaParsings->total_count : 1;
//                $completed_count    += isset($stravaParsings->completed_count) ? $stravaParsings->completed_count : 1;
//            }
//        }


        $uploadParsing      = UploadParsing::where('file_id','=',$request->input('id'))->first();
        $total_count        += $uploadParsing->total_count;
        $completed_count    += $uploadParsing->completed_count;

        if ( $total_count != 0) {
            $progress = floor($completed_count / $total_count * 100);
        }
        return $progress;
    }




}
