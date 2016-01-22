<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DB;

class Awards extends Model {

    protected $table = 'awards';


    static $sources = array(
        'achievement'=>'Achievement',
        'default_gear_male'=>'Default male',
        'default_gear_female'=>'Default female'
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

    public static function getUserAwards($user_id)
    {
        return Awards::select(
            'awards.*',
            DB::raw('achievements.title as name_source'),
            'users_awards.order as order',
            DB::raw('IF(users_awards.id,1,0) as available'),
            DB::raw('IF(users_awards.top,1,0) as top')
        )->leftJoin('users_awards',function ($join) use ($user_id){
                $join->on('awards.id','=','users_awards.awards_id')
                    ->where('users_awards.user_id', '=', $user_id);
            })
            ->leftJoin('achievements','achievements.id','=','awards.achievement_id')
            ->get()->toArray();
    }

    public static function getTopUserAwards($user_id)
    {
        return Awards::select(
            'awards.*',
            'users_awards.order as order',
            DB::raw('IF(users_awards.id,1,0) as available'),
            DB::raw('IF(users_awards.top,1,0) as top')
        )->leftJoin('users_awards',function ($join) use ($user_id){
            $join->on('awards.id','=','users_awards.awards_id');
        })
            ->where('users_awards.user_id', '=', $user_id)
            ->where('users_awards.top', '=', 1)
            ->where('users_awards.order', '<=', 2)
            ->orderBy('users_awards.order')
            ->take(3)
            ->get()
            ->toArray();
    }

    public static function getGridTopUserAwards($user_id)
    {
        $topAwards = Awards::select(
            'awards.*',
            'users_awards.order as order',
            DB::raw('IF(users_awards.id,1,0) as available'),
            DB::raw('IF(users_awards.top,1,0) as top')
        )->leftJoin('users_awards',function ($join) use ($user_id){
            $join->on('awards.id','=','users_awards.awards_id');
        })
            ->where('users_awards.user_id', '=', $user_id)
            ->where('users_awards.top', '=', 1)
            ->orderBy('users_awards.order')
            ->take(9)
            ->get()
            ->toArray();
        $gridArray = array_fill (0, 9, array('order'=>0, 'available'=>1,"top" => 1,"icon" => "assets/img/icon-empty.png"));

        foreach($topAwards as $key=>$topAward){
            $gridArray[$topAward['order']]=$topAward;
            $gridArray[$topAward['order']]['icon'] = iconPath($gridArray[$topAward['order']]['icon']);
        }

        foreach($gridArray as $key=>$gArray){
            $gridArray[$key]["order"] = $key;
        }

        return $gridArray;
    }
}