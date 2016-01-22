<?php namespace App\Http\Controllers\Users;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session, Response;
use App\Models\Files;
use Carbon\Carbon;
use Iamstuartwilson\StravaApi;



class UsersController extends Controller {

	public function __construct()
    {

    }

    /**
     * API get details current User
     * @return json
     */
    public function current()
    {
        $user = Auth::client()->user();

        $package = Package::find($user->package_id);

        return Response::json([
            'user'  => [
                'name'      => $user->name,
                'last_name'      => $user->last_name,
                'email'     => $user->email,
                'username'  => $user->username,
                'nickname'  => $user->nickname, // athlete name
                'zip'       => $user->zip,
                'dob'       => date('m/d/Y',strtotime($user->dob)),
                'gender'    => $user->gender,
                'status'    => !empty($package) ? $package->title : '',
                'member'    => date("F j, Y",strtotime($user->created_at)),
                'power'     => $user->power,
                'heart_rate'=> $user->heart_rate,
                'height_ft' => $user->height_ft,
                'height_inc'=> $user->height_inc,
                'height_m'  => $user->height_m,
                'height_cm' => $user->height_cm,
                'weight_kg' => $user->weight_kg,
                'weight'    => $user->weight,
                'units'     => $user->units,
                'body_fat'     => $user->body_fat,
                'level'     => $user->level
            ]
        ],200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $user = Auth::client()->user();

        if ( $request->input('field') == 'nickname' && $user->nickname != $request->input('value') ) {
            $nickname = User::getFirst(['nickname'=>$request->input('value')]);
            if ( !empty($nickname) ) {
                return Response::json([
                    'type'    => 'danger',
                    'message' => 'Nickname already exist'
                ],404);
            }
            $user->nickname = $request->input('value');
            $user->save();
            return Response::json([
                'type'      =>'success',
                'message'   =>'Success'
            ],200);
        }

        if ( $request->input('field') == 'email' && $user->email != $request->input('value') ) {
            $oldEmail = $user->email;
            $check = User::getFirst(['email'=>$request->input('value')]);
            if ( !empty($check) ) {
                return Response::json([
                    'type'      => 'danger',
                    'message'   => 'Email already exist'
                ],404);
            }
            $user->email = $request->input('value');
            $user->save();

            \DB::connection('mysql_forum')
                ->table('zzBB_users')
                ->where('username', $oldEmail)
                ->update([
                    'username' => $user->email,
                    'user_email' => $user->email
                ]);

            return Response::json([
                'type'      =>'success',
                'message'   =>'Success'
            ],200);
        }

        if ($request->input('field') =='dob') {
            //todo check date
            $user->dob = ($request->input('value')) ? date('Y-m-d',strtotime($request->input('value'))) : '0000-00-00';
            $age = Carbon::createFromFormat('m/d/Y',$request->input('value'))->age;
            $user->age = $age;
            $user->save();
            return Response::json([
                'type'      =>'success',
                'message'   =>'Success'
            ],200);
        }

        if ( $request->input('field') == 'password' && $request->input('value')) {
            $user->password = bcrypt($request->input('value'));
            $user->save();
            return Response::json([
                'type'      =>'success',
                'message'   =>'Success'
            ],200);
        }

        $user->{$request->input('field')} = $request->input('value');
        $user->save();

        return Response::json([
            'type'      =>'success',
            'message'   =>'Success'
        ],200);
        
        


    }



}
