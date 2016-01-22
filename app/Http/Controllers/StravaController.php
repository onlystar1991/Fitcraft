<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\StravaUsers;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Iamstuartwilson\StravaApi;

class StravaController extends Controller {

    protected $strava;

    public function __construct()
    {
        //StravaAPI connect
        $this->strava = new StravaApi(
                            config('strava.clientId'),
                            config('strava.clientSecret')
                        );
    }

    /**
     * URL Login ( for angular )
     * @return mixed
     */
    public function index()
    {
        $stravaLogin = $this->strava->authenticationUrl(config('strava.redirectUri'), $approvalPrompt = 'auto', $scope = null, $state = null);
        return $stravaLogin;
    }

    /**
     * After Login
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $tokenExchange  = $this->strava->tokenExchange($request->get('code'));
        $accessToken    = $tokenExchange->access_token;
        $this->strava->setAccessToken($accessToken);

        Session::put('stravaToken', $accessToken);
        Session::flash('stravaLogin', 1);

        $athlete = $this->strava->get('athlete');

        $user = StravaUsers::getFirst(['strava_id'=>$athlete->id]);

        if ( !empty($user) ) {
            return Redirect::to('/');
        }

        StravaUsers::add([
                        'user_id'   => Session::get('user_id'),
                        'strava_id' => $athlete->id,
                        'firstname' => $athlete->firstname,
                        'lastname'  => $athlete->lastname,
                        'sex'       => $athlete->sex,
                        'email'     => $athlete->email
                    ]);

        return Redirect::to('/');

    }

    /**
     *testing
     */
    public function activities()
    {
        $this->strava->setAccessToken(Session::get('stravaToken'));
//        $activities = $this->strava->get('activities');
        var_dump($this->strava->get('athlete'));
//        $activities = $this->strava->get('activities/281066976');
//        var_dump($activities->segment_efforts[0]);
        /*
        foreach( $activities->segment_efforts as $segment) {
            var_dump($segment);
        }*/
//        var_dump($activities);
    }

}
