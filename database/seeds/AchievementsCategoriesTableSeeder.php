<?php

use Illuminate\Database\Seeder;

class AchievementsCategoriesTableSeeder extends Seeder
{
    public function run()
    {

        $categories = [
            'RIDES'     => [
                'SPEED',
                'POWER',
                'DISTANCE',
                'TIME',
                'HEART RATE',
                'ELEVATION',
            ],
            'EXPERIENCE'    => [
            ],
            'SOCIAL'    => [
            ],
            'EXPLORATION'    => [
            ],
            'CAREER'    => [
            ],
            'LEGACY'    => []
        ];

        \App\Models\AchievementsCategories::truncate();

        foreach ($categories as $key=>$value) {

            $item = \App\Models\AchievementsCategories::create([
                'title'     => $key,
                'parent'    => 0
            ]);

            if ( is_array($value) && !empty($value) ) {

                foreach ($value as $subcat) {
                    \App\Models\AchievementsCategories::create([
                        'title'     => $subcat,
                        'parent'    => $item->id
                    ]);
                }
            }

        }

    }
}
