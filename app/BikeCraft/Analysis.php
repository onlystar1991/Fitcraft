<?php namespace App\BikeCraft;

use App\Models\Lap;
use App\Models\Record;
use App\Models\Rides;
use App\Models\User;
use Carbon\Carbon;
use Geocoder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Analysis
{

    /**
     * Heart Zones
     * @var array
     */
    public $percentsHeart = [0.01, 0.79, 0.90, 1.0, 1.05, 100];

    /**
     * Power Zones
     * @var array
     */
    public $percentsPower = [0.01, 0.75, 0.90, 1.05, 1.50, 100];

    /**
     * @var array
     */
    public $xpZone = [0, 1, 1.2, 1.4, 1.6, 2];

    /**
     * @var User
     */
    private $user;

    /**
     * @var BonusXP
     */
    private $bonusXP;

    /**
     * Xp per sone
     * @var
     */
    protected $zonesXP;

    /**
     * Time per zone
     * @var
     */
    protected $zonesTime;

    /**
     * @var VPower
     */
    private $VPower;

    /**
     * @var Achievements
     */
    private $achievements;

    /**
     * @param UserXP $userXP
     * @param User $user
     * @param BonusXP $bonusXP
     * @param VPower $VPower
     */
    public function __construct(UserXP $userXP,
                                User $user,
                                BonusXP $bonusXP,
                                VPower $VPower
                               )
    {
        $this->userXP   = $userXP;
        $this->user     = $user;
        $this->bonusXP  = $bonusXP;
        $this->VPower   = $VPower;

    }

    /**
     * Calculate Heart Zone
     * @param $lthr
     * @return array
     */
    public function heartZones($lthr)
    {
        $array = $this->percentsHeart;
        if (array_walk($array, function (&$value, $key, $lthr) {$value = $value * $lthr;}, $lthr))
        return $array;
    }

    /**
     * Calculate Power Zone
     * @param $ftp
     * @return array
     */
    public function powerZones($ftp)
    {
        $array = $this->percentsPower;

        if (array_walk($array, function (&$value, $key, $ftp) {$value = $value * $ftp; }, $ftp))
        return $array;

    }


    public function partitionData($file)
    {
        $user = User::find(Auth::client()->user()->id);

        $this->userXP->set($user);

        $lap = Lap::getFirst(['file_id'=>$file->id]);

        if ( empty($lap->estimated_power) && ( !empty($lap->max_power) || $lap->max_power != 0 ) ) {
            $zoneType = 'power';
        } elseif (  $lap->max_heart_rate != '0.00' ) {
            $zoneType = 'heart_rate';
        } else {
            $zoneType = 'power';
        }

        if ( strtolower($file->ext == 'fit') ) {
            $lat = round( $lap->start_position_lat * (180.0 / pow(2,31)), 5);
            $lng = round( $lap->start_position_long * (180.0 / pow(2,31)), 5);
        } else {
            $lat = round($lap->start_position_lat,5);
            $lng = round($lap->start_position_long,5);
        }

        $geocoder = $this->geoCoder($lat, $lng);

        $ride = Rides::create([
            'user_id'                      => $user->id,
            'file_id'                      => $file->id,
            'locality'                     => $geocoder['locality'],
            'country'                      => $geocoder['country'] ,
            'postal_code'                  => $geocoder['postal_code'],
            'administrative_area_level'    => $geocoder['administrative_area_level_1']
        ]);


        //set ride
        $this->bonusXP->setRide($ride);

        //get zones
        if ($zoneType == 'heart_rate') {
            $zones = $this->heartZones($this->userXP->getLthr());
        } else {
            $zones = $this->powerZones($this->userXP->getFtp());
        }
        $records = Record::where('file_id', $file->id)->orderBy('timestamp', 'ASC')->get();

        $this->partitionFit($records, $zones, $zoneType);

        $ride->zone_1       = $this->zonesXP[1];
        $ride->zone_2       = $this->zonesXP[2];
        $ride->zone_3       = $this->zonesXP[3];
        $ride->zone_4       = $this->zonesXP[4];
        $ride->zone_5       = $this->zonesXP[5];

        $ride->zone_0_time  = $this->zonesTime[0];
        $ride->zone_1_time  = $this->zonesTime[1];
        $ride->zone_2_time  = $this->zonesTime[2];
        $ride->zone_3_time  = $this->zonesTime[3];
        $ride->zone_4_time  = $this->zonesTime[4];
        $ride->zone_5_time  = $this->zonesTime[5];


        $ride->save();

        //default efforts
        $this->setMinEffort(0);
        $this->setMaxEffort(0);

        $this->userXP->calculateXP($this->bonusXP->getBonusXP());

        //save user level , xp
        $newXP = $this->userXP->getUserXP();
        $lap->xp = $newXP-$user->xp;
        $user->level    = $this->userXP->getUserLevel();
        $user->xp       = $newXP;

        $user->save();
        $lap->save();

        return true;
    }

    /**
     * @param $lat
     * @param $lng
     * @return array
     */
    protected function geoCoder($lat, $lng)
    {
        $geocoder = Geocoder::geocode('json', ["latlng"=>"$lat,$lng" ]);

        $reponse    = json_decode($geocoder,true);
        if(isset($reponse['results'][0]['address_components'])) {

            foreach($reponse['results'][0]['address_components'] as $key=>$value) {

                if ( $value['types'][0] == 'locality' ) {
                    $locality = $value['long_name'];
                }
                if ( $value['types'][0] == 'country' ) {
                    $country = $value['long_name'];
                }
                if ( $value['types'][0] == 'postal_code' ) {
                    $postal_code = $value['long_name'];
                }
                if ( $value['types'][0] == 'administrative_area_level_1' ) {
                    $administrative_area_level_1 = $value['long_name'];
                }
            }
        }

        return [
            'locality'                      => isset($locality) ? $locality : '',
            'country'                       => isset($country) ? $country : '',
            'postal_code'                   => isset($postal_code) ? $postal_code : '',
            'administrative_area_level_1'   => isset($administrative_area_level_1) ? $administrative_area_level_1 : '',
        ];
    }

    /**
     *
     * @param $result
     * @return mixed
     */
    public function percentagesZones($result)
    {
        $total = array_sum($result);array_walk($result, function (&$value, $key, $total) {$value = round($value / $total * 100, 1);}, $total);
        return $result;
    }

    /**
     * @param $zone
     * @param $seconds
     * @return mixed
     */
    public function getXPZone($zone, $seconds)
    {
        $xp     = $this->userXP->getXpPerSeconds() * $this->xpZone[$zone] * $seconds;
        return $xp;
    }

    /**
     * @param $file
     * @return string
     */
    private function getType($file)
    {
        $lap = Lap::getFirst(['file_id'=>$file->id]);

        if ( !empty($lap->max_power) || $lap->max_power != 0 ) {
            return 'power';
        } elseif ( $lap->max_heart_rate != '0.00' ) {
            return 'heart_rate';
        } else {
            return 'vpower';
        }
    }




    /**
     * @param $records
     * @param $zones
     */
    private function partitionFit($records, $zones, $type)
    {

        $totalZones = count($zones);

        $result             = array_fill(0, $totalZones, 0);
        $this->zonesXP      = array_fill(0, $totalZones, 0);
        $this->zonesTime    = array_fill(0, $totalZones, 0);

        foreach ( $records as $record_key=> $record ) {

            if ( $record->speed > config('bike.moving_speed') ) {
                
                for( $key = 0; $key < $totalZones; ++$key ) {

                    if( $record->{$type} <= $zones[$key] ) {

                        $seconds = 0;

                        if ( isset($records[$record_key+ 1])  ) {
                            $startDate  = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key]->timestamp));
                            $endDate    = Carbon::createFromTimestamp(Data::timeToUnix($records[$record_key+1]->timestamp));
                            $seconds    = $endDate->diffInSeconds($startDate);
                        }

                        $result[$key]   += $seconds;
                        $xp             =  $this->getXPZone($key,$seconds);

                        $this->zonesXP[$key]    += $xp;
                        $this->zonesTime[$key]  += $seconds;
                        $this->userXP->calculateXP($xp);

                        //calculate bonus
                        $this->bonusXP->calculateBonus($key, $seconds, $xp);
                        goto loop_end;
                    }
                }
            }
            loop_end:
        }
    }

    /**
     * @param int $minEffort
     */
    public function setMinEffort($minEffort)
    {
        $this->minEffort = $minEffort;
    }

    /**
     * @param int $maxEffort
     */
    public function setMaxEffort($maxEffort)
    {
        $this->maxEffort = $maxEffort;
    }


}