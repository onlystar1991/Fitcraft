<?php namespace App\BikeCraft\Achievements;

use App\Models\Rides;
use Illuminate\Support\Facades\DB;
use App\Models\UsersCards;
use App\Models\UsersSeason;
use Illuminate\Support\Facades\Auth;

class Career extends Achievements
{

    public function doProcessing($achievement)
    {
        switch ($achievement->criteria_id) {
            case 13 :
                $this->earnCategory($achievement);
                break;
            case 14 :
                $this->earnEliteCategory($achievement);
                break;
            case 15 :
                $this->countCompleteSeason($achievement);
                break;
            case 16 :
                $this->countCompleteSeason($achievement);
                break;
            case 20 :
                $this->allCareer($achievement);
                break;
        }

    }

    //EARN CATEGORY X
    public function earnCategory($achievement)
    {
        if ( Auth::client()->user()->raceCategories->nr <= $achievement->criteria_value and Auth::client()->user()->raceCategories->nr!=0) {
            $this->createAchievement($achievement);
        }
    }

    //EARN CATEGORY ELITE
    public function earnEliteCategory($achievement)
    {
        if ( Auth::client()->user()->raceCategories->nr == $achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }

    //COMPLETE YOUR N SEASON
    public function countCompleteSeason ($achievement)
    {
        $count_complete = $this->countSeason();
        if($count_complete>=$achievement->criteria_value){
            $this->createAchievement($achievement);
        }
    }

    public function countSeason(){
       return UsersSeason::where('user_id', Auth::client()->user()->id)
            ->where('user_id', Auth::client()->user()->id)
            ->where('active', '=', 0)
            ->count();
    }

    //START YOUR FIRST SEASON
    public function startSeason($achievement)
    {
        $this->createAchievement($achievement);
    }

    //COMPLETE ALL CAREER ACHIEVEMENTS
    public function allCareer($achievement)
    {
        $user_id = Auth::client()->user()->id;
        $achivements = DB::select("select `achievements`.`id` from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = $user_id) and achievements.category_id = 11");
        if(count($achivements)==0){
            $this->createAchievement($achievement);
        }
    }

}
