<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BonusXP extends Model {

    protected $table = 'bonus_xp';

    protected $fillable = ['user_id','ride_id','zone','xp'];

    public static function getByRide($ride_id)
    {
        $result = parent::select('zone',
                            DB::RAW('SUM(xp) as total_xp')
                            )
                        ->where('ride_id',$ride_id)
                        ->groupBy('zone')
                        ->get();

        $zones = array_fill(0, 5, 0);

        if ( !empty($result) ) {
            foreach ($result as $zone) {
                $zones[$zone->zone] = $zone->total_xp;
            }
        }

        return $zones;


    }

}


