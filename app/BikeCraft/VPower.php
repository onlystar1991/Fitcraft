<?php namespace App\BikeCraft;

/**
 * Estimated Power
 * Class VPower
 * @package App\BikeCraft
 */
class VPower
{

    /**
     * Default parameters
     * @var array
     */
    protected $parameters = [
        'bike_weight'           =>  9,   //kg
        'frontal_area'          => .509,
        'drag_coefficient'      => .63,
        'power_loss'            => .03,  //3%
        'rolling_resistance'    => .005,
        'air_density'           => 1.226,  //.076537

    ];

    /**
     * @var
     */
    public $grade = 0;

    /**
     * Ride Weight KG
     * @var
     */
    public $rider_weight;

    /**
     * Total Weight (bike + rider weight)
     * @var kg
     */
    public $total_weight = 86;

    /**
     * The formula for gravitational force acting on a cyclist, in metric units, is:
     *  9.8067 (m/s2) · sin(arctan(G/100)) · W (kg)
     * @return float
     */
    private function forceGravity()
    {

        return 9.8067 * sin(atan($this->grade/100)) * $this->total_weight ;
    }

    /**
     * The formula for the rolling resistance acting on a cyclist, in metric units
     * 9.8067 (m/s2) · cos(arctan(G/100)) · W (kg) · Crr
     * @return float
     */
    private function forceRolling()
    {
        return 9.8067 * cos(atan($this->grade/100)) * $this->total_weight * $this->parameters['rolling_resistance'];
    }

    /**
     * The formula for the aerodynamic drag acting on a cyclist
     * 0.5 · Cd · A (m2) · Rho (kg/m3) · (V (m/s))2
     * @param $speed m/s
     * @return float
     */
    private function forceDrag($speed)
    {
        return 0.5 * $this->parameters['drag_coefficient'] * $this->parameters['frontal_area'] * $this->parameters['air_density'] * pow($speed,2);
    }

    /**
     * The total force resisting
     * @return float
     */
    private function forceResist($speed)
    {

        return $this->forceGravity() + $this->forceRolling() + $this->forceDrag($speed);
    }


    /**
     * @param $speed
     * @return float
     */
    public function power($speed)
    {
        //Total force
        $force_resist = $this->forceResist($speed);

        /*
         * Wheel Power
         * Fresist· V (m/s)
         */
        $wheel_power = $force_resist * $speed;

        // Leg Power
        $leg_power = $wheel_power / ( 1 - $this->parameters['power_loss'] );
        $leg_power = ($leg_power > 0) ? $leg_power : 0;

        return $leg_power > 0 ? $leg_power : 0;

    }


    /**
    * @return mixed
    */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
    * @param mixed $grade
    */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return mixed
     */
    public function getRiderWeight()
    {
        return $this->rider_weight;
    }

    /**
     * @param mixed $rider_weight
     */
    public function setRiderWeight($rider_weight)
    {
        $this->rider_weight = $rider_weight;
    }

    /**
     * @return mixed
     */
    public function getTotalWeight()
    {
        return $this->total_weight;
    }

    /**
     * @return mixed
     */
    public function setTotalWeight()
    {
        return $this->total_weight = $this->rider_weight + $this->parameters['bike_weight'];
    }


} 