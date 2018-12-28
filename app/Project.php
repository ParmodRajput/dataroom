<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    
    public $timestamps = true;

    protected $fillable = ['project_name', 'company' ];


     public function groups()
    {
        return $this->hasMany('App\Group','project_id');
    }

     public function group_members() 
    { 
        return $this->hasManyThrough('App\Group_Member','App\Group','project_id','group_id','id','id'); 
    } 
}
