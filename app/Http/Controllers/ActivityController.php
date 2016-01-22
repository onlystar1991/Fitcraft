<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Models\Lap;

class ActivityController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index(Request $request)
    {
        $page = (int)$request->input('page');
        $result = (new Lap())->getActivity($this->user,$page);
        return Response::json($result,200);
    }

}
