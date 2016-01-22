<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\AchievementsRequest;
use App\Models\Achievements;
use App\Models\AchievementsCategories;
use App\Models\AchievementsCriteria;
use App\Models\Awards;
use App\Models\Cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Image;

/**
 * Class AchievementsController
 * @package App\Http\Controllers\Admin
 */
class AchievementsController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Input::has('s')) {
           $achievements = Achievements::getSearchList(Input::get('s'));
        } else {
            $achievements = Achievements::getList();
        }

        return view('admin.achievements.index',compact('achievements'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function add()
    {
        $categories = AchievementsCategories::where('parent',0)->get();
        $criteria   = AchievementsCriteria::all();
        $achievements   = Achievements::select('id','title')->get();
        return view('admin.achievements.add',compact('categories','criteria','achievements'));
    }

    /**
     * @param AchievementsRequest $achievementsRequest
     * @return array
     */
    public function save(AchievementsRequest $achievementsRequest, $id = null )
    {

        if ( $id ) {
            $achievement    = Achievements::find($id);
            $msg            = 'Achievement has been updated';
        } else {
            $achievement    = new Achievements();
            $msg            = 'Achievement has been created';
        }

        if ( !empty($achievement->icon) ) {
            //Storage::disk('s3')->delete('icons/'.$achievement->icon);
        }

        $achievement->title         = $achievementsRequest->get('title');
        $achievement->points        = $achievementsRequest->get('points');
        $achievement->category_id   = $achievementsRequest->get('category');
        $achievement->subcategory_id= $achievementsRequest->get('sub_category');
        $achievement->parent_achievement = $achievementsRequest->get('parent_achievement');
        $achievement->criteria_text = $achievementsRequest->get('criteria_text');
        $achievement->difficulty    = $achievementsRequest->get('difficulty');
        $achievement->icon          = $achievementsRequest->get('icon_achievement');
        $achievement->icon_grey     = 'grey_'.$achievementsRequest->get('icon_achievement');
        $achievement->criteria_id   = $achievementsRequest->get('criteria');
        $achievement->criteria_value= $achievementsRequest->get('criteria_value');
        $achievement->criteria_show= $achievementsRequest->get('criteria_show');

        $achievement->save();

        $get_cards                 = Cards::getFirst(['achievement_id'=>$achievement->id]);

        if ( $get_cards ) {
            $Cards  = Cards::find($get_cards->id);
        } elseif( $achievementsRequest->get('icon_player_card') &&  $achievementsRequest->get('icon_path_player_card')) {
            $Cards  = new Cards();
        }

        if ( isset($Cards) ) {
            $Cards->title          = $achievementsRequest->get('player_card_title');
            $Cards->icon           = $achievementsRequest->get('icon_player_card');
            if(!empty($achievementsRequest->get('icon_player_card'))){
                $Cards->icon_grey           = 'grey_'.$achievementsRequest->get('icon_player_card');
            }else{
                $Cards->icon_grey           = '';
            }
            $Cards->path           = $achievementsRequest->get('icon_path_player_card');
            if(!empty(Input::get('icon_path_player_card')))
                $Cards->path_grey     = 'grey_'.Input::get('icon_path_player_card');

            $Cards->achievement_id = $achievement->id;
            $Cards->difficulty     = $achievementsRequest->get('difficulty');
            $Cards->source         = 'achievement';
            $Cards->save();
        }

        $get_gear                 = Awards::getFirst(['achievement_id'=>$achievement->id]);

        if ( $get_gear ) {
            $Gear  = Awards::find($get_gear->id);
        } else{
            $Gear  = new Awards();
        }

        if ( isset($Gear) and  !empty($achievementsRequest->get('trophy_title'))) {

            $Gear->title          = $achievementsRequest->get('trophy_title');

            if(!empty($achievementsRequest->get('icon_trophy')))
                $Gear->icon           = $achievementsRequest->get('icon_trophy');


            if(!empty($achievementsRequest->get('icon_trophy'))){
                $Gear->icon_grey            = 'grey_'.$achievementsRequest->get('icon_trophy');
                $Gear->path           = 'grey_'.$achievementsRequest->get('icon_trophy');
            }else{
                $Gear->icon_grey            = '';
                $Gear->path            = '';
            }

            $Gear->achievement_id = $achievement->id;
            $Gear->difficulty     = $achievementsRequest->get('difficulty');
            $Gear->source         = 'achievement';
            $Gear->save();
        }

        Session::flash('notification',['type'=>'success','msg'=>$msg]);

        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categories     = AchievementsCategories::where('parent',0)->get();
        $achievements   = Achievements::select('id','title')->where('id','!=',$id)->get();
        $achievement    = Achievements::find($id);
        $sub_categories = AchievementsCategories::where('parent',$achievement->category_id)->get();
        $cards          = Cards::getFirst(['achievement_id'=>$id]);
        $gear           = Awards::getFirst(['achievement_id'=>$id]);
        $criteria       = AchievementsCriteria::all();
        return view('admin.achievements.edit',compact('cards','categories','sub_categories','achievement','criteria','gear','achievements'));
    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function delete($id)
    {        
        $achievement    = Achievements::find($id);
        if ($achievement ) {
            $achievement->delete(); 
        }        
        $cards          = Cards::getFirst(['achievement_id'=>$id]);
        if ( $cards ) {
            $cards->delete();
        }

        Session::flash('notification', ['type'=>'success','msg'=>'Achievements has been deleted']);

        return redirect()->back();
    }


    /**
     * @param Request $request
     * @return json
     */
    public function ajaxSubcategories(Request $request)
    {
        $subcategories = AchievementsCategories::select('id','title')->where('parent',(int)$request->input('id'))->get();
        return Response::json($subcategories);
    }




}
