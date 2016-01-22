<?php namespace App\Http\Controllers\Auth;

use App\BikeCraft\Achievements\Career;
use App\BikeCraft\Achievements\Legacy;
use App\BikeCraft\UserXP;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAuthRequest;
use App\Models\Achievements;
use App\Models\AchievementsCriteria;
use App\Models\Awards;
use App\Models\UsersAwards;
use App\Models\UsersSeason;
use App\Models\UsersTutorial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use App\Models\Cards;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\UsersCards;
use Geocoder;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('client.auth');
    }

    /**
     * Get login page
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth/login');
    }


    /**
     * @param ClientAuthRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(ClientAuthRequest $request)
    {
        if (Auth::client()->attempt(['nickname' => Request::input('email'), 'password' => Request::input('password'), 'banned' => 0], Request::input('remember'))
            or
            Auth::client()->attempt(['email' => Request::input('email'), 'password' => Request::input('password'), 'banned' => 0], Request::input('remember'))
        ) {
            $ckname = Auth::client()->getRecallerName();
            Cookie::queue($ckname, Cookie::get($ckname), 20160);
            return redirect()->intended('/');
        } elseif (Auth::client()->attempt(['nickname' => Request::input('email'), 'password' => Request::input('password'), 'banned' => 1], Request::input('remember'))
            or
            Auth::client()->attempt(['email' => Request::input('email'), 'password' => Request::input('password'), 'banned' => 1], Request::input('remember'))
        ) {
            Auth::client()->logout();
            return redirect()->back()->withErrors('Your account was blocked');
        } else {
            return redirect()->back()->withErrors('Invalid email/nickname or password');
        }
    }

    /**
     * Get Register
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        $cards = Cards::getWhere(['achievement_id' => 0]);
        return view('auth.register', compact('cards'));
    }

    /**
     * Chek Email
     * @return \Illuminate\View\View
     */
    public function postCheckEmail()
    {
        $getUser = User::getFirst(['email' => Request::input('email')]);
        if ($getUser) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * Chek Email
     * @return \Illuminate\View\View
     */
    public function postCheckNickname()
    {
        $validator = Validator::make(
            array('nickname' => Request::input('nickname')),
            array('nickname' => 'required|max:12|min:2|unique:users|alpha')
        );

        if (Request::input('nickname') && !$validator->fails()) {
            $getNickname = User::getFirst(['nickname' => Request::input('nickname')]);
            if ($getNickname) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            echo "false";
        }

    }

    /**
     * Chek Email
     * @param Career $career
     * @return \Illuminate\View\View
     */
    public function postRegister(Career $career, Legacy $legacy, UserXP $userXP, UsersTutorial $tutorial)
    {
        $user = new User();
        $user->name = Request::input('first_name');
        $user->last_name = Request::input('last_name');
        $user->password = bcrypt(Request::input('password'));
        $user->email = strtolower(Request::input('email'));
        $user->height_inc = Request::input('inch');
        $user->height_ft = Request::input('ft');
        $user->weight = Request::input('lbs');
        $user->zip = (int)Request::input('zip');
        $user->height_m = IncToM(Request::input('ft'), Request::input('inch'));
        $user->height_cm = IncToCm(Request::input('ft'), Request::input('inch'));
        $user->weight_kg = LbsToKg(Request::input('lbs'));
        $user->gender = Request::input('gender');
        $user->nickname = strtolower(Request::input('athlete_name'));
        $user->age = Carbon::createFromFormat('Y-m-d', Request::input('year') . '-' . Request::input('month') . '-' . Request::input('day'))->age;
        $user->dob = Request::input('year') . '-' . Request::input('month') . '-' . Request::input('day');
        $user->package_id = 3;
        $user->units = 'imperial';
        $user->body_fat = Request::input('body_fat');


        $card_man = Cards::select('id')->where('source','=','default_male')->first();

        $card_girl = Cards::select('id')->where('source','=','default_female')->first();
        if($user->gender=='m'){
            if($card_man){
                $user->cards_id = $card_man->id;
            }
        }else{
            if($card_girl){
                $user->cards_id = $card_girl->id;
            }
        }

        $user->save();

        $userXP->calculateFTP($user);
        $userXP->calculateLTHR($user->age);

        $user->power = $userXP->getFtp();
        $user->heart_rate = $userXP->getLthr();


        //set country
        $user->country = 'United States';
        //create new user
        $user->save();

        //set for tutorial
        $tutorial->user_id = $user->id;
        $tutorial->save();

        $default_cards = Cards::select('id')
            ->where('source','=','default_male')
            ->orWhere('source','=','default_female')
            ->get();

        if(!empty($default_cards)){
            foreach($default_cards as $default_card){
                $userscards           = new UsersCards();
                $userscards->user_id  = $user->id;
                $userscards->cards_id = $default_card->id;
                $userscards->save();
            }
        }

        $default_gears = Awards::select('id')
            ->where('source','=','default_gear_male')
            ->orWhere('source','=','default_gear_female')
            ->get();

        if(!empty($default_gears)){
            foreach($default_gears as $default_gear){
                $userswards           = new UsersAwards();
                $userswards->user_id  = $user->id;
                $userswards->awards_id = $default_gear->id;
                $userswards->save();
            }
        }

        Auth::client()->login($user);


        $userSeason = new UsersSeason();

        $userSeason->user_id = $user->id;
        $userSeason->start = date('Y-m-d H:i:s');
        $userSeason->end = date('Y-m-d H:i:s', strtotime('+365 days', strtotime(date('Y-m-d H:i:s'))));
        $userSeason->save();

        return redirect('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        Auth::client()->logout();
        return redirect('auth/login');
    }

}
