<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\ActivityFeed;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ActivityFeedController extends Controller {

    protected $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index()
    {
        return Response::json([
            'feed' => ActivityFeed::getUserAsideFeed($this->user->id)
        ],200);
    }

}
