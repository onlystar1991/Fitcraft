<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceInfo extends Model {

    protected $table = 'device_info';

    protected $fillable = ['file_id','user_id','timestamp','serial_number','serial_number','manufacturer','product','software_version','device_index','device_type'];
}



