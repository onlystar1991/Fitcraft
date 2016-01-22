<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $table = 'event';

    protected $fillable = ['file_id','user_id','timestamp','timer_trigger','event','event_type','event_group'];
}
