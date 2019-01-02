<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Project;
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

class GroupsController extends Controller
{
    public function store(Request $request)
    {
     
      $project_id = $request->project_id;
      $userId =Auth::user()->id;

    	$group = new Group();
        $userForGroup = $request->userGroup;
        $setGroupUserType = $request->choose_user_type;
        $collaborationWith = $request->group_type_collaboration;
        $setGroupTime = $request->group_time_limit;
      	$group->group_name = $request->group_name;
      	$group->project_id = $project_id;
      	$group->created_by = $userId;
        $group->updated_by = $userId; 
        $group->group_for  = $userForGroup;
        $group->group_user_type = $setGroupUserType;
        $group->collaboration_with = $collaborationWith;
        $access_limit = $request->access_limit;
        $active_date = $request->validOnDate;  

          if($access_limit == 1)
          {
            $active_date = null;
          }
        $group->access_limit = $access_limit;
        $group->active_date  = $active_date;
        $group->QA_access_limit = $setGroupTime;    
    	  $group->save();

        $current_group_id = $group->id;

      // add collaboration


        if($collaborationWith == 'own_group')
       {
                $Collaboration = new Collaboration();

                $Collaboration->group_id = $current_group_id;
                $Collaboration->project_id = $project_id;
                $Collaboration->collaboration_group_id = $current_group_id; 
                $Collaboration->save();
       }


       if($collaborationWith == 'all_group')
       {
             $getGroups = Group::where('project_id',$project_id)->pluck('id');
             
             foreach ($getGroups as $Group_id) {

                $Collaboration = new Collaboration();

                $Collaboration->group_id = $Group_id;
                $Collaboration->project_id = $project_id;
                $Collaboration->collaboration_group_id = $current_group_id; 
                $Collaboration->save();
                 
             }
       }

      if($collaborationWith == 'users_group')
       {

             $getGroups = Group::where('project_id',$project_id)->where('group_user_type','Collaboration_users')->orWhere('group_user_type','Individual_users')->pluck('id');
             
             foreach ($getGroups as $Group_id) {

                $Collaboration = new Collaboration();
                $Collaboration->group_id = $Group_id;
                $Collaboration->project_id = $project_id;
                $Collaboration->collaboration_group_id = $current_group_id; 
                $Collaboration->save();
                 
             }
       }


        return "success";

    }
    public function GroupInvites(Request $request)
    {
       
       $check = '';
       $ExitsUser;
       $group_id = $request->choose_group;
       $userEmail = $request->user_email;
       $User_type = $request->forUser;
       $user_role = $request->user_role;
       $access_limit = $request->access_limit;
       $active_date = $request->validOnDate;  
       $project_id = $request->project_id;

          if($access_limit == 1)
          {
            $active_date = null;
          }

       $access_ques_ans = $request->access_Ques_ans;

       $email = $request->user_email;
       $emailPass = explode(',',$email);
       // $group = Group::find($group_id);
       // $project_id = $group->project_id;
       $SenderEmail = Auth::user()->email;
       $SenderName = Auth::user()->name;
       
    foreach($emailPass as $userEmail)
         {

          $encryptedGroupId = Crypt::encryptString($group_id);

          $encryptedUserEmail = Crypt::encryptString($userEmail);
          $verifyUrl = url('/project/checkUser/'.$encryptedGroupId.'/'.$encryptedUserEmail);

          $CheckUserIsExitInGroups = Group_Member::where('project_id',$project_id)->pluck('member_email')->toArray();

             if (in_array($userEmail, $CheckUserIsExitInGroups))
                {
                
                  $check = 'alreadyExit';
                  $ExitsUser  = $userEmail;
                 
                }else{

                      $data = array(

                          'name' => "Invite To Prodata room By prodata.com",
                          'user_email' => $userEmail,
                          'userEmail'  => $encryptedUserEmail,
                          'gropu_id'   => $group_id,
                          'SenderEmail'=> $SenderEmail,
                          'SenderName' =>  $SenderName,
                          'verifyUrl'  => $verifyUrl,

                      );

                      Mail::send('mail.inviteEmail',$data, function ($message)use ($userEmail) {
                          $message->from('admin@prodata.com', 'Prodata room');
                          $message->to($userEmail)->subject('inviteEmail')->setBody("url('/')");

                      });

                      $group_members = new Group_Member();

                      $group_members->group_id = $group_id;
                      $group_members->project_id = $project_id; 
                      $group_members->member_email = $userEmail; 
                      $group_members->user_type = $User_type ;
                      $group_members->role = $user_role ;
                      $group_members->access_limit = $access_limit;
                      $group_members->active_date = $active_date;
                      $group_members->access_qa = $access_ques_ans;

                      $group_members->created_by = Auth::user()->id;
                      $group_members->updated_by = Auth::user()->id; 
                             
                      $group_members->save();

                }

         }

         if($check == 'alreadyExit')
         {
            return $ExitsUser;

         }else{

           return "inviteSent";
         }
         
    }

    public function getGroups($project_id)
    {
        
        $authEmail = Auth::user()->email; 

        $authId = Auth::user()->id;  

        // $getAdminGroup = Group::where('created_by','admin')->where('project_id',$project_id)->get();  

        $getGroups = Group::where('project_id',$project_id)->get();  

        $group  = Group_Member::where('member_email',$authEmail)->where('project_id',$project_id)->pluck('group_id'); 

        // $group  = Group_Member::where('member_email',$authEmail)->whereNotIn('created_by', 'admin')->pluck('group_id'); 

        $groups   = Group::find($group);

        // $groups2   = Project::find($project_id)->groups;

        $ProjectGroup = ['first'=>$getGroups,'second'=>$groups]; 
        
        return $ProjectGroup;

    }

    public function getGroupInfo(Request $request)
    {
         $group_id = $request->groupId; 
         $group_Info = Group::where('id', $group_id)->get();
         $group_users =  Group_Member::where('group_id', $group_id)->get();
         $GroupInfoAndUsers = ['userInfo'=>$group_users , 'groupInfo'=> $group_Info];
        
         return $GroupInfoAndUsers;
         
    } 

    public function deleteGroup(Request $request){

          $deleteGroups = $request->deletePath;
          foreach ($deleteGroups as $deleteGroups) {
             print_r($deleteGroups);
             die();
          }
         
    }

    public function getAllGroups(Request $request){

      
        $project_id = $request->project_id;

        $authId = Auth::user()->id;  
        
        $Auth_group_id = getAuthgroupId($project_id);

        $getCurrentGroupUser = Group::where('id',$Auth_group_id)->first();

        $CurrentGroupUser = $getCurrentGroupUser->group_user_type;

        if($CurrentGroupUser == 'Administrator')
        {

          $getGroups = [];
          $getGroupUsers1 = [];

          $getGroupsInfo = Group::where('project_id',$project_id)->pluck('id');

          foreach ($getGroupsInfo as $getGroupsInfo) {
            
            $getGroupsId = $getGroupsInfo;

            $getGroupsInfo = Group::where('id',$getGroupsId)->first();

            $group_permission = Permission::where('group_id',$getGroupsId)->where('project_id',$project_id)->pluck('permission_id');

            $count = count($group_permission);

            if($count == '0')
            {
              $group_permission = '0';

            }else{

               $group_permission = '1';
            }

              $getGroupsInfo1 = ['id'=>$getGroupsInfo->id,'permission'=>$group_permission,'group_user_type'=>$getGroupsInfo->group_user_type,'group_name'=>$getGroupsInfo->group_name];
               
                             // get groups users
              $getGroupUser = Group_Member::where('group_id',$getGroupsId)->pluck('member_email'); 

              $getGroupUsers1 = ['groups'=>$getGroupsInfo1 , 'users'=>$getGroupUser];

              array_push($getGroups,$getGroupUsers1);

          }


        }elseif($CurrentGroupUser == 'Collaboration_users'){


          $getGroups = [];
          $getGroupUsers = [];

          $getGroupsId = Collaboration::where('project_id',$project_id)->where('collaboration_group_id',$Auth_group_id)->pluck('group_id');


           foreach ($getGroupsId as $getGroupsId) {

              // get groups  
              $getGroupsInfo = Group::where('id',$getGroupsId)->first();

              $group_permission = Permission::where('group_id',$getGroupsId)->where('project_id',$project_id)->pluck('permission_id');

              $count = count($group_permission);

              if($count == '0')
              {
                $group_permission = '0';

              }else{

                 $group_permission = '1';
              }


              $getGroupsInfo1 = ['id'=>$getGroupsInfo->id,'permission'=>$group_permission,'group_user_type'=>$getGroupsInfo->group_user_type,'group_name'=>$getGroupsInfo->group_name];


                             // get groups users
              $getGroupUser = Group_Member::where('group_id',$getGroupsId)->pluck('member_email'); 

              $getGroupUsers = ['groups'=>$getGroupsInfo1 , 'users'=>$getGroupUser];

              array_push($getGroups,$getGroupUsers);

            } 


        }else{
          
          $getGroups = '';

        }

        return $getGroups;
    }

    public function GroupsUsersGet(Request $request){

        $project_id = $request->project_id;

        $get = Group::where('project_id',$project_id)->get();

        return $get;
        
    }


    public function getAllUserInProject(Request $request)
    {
         $project_id =  $request->project_id;
         $authEmail  = Auth::user()->email;

         $getUsers = Group_Member::where('project_id',$project_id)->whereNotIn( 'member_email', [$authEmail])->pluck('member_email');

         return $getUsers;
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


 
// Get the All document in folder of the document//

public function getPermissionDocument($project_id)

{

  $project_id = $project_id;
  $project = Project::where('id', $project_id)->first();
  $folder_tree = array();
  $project_name = $project->project_slug;
  $projectCreaterId = $project->user_id; 

  // get groups of the project

  $groups = $this-> getGroupsByPermission($project_id);

  // Auth checked
  $authEmail = Auth::user()->email;
  $authId    = Auth::user()->id;
  $getProjectCreater = Project::find( $project_id);
  $projectCreater = $getProjectCreater->user_id;
  $group = Group_Member::where('member_email',$authEmail)->pluck('group_id');
  $groupProject = Group::find($group);
  $groupProjectId=array();


          $CurrentGroupId = getAuthgroupId($project_id); 

          $CurrentGroupUser = checkCurrentGroupUser($project_id);
          
         if($CurrentGroupUser == 'Administrator'){
    
                  $projectFolderPath = 'public/documents/'.$project->user_id."/".$project->project_slug;

                  $document_id =  Document::where('path',$projectFolderPath)->pluck('id');

                  $projectFolderPermission = $this->getPermission($projectFolderPath);

                  if($projectFolderPermission == '')
                  {
                    $projectFolderPermission ='';
                  }
                  
                  $folder_file_tree =  $this->get_FoldersAndFiles($projectFolderPath);


                  return view('groups.index',compact('project_name','groups','projectFolderPermission','folder_file_tree','project_id','projectCreaterId','CurrentGroupUser'));

      }elseif($CurrentGroupUser == 'Collaboration_users' || $CurrentGroupUser == 'Individual_users'){
          

                  $projectFolderPath = 'public/documents/'.$project->user_id."/".$project->project_slug;

                  $document_id =  Document::where('path',$projectFolderPath)->pluck('id'); 

                  $folder_tree = $this->get_Folders($projectFolderPath);

                  if($CurrentGroupUser == 'Individual_users')
                  {
                    
                    $projectFolderPermission ='';
                    $folder_file_tree ='';

                  }else{

                    $projectFolderPermission = $this->getSingleGroupsPermission($projectFolderPath);
                  
                    $folder_file_tree = $this->get_FoldersAndFiles($projectFolderPath);

                  }


              return view('groups.index',compact('project_name','groups','projectFolderPermission','folder_file_tree','project_id','projectCreaterId','CurrentGroupUser'));

    }else{
                   
            abort(403, 'Unauthorized action.');

         }


            if(isset($_SESSION["UserDocuments"])){

              $UserEmail = $_SESSION["UserDocuments"]; 
              $invitedUser = User::where('email',$UserEmail)->first();
              $invitedUserId = $invitedUser['id'];

            }
 
   }

     public function getGroupsByPermission($project_id){

          $getGroups = Group::where('project_id',$project_id)->get();

          return $getGroups;
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
