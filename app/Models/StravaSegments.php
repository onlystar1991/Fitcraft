<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StravaSegments extends Model {

    protected $table = 'strava_segments';

    /**
     * @param $fields
     * @return StravaSegments
     */
    public static function add($fields)
    {
        $model = new StravaSegments();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

}



