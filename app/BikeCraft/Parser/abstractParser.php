<?php namespace App\BikeCraft\Parser;


abstract class abstractParser {


    public function calculateGrade($current, $last, $distance)
    {
        $grade = 0;

        if ( $distance > 0 ) {
            $grade = ($current - $last) / $distance * 100;
            return $grade ;
        }

        return $grade;
    }

}