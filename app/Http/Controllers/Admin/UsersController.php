<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Models\RaceCategories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller {


    /**
     * List of users
     * @return $this
     */
    public function index()
    {
        if (Input::has('s')) {
            $users = User::where('username', 'like', '%' . Input::get('s') . '%')
                        ->orWhere('name', 'like', '%' . Input::get('s') . '%')
                        ->orWhere('email', 'like', '%' . Input::get('s') . '%')
                        ->orWhere('id', 'like', '%' . Input::get('s') . '%')
                        ->paginate(30);
        } else {
            $users = User::paginate(30);
        }
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Get user
     * @param $user_id
     * @return $this
     */
    public function edit($user_id)
    {
        $user           = User::find($user_id);
        $packages       = Package::all();
        $race_category  = RaceCategories::find($user->category_id);
        return view('admin/users/edit',compact('user','race_category','packages'));
    }
    /**
     * Add new user
     * @return \Illuminate\View\View
     */
    public function add()
    {
        $packages       = Package::all();
        return view('admin/users/add', compact('packages'));
    }


    public function save($user_id = null)
    {
        if ( $user_id ) {
            $user   = User::find($user_id);
            $msg    = 'User has been updated';
        } else {
            $user   = new User();
            $msg    = 'User has been created';
        }

        $rules ['email']    = 'required|email';

        $rules['package']   = 'required';

        if ( $user->last_name != Input::get('last_name') ) {
            $user->last_name = Input::get('last_name');
        }

        if ( $user->email != Input::get('email') ) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        if ( $user_id ) {
            $rules['nickname']  = 'required';
            $rules['gender']    = 'required';
            if ( $user->nickname != Input::get('nickname') ) {
                $rules['nickname'] = 'required|max:12|min:2|unique:users|alpha';
            }
        } else {
            $rules['password'] = 'required|min:8|confirmed';
        }

        if ( Input::get('zip') ) {
            $rules['zip'] = 'required|integer|digits:5';
        }

        if ( Input::get('password') ) {
            $rules['password'] = 'required|min:8|confirmed';
        }
        if ( Input::get('password') ) {
            $rules['password'] = 'required|min:8|confirmed';
        } 

        $rules['dob'] = 'required|date|date_format:m/d/Y';  
                    

        $validator = Validator::make(Input::all(),$rules);

        if ($validator->passes()) {
            if ( $user_id ) {
                $raceCategory = RaceCategories::where('level','<=',Input::get('level'))
                    ->orderBy('level','DESC')
                    ->first();
                if($raceCategory) {$user->category_id = $raceCategory->id;}
            }
            if (Input::get('dob') ) {
                $user->dob = (Input::get('dob')) ? date('Y-m-d',strtotime(Input::get('dob'))) : '0000-00-00';
                $age = Carbon::createFromFormat('m/d/Y',Input::get('dob'))->age;
                $user->age = $age;
            }


            $user->email       = Input::get('email');

            if ( $user_id) {
                $user->nickname    = Input::get('nickname');
            }
            $user->name        = Input::get('name');           
            $user->level       = Input::get('level') ? Input::get('level') : 1;
            $user->package_id  = Input::get('package');
            $user->gender      = Input::get('gender') ? Input::get('gender') : 'm';
            $user->zip         = Input::get('zip') ? Input::get('zip') : '';

            if ( Input::get('password') ) {
                $user->password = bcrypt(Input::get('password'));
            }

            $user->save();

            Session::flash('notification',['type'=>'success','msg'=>$msg]);
            return redirect('admin/users/edit/' . $user->id);

        } else {

            $messages = $validator->messages();
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }

    /**
     * Ban an user
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ban($user_id)
    {
        try {
            $user = User::find($user_id);
            $user->banned = 1;
            $user->save();
            Session::flash('notification',['type'=>'success','msg'=>'User has been updated']);
        }
        catch (\Exception $e) {

        }
        return redirect()->back();
    }

    /**
     * Unban a user
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unban($user_id)
    {
        try {
            $user = User::find($user_id);
            $user->banned = 0;
            $user->save();
            Session::flash('notification',['type'=>'success','msg'=>'User has been updated']);
        }
        catch (\Exception $e) {

        }
        return redirect()->back();
    }


    public function delete($user_id)
    {

        $user = User::find($user_id);

        if ( $user ) {
            $user->delete();
        }

        Session::flash('notification', ['type'=>'success','msg'=>'User has been deleted']);

        return redirect()->back();
    }
}

