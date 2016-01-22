<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Administrators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdministratorsController extends Controller {


    /**
     * List of admins
     * @return $this
     */
    public function index()
    {
        if (Input::has('s')) {
            $admins = Administrators::where('full_name', 'like', '%' . Input::get('s') . '%')->orWhere('email', 'like', '%' . Input::get('s') . '%')->paginate(30);
        } else {
            $admins = Administrators::paginate(30);
        }
        return view('admin/admins/index',compact('admins'));
    }

    /**
     * Edit a admin
     * @param $admin_id
     * @return \Illuminate\View\View
     */
    public function edit($admin_id)
    {
        $user = Administrators::find($admin_id);

        return view('admin/admins/edit',compact('user'));
    }

    /**
     * Add new admin
     * @return \Illuminate\View\View
     */
    public function add()
    {
        return view('admin/admins/add');
    }

    /**
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save($user_id = null)
    {
        if ( $user_id ) {
            $user = Administrators::find($user_id);
        } else {
            $user = new Administrators();
        }

        $rules['name']   = 'required';
        $rules ['email'] = 'required|email';

        if ( $user->email != Input::get('email') ) {
            $rules['email'] = 'required|email|unique:administrators,email';
        }

        if ( Input::get('password') ) {
            $rules['password'] = 'required|min:8|confirmed';
        }elseif (!$user_id) {
            $rules['password'] = 'required|min:8|confirmed';

        }

        $validator = Validator::make(Input::all(),$rules);

        if ($validator->passes()) {

            $user->name     = Input::get('name');
            $user->email    = Input::get('email');

            if ( Input::get('password') ) {
                $user->password = bcrypt(Input::get('password'));
            }

            $user->save();
            Session::flash('notification',['type'=>'success','msg'=>'Administrator has been created']);
            return redirect('admin/admins/edit/' . $user->id);
        } else {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }

    /**
     * Remove a admin
     * @param $admin_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($admin_id)
    {
        if ($admin_id == Auth::admin()->user()->id) {
            return redirect()->back();
        }

        $admin = Administrators::find($admin_id);
        if ($admin) {
            $admin->delete();
        }

        Session::flash('notification', ['type'=>'success','msg'=>'Administrator has been deleted']);

        return redirect()->back();
    }

}
