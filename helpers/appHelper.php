<?php
use Carbon\Carbon;

/**
 * Notification
 */
function notification()
{

    if (Session::has('notification') && is_array(Session::get('notification'))) {

        $notification = Session::get('notification');
        echo  '<div class="alert alert-custom alert-'.$notification['type'].'">';
        if ( is_object($notification['msg']) ) {
            foreach ($notification['msg'] as $error->item):
                echo '<p>'.$error.'</p>';
            endforeach;
        } else {
            echo  $notification['msg'];
        }
        echo '</div>';
    }
}

function seasonDays($season_start)
{
    $created = new Carbon($season_start);
    $now = Carbon::now();

    return $created->diff($now)->days;

}

function seasonAllDays($season_start,$season_end)
{
    $start = new Carbon($season_start);
    $end = new Carbon($season_end);

    return $start->diff($end)->days;

}

/**
 * Convert meters to miles
 * @param $meters
 * @return float
 */
function metersToMiles($meters)
{
    return round($meters * 0.000621371192, 2);
}


/**
 * Height Inc to Height M
 * @param $inc
 * @return float
 */
function IncToM($ft,$inc)
{
    $cm = round(($ft * 12 / 0.393700787) + ($inc / 0.393700787));
    $m  = ($cm / 100);
    return floor($m);
}

/**
 * Height Inc to Height Cm
 * @param $inc
 * @return float
 */
function IncToCm($ft,$inc)
{
    $cm = round(($ft * 12 / 0.393700787) + ($inc / 0.393700787));
    $cm = ($cm / 100)-floor($cm / 100);   
    return ($cm);
}

/**
 * Weight lbs to Weight kg
 * @param $inc
 * @return float
 */
function LbsToKg($weight)
{
    $weight_kg = $weight*0.45359237;
    return ceil($weight_kg);
}
/**
 * Meters per second to Miles per hour
 * @param $mps meters per second
 * @return float
 */
function MpsToMph($mps)
{
    $mph = $mps * 2.2369362920544;
    return round($mph, 2);
}

function elevation($altitude) {

}

function timeAgo($seconds)
{
    $minutes    = floor($seconds / 60 );
    $hours      = floor($seconds / 3600);
    if ( $seconds < 59 ) {
        return $seconds.' s';
    }
    //Minutes
    else if($minutes <=60){

        $sec = $seconds - $minutes * 60;

        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }

        return $minutes.':'.$sec ;
        //return "$minutes minutes ago";
    }
    //hours
    else if($hours <=24000){
        $min = round(($seconds -  $hours * 3600) / 60) ;
        if ( $min > 0 ) {
            $min = ($min <10) ? '0'.$min : $min;
        } else {
            $min = '00';
        }

        $sec = $seconds -  $hours * 3600 - $min* 60;

        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }
        $secod = number_format($sec,0);
        if($secod=='0') {
            $secod = '00';
        } 
        return $hours.':'.$min.':'.$secod;
    }


}

function timeStatistic($seconds)
{
    $minutes    = round($seconds / 60 );
    $hours      = floor($seconds / 3600);
    if ( $seconds < 59 ) {
        return $seconds.' s';
    }
    //Minutes
    else if($minutes <=60){
        $sec = $seconds - $minutes * 60;
        $sec = number_format($sec,0);
        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }
        return $minutes.':'.$sec;
    }
    //hours
    else if($hours <=24000){
        $min = round(($seconds -  $hours * 3600) / 60) ;
        if ( $min > 0 ) {
            $min = ($min <10) ? '0'.$min : $min;
        } else {
            $min = '00';
        }

        $sec = $seconds -  $hours * 3600 - $min* 60;

        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }
        $secod = number_format($sec,0);
        if($secod=='0') {
            $secod = '00';
        } 
        return $hours.':'.$min.':'.$secod;
    }


}


/**
 *
 * @param $seconds
 * @return string
 */
function timeRide($seconds,$digit_2 = '')
{
    $minutes    = round($seconds / 60 );
    $hours      = floor($seconds / 3600);
    if ( $seconds < 59 ) {
        return $seconds.' s';
    }
    //Minutes
    else if($minutes <=60){
        $sec = $seconds - $minutes * 60;
        $sec = number_format($sec,0);
        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }
        if($digit_2) {
            return $minutes.':'.$sec;
        } else {
            return '00:'.$minutes.':'.$sec;
        }
        
    }
    //hours
    else if($hours <=24000){
        $min = round(($seconds -  $hours * 3600) / 60) ;
        if ( $min > 0 ) {
            $min = ($min <10) ? '0'.$min : $min;
        } else {
            $min = '00';
        }

        $sec = $seconds -  $hours * 3600 - $min* 60;

        if ( $sec > 0 ) {
            $sec = ($sec <10) ? '0'.$sec : $sec;
        } else {
            $sec = '00';
        }
        $secod = number_format($sec,0);
        if($secod=='0') {
            $secod = '00';
        } 
        if($digit_2) {
            return $hours.':'.$min;  
        } else {
            return $hours.':'.$min.':'.$secod;  
        }       
        
    }


}

function cardsPath($filename) {
    return '/public/assets/img/cards/'.$filename;
}

function iconPath($filename = null)  {
    if ( $filename ) {
        return config('bike.cloudfront').'/icons/'.$filename;
    }

    return '/public/assets/img/icon-empty.png';
}

function distanceTwoPoints($lat1, $lon1, $lat2, $lon2, $unit)
{
//     echo "<br />lat1= ".$lat1;
// echo "<br />lon1= ".$lon1;
// echo "<br />lat2= ".$lat2;
// echo "<br />lon2= ".$lon2;


    // $lon1 =0;
    $theta = $lon1 - $lon2;

  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

  $dist = acos($dist);

  $dist = rad2deg($dist);

  $miles = $dist * 60 * 1.1515;

  $unit = strtoupper($unit);
  // mi = m
  // 1.0 = 1609.344
  if ($unit == "K") {

    return ($miles * 1.609344);

   } 
   else if ($unit == "M") {
      return ($miles * 1609.344);
   }    
   else if ($unit == "N") {

      return ($miles * 0.8684);

   } 
    else {

        return $miles;

      }

}