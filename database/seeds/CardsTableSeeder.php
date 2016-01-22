<?php

use Illuminate\Database\Seeder;

class CardsTableSeeder extends Seeder
{
    public function run()
    {
        $cards = [
            [
                'title'         => 'POC STAR',
                'source'        => 'level',
                'difficulty'    => '2',
                'path'          => 'PC_PocStar_grey.png',
                'icon'          => 'IC_pocStar_grey.png',
            ],
            [
                'title'         => 'ROADIE',
                'source'        => 'achievement',
                'difficulty'    => '1',
                'path'          => 'PC_Roadie_grey.png',
                'icon'          => 'IC_roadie_grey.png',
            ],
            [
                'title'         => 'ROADETTE',
                'source'        => 'level',
                'difficulty'    => '1',
                'path'          => 'PC_Roadette_grey.png',
                'icon'          => 'IC_roadette_grey.png',
            ],
            [
                'title'         => 'NIGHT RIDER',
                'source'        => 'level',
                'difficulty'    => '3',
                'path'          => 'PC_nightRider_grey.png',
                'icon'          => 'IC_nightRider_grey.png',
            ],
            [
                'title'         => 'THE MESSENGER',
                'source'        => 'level',
                'difficulty'    => '3',
                'path'          => 'PC_theMessenger_grey.png',
                'icon'          => 'IC_theMessenger_grey.png',
            ],
            [
                'title'         => 'TRACK STAR',
                'source'        => 'level',
                'difficulty'    => '3',
                'path'          => 'PC_trackStar_grey.png',
                'icon'          => 'IC_trackStar_grey.png',
            ]
        ];

        foreach ( $cards as $card ) {
            \App\Models\Cards::create($card);
        }
    }
}
