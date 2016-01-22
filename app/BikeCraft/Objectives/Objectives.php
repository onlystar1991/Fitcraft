<?php namespace App\BikeCraft\Objectives;

use Illuminate\Support\Facades\Auth;

class Objectives
{
    public $user;

    public function __construct()
    {
        $this->user  = Auth::client()->user();
    }


}
