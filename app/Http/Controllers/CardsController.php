<?php namespace App\Http\Controllers;

use App\Http\Requests;
use DB;

use App\Models\Cards;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CardsController extends Controller {

    protected $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

	public function index()
    {
        $cards = Cards::select(
                            'cards.*',
                            DB::raw('IF(users_cards.id,1,0) as available')
                            )
                            ->leftJoin('users_cards',function ($join) {
                                $join->on('cards.id','=','users_cards.cards_id')
                                    ->where('users_cards.user_id', '=', $this->user->id);
                            })
                            ->where('cards.icon_grey','<>','')
                            ->get()->toArray();


        $cardsClear = [];
        foreach ($cards as $n=>$c) {
            if ($this->user->cards_id == $c['id']) {
                $c['available'] = 1;
            }
            $c['available'] = (int)$c['available'];
//            $c['path_grey'] = 'grey_'.$c['path'];
            $cardsClear[$n] = $c;

            $cardsClear[$n]["source"] = Cards::getSource($c["source"]);
        }

        return Response::json([
            'cards' => $cardsClear,
            'card'  => $this->user->cards_id
        ],200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $user = User::find($this->user->id);
        $user->cards_id = $request->input('id');
        $user->save();

        return Response::json(null,204);

    }

}
