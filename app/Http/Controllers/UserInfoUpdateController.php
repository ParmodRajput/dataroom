<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserInfoUpdateController extends Controller
{
 
	protected function validator(Request $request)
    {
        return Validator::make($request, [
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255|unique:users',
        ]);
    }

    public function updateUserInfo(Request $request){
        
        $updated_name = $request->updated_name;
        $updated_phone = $request->updated_phone;

        $user = Auth::user();
        $user->update(['name'=>$request->updated_name,'phone_no'=>$request->updated_phone]);

        return "success";

    }
}


        // $updated_phone = 
        
        // $user_id = Auth::user()->id;
        // $user = new User();
        // $user->name = $updated_name;
        // $user->phone_no =  $updated_phone;
        // $user->save();