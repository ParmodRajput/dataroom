<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    
    public $timestamps = true;

    protected $fillable = ['project_id', 'group_name'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

  public function group_members()
    {
        return $this->hasMany('App\Group_Member','group_id');
    }

}


