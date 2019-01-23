<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin_users';
    
    public $timestamps = true;

    protected $fillable = ['name', 'email','password', 'phone_no'];
}
