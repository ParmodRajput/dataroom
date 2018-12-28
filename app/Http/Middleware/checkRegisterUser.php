<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Closure;
session_start();


class checkRegisterUser
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
        
        //user name
        $UserName =  $request->route()->parameter('Name');
        $decryptedUserName = Crypt::decryptString($UserName); 

        //user Email
        $userEmail = $request->route()->parameter('Email'); 
        $decryptedEmail = Crypt::decryptString($userEmail);  
  
          //user phone
        $userPhone = $request->route()->parameter('Phone'); 
        $decryptedPhone = Crypt::decryptString($userPhone);
        
          //user company
        $userCompany = $request->route()->parameter('Company'); 
        $decryptedCompany = Crypt::decryptString($userCompany);  
       
          //user project
        $userProject = $request->route()->parameter('Project'); 
        $decryptedProject = Crypt::decryptString($userProject);  

        

        $_SESSION["register_user_info"] = array($decryptedUserName,$decryptedEmail,$decryptedPhone,$decryptedCompany,$decryptedProject);

        return redirect(url('/register'));
        


    }
}
