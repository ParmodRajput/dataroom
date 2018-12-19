<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use Session;
use App\Document;
use App\Group;
use App\Group_Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use storage\app;

class ProjectsController extends Controller
{

    public function store(Request $request){

      $userEmail = Auth::user()->email;

      $request->validate([
          'project_name' => 'required|unique:projects|max:255',
          
      ]);

       $project_slug = str_slug($request->project_name, '_');
       
       $post = new project();
       $post->user_id      = Auth::user()->id;
       $post->project_name = $request->project_name;	
       $post->project_slug = $project_slug;
       $post->company_name = $request->company_name; 
       $post->created_by   = Auth::user()->id;
       $post->updated_by   = Auth::user()->id;  
       $post->industry      =  $request->industry;
       $post->server_location = $request->server_location;
       $post->save(); 
	   
	     $project_id=$post->id;
       $projects=Storage::disk('public')->makeDirectory('documents/'.Auth::user()->id."/".$project_slug);	
       // create recycleBin folder
       Storage::disk('public')->makeDirectory('documents/'.Auth::user()->id."/".$request->project_name."/RecycleBin"); 
   
          $document_path ='public/documents/'.Auth::user()->id.'/'.$project_slug;
         //document Store
          $document = new document();
          $document->project_id = $project_id;
          $document->doc_index = '0';
          $document->document_name  = $project_slug;  
          $document->path = $document_path;
          $document->directory_url = '';
          $document->document_status = '';
          $document->type = '';
          $document->deleted_at = '';
          $document->restored_at ='';
          $document->uploaded_by = Auth::user()->id;
          $document->updated_by  = Auth::user()->id;
          $document->deleted_by = '';
          $document->restored_by  = '';
          $document->save(); 
       
       //create a administrator group//
            $group = new Group();
            $group->group_name = 'Administrator';
            $group->project_id = $project_id;
            $group->created_by = Auth::user()->id;
            $group->updated_by = Auth::user()->id; 
            $group->group_for  = 'Administrator';
            $group->group_user_type = 'Administrator';
            $group->collaboration_with = 'all_group';
            $group->access_limit = '1';
            $group->active_date  = null;
            $group->QA_access_limit = '0';    
            $group->save();

            $group_id=$group->id;

 
       //end

       //add auth in adminstrator group
       
            $group_members = new Group_Member();

            $group_members->group_id =$group_id;
            $group_members->project_id = $project_id;
            $group_members->member_email = $userEmail; 
            $group_members->user_type = 'Administrator';
            $group_members->role = 'Administrator';
            $group_members->access_limit = '1';
            $group_members->active_date = null;
            $group_members->access_qa = '00';
            $group_members->created_by = Auth::user()->id;
            $group_members->updated_by = Auth::user()->id; 
            $group_members->save();

       //end     

       return  $project_id; 
       //return redirect( url('/').'/project/'.$project_id.'/documents');                 

    }

    public function getUserProjects(Request $request){
		//$projects = DB::table('projects')->select('projects.id','projects.company','projects.project_name');
		  $user_id = Auth::user()->id;
      $authEmail = Auth::user()->email;

        $group = Group_Member::where('member_email',$authEmail)->pluck('group_id');
        $groupProject = Group::find($group);
        $groupProjectId=array();

      foreach ($groupProject as  $group_id) 
      {
               
          $getGroupProject   =  $group_id->project_id;
          array_push($groupProjectId, $getGroupProject);

      }

      //  $projects1 = DB::table('projects')->get()->whereIn('id', $groupProjectId);
      //  print_r($projects1);
      //  die();

	    // $projects = DB::table('projects')->get()->where('user_id', $user_id);

      $projects = DB::table('projects')->whereIn('id', $groupProjectId)->orWhere('user_id', $user_id)->get();

      return view('projects.all', ['projects' => $projects]);
	}


  public function deleteProject($id)
  {
   
    $project = Project::find($id);
      $project_name = Project::where('id', $id)->value('project_slug');
    $status = Storage::deleteDirectory('public/documents/'.Auth::user()->id."/".$project_name);
  
    $project->delete();
    return "success";

  }

  public function editProject($id,Request $request)
  {
       $project = Project::find($id);
      return view('projects.edit', ['project' => $project]);
  }

   public function updateProject(Request $request)
  {
      $id = $request->project_id;
      $project = Project::find($id);
      $old_name = Project::where('id', $id)->value('project_slug');
      
      $project_name = $request->project_name;
      $project_slug = str_slug($project_name, '-');
      Storage::move('public/documents/'.Auth::user()->id."/".$old_name,'public/documents/'.Auth::user()->id."/".$project_slug);
      Project::where('id', $id)->update(['project_name' => $project_name, 'project_slug' => $project_slug]);
       return "success";
  }



}
