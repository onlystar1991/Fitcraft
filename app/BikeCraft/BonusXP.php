<?php namespace app\BikeCraft;
use Illuminate\Support\Facades\Auth;

/**
 * Class BonusXP
 * @package app\BikeCraft
 */
class BonusXP {

    /**
     * @var int default maxZone
     */
    private $maxZone = 2;

    /**
     * @var int
     */
    protected $seconds = 0;

    /**
     * @var float
     */
    protected $bonusXP = 0;

    /**
     * @var array
     */
    protected $percentersBonusChance = [0, 0 ,0.05, 0.1, 0.25, 0.5];

    /**
     * @var
     */
    private $ride;

    /**
     * @var array
     */
    protected $bonusXPChange = [
        2   => ['min'=>5,  'max'=>10],
        3   => ['min'=>10, 'max'=>15],
        4   => ['min'=>25, 'max'=>50],
        5   => ['min'=>75, 'max'=>100]
    ];

    /**
     * @var float
     */
    protected $xp = 0;

    /**
     * @param $probability
     * @return bool
     */
    public function percentageChance($probability)
    {
        // Generate a random number between 0 and 10,000
        $random_number = rand(0,10000);

        $check_probability = $probability * 100;

        if ($random_number <= $check_probability) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $zone
     * @param $seconds
     * @param $xp
     * @return float|int
     */
    public function calculateBonus($zone, $seconds, $xp)
    {
        if ( $zone > 1 ) {

            $this->xp += $xp;

            //set max sone
            $this->maxZone = ($zone > $this->maxZone) ? $zone : $this->maxZone;

            $this->seconds += $seconds;

            if ( $this->seconds >= 30 ) {

                $change = $this->percentageChance($this->getPercentageZone($this->maxZone));

                if ( $change == true ) {
                    $min = $this->bonusXPChange[$this->maxZone]['min'];
                    $max = $this->bonusXPChange[$this->maxZone]['max'];

                    $percentage = rand($min, $max);

                    if ($this->percentageChance($percentage)) {
                        $bonusXp = $this->xp / 100 * $percentage;
                        $this->bonusXP += $bonusXp;
                        \App\Models\BonusXP::create([
                           'user_id'    => Auth::client()->user()->id,
                           'ride_id'    => $this->ride->id,
                           'zone'       => $this->maxZone,
                            'xp'        => $bonusXp
                        ]);
                    }

                }

                $this->setMaxZone(2);
                $this->setSeconds($this->seconds - 30);
                $this->setXp(0);
            }
        } else {
            $this->setMaxZone(2);
            $this->setSeconds(0);
            $this->setXp(0);
        }

    }

    /**
     * @param $zone
     * @return mixed
     */
    private function getPercentageZone($zone)
    {
        return $this->percentageChance($zone) * 100;
    }

    /**
     * @return int
     */
    public function getMaxZone()
    {
        return $this->maxZone;
    }

    /**
     * @param int $maxZone
     */
    public function setMaxZone($maxZone)
    {
        $this->maxZone = $maxZone;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param int $seconds
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @return float
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * @param float $xp
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    }

    /**
     * @return float
     */
    public function getBonusXP()
    {
        return $this->bonusXP;
    }

    /**
     * @param float $bonusXP
     */
    public function setBonusXP($bonusXP)
    {
        $this->bonusXP = $bonusXP;
    }

    /**
     * @return mixed
     */
    public function getRide()
    {
        return $this->ride;
    }

    /**
     * @param mixed $ride
     */
    public function setRide($ride)
    {
        $this->ride = $ride;
    }


}