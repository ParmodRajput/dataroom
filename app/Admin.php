
<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class admin extends Authenticatable
{
    use Notifiable;
 protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'admin_users';
    protected $fillable = [

        'name', 'email', 'password','phone_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
