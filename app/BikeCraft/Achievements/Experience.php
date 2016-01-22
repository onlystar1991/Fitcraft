<?php namespace App\BikeCraft\Achievements;


use App\Models\BonusXP;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Rides;
use Illuminate\Support\Facades\Auth;

class Experience extends Achievements {

    public function doProcessing($achievement)
    {
        switch ($achievement->criteria_id) {
            case 9:
                $this->earnLevel($achievement);
                break;
            case 10 :
                $this->earnNXPPoints($achievement);
                break;
            case 11 :
                $this->earnNXPPointsMonth($achievement);
                break;
            case 12:
                $this->completeAllExpiriences($achievement);
                break;
        }

    }

    //COMPLETE ALL EXPERIENCE ACHIEVEMENTS
    public function completeAllExpiriences($achievement)
    {
        $user_id = Auth::client()->user()->id;
        $achivements = DB::select("select `achievements`.`id` from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = $user_id) and achievements.category_id = $achievement->category_id and achievements.criteria_id <> $achievement->criteria_id");
        if(count($achivements)==0){
            $this->createAchievement($achievement);
        }
    }


    //EARN MORE THAN N EXPERIENCE POINTS IN A SINGLE RIDE
    public function earnNXPPoints($achievement)
    {
        $ride = Rides::haveXP(Auth::client()->user()->id,$achievement->criteria_value);
        if ( !empty($ride) ) {
           $this->createAchievement($achievement);
        }
    }

    //EARN MORE THAN X EXPERIENCE POINTS IN A SINGLE MONTH
    public function earnNXPPointsMonth($achievement)
    {
        $ride = Rides::haveMonthXP(Auth::client()->user()->id,$achievement->criteria_value);
        if ( count($ride)>0 ) {
           $this->createAchievement($achievement);
        }
    }

    //EARN LEVEL N
    public function earnLevel($achievement)
    {
        $current_user = User::getFirst(['id'=> Auth::client()->user()->id ]);
        if ((int)$current_user->level >= (int)$achievement->criteria_value ) {
            $this->createAchievement($achievement);
        }
    }



} 