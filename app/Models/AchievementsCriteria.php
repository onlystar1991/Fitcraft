<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementsCriteria extends Model {

    /**
     * @var string
     */
    protected $table = 'achievements_criteria';

    /**
     * @var array
     */
    protected $fillable = ['title','key', 'category_id'];


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
