<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Admin;

class AdminController extends Controller
{
    
	public function admin(){

    	return view('Admin.login');

    }

   public function adminLogin(Request $request)
    {

        // $this->validate($request, [
        //     'email'   => 'required|email',
        //     'password' => 'required|min:6'
        // ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

        	print_r('fdsfsdf');

            // return redirect()->intended('/admin/trtrrt');
        }
        // return back()->withInput($request->only('email', 'remember'));
    }

    public function dashboard(){

    	return view('Admin.dashboard');

    }

}
