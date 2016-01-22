<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $table = 'activity';

    protected $fillable = ['file_id','timestamp','total_timer_time','num_sessions','type','event','event_type','user_id'];
}



