<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Iamstuartwilson\StravaApi;

use App\BikeCraft\Data;
use Carbon\Carbon;

class TestController extends Controller {
	public function  stravaLogin()
    {
        echo \App\BikeCraft\Data::showDate('2012-10-14 15:19:26');
        return 'x';
        echo  Carbon::createFromTimeStamp( Data::timeToUnix(744049946))->toDateTimeString();
        echo '<br/>';
        echo  Carbon::createFromTimeStamp( Data::timeToUnix(744049946+378139.402))->toDateTimeString();

        return 'x';
        $api = new StravaApi(
            5497,
            'b98dadeb26b58e51120e65c9560d69e5bc451745'
        );
        $redirect = 'http://homestead.app/login-strava';
       echo $api->authenticationUrl($redirect, $approvalPrompt = 'auto', $scope = null, $state = null);
    }

    public function getstravaLogin(Request $request)
    {
        $api = new StravaApi(
            5497,
            'b98dadeb26b58e51120e65c9560d69e5bc451745'
        );
        $test = $api->tokenExchange($request->get('code'));
        $accessToken = $test->access_token;
        $api->setAccessToken($accessToken);
//        var_dump($api);
        var_dump($api->get('athlete'));
//        var_dump($api->get('athlete/activities'));
//        var_dump($api->get('activities/:id',[281051768]));
//        var_dump($api->get('segments/:id',[229781]));
    }

}
