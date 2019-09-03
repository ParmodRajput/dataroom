<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'action_type';
    
    public $timestamps = true;

    protected $fillable = ['action'];
}
