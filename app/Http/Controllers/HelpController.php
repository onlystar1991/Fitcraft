<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Mail;
use Config;

class HelpController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index(Request $request)
    {
        $text = trim($request->input('text'));
        $type = trim($request->input('type'));
        $user = $this->user;
        $helpTypes = [
            'help' => 'Help request from '.$user->username,
            'bug' => 'Bug report from '.$user->username
        ];

        if (isset($helpTypes[$type])) {
            if ($text) {
                Mail::send('emails.help', compact('user','text'), function($message) use ($helpTypes,$type)
                {
                    $to = Config::get('mail.to')[APPLICATION_ENV];
                    $message->to($to, 'Fitcraft')->subject($helpTypes[$type]);
                });
            } else {
                return Response::json([
                    'message'   => 'Empty text not allowed'
                ],400);
            }
        } else {
            return Response::json([
                'message'   => 'Not correct type'
            ],400);
        }
    }

}
