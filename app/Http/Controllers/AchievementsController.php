<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Achievements;
use App\Models\AchievementsCategories;
use App\Models\AchievementsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AchievementsController extends Controller {

    private $user;

    public function __construct()
    {
        $this->user = Auth::client()->user();
    }

    /**Get list of categories
     * @return mixed
     */
    public function categories()
    {
        $categories = AchievementsCategories::where('parent',0)->get();
        foreach ($categories as $category) {
            $category->child = AchievementsCategories::where('parent',$category->id)->get();
        }

        return Response::json($categories,200);
    }

	public function index( $id = null)
    {

        $categories = AchievementsCategories::getPointsByCat();
        $statistic['score'] = [
            'completed' => 0,
            'total'     => 0,
            'progress'  => 0
        ];

        foreach ($categories as $category) {
            $count = AchievementsUsers::getPointUserCategory($this->user->id, $category->id);

            $statistic[strtolower($category->title)] = [
                'completed' => $count,
                'total'     => $category->total,
                'progress'  => ($category->total > 0) ?  $count / $category->total  * 100 : 0
            ];
            $statistic['score'] = [
                'completed' => $statistic['score']['completed'] + $count ,
                'total'     => $statistic['score']['total'] + $category->total,
                'progress'  => ($statistic['score']['total'] > 0) ?  $statistic['score']['completed'] / $statistic['score']['total']  * 100 : 0
            ];
        }

        $getCategory = AchievementsCategories::getFirst(['id'=>$id]);
        
        $achievements = Achievements::getListByUser($getCategory, $this->user->id );

        foreach ($achievements as $achievement)
        {

            if($achievement->completed==0){
                $achievement->icon_player_card  = iconPath($achievement->icon_player_card_grey);
                $achievement->icon_trophy       = iconPath($achievement->icon_gear_grey);
                $achievement->icon = iconPath($achievement->icon_grey);
            }else{
                $achievement->icon_player_card  = iconPath($achievement->icon_player_card);
                $achievement->icon_trophy       = iconPath($achievement->icon_gear);
                $achievement->icon = iconPath($achievement->icon);
            }

        }

        return Response::json([
            'achievements'  => $achievements,
            'statistic'     => $statistic
        ],200);
    }

}
