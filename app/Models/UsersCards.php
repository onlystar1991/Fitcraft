<?php namespace App\Models;

use App\Models\Cards;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersCards
 * @package App\Models
 */
class UsersCards extends Model
{

    /**
     * @var string
     */
    protected $table = 'users_cards';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'cards_id'];

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
        $card = Cards::find($attributes['cards_id']);
        ActivityFeed::create([
            'user_id' => $attributes['user_id'],
            'file_id' => $attributes['file_id'],
            'type' => ActivityFeed::getTypes(true)['card'],
            'icon' => $card->icon,
            'earned' => 0,
            'name' => $card->title,
        ]);

        unset($attributes['file_id']);
        $model = new static($attributes);
        $model->save();
        return $model;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getCardsIcon($user_id)
    {
        $user = User::find($user_id)->select('cards_id')
            ->first();
        if (isset($user)) {
            $card = $user->toArray();
            $all_cart = Cards::select('icon')->where('id', '=', $card['cards_id'])->first();

            if (isset($all_cart)) {
                $vard_image = $all_cart->toArray();
                return iconPath($vard_image["icon"]);
            } else {
                return iconPath('/assets/img/user_1.png');
            }

        } else {
            return iconPath('/assets/img/user_1.png');
        }

    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getCardsIcon2($card_id)
    {
        if (isset($card_id)) {
            $all_cart = Cards::find($card_id);
            if (isset($all_cart)) {
                return iconPath($all_cart->icon);
            } else {
                return '/assets/img/icon-empty.png';
            }
        } else {
            return ;
        }

    }

} 