<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\BikeCraft\UserXP;
use App\BikeCraft\Data;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * List
     * @return mixed
     */
    public static function getUser($id)
    {
        $user_request = Auth::client()->user()->id;
        return parent::select('users.*',
                        'race_categories.nr',
                        'users_season.end as season_end',
                        DB::RAW("IF(users.id = $user_request, 0, 1) as report_enable")
                        )
                       ->leftJoin('race_categories','race_categories.id','=','users.category_id')
                       ->leftJoin('users_season','users.id','=','users_season.user_id')
                       ->where('users.id',$id)
                       ->where('users_season.active',1)
                       ->first();
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     */
    public static function updateWhere($where, $data)
    {
        return parent::where($where)
            ->update($data);
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

    public function raceCategories()
    {
        return $this->hasOne('App\Models\RaceCategories', 'id', 'category_id');
    }

    public function uploadParsing()
    {
        return $this->hasMany('upload_parsings');
    }


    public static function getUserProfileInfo($user_id,$request = false)
    {
        $profile = User::getUser($user_id);
        // Forum
        if (!is_numeric($profile->forum_user_id)) {
            $otf = new OTF([
                'driver'   => config('database.default'),
                'database' => 'fitcraft_forum',
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
            ]);
            if ($forum_user = $otf->getTable('zzBB_users')->where('username','=',$profile->email)->first()) {
                $profile->forum_user_id = $forum_user->user_id;
                $profile->forum_nickname = $forum_user->username_clean;
                User::where('id','=',$user_id)->update(['forum_user_id' => $forum_user->user_id]);
            }
        }else{
            $otf = new OTF([
                'driver'   => config('database.default'),
                'database' => 'fitcraft_forum',
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
            ]);
            if ($forum_user = $otf->getTable('zzBB_users')->where('username','=',$profile->email)->first()) {
                $profile->forum_user_id = $forum_user->user_id;
                $profile->forum_nickname = $forum_user->username_clean;
                User::where('id','=',$user_id)->update(['forum_user_id' => $forum_user->user_id]);
            }
        }
        
        // Card
        $cards_find = Cards::find($profile->cards_id);
        $profile->avatar = (!empty($cards_find))? iconPath($cards_find->path):'';


        // Level
        $table_levels = new Levels();
        $levels  = $table_levels->where('level',$profile->level)->first();
        $levels_count = $table_levels->maxLevel();

        var_dump($profile->level);
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        var_dump($levels);
        die;

        $progress_level  = round($profile->xp / $levels->xp_required * 100);
        $profile->progress_level  = round($profile->xp / $levels->xp_required * 100);
        $profile->levels_xp = round($levels->xp_required);
        $profile->xp = round($profile->xp);

        // Season
        $season_days     = seasonDays($profile->season_start);
        $season_days_all     = seasonAllDays($profile->season_start,$profile->season_end);
        $progress_season = $season_days / $season_days_all * 100;
        $season = [
            'progress' => $progress_season,
            'days_all' => $season_days_all,
            'days'     => $season_days
        ];

        // Achievements
        $table_achievements = new Achievements();
        $table_achievementsUsers = new AchievementsUsers();

        $achievements_all = $table_achievements->getPoints();
        $achievements_user = $table_achievementsUsers->getCountPoints($profile->id);
        $achievements = [
            'achievements_all' => $achievements_all,
            'achievements_user' => $achievements_user,
            'progress' => $achievements_user>0?$achievements_user / $achievements_all * 100:0
        ];

        // Trophies
        $trophies = Awards::getGridTopUserAwards($user_id);
        $result = [
            'profile' => $profile,
            'progress_level' => $progress_level,
            'levels_count' => $levels_count,
            'trophies' => $trophies,
            'season' => $season,
            'achievements' => $achievements
        ];

        if ($request) {
            $userXP = new UserXP(new Levels());
            $userXP->calculateFTP($profile);

            $statistic = Lap::getStatistics($user_id,$request->get('filter'),$userXP->getFtp());

            $rides = Rides::getByUserId($user_id, $request);
            foreach ($rides as $ride) {

                $bonusZones = BonusXP::getByRide($ride->id);

                $ride->zone_1 += $bonusZones[1];
                $ride->zone_2 += $bonusZones[2];
                $ride->zone_3 += $bonusZones[3];
                $ride->zone_4 += $bonusZones[4];
                $ride->zone_5 += isset($bonusZones[5]) ? $bonusZones[5] : 0;

                $ride->zone_1 = round($ride->zone_1);
                $ride->zone_2 = round($ride->zone_2);
                $ride->zone_3 = round($ride->zone_3);
                $ride->zone_4 = round($ride->zone_4);
                $ride->zone_5 = round($ride->zone_5);

                $ride->total_xp         = round($ride->total_xp);
                $ride->total_bonus_xp   = round(array_sum($bonusZones));

                $zones = [$ride->zone_1_time, $ride->zone_2_time, $ride->zone_3_time, $ride->zone_4_time, $ride->zone_5_time ];
                $total = array_sum($zones);
                if ( $total != 0 ) {
                    array_walk($zones, function (&$value, $key, $total) {
                        $value = round($value / $total * 100, 1);
                    }, $total);
                }

                $ride->zones_percentages    = $zones;
                $ride->avg_heart_rate       = (int) $ride->avg_heart_rate;
                $ride->max_heart_rate       = (int) $ride->max_heart_rate;
                $ride->avg_cadence          = (int) $ride->avg_cadence;
                $ride->max_cadence          = (int) $ride->max_cadence;
                $ride->avg_power            = (!empty($ride->avg_power)) ? (int) $ride->avg_power : (int) $result['profile']->power;
                $ride->max_power            = (!empty($ride->max_power)) ? (int) $ride->max_power : (int) $result['profile']->power;

                $ride->ride_start_time      = date('H:i:s',Data::timeToUnix($ride->start_time));
                $ride->ride_end_time        = date('H:i:s',Data::timeToUnix($ride->start_time + $ride->total_elapsed_time  ) );
                $ride->total_elapsed_time   = gmdate("H:i:s",$ride->total_elapsed_time);
                $ride->date                 = date('m/d/y',Data::timeToUnix($ride->start_time));
                $ride->time                 = timeRide($ride->moving_time);

            }

            $result['rides'] = $rides;
            $result['statistic'] = $statistic;
        } else {
            $result['feed'] = ActivityFeed::getUserAsideFeed($user_id);
        }

        $tutorial = UsersTutorial::select(
            'player_card_btn',
            'choose_card_btn',
            'upload_ride_btn',
            'browse_file__btn',
            'upload_file_btn',
            'upload_complete_next',
            'activity_feed_next',
            'athlete_profile_next',
            'leaderboard_next',
            'ride_library_btn',
            'ride_library_next',
            'finish_tooltips_btn',
            'exit_achievements_btn',
            'exit_objectives_btn',
            'exit_gear_btn'
        )
            ->where('user_id', $user_id)->first();
        $result['tutorial'] = $tutorial;
        return $result;
    }


}
