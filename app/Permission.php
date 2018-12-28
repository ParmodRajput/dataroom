<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'document_permission';
    
    public $timestamps = true;

    protected $fillable = ['document_id', 'project_id','group_id', 'permission_id','created_by','updated_by'];
}
