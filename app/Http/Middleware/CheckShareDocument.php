<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Closure;
use App\Document;
use App\ShareDocument;

class CheckShareDocument
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        $project_id =  $request->route()->parameter('project_id');
        $encryptedUserEmail =  $request->route()->parameter('email');
        $userEmail = Crypt::decryptString($encryptedUserEmail);
        $access_token =  $request->route()->parameter('access_token');

        



        if($decryptedRegisterChecker == '1')
        {
            
            if (User::where('email', '=', $decryptedUserEmail)->exists()) {  


                 if(Auth::user())
                    {
                        $authUserEmail = Auth::user()->email; 
                        
                        if($decryptedUserEmail == $authUserEmail)
                        {

                            return view('Share.shareWithMe');

                        }else{
                               
                            Auth::logout();   
                            return redirect(url('/login'));
                        }

                    }else{

                       return redirect(url('/login')); 
                    }

                
            }else{

             return redirect(url('/register'));
                
            }
            
        }else{


        }

die();
        

        

        return $next($request);
    }
}
