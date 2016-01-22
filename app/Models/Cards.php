<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Cards extends Model {

    protected $table = 'cards';

    static $sources = array(
        'achievement'=>'Achievement',
        'default_male'=>'Default male',
        'default_female'=>'Default female'
    );

    static function getSource($key){
        if(!empty(self::$sources[$key])){
            return self::$sources[$key];
        }else{
            return $key;
        }

    }

    protected $fillable = ['title','source','difficulty','path','icon','icon_grey'];

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
     * @param $where
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
                        ->get();
    }


}