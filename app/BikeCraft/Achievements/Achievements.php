<?php namespace App\BikeCraft\Achievements;

use App\Models\AchievementsUsers;
use App\Models\UsersAwards;
use App\Models\UsersCards;
use Illuminate\Support\Facades\Auth;

class Achievements
{
    public $user;

    public function __construct()
    {
        $this->user  = Auth::client()->user();
    }

    /**
     * @param $achievement
     */
    public function createAchievement($achievement)
    {
        AchievementsUsers::create([
            'user_id'        => Auth::client()->user()->id,
            'file_id'        => $achievement->file_id,
            'achievement_id' => $achievement->id,
            'points'         => $achievement->points
        ]);

        //users cards
        if ( $achievement->cards_id != 0 ) {
            UsersCards::create([
                'user_id'   => Auth::client()->user()->id,
                'cards_id'  => $achievement->cards_id,
                'file_id'   => $achievement->file_id
            ]);
        }

        //users gear
        if ( $achievement->gear_id != 0 ) {
            UsersAwards::create([
                'user_id'   => Auth::client()->user()->id,
                'awards_id'  => $achievement->gear_id,
                'file_id'   => $achievement->file_id
            ]);
        }

    }


}
