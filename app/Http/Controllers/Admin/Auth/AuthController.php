<?php namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\AdminAuthRequest;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('adminauth');
    }

    public function getLogin()
    {
        return view('admin/auth/login');
    }

    public function postLogin(AdminAuthRequest $request)
    {
        if (Auth::admin()->attempt(['email' => Request::input('email'), 'password' => Request::input('password')], Request::input('remember'))) {
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->back()->withErrors('Invalid email or password');
        }
    }

    public function getLogout()
    {
        Auth::admin()->logout();
        return redirect('/admin/auth/login');
    }

}
