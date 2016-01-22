<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StravaParsings extends Model {

    protected $table = 'strava_parsings';


    /**
     * @param $fields
     * @return StravaParsings
     */
    public static function add($fields)
    {
        $model = new StravaParsings();
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



