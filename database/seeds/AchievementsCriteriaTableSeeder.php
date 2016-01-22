<?php

use Illuminate\Database\Seeder;
class AchievementsCriteriaTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\AchievementsCriteria::truncate();

        $exploration = [
            'RIDE X MILES WITHIN YOUR HOME ZIP CODE',
            'RIDE X MILES WITHIN YOUR HOME COUNTRY',
            'RIDE X MILES OUTSIDE OF YOUR HOME COUNTRY',
            'RIDE AT LEAST X MILES IN AND OUT OF YOUR COUNTRY IN A SINGLE MONTH',
            'COMPLETE X RIDES IN X COUNTRIES OF AT LEAST 30 MINUTES',
            'CLIMB AT LEAST X FT OUTSIDE YOUR HOME COUNTRY',
            'CLIMB AT LEAST X FT AND RIDE 100 MILES OUTSIDE OF YOUR HOME COUNTRY',
            'COMPLETE ALL EXPLORATION ACHIEVEMENTS',
        ];


        foreach ($exploration as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 10
            ]);
        }

        $experience = [
            'EARN LEVEL N',
            'EARN MORE THAN X EXPERIENCE POINTS IN A SINGLE RIDE',
            'EARN MORE THAN X EXPERIENCE POINTS IN A SINGLE MONTH',
            'COMPLETE ALL EXPERIENCE ACHIEVEMENTS',
        ];

        foreach ($experience as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 8
            ]);
        }

        $career = [
            'EARN CATEGORY N',
            'EARN ELITE CATEGORY',
            'COMPLETE YOUR N SEASON',
            'START YOUR FIRST SEASON',
            'UPGRADE A SEASON DIFFICULTY',
            'COMPLETE A SEASON ON HARD MODE',
            'COMPLETE A SEASON ON EPIC DIFFICULTY',
            'COMPLETE ALL CAREER ACHIEVEMENTS',
        ];


        foreach ($career as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 11
            ]);
        }

        $rides = [
            'COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE DAY',
            'COMPLETE X RIDES OF AT LEAST 30 MINUTES IN ONE WEEK',
            'COMPLETE A RIDE A DAY OF AT LEAST 30 MINUTES FOR AN ENTIRE CALENDER MONTH',
            'COMPLETE A RIDE ON OCTOBER 31ST',
            'COMPLETE A RIDE ON THANKSGIVING',
            'COMPLETE A RIDE ON FEBUARY 14TH',
            'UPLOAD X RIDES',
            'COMPLETE ALL RIDE ACHIEVEMENTS',
            'RIDE A TOTAL OF X MILES',
            'RIDE AT LEAST X MILES IN A SINGLE RIDE',
            'RIDE AT LEAST X MILES, TWICE IN A SINGLE WEEKEND',
            'RIDE AT LEAST X MILES IN ONE WEEK',
            'RIDE AT LEAST X MILES IN ONE MONTH',
            'COMPLETE A RIDE ON JANUARY 1ST',
            'RIDE A TOTAL OF X HOURS',
            'RIDE FOR AT LEAST X MINUTES IN A SINGLE RIDE',
            'RIDE AN AVG SPEED OF X MPH OR HIGHER ON A RIDE OF 30 MIN OR MORE',
            'RIDE FOR AT LEAST 10 SECONDS ABOVE X MPH',
            'CLIMB A TOTAL OF X FT IN ELEVATION',
            'CLIMB A MORE THAN X FT IN A SINGLE RIDE',
            'RIDE AT LEAST X CONSECUTIVE DAYS IN A ROW FOR A MINIMUM OF 30 MIN PER RIDE',
            'RIDE AT LEAST X HOURS, TWICE IN A SINGLE WEEKEND',
            'COMPLETE ALL ELEVATION ACHIEVEMENTS',
            'COMPLETE ALL HEART RATE ACHIEVEMENTS',
            'COMPLETE ALL POWER ACHIEVEMENTS',
            'COMPLETE ALL TIME ACHIEVEMENTS',
            'COMPLETE ALL SPEED ACHIEVEMENTS',
            'COMPLETE ALL DISTANCE ACHIEVEMENTS',
            'AVG ABOVE X WATTS IN A RIDE OF 30 MINUTES OR MORE',
            'AVG ABOVE X WATTS IN A RIDE OF 60 MINUTES OR MORE',
            'RECORD A TOP SPEED OVER X MPH',
            'RIDE 1000 MILES DURING THE MONTH OF X MONTH',
            'CLIMB MORE THAN X FT IN A SINGLE MONTH',
            'CLIMB 30,000 FT DURING THE MONTH OF X MONTH',
            'RIDE 50 HOURS OR MORE DURING THE MONTH OF X',
            'RIDE X HOURS DURING THE 2ND WEEK OF JUNE',
            'COMPLETE A RIDE OF X HOURS OR MORE DURING THE 3RD WEEK OF MARCH',
            'COMPLETE A RIDE OF X HOURS OR MORE DURING THE 1ST WEEK OF APRIL',
            'COMPLETE A RIDE OF X HOURS OR MORE DURING THE 2ND WEEK OF APRIL',
            'COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF APRIL',
            'COMPLETE A RIDE OF X HOURS OR MORE DURING THE 4TH WEEK OF SEPTEMBER',
            'COMPLETE KING OF THE MOUNTAIN IV / ROAD TO THE TOP III',
            'COMPLETE I HAVE THE POWER III / ABOVE AND BEYOND',
            'COMPLETE SPEED DEMON IV / FAST LANE I / CONSISTENCY IS KEY III',
            'COMPLETE SPEED IT UP II / TIME TRIAL TRAINING IV / HIGH SPEED TRAINING II',
            'COMPLETE A RIDE OF X MILES OR MORE DURING THE 3RD WEEK OF MARCH',
            'COMPLETE A RIDE OF X MILES OR MORE DURING THE 1ST WEEK OF APRIL',
            'COMPLETE A RIDE OF X MILES OR MORE DURING THE 2ND WEEK OF APRIL',
            'COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF APRIL',
            'COMPLETE A RIDE OF X MILES OR MORE DURING THE 4TH WEEK OF SEPTEMBER',
            'RIDE X MILES DURING THE 2ND WEEK OF JUNE',
            'RIDE AN AVG OF X MPH OR HIGHER FOR 3 CONSECUTIVE RIDES',
            'RIDE AN AVG OF X MPH OR HIGHER FOR 5 CONSECUTIVE RIDES',
            'RIDE AN AVG OF X MPH OR HIGHER FOR 10 CONSECUTIVE RIDES',
            'COMPLETE HEARTBREAKER III / VO2 MACHINE II / THE SUFFERING II',
            'RIDE FOR AT LEAST 15 SECONDS WITH AN AVG POWER OF X WATTS OR MORE',
            'RIDE WITH AN AVG HEART RATE IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE',
            'RIDE WITH AN AVG HEART RATE IN YOUR ZONE 3 FOR AT LEAST 60 MINUTES',
            'RIDE WITH AN AVG HEART RATE IN ZONE 3 FOR AT LEAST 60 MINUTES ON 10 RIDES',
            'RECORD AN AVG HEART RATE IN ZONE 4 FOR AT LEAST 5 MINUTES AT LEAST X TIMES IN ONE RIDE',
            'RECORD AN AVG HEART RATE IN ZONE 5 FOR AT LEAST 20 SECONDS AT LEAST X TIMES IN ONE RIDE',
            'RIDE WITH AN AVG POWER IN YOUR ZONE X DIFFICULTY ON A RIDE OF AT LEAST 30 MIN OR MORE',
            'RIDE WITH AN AVG POWER IN YOUR ZONE 3 FOR AT LEAST 120 MINUTES',
            'COMPLETE A RIDE ON JANUARY 1ST',
            'RIDE X MILES DURING THE MONTH OF MAY',
            'RIDE X MILES DURING THE MONTH OF JULY',
            'RIDE X MILES DURING THE MONTH OF SEPTEMBER',
        ];

        foreach ($rides as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 1
            ]);
        }

        $legacy = [
            'BE PART OF THE FITCRAFT BETA',
            'COMPLETE RIDE THE TOUR / CLIMB THE TOUR / EXPERIENCE THE TOUR',
            'COMPLETE RIDE THE GIRO / CLIMB THE GIRO/ EXPERIENCE THE GIRO',
            'COMPLETE RIDE THE VUELTA/ CLIMB THE VUELTA/ EXPERIENCE THE VUELTA',
            'COMPLETE YELLOW JERSEY / PINK JERSEY / RED JERSEY',
            'COMPLETE RIDE MILANO SAN REMO / CYCLE MILANO SAN REMO',
            'COMPLETE RIDE PARIS ROUBAIX / CYCLE PARIS ROUBAIX',
            'COMPLETE RIDE TOUR OF FLANDERS / CYCLE TOUR OF FLANDERS',
            'COMPLETE RIDE TOUR DE SUISSE / CYCLE TOUR DE SUISSE',
            'COMPLETE RIDE LIEGE BASTOGNE LIEGE / CYCLE LIEGE BASTOGNE LIEGE'
        ];


        foreach ($legacy as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 12
            ]);
        }

        $social = [
            'FOLLOW SOMEONE WHO IS FOLLOWING YOU',
            'GAIN A FOLLOWER FROM OUTSIDE YOUR COUNTRY',
            'GAIN A FOLLOWER FROM YOUR ZIP CODE',
            'GAIN X FOLLOWERS',
            'FOLLOW X ATHLETES',
            'COMPLETE AT LEAST X RIDES WITH SOMEONE YOU FOLLOW',
            'COMPLETE AT LEAST X RIDES WITH A FOLLOWER',
            'COMPLETE ALL SOCIAL ACHIEVEMENTS',
        ];


        foreach ($social as $item) {
            \App\Models\AchievementsCriteria::create([
                'title'          => $item,
                'category_id'   => 9
            ]);
        }

        $this->command->info('Achievements criteria seed ');

    }
}
