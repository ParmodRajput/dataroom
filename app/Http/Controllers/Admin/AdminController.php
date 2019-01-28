<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    
	public function admin(){

    	return view('Admin.login');

    }

   public function adminLogin(Request $request)
    {


          $email = $request->email;
          $password = $request->password;

          $user = Admin::where('email', $email)->first();
          $name = $user['name'];

		  $validCredentials = Hash::check($password, $user['password']);

			if ($validCredentials) {

			    return redirect()->route('dashboard');
			    //return View::make('Admin.dashboard', compact(['name','']));

			}

		 return redirect()->route('login_Page');

    }

    public function dashboard(){

    	return view('Admin.dashboard');

    }

}
