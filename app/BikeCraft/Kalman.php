<?php namespace App\BikeCraft;

/**
 *
 * Kalman Position Filter - Simple Kalman filter class for GPS position data
 * http://en.wikipedia.org/wiki/Kalman_filter
 * http://stackoverflow.com/a/15657798
 *
 * Class KalmanPosition
 * @package App\BikeCraft
 */
class Kalman {

    /**
     * @var float
     */
    private $MinAccuracy = 1.0;

    /**
     * @var float
     */
    private $Q_metres_per_second = 0.0;

    /**
     * @var int  milliseconds
     */
    private $timestamp = 0;

    /**
     * @var float
     */
    private $lat = 0.0;

    /**
     * @var float
     */
    private $lng = 0.0;

    /**
     * @var float
     */
    private $ele = 0.0;

    /**
     * @var float
     */
    private $variance = 0.0;

    public function __construct($Q_metres_per_second)
    {
        $this->Q_metres_per_second = $Q_metres_per_second;
        $this->variance = -1.0;
    }

    /**
     * @param $lat
     * @param $lng
     * @param $ele
     * @param $accuracy
     * @param $timestamp
     */
    public function setState($lat, $lng, $ele, $accuracy, $timestamp)
    {
        $this->lat          = $lat;
        $this->lng          = $lng;
        $this->ele          = $ele;
        $this->variance     = $accuracy * $accuracy;
	    $this->timestamp    = $timestamp;
    }

    /**
     * @param $lat_measurement
     * @param $lng_measurement
     * @param $ele_measurement
     * @param $accuracy
     * @param $timestamp
     */
    public function process($lat_measurement, $lng_measurement, $ele_measurement, $accuracy, $timestamp)
    {
        if ( $accuracy < $this->MinAccuracy ) {
            $accuracy = $this->MinAccuracy;
        }

        if ( $this->variance < 0 ) {

            $this->timestamp    = $timestamp;
            $this->lat          = $lat_measurement;
            $this->lng          = $lng_measurement;
            $this->ele          = $ele_measurement;
            $this->variance     = $accuracy * $accuracy;

        } else {

            $time_inc = $timestamp - $this->timestamp;

            if ( $time_inc > 0 ) {
                $this->variance += $time_inc * $this->Q_metres_per_second * $this->Q_metres_per_second / 1000;
                $this->timestamp = $timestamp;
            }

            # Kalman gain matrix K = Covarariance * Inverse(Covariance + MeasurementVariance)
            # NB: because K is dimensionless, it doesn't matter that variance has different units to lat and lng
            $K = $this->variance / ( $this->variance + $accuracy * $accuracy );

            # apply K
            $this->lat += $K * ( $lat_measurement - $this->lat );
            $this->lng += $K * ( $lng_measurement - $this->lng );
            $this->ele += $K * ( $ele_measurement - $this->ele );

            # new Covarariance  matrix is (IdentityMatrix - K) * Covarariance
            $this->variance = ( 1- $K ) * $this->variance;

        }

    }

    /**
     * @return float
     */
    public function getEle()
    {
        return $this->ele;
    }

    /**
     * @param float $ele
     */
    public function setEle($ele)
    {
        $this->ele = $ele;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return float
     */
    public function getVariance()
    {
        return sqrt( $this->variance );
    }

    /**
     * @param float $variance
     */
    public function setVariance($variance)
    {
        $this->variance = $variance;
    }

} 