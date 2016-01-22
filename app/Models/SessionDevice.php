<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionDevice extends Model {

    protected $table = 'session';

    /**
     * @param $fields
     * @return Files
     */
    public static function add($fields)
    {
        $model = new SessionDevice();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    public static function addSession($row)
    {
        return self::add([
            'file_id'               => $row['file_id'],
            'timestamp'             => $row[53],
            'start_time'            => $row[54],
            'start_position_lat'    => $row[55],
            'start_position_long'   => $row[56],
            'start_position_long'   => $row[57],
            'total_elapsed_time'    => $row[58],
            'total_timer_time'      => $row[59],
            'total_distance'        => $row[60],
            'total_cycles'          => $row[61],
            'nec_lat'               => $row[62],
            'nec_long'              => $row[63],
            'swc_lat'               => $row[64],
            'swc_long'              => $row[65],
            'message_index'         => $row[66],
            'total_calories'        => $row[67],
            'total_fat_calories'    => $row[68],
            'avg_speed'             => $row[69],
            'max_speed'             => $row[70],
            'total_descent'         => $row[71],
            'first_lap_index'       => $row[72],
            'num_laps'              => $row[73],
            'event'                 => $row[74],
            'event_type'            => $row[75],
            'sport'                 => $row[76],
            'sub_sport'             => $row[77],
            'avg_cadence'           => $row[78],
            'max_cadence'           => $row[79],
            'trigger'               => $row[80],

        ]);
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
                        ->get();
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFirst($where)
    {
        return parent::where($where)
                        ->first();
    }

}
