<?php namespace App\Http\Controllers\Users;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {


	public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::client()->attempt($credentials, $request->input('remember')))
        {
            return response(['msg' => 'Login Successfull'], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
        return response(['msg' => 'Wrong username or password'], 400)
                        ->header('Content-Type', 'application/json');
    }

}
