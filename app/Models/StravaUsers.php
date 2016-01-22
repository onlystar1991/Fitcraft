<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StravaUsers extends Model {

    protected $table = 'strava_users';

    /**
     * @param $fields
     * @return StravaUsers
     */
    public static function add($fields)
    {
        $model = new StravaUsers();
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



