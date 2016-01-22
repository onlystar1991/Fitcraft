<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Models\UsersTutorial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lesson = $request->get('lesson');

        if(!empty($lesson)){
            $user_tutorial = UsersTutorial::where('user_id', $this->user->id)->first();
            if(empty($user_tutorial)){
                UsersTutorial::create(['user_id' => $this->user->id, $lesson=>1 ]);
                $tutorial = new UsersTutorial();
                $tutorial->user_id = $this->user->id;
                $tutorial->{$lesson} = 1;
                $tutorial->save();
            }else{
                if(isset($user_tutorial->{$lesson})){
                    $user_tutorial->{$lesson} = 1;
                    $user_tutorial->save();
                }else{
                    return Response::json([
                        'status'  => 'error'
                    ],400);
                }
            }
            return Response::json([
                'status'  => 'ok'
            ],200);
        }else{
            return Response::json([
                'status'  => 'error'
            ],400);
        }

    }

    public function index()
    {
        return $tutorial = UsersTutorial::where('user_id', $this->user->id)->first();
    }

}
