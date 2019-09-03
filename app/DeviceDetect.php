<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceDetect extends Model
{
    protected $table = 'device_detect';
    
    public $timestamps = true;
    
    protected $fillable = ['share_documents_id', 'user_agent','browser', 'operator','device','time','ip_address','location','latitude','longitude','project_id','document_id','created_at', 'updated_at'];
}
