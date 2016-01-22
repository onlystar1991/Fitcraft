<?php namespace App\BikeCraft\Achievements;

use Illuminate\Support\Facades\DB;

/**
 * Class Ride
 * @package App\BikeCraft\Achievements
 */
class Legacy extends Achievements {

    /**
     * @var
     */
    public $user;

    public function doProcessing($achievement)
    {
        $app_version = config('app.app_version');
        switch ($achievement->criteria_id) {
            //BE PART OF THE FITCRAFT BETA
            case 88:
                if($app_version=='beta') $this->setPoints($achievement);
                break;

        }
    }

    /**
     * @return mixed
     */
    public function setPoints($achievement)
    {
        $this->createAchievement($achievement);
    }

}