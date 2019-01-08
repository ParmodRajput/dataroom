<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Project;
use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Collaboration;
use App\Group_Member;
use App\Permission;
use App\Document;
use Mail;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use storage\app;
use Illuminate\Support\Facades\Crypt;

class ReportsController extends Controller
{
  
  public function ReportOverview(Request $Request){

  	$project_id = $project_id;
  	$project = Project::where('id', $project_id)->first();

    $projectCreaterId = $project->user_id;
  	$project = Project::where('id', $project_id)->first();
    $project_name = $project->project_slug;
  
  } 


      public function getDocsAndGroups($project_id)
    {

        $authEmail = Auth::user()->email; 

        $authId = Auth::user()->id;    

        $getGroups = Group::where('project_id',$project_id)->get();  

        $project = Project::where('id', $project_id)->first();

        $projectCreaterId = $project->user_id;
        $project_name = $project->project_slug;

    	$projectFolderPath = 'public/documents/'.$projectCreaterId."/".$project_name;

    	$folder_file_tree =  $this->get_FoldersAndFiles($projectFolderPath);

        return view('Reports.index',compact('getGroups','project_name','folder_file_tree','project_id','projectCreaterId'));


    }


     public function get_FoldersAndFiles($project_path)

             {
             
              $return = array();

              $project_folders =  DB::table('documents')->select('path')->where('directory_url', '=', $project_path)->get()->toArray();

              if ($project_folders) {

                  foreach ($project_folders as $folder) {

                      $folder_permission = $this->getPermission($folder->path);

                      $folder_path_permission = $folder->path.'@?#'.$folder_permission;

                      $return[$folder_path_permission] =  $this->get_FoldersAndFiles($folder->path);

                  }
              }
              return $return;
    }
   

     // get permission

   public function getPermission($path)         
    {         
              
              $document_permission1 ='';

              $getDocumentId = Document::where('path',$path)->pluck('id');

              if($getDocumentId !== '')
              {
                  $documentPermission = Permission::where('document_id',$getDocumentId)->get(); 

                  foreach ($documentPermission as $documentPermission) {

                      $document_permission = $documentPermission->group_id.'/'.$documentPermission->permission_id;
                       
                     $document_permission1 .= $document_permission.',';

                  }

                 return $document_permission1;
              }

    }

}
