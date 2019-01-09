<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|string|min:8|',
                    'confirm_password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            return response()->json(['validation_failed'=>true,'errors'=>$errors]);   
        } else{       
            $current_password = $request->current_password;            
            $get_new_password = $request->new_password;
            $confirm_password = $request->confirm_password;
            if($get_new_password == $confirm_password){
            $userpassword     = Auth::user()->password;
                if(Hash::check($current_password, $userpassword)){
                $new_password     =  bcrypt($get_new_password);           
                $user             = Auth::user();
                $user->update(['password'=>$new_password]);
                return "changePassword";

                }else{
                    return response()->json(['message'=>"notmatchpassword",'errors'=>"password not match"]);
                }            

            }else{
               return response()->json(['message'=>"notmatchcomfirm",'errors'=>"comfirm password not match"]); 
            }

        }
         
    }
}
