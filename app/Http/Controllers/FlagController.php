<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Rides;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Mail;
use Config;

class FlagController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index(Request $request)
    {
        $type = trim($request->input('type'));
        $user_id = trim($request->input('user_id'));
        $ride_id = trim($request->input('ride_id'));
        $user = $this->user;

        if (is_numeric($user_id)) {
            if ($user_bad = User::find($user_id)) {
                $flagTypes = [
                    'user_cheating' => 'User cheating report from '.$user->username,
                    'user_conduct' => 'User conduct report from '.$user->username,
                    'ride_cheating' => 'Ride cheating report from '.$user->username,
                    'ride_data' => 'Ride inaccurate data report from '.$user->username,
                ];

                if (isset($flagTypes[$type])) {
                    $ride = null;

                    if (is_numeric($ride_id)) {
                        if (in_array($type,['ride_cheating','ride_data'])) {
                            if (!$ride = Rides::find($ride_id)) {
                                return Response::json([
                                    'message'   => 'Ride id not correct'
                                ],400);
                            }
                        } else {
                            return Response::json([
                                'message'   => 'Not correct type but ride_id sent'
                            ],400);
                        }
                    } elseif (!in_array($type,['user_cheating','user_conduct'])) {
                        return Response::json([
                            'message'   => 'Not correct type but ride_id not sent'
                        ],400);
                    }

                    Mail::send('emails.flag', compact('user','user_bad','ride','type'), function($message) use ($flagTypes,$type)
                    {
                        $to = Config::get('mail.to')[APPLICATION_ENV];
                        $message->to($to, 'Fitcraft')->subject($flagTypes[$type]);
                    });

                    return Response::json([],200);
                } else {
                    return Response::json([
                        'message'   => 'Not correct type'
                    ],400);
                }
            } else {
                return Response::json([
                    'message'   => 'User id not correct'
                ],400);
            }
        } else {
            return Response::json([
                'message'   => 'User id not set'
            ],400);
        }
    }

}
