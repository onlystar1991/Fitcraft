<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UsersCards;
use App\Models\Cards;
use App\Models\UsersTutorial;
use Geocoder;

class CardUsers extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'CardUsers';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add country for users';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$users = User::select('users.id')
			->get();

		foreach($users as $user){
            $card_man = Cards::select('id')->where('source','=','default_man')->first();
            $card_girl = Cards::select('id')->where('source','=','default_female')->first();
            if($user->gender=='m'){
                if($card_man){
                    $user->cards_id = $card_man->id;
                }
            }else{
                if($card_girl){
                    $user->cards_id = $card_girl->id;
                }
            }

            // inster in cards
            if(isset($card_man)) {
                $userscards           = new UsersCards();
                $userscards->user_id  = $user->id;
                $userscards->cards_id = $card_man->id;
                $userscards->save();
            }

            // inster in cards
            if(isset($card_girl)) {
                $userscards           = new UsersCards();
                $userscards->user_id  = $user->id;
                $userscards->cards_id = $card_girl->id;
                $userscards->save();
            }
		}
	}

}
