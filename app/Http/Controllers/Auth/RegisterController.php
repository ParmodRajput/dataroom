<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Project;
use Session;
use App\Document;
use App\Group;
use App\Group_Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
session_start();

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/projects';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'company'  => 'required|string|max:255',
            'phone_no' => 'required|string|max:255|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
            $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_no' => $data['phone_no'],
            'company' =>  $data['company'],
            ]);

           Storage::disk('public')->makeDirectory('documents/'.$user->id); 
                   
                if(isset($_SESSION["register_user_info"]))
                {

                   $project = new project();
                   $project->user_id      = $user->id;
                   $project->project_name = $_SESSION["register_user_info"][4];    
                   $project->project_slug = str_slug($_SESSION["register_user_info"][4], '-');
                   $project->company_name = $_SESSION["register_user_info"][3]; 
                   $project->created_by   = $user->id;
                   $project->updated_by   = $user->id;
                   $project->industry      = "empty";
                   $project->server_location = "empty";  
                   $project->save();

                   // get project id current create project // 

                   $project_name =  str_slug($_SESSION["register_user_info"][4], '-');
                   $project_id = $project->id;
                   $document_path ='public/documents/'.$user->id.'/'.$project_name;

                    //document Store
                    $document = new document();
                    $document->project_id = $project_id;
                    $document->doc_index ='0';
                    $document->document_name  = $project_name;  
                    $document->path = $document_path;
                    $document->directory_url = '';
                    $document->document_status = '';
                    $document->type = '';
                    $document->deleted_at = '';
                    $document->restored_at ='';
                    $document->uploaded_by = $user->id;
                    $document->updated_by  = $user->id;
                    $document->deleted_by = '';
                    $document->restored_by  = '';
                    $document->save();

                    // create admintrator group 

                    $create = new Group();
                    $create->group_name = 'Administrator';
                    $create->project_id = $project_id;
                    $create->group_for = 'Administrator';
                    $create->group_user_type = 'Administrator';
                    $create->collaboration_with = 'all_groups';
                    $create->access_limit = 1;
                    $create->active_date = null;
                    $create->created_by = $user->id;
                    $create->updated_by = $user->id;
                    $create->QA_access_limit = 0;
                    $create->save();  

                    $group_id = $create->id;

                     
                    //add auth in adminstrator group
               
                    $group_members = new Group_Member();

                    $group_members->group_id = $group_id;
                    $group_members->project_id = $project_id;
                    $group_members->member_email = $user->email; 
                    $group_members->user_type = 'Administrator';
                    $group_members->role = 'Administrator';
                    $group_members->access_limit = '1';
                    $group_members->active_date = null;
                    $group_members->access_qa = '00';
                    $group_members->created_by = $user->id;
                    $group_members->updated_by = $user->id; 
                    $group_members->save();

                  //end  

                }

                unset($_SESSION['register_user_info']);
           
           return $user;
    }

}






