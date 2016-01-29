<?php namespace App\Http\Controllers;

use App\Models\Achievements;
use App\Models\AchievementsUsers;
use App\Models\Cards;
use App\Models\Levels;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Session;
class HomeController extends Controller {


	public function __construct()
	{
      
	}

	/**
	 * @return Response
	 */
	public function index()
	{
		echo Auth::client()->user()->id;
		die;
		return view('home',User::getUserProfileInfo(Auth::client()->user()->id));
	}

}
