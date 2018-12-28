<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UpdateUserpasswordController extends Controller
{


	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_no' => 'required|string|max:255|unique:users',
        ]);
    }
    
    public function updateUserPass(Request $request)
    {
      
            $current_password = $request->current_password;
            $get_new_password = $request->new_password;
            $new_password     =  bcrypt($get_new_password);
            $userpassword     = Auth::user()->password;
            $user             = Auth::user();
            $user->update(['password'=>$new_password]);
            return "changePassword";
         
    }
}
