<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Admin;
use App\User;
use App\Group;
use App\Group_Member;
use App\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
     /*public function __construct()
    {
		//$this->middleware('guest');
        $this->middleware('admin',['except' => '/logout']);
		
    }*/
    
	public function admin(){

    	return view('Admin.login');

    }

   public function adminLogin(Request $request)
    {
		
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
			return redirect()->intended('admin/');
        }
       else{
		   return redirect()->intended('/admin/login');
	   }

    }
	
	public function getAdminLogin() {
		if (Auth::check()){
			return redirect()->intended('/admin');
		}
		return view('Admin.login');
	}

    public function dashboard(){

    	return view('Admin.dashboard');

    }
	
	/* List Of all  Users */
	public function usersList(){
		 $select = DB::select('select * from users');
		 return view ('Admin.all_users')->with('users_list',$select);
    }
	
	/* List Of all Enable Users */
	public function usersEnable(){
		 $select = DB::select('select * from users where is_active = 1');
		 return view ('Admin.all_users')->with('users_list',$select);
    }
	
	/* List Of all Disable Users */
	public function usersDisable(){
		 $select = DB::select('select * from users where is_active = 0');
		 return view ('Admin.all_users')->with('users_list',$select);
    }
	
	
	/* Get Project List By Single User */
	public function projectList($user_id){ 
        $user = User::find($user_id);
		$userEmail = $user->email;

        $group = Group_Member::where('member_email',$userEmail)->pluck('group_id');
        $groupProject = Group::find($group);
        $groupProjectId=array();

      foreach ($groupProject as  $group_id) 
      {
               
          $getGroupProject   =  $group_id->project_id;
          array_push($groupProjectId, $getGroupProject);

      }

      $projects = DB::table('projects')->whereIn('id', $groupProjectId)->orWhere('user_id', $user_id)->get();
	  return view('Admin.projects', ['projects' => $projects]);
	}
	
	/* Update Project Status */
	public function changeProjectStatus($project_id)
    {	
		$project = Project::find($project_id);
		$status		 = $project->is_active;
		$user_id	 = $project->user_id;
			if($status == 1){
				$status = 0;
			}else{
				$status = 1;
			}
		
		$project->is_active = $status;
		$project->save();
		
		return back();
    }
	
	/* Update User Status */
	public function changeStatus($user_id)
    {
        $user    = User::find($user_id);
        $status	 = $user->is_active; 
		if($status == 1){
				$status = 0;
			}else{
				$status = 1;
			}
		$user->is_active = $status;
		
		$user->save();
  
        return back();
    }
	
	/* Get User Details*/
	public function detail($user_id)
    {	
		$user = User::find($user_id);
		return view('Admin.user_details', ['user' => $user]);
    }
	
	
	public function allProjects()
    {	
		$projects = DB::table('projects')
						->Join('users', 'users.id', '=', 'projects.user_id') 
						->select('projects.id', 'projects.project_name', 'projects.user_id', 'users.name','projects.is_active', 'users.email')
						//->orderBy('user_id', 'ASC')
						->get();
		return view('Admin.all_projects', ['projects' => $projects]);
    }
	
	public function changeStatusAjax(Request $request)
    { 
        $project = Project::find($request->project_id);
		$project->is_active = $request->status;
		$project->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
	
	/*Logout*/
	public function logout() {
		Auth::guard('admin')->logout();
		return redirect('/admin/login');
	}
}
