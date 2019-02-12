<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_Member extends Model
{

 
  protected $table = 'group_members';
  public $timestamps = true;
  protected $fillable = ['group_id','member_email'];
     
   public function group()
    {
        return $this->belongsTo('App\Group','group_id');
    }
   
   public function getProjectAttribute() 
   { 
   	return $this->group_member->project; 
   } 
 

}
