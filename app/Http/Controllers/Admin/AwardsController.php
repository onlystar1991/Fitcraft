<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Awards;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;

class AwardsController extends Controller {

    /**
     * List of awards
     * @return $this
     */
    public function index()
    {
        if (Input::has('s')) {
            $awards = Awards::where('title', 'like', '%' . Input::get('s') . '%')
                        ->paginate(30);
        } else {
            $awards = Awards::paginate(30);
        }
        return view('admin.awards.index')->with('awards', $awards);
    }

    /**
     * Get award
     * @param $award_id
     * @return $this
     */
    public function edit($award_id)
    {
        $award = Awards::find($award_id);
        return view('admin.awards.edit',compact('award'))->with('sources', Awards::$sources);
    }

    /**
     * Add new award
     * @return \Illuminate\View\View
     */
    public function add()
    {
        return view('admin.awards.add')->with('sources', Awards::$sources);
    }

    public function delete($award_id)
    {
        if ( $award = Awards::find($award_id) ) {
            $award->delete();
        }
        Session::flash('notification', ['type'=>'success','msg'=>'Award has been deleted']);

        return redirect()->back();
    }

    public function save($award_id = null)
    {
        if ( $award_id ) {
            $award   = Awards::find($award_id);
            $msg    = 'Award has been updated';
        } else {
            $award   = new Awards();
            $msg    = 'Award has been created';
        }

        $rules['title']   = 'required';
        $validator = Validator::make(Input::all(),$rules);
        if ($validator->passes()) {

            $award->achievement_id = Input::get('achievement_id');
            $award->title          = Input::get('title');
            $award->source     = Input::get('source');
            $award->difficulty     = Input::get('difficulty');
            $award->path     = Input::get('icon_award');
            $award->icon     = Input::get('icon_award');
            if(!empty(Input::get('icon_award'))){
                $award->icon_grey     = 'grey_'.Input::get('icon_award');
            }else{
                $award->icon_grey     = "";
            }
            $award->save();

            Session::flash('notification',['type'=>'success','msg'=>$msg]);
            return redirect('admin/awards/edit/' . $award->id);

        } else {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->withErrors($validator);
        }

    }

}

