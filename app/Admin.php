<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
	use Notifiable;
    protected $guard = 'admin';
    protected $table = 'admin_users';
    protected $rememberTokenName = false;
    public $timestamps = true;
	
    protected $fillable = ['name', 'email','password', 'phone_no'];
}
