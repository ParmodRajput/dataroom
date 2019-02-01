<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Closure;

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

        $authUserEmail='';

        $project_id =  $request->route()->parameter('project_id');
        $decryptedProjectId = Crypt::decryptString($project_id);

        $userEmail =  $request->route()->parameter('userEmail');
        $decryptedUserEmail = Crypt::decryptString($userEmail);

        $registerChecker =  $request->route()->parameter('registerChecker');
        $decryptedRegisterChecker = Crypt::decryptString($registerChecker); 

        $time =  $request->route()->parameter('time');


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
