<?php namespace App\BikeCraft\Achievements;

use App\BikeCraft\Analysis;
use App\Models\Achievements;
use App\Models\AchievementsUsers;
use App\Models\BonusXP;
use App\Models\Lap;
use App\Models\Rides;
use App\Models\UsersCards;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchievementsAnalysis {

    private $user;
    /**
     * @var Analysis
     */
    private $analysis;
    /**
     * @var Career
     */
    private $career;
    /**
     * @var Experience
     */
    private $experience;

    /**
     * @var Legacy
     */
    private $legacy;
    /**
     * @var Exploration
     */
    private $exploration;

    /**
     * @param Analysis $analysis
     * @param Ride $ride
     * @param Career $career
     * @param Experience $experience
     * @param Exploration $exploration
     * @param Legacy $legacy
     */
    public function __construct( Analysis $analysis,
                                 Ride $ride,
                                 Career $career,
                                 Experience $experience,
                                 Exploration $exploration,
                                 Legacy $legacy
                                )
    {
        $this->user     = Auth::client()->user();

        $this->ride         = $ride;
        $this->analysis     = $analysis;
        $this->career       = $career;
        $this->experience   = $experience;
        $this->exploration   = $exploration;
        $this->legacy   = $legacy;
    }


    public function doProcessing($file)
    {

        $achievements = Achievements::getLocked($this->user->id);

        foreach ($achievements as $achievement) {
            $achievement->file_id = $file->id;
            $this->ride->doProcessing($achievement);
            $this->career->doProcessing($achievement);
            $this->exploration->doProcessing($achievement);
            $this->experience->doProcessing($achievement);
            $this->legacy->doProcessing($achievement);

        }

    }


}
