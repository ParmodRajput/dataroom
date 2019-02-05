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

        
        $SHRdoc = ShareDocument::where('project_id',$project_id)->where('project_id',$project_id)->where('Shared_with',$userEmail)->where('access_token',$access_token)->first();

        $RegisterChecker = $SHRdoc['register_required'];

        $current_date = date('Y-m-d');

        if($SHRdoc['duration_time'] >= $current_date){
            
            $verifyThis = 'true';

        }else{

            $verifyThis = 'false';

        }

        if($RegisterChecker == '1')
        {
            
            if (User::where('email', '=', $userEmail)->exists()) {  


                 if(Auth::user())
                    {
                        $authUserEmail = Auth::user()->email; 
                        
                        if($userEmail == $authUserEmail)
                        {
                              
                              if($verifyThis == 'true')
                              {

                                

                              }
                            

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
