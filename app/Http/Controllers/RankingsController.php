<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lap;
use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Session;
class RankingsController extends Controller {

	private $user;

	public function __construct()
	{
		$this->user = Auth::client()->user();
	}

	/**
	 * @return Response
	 */
	public function index(Request $request)
	{
        $rankings = Lap::getRankings($request,$this->user);   
        return $rankings;
	}

	/**
	 * @return Response
	 */
	public function getUserPSST(Request $request)
	{	
        $PSST = Lap::getStatisticsRight($request->get('id'),$request->get('days'));   
        return $PSST;
	}

}
