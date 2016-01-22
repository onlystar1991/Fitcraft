<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\UsersAwards;

use App\Models\Awards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AwardsController extends Controller {

    protected $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index()
    {
        $gears = Awards::getUserAwards($this->user->id);

        foreach($gears as $key=>$gear){
            $gears[$key]["source"] = Awards::getSource($gear["source"]);
        }

        return Response::json([
            'awards' =>$gears
        ],200);
    }

    public function save(Request $request)
    {
        $awards_id = $request->input('awards_id');
        if (is_numeric($awards_id)) {
            $top = ($request->input('top'))?1:0;
            UsersAwards::where('awards_id','=',$awards_id)
                ->where('user_id','=',$this->user->id)->update([
                    'top' => $top
                ]);
            return Response::json(null,200);
        } else {
            return Response::json(null,400);
        }

    }

    public function order(Request $request)
    {
        if ($order = $request->input('order')) {
            foreach ($order as $row) {
                if (isset($row['id']) && is_numeric($row['id']) && isset($row['order']) && is_numeric($row['order']) && isset($row['top']) && is_numeric($row['top'])) {
                    UsersAwards::where('awards_id','=',$row['id'])
                        ->where('user_id','=',$this->user->id)->update([
                            'order' => $row['order'],
                            'top' => $row['top']
                        ]);
                }
            }
            return Response::json(null,200);
        } else {
            return Response::json(null,400);
        }

    }

}
