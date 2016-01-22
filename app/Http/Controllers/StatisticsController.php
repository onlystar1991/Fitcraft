<?php namespace App\Http\Controllers;

use App\Models\Statistics;
use App\Models\Lap;
use App\Models\User;
use App\Http\Requests;
use App\BikeCraft\UserXP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Session;
class StatisticsController extends Controller {

	private $user;

	public function __construct()
	{
		$this->user = Auth::client()->user();
	}

    /**
     * @param Request $request
     * @param UserXP $userXP
     * @return Response
     */
	public function index(Request $request,UserXP $userXP)
	{
		$user_id	= ($request->get('user_id')>0?$request->get('user_id'):$this->user->id);        
		$user		= User::getFirst(['id'=>$user_id]);
		$userXP->calculateFTP($user);
		$ftp		= $userXP->getFtp();
		$statistics	= Lap::getStatistics($user_id,$request->get('filter'),$ftp);   
        return $statistics;
	}

}
