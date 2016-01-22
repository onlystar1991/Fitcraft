<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cards;
use Image;

class CardsGreyIcon extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'CardsGreyIcon';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Set grey path for cards';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $cards = Cards::get();
        foreach ($cards as $card) {
            if(!empty($card->path)){
                if(@fopen(public_path('uploads/icons/'.$card->path), 'r')) {
                    Image::make(public_path('uploads/icon/' . $card->path))->greyscale()->save(public_path('uploads/icon/grey_' . $card->path));
                    $cards->path_grey = 'grey_' . $card->path;
                    $cards->save();
                }
            }
        }
	}

}
