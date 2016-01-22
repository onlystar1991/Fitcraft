<?php namespace App\BikeCraft;

use App\Models\Levels;
use Carbon\Carbon;

/**
 * Class UserXP
 *
 * @package App\BikeCraft
 */
class UserXP {

    /**
     * @var int current user level
     */
    protected $userLevel;

    /**
     * @var float current user xp
     */
    protected $userXP;

    /**
     * @var float xp/second
     */
    protected $xpPerSeconds;

    /**
     * @var float xp required for next level
     */
    protected $xpRequired;

    /**
     * @var
     */
    protected $ftp;

    /**
     * @var
     */
    protected $lthr;

    /**
     * @var object Levels
     */
    private $levels;

    /**
     * @var object User
     */
    private $user;

    /**
     * @param Levels $levels
     */
    public function __construct( Levels $levels)
    {
        $this->levels = $levels;
    }

    /**
     * @param $user
     */
    public function set($user)
    {
        $this->user = $user;

        if ( $user->heart_rate == 0 ) {
            $this->setLthr($this->calculateLTHR($this->user->age));
        } else {
            $this->setLthr($user->heart_rate);
        }

        if ( $user->power == 0 ) {
            $this->setFtp($this->calculateFTP($this->user));
        } else {
            $this->setFtp($user->power);
        }

        $this->setUserXP($user->xp);
        $this->setUserLevel($this->user->level);
        $this->initXP($this->user->level);

    }


    /**
     * @param $level
     */
    protected function initXP($level)
    {
        $levelDetails = $this->levels->where('level',$level)->first();

        $this->setXpPerSeconds($levelDetails->xp_second);
        $this->setXpRequired($levelDetails->xp_required);
    }

    /**
     * @return mixed
     */
    public function getUserLevel()
    {
        return $this->userLevel;
    }

    /**
     * @param mixed $userLevel
     */
    public function setUserLevel($userLevel)
    {
        $this->userLevel = $userLevel;
    }

    /**
     * @return mixed
     */
    public function getUserXP()
    {
        return $this->userXP;
    }

    /**
     * @param mixed $userXP
     */
    public function setUserXP($userXP)
    {
        $this->userXP = $userXP;
    }

    /**
     * @return mixed
     */
    public function getXpPerSeconds()
    {
        return $this->xpPerSeconds;
    }

    /**
     * @param mixed $xpPerSeconds
     */
    public function setXpPerSeconds($xpPerSeconds)
    {
        $this->xpPerSeconds = $xpPerSeconds;
    }

    /**
     * Calculate XP
     * @param $xp
     */
    public function calculateXP($xp)
    {
        $this->userXP += $xp;

        if ( $this->userXP > $this->xpRequired ) {

            //increment level
            $this->userLevel++;

            $this->initXP($this->userLevel);

            $this->userXP   = abs($this->xpRequired - $this->userXP);

        }
    }

    /**
     * Geg xp required for next level
     * @return mixed
     */
    public function getXpRequired()
    {
        return $this->xpRequired;
    }

    /**
     * @param mixed $xpRequired
     */
    public function setXpRequired($xpRequired)
    {
        $this->xpRequired = $xpRequired;
    }

    /**
     * Calculate LTHR
     * @param $userAge
     * @return int
     */
    public function calculateLTHR($userAge)
    {
        $this->setLthr((220 - $userAge) * 0.75);
    }

    /**
     * Calculate FTP
     * @param object $user
     * @return mixed
     */
    public function calculateFTP($user)
    {
        $ftp  = ($user->weight - ( $user->weight *(($user->body_fat - 5) / 100) )) * 1.25;

        $age = Carbon::createFromFormat('Y-m-d',$user->dob)->age;

        if ( $age > 35 ) {
            $subtract  = ($age - 35) * 0.005;
            $ftp_subtract=  $ftp * $subtract;
            $ftp = $ftp - $ftp_subtract;
        }
        
        if ( $user->gender == 'f' ) {
            $ftp = $ftp * 0.9;
        }

        $this->setFtp($ftp);

    }

    /**
     * @return mixed
     */
    public function getLthr()
    {
        return $this->lthr;
    }

    /**
     * @param mixed $lthr
     */
    public function setLthr($lthr)
    {
        $this->lthr = $lthr;
    }

    /**
     * @return mixed
     */
    public function getFtp()
    {
        return $this->ftp;
    }

    /**
     * @param mixed $ftp
     */
    public function setFtp($ftp)
    {
        $this->ftp = $ftp;
    }

}

