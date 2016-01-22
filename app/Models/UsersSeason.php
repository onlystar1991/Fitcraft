<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSeason extends Model {

    protected $table = 'users_season';

    protected $fillable = ['user_id','start','end'];
}



