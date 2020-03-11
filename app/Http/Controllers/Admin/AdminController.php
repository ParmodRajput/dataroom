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
use Illuminate\Support\Facades\Redirect;
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
	public function usersListOrder($length,$draw,$start,$order,$search,$columns,$search_value,$search_regex,$filter_users,$dir,$type){
		$all_users  =User::select('*');
		if($type =='Disable'){
			$all_users->where('is_active','=','0');
		}if($type =='Enable'){
			$all_users->where('is_active','=','1');
		}
		$count_users = $all_users->count();
		if(!empty($search_value)){
			$all_users =$all_users->where(function($q) use ($search_value){
						$q->orWhere('name' ,'like', '%'.$search_value.'%')
						->orWhere('email' ,'like', '%'.$search_value.'%')
						->orWhere('phone_no' ,'like', '%'.$search_value.'%')
						->orWhere('company' ,'like', '%'.$search_value.'%');
						});
		}
		if($order){
            $all_users = $all_users->orderBy($order, $dir);
        }else{
            $all_users = $all_users->orderBy('id', 'desc');
        }	
		$all_users = $all_users->offset($start)->limit($length)->get();
		$filter_users = $all_users->count();
		$pageLength = $count_users/$filter_users;
		$page = intval($pageLength);
		$pageLength =($pageLength > $page) ? intval($pageLength+1) : intval($pageLength);
		$data = array();
		$i = 0;
		foreach($all_users as $user){
	        $data[$i][]  = $user->name;
	        $data[$i][]  = $user->email;
	        $data[$i][]  = $user->phone_no;
	        $data[$i][]  = $user->company;
	        $data[$i][]  = '<a href="'.route('projectList',$user->id).'">click</a>';
	        $data[$i][]  = '<a href="'.route('userdetail',$user->id).'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
	        $i++;
        } 

        return array(
                    'draw' => $draw,
                    'recordsTotal' => $count_users,
                    'recordsFiltered' => $filter_users,
                    "pageLength" => $pageLength,
                    'data' => $data
                );
	}
	/* List Of all  Users */
	public function usersList(Request $request){
		$length=10;
		$draw=1;
		$start=0;
		$order='';
		$search='';
		$columns='';
		$search_value='';
		$search_regex='';
		$filter_users=10;
		if ($request->isMethod('post')) {
			if($request->has('type')){
	            $type  = $request->input('type');
	        }if($request->has('start')){
	            $start  = $request->input('start');
	        }if($request->has('length')){
	            $length  = $request->input('length');
	        }if($request->has('draw')){
	            $draw  = $request->input('draw');
	        }if($request->has('order')){
	            $order  = $request->input('order');
	        }if($request->has('search')){
	            $search_arr  = $request->input('search');
	        }if($request->has('columns')){
	            $columns  = $request->post("columns");
	        }
	        if(!empty($search_arr)){
	            $search_value = $search_arr['value'];
		        $search_regex = $search_arr['regex'];
	        }
	        $col = 0;
	        $dir = "";
	        if(!empty($order)) {
	            foreach($order as $o) {
	                $col   = $o['column'];
	                $dir   = $o['dir'];
	                $order = $columns[$col]['name'];
	            }
	        }
	        if($dir != "asc" && $dir != "desc") {
	            $dir = "asc";
	        }
			$output = $this->usersListOrder($length,$draw,$start,$order,$search,$columns,$search_value,$search_regex,$filter_users,$dir,$type);
	        echo json_encode($output);
	        exit();
		}else{
			$type ="All";
		 	return view ('Admin.all_users')->with('type',$type);
		}
    }
	
	/* List Of all Enable Users */
	public function usersEnable(){
		 $type = "Enable";
		 return view ('Admin.all_users')->with('type',$type);
    }
	
	/* List Of all Disable Users */
	public function usersDisable(){
		 $type = "Disable";
		 return view ('Admin.all_users')->with('type',$type);
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
	
	/* Get User Detail*/
	public function userDetail(Request $request,$user_id)
    {
    	$user = User::find($user_id);
    	if ($request->isMethod('post')) {
			$user->update($request->all());
			if($user){
				return Redirect::back()->with('success','User account has been updated!');
			}else{
				return Redirect::back()->with('error','Something Wrong!');
			}
		}else{
			return view('Admin.user_details', ['user' => $user]);
		}
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
