<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cards;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CardsController extends Controller {



    /**
     * List of cards
     * @return $this
     */
    public function index()
    {
        if (Input::has('s')) {
            $cards = Cards::where('title', 'like', '%' . Input::get('s') . '%')
                        ->paginate(30);
        } else {
            $cards = Cards::paginate(30);
        }
        return view('admin.cards.index')->with('cards', $cards);
    }

    /**
     * Get card
     * @param $card_id
     * @return $this
     */
    public function edit($card_id)
    {
        $card = Cards::find($card_id);
        return view('admin.cards.edit',compact('card'))->with('sources', Cards::$sources);
    }

    /**
     * Add new card
     * @return \Illuminate\View\View
     */
    public function add()
    {
        return view('admin.cards.add')->with('sources', Cards::$sources);
    }

    public function delete($card_id)
    {
        if ( $card = Cards::find($card_id) ) {
            $card->delete();
        }
        Session::flash('notification', ['type'=>'success','msg'=>'Card has been deleted']);

        return redirect()->back();
    }

    public function save($card_id = null)
    {
        if ( $card_id ) {
            $card   = Cards::find($card_id);
            $msg    = 'Card has been updated';
        } else {
            $card   = new Cards();
            $msg    = 'Card has been created';
        }

        $rules['title']   = 'required';
        $validator = Validator::make(Input::all(),$rules);

        if ($validator->passes()) {
            $card->achievement_id = Input::get('achievement_id');
            $card->title          = Input::get('title');
            $card->source     = Input::get('source');
            $card->difficulty     = Input::get('difficulty');
            $card->path     = Input::get('icon_art_card');

            if(!empty(Input::get('icon_art_card')))
            $card->path_grey     = 'grey_'.Input::get('icon_art_card');

            $card->icon     = Input::get('icon_card');
            if(!empty(Input::get('icon_card'))){
                $card->icon_grey     = 'grey_'.Input::get('icon_card');
            }else{
                $card->icon_grey     = '';
            }

            $card->save();

            Session::flash('notification',['type'=>'success','msg'=>$msg]);
            return redirect('admin/cards/edit/' . $card->id);

        } else {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }

}

