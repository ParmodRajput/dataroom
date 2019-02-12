<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    // public function reset(Request $request){
    //    $token = $request->token;
    //    $email = $request->email;

    //    $check = Db::table('password_resets')->where([
    // ['token', '=',$token],
    // ['email', '=',$email],])->get();
    //    if($check){

    //         $new_password     =  bcrypt($request->password);           
    //         $user = User::where('email',$email)->first();
    //         $user->update(['password'=>$new_password]);
    //         return "changePassword";

    //    }

    // }
    
}
