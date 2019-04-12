<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceDetect extends Model
{
    protected $table = 'device_detect';
    
    public $timestamps = true;

    protected $fillable = ['document_id', 'user_agent','browser', 'operator','device','time','ip_address','location','latitude','longitude'];
}
