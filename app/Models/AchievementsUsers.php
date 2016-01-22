<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AchievementsUsers extends Model {

    /**
     * @var string
     */
    protected $table = 'achievements_users';

    /**
     * @var array
     */
    protected $fillable = ['user_id','file_id','achievement_id','points'];


    /**
     * @param $user_id
     * @param $category
     * @return mixed
     */
    public static function getCountUserCategory($user_id, $category)
    {
        return parent::leftJoin('achievements','achievements.id','=','achievements_users.achievement_id')
                        ->where('user_id',$user_id)
                        ->where(function($query) use ($category){
                            $query->where('category_id','=',$category)
                                   ->orWhere('subcategory_id','=',$category);
                        })
                        ->count();
    }

    /**
     * @param $user_id
     * @param $category
     * @return mixed
     */
    public static function getPointUserCategory($user_id, $category)
    {
         $query = parent::
            select(
                DB::RAW(' IF(ROUND(SUM(achievements.points),0), ROUND(SUM(achievements.points),0) ,0) as allUserpoints')
            )
            ->leftJoin('achievements','achievements.id','=','achievements_users.achievement_id')
            ->where('user_id',$user_id)
            ->where(function($query) use ($category){
                $query->where('category_id','=',$category)
                    ->orWhere('subcategory_id','=',$category);
            })
            ->first();
            if(!empty($query))
                return (int)$query->allUserpoints;
            else return 0;
    }


    public function getCount($user_id)
    {
        return $this->select()->where('user_id',$user_id)->count();
    }

    public function getCountPoints($user_id)
    {
        $query = $this->select(
            DB::RAW(' ROUND(SUM(points),0) as allUserpoints  ')
        )->where('user_id',$user_id)->first();
        return (int)$query->allUserpoints;
    }

    public function getByFile($file_id)
    {
        $query = $this->select(
            'achievements.title',
            'achievements.points',
            'achievements.icon',
            'achievements.difficulty',
            'achievements.criteria_text',
            'cards.icon as icon_player_card'
        )
            ->leftJoin('achievements','achievements.id','=','achievements_users.achievement_id')
            ->leftJoin('cards','cards.achievement_id','=','achievements.id')
            ->where('achievements_users.file_id','=',$file_id)
            ->orderBy('achievements.criteria_id','asc');
        return   $query->get();
    }

    public static function create(array $attributes = [])
    {
        $achievement = Achievements::find($attributes['achievement_id']);
        ActivityFeed::create([
            'user_id' => $attributes['user_id'],
            'file_id' => $attributes['file_id'],
            'type' => ActivityFeed::getTypes(true)['achievement'],
            'icon' => $achievement->icon,
            'earned' => $attributes['points'],
            'name' => $achievement->title,
        ]);

        $model = new static($attributes);
        $model->save();
        return $model;
    }
}
