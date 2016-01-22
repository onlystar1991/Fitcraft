<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersAwards
 * @package App\Models
 */
class UsersAwards extends Model {

    /**
     * @var string
     */
    protected $table = 'users_awards';

    /**
     * @var array
     */
    protected $fillable = ['user_id','awards_id','top','order'];

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getCountByUser($user_id)
    {
        return parent::where('user_id', $user_id)
                        ->count();
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

    public static function create(array $attributes = [])
    {
        $award = Awards::find($attributes['awards_id']);
        ActivityFeed::create([
            'user_id' => $attributes['user_id'],
            'file_id' => $attributes['file_id'],
            'type' => ActivityFeed::getTypes(true)['award'],
            'icon' => $award->icon,
            'earned' => 0,
            'name' => $award->title,
        ]);

        unset($attributes['file_id']);
        $model = new static($attributes);
        $model->save();
        return $model;
    }

} 