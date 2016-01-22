<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

//        $this->call('RaceCategoriesTableSeeder');
//        $this->call('UsersTableSeeder');
//        $this->call('LevelsTableSeeder');
//        $this->call('PackagesTableSeeder');
//        $this->call('AdminsTableSeeder');
//        $this->call('CardsTableSeeder');
//        $this->call('AchievementsCategoriesTableSeeder');
        $this->call('AchievementsCriteriaTableSeeder');
	}

}
