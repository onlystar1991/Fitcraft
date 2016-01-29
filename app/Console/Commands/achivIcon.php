<?php namespace App\Console\Commands;

use App\Models\Achievements;
use Illuminate\Console\Command;
use App\Models\User;
use Image;

class AchivIcon extends Command {

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'AchivIcon';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Set grey icons for achievements';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $achievements = Achievements::get();
        foreach ($achievements as $achievement) {
            if(!empty($achievement->icon)){
                if(@fopen(public_path('uploads/icons/'.$achievement->icon), 'r'))
                    Image::make(public_path('uploads/icons/'.$achievement->icon))->greyscale()->save(public_path('uploads/icons/grey_'.$achievement->icon));
                $achievement->icon_grey = 'grey_'.$achievement->icon;
                $achievement->save();
            }
        }

    }

}
