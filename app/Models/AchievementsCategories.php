<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AchievementsCategories extends Model {

    /**
     * @var string
     */
    protected $table = 'achievements_categories';

    /**
     * @var array
     */
    protected $fillable = ['title','parent'];


    /**
     * @return mixed
     */
    public static function getTotalByCat()
    {
        return parent::select(
                    'achievements_categories.id',
                    'achievements_categories.title',
                    DB::RAW('COUNT(achievements.id) as total')
                    )
                    ->leftJoin('achievements','achievements.category_id','=','achievements_categories.id')
                    ->where('achievements_categories.parent','=',0)
                    ->groupBy('achievements_categories.id')
                    ->get();
    }

    /**
     * @return mixed
     */
    public static function getPointsByCat()
    {
        return parent::select(
            'achievements_categories.id',
            'achievements_categories.title',
            DB::RAW('ROUND(SUM(achievements.points),0) as total')
        )
            ->leftJoin('achievements','achievements.category_id','=','achievements_categories.id')
            ->where('achievements_categories.parent','=',0)
            ->groupBy('achievements_categories.id')
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
