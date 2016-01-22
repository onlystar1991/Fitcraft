<?php namespace App\BikeCraft\Achievements;


use App\Models\BonusXP;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Rides;
use Geocoder;
use Illuminate\Support\Facades\Auth;

class Exploration extends Achievements {

    public function doProcessing($achievement)
    {
        switch ($achievement->criteria_id) {
            case 1:
                $this->milesFromZipCode($achievement);
                break;
            case 2:
                $this->milesFromHomeCountry($achievement);
                break;
            case 3:
                $this->milesFromOutsideCountry($achievement);
                break;
            case 4:
                $this->getMilesOutHomeCountryMonth($achievement);
                break;
            case 5:
                $this->completeXridersXcountryLeast30min($achievement);
                break;
            case 6:
                $this->milesTotalFtOutsideCountry($achievement);
                break;
            case 7:
                $this->milesTotalFtOutsideCountryAndRide100miles($achievement);
                break;
            case 8:
                $this->allExplorations($achievement);
                break;

        }

    }

    //COMPLETE ALL EXPLORATION ACHIEVEMENTS
    public function allExplorations($achievement)
    {
        $user_id = Auth::client()->user()->id;
        $achivements = DB::select("select `achievements`.`id` from `achievements` left join `cards` on `cards`.`achievement_id` = `achievements`.`id` where achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = $user_id) and achievements.category_id = $achievement->category_id and achievements.criteria_id <> $achievement->criteria_id");
        if(count($achivements)==0){
            $this->createAchievement($achievement);
        }
    }

    //RIDE X MILES WITHIN YOUR HOME ZIP CODE
    public function milesFromZipCode($achievement)
    {
        $user_zip = Auth::client()->user()->zip;
        if(!is_null($user_zip)){
            $ride_miles = Rides::getMilesZip(Auth::client()->user()->id,$user_zip,$achievement->criteria_value);
            if(count($ride_miles)>0) {
                $this->createAchievement($achievement);
            }
        }
    }

    //COMPLETE X RIDES IN X COUNTRIES OF AT LEAST 30 MINUTES
    public function completeXridersXcountryLeast30min($achievement)
    {
            $countries = Rides::completeXridersXcountryLeast30min(Auth::client()->user()->id,$achievement->criteria_value);

            if(count($countries)>0) {
                $this->createAchievement($achievement);
            }
    }

    public function getUserCountry($zip){
        $geocoder = Geocoder::geocode('json', ["address"=>$zip ]);
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

    //RIDE X MILES WITHIN YOUR HOME COUNTRY
    public function milesFromHomeCountry($achievement)
    {
        if(empty(Auth::client()->user()->country)) return false;

            $ride_miles = Rides::getMilesHomeCountry(Auth::client()->user()->id,Auth::client()->user()->country,$achievement->criteria_value);
            if(count($ride_miles)>0) {
                $this->createAchievement($achievement);
            }
    }

    ///RIDE X MILES OUTSIDE YOUR COUNTRY
    public function milesFromOutsideCountry($achievement)
    {
        if(empty(Auth::client()->user()->country)) return false;

            $ride_miles = Rides::getMilesOutsideCountry(Auth::client()->user()->id,Auth::client()->user()->country,$achievement->criteria_value);
            if(count($ride_miles)>0) {
                $this->createAchievement($achievement);
            }
    }

    ///CLIMB AT LEAST X FT OUTSIDE YOUR HOME COUNTRY
    public function milesTotalFtOutsideCountry($achievement)
    {
        if(empty(Auth::client()->user()->country)) return false;

            $ride_ft = Rides::getTotalFtOutsideCountry(Auth::client()->user()->id,Auth::client()->user()->country,$achievement->criteria_value);
            if(count($ride_ft)>0) {
                $this->createAchievement($achievement);
            }
    }

    //CLIMB AT LEAST X FT AND RIDE 100 MILES OUTSIDE OF YOUR HOME COUNTRY
    public function milesTotalFtOutsideCountryAndRide100miles($achievement)
    {
        if(empty(Auth::client()->user()->country)) return false;

            $ride_ft = Rides::getTotalFtOutsideCountryRide100m(Auth::client()->user()->id,Auth::client()->user()->country,$achievement->criteria_value);
            if(count($ride_ft)>0) {
                $this->createAchievement($achievement);
            }
    }

    //RIDE AT LEAST X MILES IN AND OUT OF YOUR COUNTRY IN A SINGLE MONTH
    public function getMilesOutHomeCountryMonth($achievement)
    {
        if(empty(Auth::client()->user()->country)) return false;

            $ride_miles = Rides::getMilesOutHomeCountryMonth(Auth::client()->user()->id, Auth::client()->user()->country,$achievement->criteria_value);
            if(count($ride_miles)>0) {
                $this->createAchievement($achievement);
            }
    }


}