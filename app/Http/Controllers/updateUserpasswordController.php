<?php

namespace App\Http\Controllers;
use App\User;
use Redirect;
use View;
use Mail;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;

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



    public function forgotpassword(Request $request){
        
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
        ]);
        
        if ($validator->fails()) {

            $errors = $validator->getMessageBag()->toArray();
            $message = "The email field is required.";
            return View::make('users.passwordForgot',compact('message'));

        }else{

           $email=input::post('email');
           $credentials = ['email' =>$email];
           $response = Password::sendResetLink($credentials, function (Message $message) {
           $message->subject($this->getEmailSubject());

        });

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    $message = trans($response);
                return View::make('users.passwordForgot',compact('message'));
            
                case Password::INVALID_USER:
                     $message = trans($response);
                return View::make('users.passwordForgot',compact('message'));
             }
        }
    }

    

    // public function forgotpassword(Request $request){
    //     $validator = Validator::make($request->all(), [
    //                 'email' => 'required',
    //     ]);
        
    //     if ($validator->fails()) {

    //         $errors = $validator->getMessageBag()->toArray();
    //         $message = "The email field is required.";
    //         return View::make('users.passwordForgot',compact('message'));

    //     }else{

    //         $data['email'] = $request->email;
    //         $data['email_token']="test";
    //         $users =DB::table('password_resets')->insert(['email' => $data['email'], 'token' => $data['email_token'], "created_at"=>now()]);

    //     $response = mail::send('auth.passwords.email',$data, function($message) use($data){
    //          $message->to($data['email']);              
    //          $message->Subject( 'Forgot Password');                
    //         }
    //          );

    //     }

    // }


}
