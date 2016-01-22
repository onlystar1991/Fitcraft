<?php namespace App\BikeCraft;

use Carbon\Carbon;

/**
 * Class Data
 * @package App\BikeCraft
 */
class Data {

    /**
     * Convert unix time to Garmin epoch timestamp.
     * @param int $unixtime
     * @return int
     */
	public static function timeToGarmin($unixtime)
    {
        return $unixtime - mktime(0,0,0,12,31,1989);
    }

    /**
     * Convert garmin time to unix timestamp
     * @param $garmin_time
     * @return int
     */
    public static function timeToUnix($garmin_time)
    {
        return $garmin_time + mktime(0,0,0,12,31,1989);
    }

    /**
     * Show date by format
     * @param $date
     * @param string $format
     * @return string
     */
    public static function showDate($date, $format='d.m.y')
    {
        return date($format, strtotime($date));
    }

    /**
     * @param $start
     * @param $end
     * @return string
     */
    public static function sessionTimeStartEnd($start, $end)
    {
        return date('H:i',strtotime($start)).'-'.date('H:i',strtotime($end));
    }



}