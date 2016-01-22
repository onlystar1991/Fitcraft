<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rides;

class Record extends Model {

    protected $table = 'record';

    /**
     * @param $fields
     * @return Files
     */
    public static function add($fields)
    {
        $model = new Record();
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

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getMaxElevation($file_id)
    {
        return parent::select(
                        DB::RAW('MAX(altitude) as altitude')
                        )
                        ->where('file_id',$file_id)
                        ->first();
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function calculateElevation($file_id)
    {
        return parent::select(
                    DB::RAW('MAX(altitude) - MIN(altitude) as elevation')
                    )
                    ->where('file_id',$file_id)
                    ->first();
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getMaxPower($file_id)
    {
        return parent::select(
                                DB::RAW('MAX(power)as power')
                            )
                            ->where('file_id',$file_id)
                            ->first();
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function topSpeedRideMPH($user_id, $speed)
    {
        $query =  parent::select(
            DB::RAW('MAX(record.speed * 2.23693629) as top_speed')
        )
            ->where('record.user_id','=',$user_id)
            ->groupBy('record.file_id')
            ->having('top_speed','>=',$speed);
        return $query->first();
    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getLeast15SecAboveAVGPower($user_id, $avg_power)
    {
        $query =  RECORD::select('record.power','record.file_id','timestamp')
            ->where('record.user_id','=',$user_id)
            ->where('speed','>',config('bike.moving_speed'))
            ->orderBy('record.id', 'ASC');

        $i=1;
        $old_file=0;
        $sumAVG=0;
        $old_time = 0;
        $sec = 0;

        foreach($query->get()->toArray() as $record){

            if($old_file!=$record["file_id"]){
                $i=1;
                $sumAVG=0;
                $old_time = 0;
                $sec = 0;
            };

            $old_file=$record["file_id"];
            $sumAVG+=$record["power"];
            if(($sumAVG/$i)>=$avg_power){
                if($old_time==0){
                    $sec =  0;
                }else{
                    $sec +=  $record["timestamp"]-$old_time;
                }
            }
            if($sec>=15) break;
            $old_time = $record["timestamp"];

            $i++;
        }
        return $sec;
    }


}
