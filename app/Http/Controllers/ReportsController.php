<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Project;
use App\Action;
use App\Group;
use App\User;
use App\Question;
use App\QuesReply;
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

    public function getAction(Request $request){

      $project_id = $request->project_id;
      $project_name = $request->project_name;
      $data_value = $request->data_value;
      $project_path = $request->project_path;

      $All_actions = [];

            if($data_value == '0')
            {
               
              $actions = Report::where('document_path','LIKE',"%{$project_name}%")->get()->toArray();

                     foreach ($actions as $actions) {

                        $actionTypeId = $actions['action'];

                        $getAction = Action::where('id',$actionTypeId)->first();          
                        //first
                        $Action = $getAction['action'];

                        $document = $actions['document_path'];

                        $doucment_regards = explode('/',$document);
                          
                        // second
                        $document_name = end($doucment_regards);
                       
                        //third
                        $Auth = $actions['Auth'];

                        $getAuther = User::where('id',$Auth)->first();

                        $auther = $getAuther['name'];

                        //forth
                        
                        $time = $actions['created_at'];

                        $action = ['action'=>$Action, 'document'=>$document_name ,'auther'=>$auther, 'time'=> $time];

                        array_push($All_actions, $action);

                     }

            }else{

              foreach ($data_value as $data_value) {
                   
                  $actions = Report::where('action',$data_value)->where('document_path','LIKE',"%{$project_path}%")->get()->toArray();

                          foreach ($actions as $actions) {

                            if(!empty($actions))
                            {

                                $actionTypeId = $actions['action'];

                                $getAction = Action::where('id',$actionTypeId)->first();          
                                //first
                                $Action = $getAction['action'];

                                $document = $actions['document_path'];

                                $doucment_regards = explode('/',$document);
                                  
                                // second
                                $document_name = end($doucment_regards);
                               
                                //third
                                $Auth = $actions['Auth'];

                                $getAuther = User::where('id',$Auth)->first();

                                $auther = $getAuther['name'];

                                //forth
                                
                                $time = $actions['created_at'];

                                $action = ['action'=>$Action, 'document'=>$document_name ,'auther'=>$auther, 'time'=> $time];

                                array_push($All_actions, $action);

                      }

                 }

               }

            }

        return $All_actions;

    }

    public function getGroupsReports(Request $request){

        $project_id = $request->project_id;
        $project_name = $request->project_name;
        $data_value = $request->data_value;


        $returnArray1 = [];

        $group_details = [];

        $countUserIsMember = [];
        
        foreach ($data_value as $data_value) {

          $totalQuestion = '0';
            
          $invitedUser = Group_Member::where('group_id',$data_value)->get()->toArray();

          $getGroup_name = Group::where('id',$data_value)->first()->toArray();

          $group_name = $getGroup_name['group_name'];

          $invitedUserCount = count($invitedUser);

          foreach ($invitedUser as $invitedUser) {

             $UserEmail = $invitedUser['member_email'];
            
             $checkUserIsExits = User::Where('email',$UserEmail)->get()->toArray();

             if(!empty($checkUserIsExits))
               { 
                 
                     $userId = $checkUserIsExits['0']['id'];

                     $getPostedQuestionCount = Question::where('send_by',$userId)->get();

                     $countPost = count($getPostedQuestionCount);

                     $totalQuestion = $totalQuestion+$countPost;

                     $get = '1';

                     array_push($countUserIsMember,$get);

               }else{


               }

             }


          $UserIsMemberOfProject = count($countUserIsMember);


          $getPermittedDocument = Permission::where('group_id',$data_value)->get()->toArray();
          
          $permittedDocument = count($getPermittedDocument);

          
          $returnArray = ['group_name'=>$group_name,'invitedUser'=>$invitedUserCount, 'permittedDoc'=>$permittedDocument,'GroupPosted'=>$totalQuestion,'loginUser'=>$UserIsMemberOfProject ];

          array_push($returnArray1,$returnArray);

        }

        return $returnArray1;

      }







}

