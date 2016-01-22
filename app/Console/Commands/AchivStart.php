<?php namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;


use App\BikeCraft\Analysis;
use App\Models\Achievements;
use App\Models\AchievementsUsers;
use App\Models\BonusXP;
use App\Models\Lap;
use App\Models\Rides;
use App\Models\UsersCards;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchivStart extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'AchivStart';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'test achivments';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	protected $user;
	/**
	 * @var Analysis
	 */
	protected $analysis;
	/**
	 * @var Career
	 */
	protected $career;
	/**
	 * @var Experience
	 */
	protected $experience;

	/**
	 * @var Legacy
	 */
	protected $legacy;
	/**
	 * @var Exploration
	 */
	protected $exploration;

	/**
	 * @param Analysis $analysis
	 * @param Ride $ride
	 * @param Career $career
	 * @param Experience $experience
	 * @param Exploration $exploration
	 * @param Legacy $legacy
	 */
    static function getUser($id){
        return User::select('users.*',
            'race_categories.nr',
            'users_season.end as season_end'
        )
            ->leftJoin('race_categories','race_categories.id','=','users.category_id')
            ->leftJoin('users_season','users.id','=','users_season.user_id')
            ->where('users.id',$id)
            ->where('users_season.active',1)
            ->first();
    }

	public function handle(
                            \App\BikeCraft\Analysis $analysis,
						   \App\BikeCraft\Achievements\Ride $ride,
						   \App\BikeCraft\Achievements\Career $career,
						   \App\BikeCraft\Achievements\Experience $experience,
						   \App\BikeCraft\Achievements\Exploration $exploration,
						   \App\BikeCraft\Achievements\Legacy $legacy)
	{
		$user_ = self::getUser(80);
		$user     = Auth::client()->login($user_);
		$user = Auth::client()->user();
		$this->ride         = $ride;
		$this->analysis     = $analysis;
		$this->career       = $career;
		$this->experience   = $experience;
		$this->exploration   = $exploration;
		$this->legacy   = $legacy;
		$file_id = 484;
		$achievements = \App\Models\Achievements::getLocked($user->id);
		foreach ($achievements as $achievement) {
			$achievement->file_id = $file_id;
            $this->ride->doProcessing($achievement);
            $this->career->doProcessing($achievement);

			$this->exploration->doProcessing($achievement);

            $this->experience->doProcessing($achievement);
            $this->legacy->doProcessing($achievement);

		}

		dd("Done");
	}

}
