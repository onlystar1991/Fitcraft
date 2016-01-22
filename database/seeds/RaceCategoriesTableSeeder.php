<?php

use Illuminate\Database\Seeder;

use App\Models\RaceCategories;
class RaceCategoriesTableSeeder extends Seeder {

    public function run()
    {
        $race_categories = [
            ['title' => '',                 'level'=>0,  'nr'=>0],
            ['title' => 'Category 5',       'level'=>50, 'nr'=>5],
            ['title' => 'Category 4',       'level'=>60, 'nr'=>4],
            ['title' => 'Category 3',       'level'=>70, 'nr'=>3],
            ['title' => 'Category 2',       'level'=>80, 'nr'=>2],
            ['title' => 'Category 1',       'level'=>90, 'nr'=>1],
            ['title' => 'Elite Category',   'level'=>100,'nr'=>'ELITE'],
        ];

        foreach($race_categories as $category) {
            RaceCategories::create($category);
        }
        $this->command->info('Race Categories seeded :-)');
    }

}