<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    protected $table = 'collaboration_with_group';
    
    public $timestamps = true;

    protected $fillable = ['group_id', 'project_id','collaboration_group_id'];
}
