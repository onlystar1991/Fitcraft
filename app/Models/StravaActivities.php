<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StravaActivities extends Model {

    protected $table = 'strava_activities';


    /**
     * @param $fields
     * @return StravaActivities
     */
    public static function add($fields)
    {
        $model = new StravaActivities();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFirst($where)
    {
        return parent::where($where)->first();
    }
}



