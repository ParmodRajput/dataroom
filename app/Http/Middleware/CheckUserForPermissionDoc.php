<?php

namespace App\Http\Middleware;
use App\Group;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Closure;
session_start();

class CheckUserForPermissionDoc
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
        //group id
        $group_id =  $request->route()->parameter('group_id');
        $decryptedGroupId = Crypt::decryptString($group_id); 

        //user Email
        $userEmail = $request->route()->parameter('userEmail'); 
        $decryptedEmail = Crypt::decryptString($userEmail);  

        //get project id
        $group = Group::find($decryptedGroupId);
        $project_id = $group->project_id;

        if(Auth::user())
        {
           $authUserEmail = Auth::user()->email; 
        }
        
        if( $decryptedEmail == $authUserEmail)
        {
             $_SESSION["UserDocuments"] = array($decryptedEmail,$project_id);
             return redirect(url('/project/'.$project_id.'/documents'));
        }

        if( $decryptedEmail !== $authUserEmail)
        {
              Auth::logout();
              Session::flush();

        }
       
        $user = User::where('email', $decryptedEmail)->first();

        if(is_null($user)) 
        {
            $_SESSION["registerUser"] = array($decryptedEmail); 
            return redirect(url('/register'));
        }
        else{
             
             $_SESSION["registerUser"] = array($decryptedEmail); 
             return redirect(url('/login'));
            // session('email',$decryptedEmail );
            // print_r(session('email'));die();
        }
            die();

        return $next($request);
    }
}
