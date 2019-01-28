<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Group;
use App\User;
use App\Report;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Collaboration;
use App\Group_Member;
use App\Permission;
use App\Document;
use Mail;
use Session;
use Illuminate\Support\Facades\Validator;
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


        $userForGroup = $request->userGroup;

        if($userForGroup == 'Administrator')
        {
           $setGroupUserType = 'Administrator';
           $collaborationWith = 'all_groups';
           $setGroupTime = '1';
           $access_limit = '1';
           $active_date = null;  

        }
        else{

           $setGroupUserType = $request->choose_user_type;
           $collaborationWith = $request->group_type_collaboration;
           $setGroupTime = $request->group_time_limit;
           $access_limit = $request->access_limit;
           $active_date = $request->validOnDate; 

            if($access_limit == 1)
            {
              $active_date = null;
            }

        }
      
    	  $group = new Group();

      	$group->group_name = $request->group_name;
      	$group->project_id = $project_id;
      	$group->created_by = $userId;
        $group->updated_by = $userId; 
        $group->group_for  = $userForGroup;
        $group->group_user_type = $setGroupUserType;
        $group->collaboration_with = $collaborationWith;
        $group->access_limit = $access_limit;
        $group->active_date  = $active_date;
        $group->QA_access_limit = $setGroupTime;    
    	  $group->save();

        $current_group_id = $group->id;

         // Save record

       $report = new Report();
       $report->action = '28';
       $report->document_path = $current_group_id;
       $report->Auth = Auth::user()->id;
       $report->save();

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

       $ReturnData = $request->group_name.'?#'.$current_group_id.'?#'.$setGroupUserType;;

        return $ReturnData;

    }



    public function GroupInvites(Request $request){

      //echo $request->choose_group; die();
      $validator = Validator::make($request->all(), [
                  'user_email' => 'required',
                  'choose_group' => 'required|min:1'
      ]);

      if ($request->choose_group == '0' || $request->user_email == '') {
         // $errors = $validator->getMessageBag()->toArray();
         // return response()->json(['validation_failed'=>true,'errors'=>$errors]);
         if ($request->choose_group == '0' &&  $request->user_email == '') {

          return response()->json(['choose_group'=>'Choose group','user_email'=>'Choose users email']);

         }

          if($request->choose_group == '0'){

           return response()->json(['choose_group'=>'Choose group']);

          }

          if($request->user_email == ''){

            return response()->json(['user_email'=>'Choose users email']);

          }
 
      } else{   

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
             //print_r($ExitsUser); die();

          return response()->json(['alreadyExit'=>true,'errors'=>$ExitsUser]);
            //return 'alreadyExit';

         }else{

           return "inviteSent";
         }

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

    public function getUserInfo(Request $request) {
         $email = $request->userEmail; 
         $project_id = $request->project_id;
         $checkUser = User::where('email', $email)->first();

         $checker  = $checkUser['email'];

         if($checker !== ""){

               $userInfo = User::where('email', $email)->get();       

         }else{

             $userInfo = '';

         }

         $groupInfo =  Group_Member::where('member_email', $email)->where('project_id', $project_id)->get();
         $GroupInfoAndUsers = ['userInfo'=>$userInfo , 'groupInfo'=>$groupInfo];
        
         return $GroupInfoAndUsers;
         


    } 

    public function deleteGroup(Request $request){

          $deleteGroups = $request->deletePath;
          $project_id   = $request->project_id;
          $deleteUser   = $request->deleteUser;

          $check = checkCurrentGroupUser($project_id);

          if(!empty($deleteGroups))
          {

                      foreach ($deleteGroups as $deleteGroups) {

                        if($check = 'Administrator')
                        {
                           Group::where('id', $deleteGroups)->delete();

                           Group_Member::where('group_id', $deleteGroups)->delete();             
                        }

                      }

                 return "deleteGroup";
          }

          if(!empty($deleteUser))
          {

              foreach ($deleteUser as $deleteUser) {

                         $getGroupId = explode('/',$deleteUser);

                         $group_id = $getGroupId['0'];

                         $DeleteUserEmail = $getGroupId['1'];

                        if($check = 'Administrator')
                        {

                           Group_Member::where('group_id',$group_id)->where('member_email', $DeleteUserEmail)->delete();             
                        }

                      }


               return "userGroup";
          }

          
         
    }

    public function getAllGroups(Request $request){

      
        $project_id = $request->project_id;
        $seachContant = $request->seachContant;
        $authId = Auth::user()->id;  
         $responseResult = [];

        if(!empty ( $seachContant )){


          $getCurrentGroupUsers = Group::where('group_name','LIKE',"{$seachContant}%")->get();

          foreach ($getCurrentGroupUsers as $getCurrentGroupUser) {

           $Auth_group_id = $getCurrentGroupUser->id;

           $responseResult = $this->FetchGroupAndUser($project_id,$seachContant,$authId,$Auth_group_id,$getCurrentGroupUser);

          }

          return  $responseResult;

        }else{

          $Auth_group_id = getAuthgroupId($project_id);

          $getCurrentGroupUser = Group::where('id',$Auth_group_id)->first();

          $responseResult = $this->FetchGroupAndUser($project_id,$seachContant,$authId,$Auth_group_id,$getCurrentGroupUser);

         return  $responseResult;
          
        }

    }

    function FetchGroupAndUser($project_id,$seachContant,$authId,$Auth_group_id,$getCurrentGroupUser){


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
        //$userRole = $request->role;
        $get = Group::where('project_id',$project_id)->get();

        return $get;
        
    }

    public function SelectGroupsUsers(Request $request){

        $project_id = $request->project_id;
        $userRole = $request->role;
        $get = Group::where('project_id',$project_id)->where('group_user_type',$userRole)->get();

        return $get;
        
    }    


    public function getAllUserInProject(Request $request)
    {
         $project_id =  $request->project_id;
         $authEmail  = Auth::user()->email;

         $getUsers = Group_Member::where('project_id',$project_id)->whereNotIn( 'member_email', [$authEmail])->pluck('member_email');

         return $getUsers;
    }


    public function get_Folders($project_path){

        $return = array();

        $project_folders = DB::table('documents')->select('path')->where('directory_url', '=', $project_path)->where('document_status','1')->get()->toArray();

            if ($project_folders) {
              
              foreach ($project_folders as $folder) {

                 $folder_permission = $this->getSingleGroupsPermission($folder->path);

                 $project_id =  Document::where('path',$folder->path)->pluck('project_id');

                 $CurrentGroupUser = checkCurrentGroupUser($project_id);

                 if($CurrentGroupUser == 'Individual_users')
                 {
                    $folder_path_permission = '';

                 }else{

                   $folder_path_permission = $folder->path.'@?#'.$folder_permission;
                 }
                 
                 $return[$folder_path_permission]  =  $this->get_Folders($folder->path);

              }

            }
        return $return;
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


//get Single group permission
    public function getSingleGroupsPermission($path){
                   
                $authEmail = Auth::user()->email;

                $getProjectID = Document::where('path',$path)->first();

                $project_id = $getProjectID->project_id;

                $document_id = $getProjectID->id;

               // current project group_id

                $CurrentGroupId = getAuthgroupId($project_id); 

                $CurrentGroupUser = checkCurrentGroupUser($project_id); 

                $GetprojectFolderPermission = Permission::where('document_id',$document_id)->where('project_id',$project_id)->where('group_id',$CurrentGroupId)->first();

                if($GetprojectFolderPermission == '')
                {

                  if($CurrentGroupUser == 'Administrator')
                  {
                    $projectFolderPermission = 'none';

                  }else{

                    $projectFolderPermission = '';
                  }

                }else{

                   $projectFolderPermission = $GetprojectFolderPermission->permission_id;

                }

                return $projectFolderPermission;

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

    public function MoveUser(Request $request){

      $project_id = $request->project_id;
      $movedGroupId = $request->movedGroupId;
      $userEmail = $request->userEmail;
      $current_group_id = $request->current_group_id;


                  $getGroupIs = Group::where('id',$movedGroupId)->first();
                  $groupRoleIs = $getGroupIs->group_user_type;

                  if($groupRoleIs == 'Administrator')
                  {
                    $User_type ='Administrator';
                    $user_role ='Administrator';

                  }

                  if($groupRoleIs == 'Collaboration_users')
                    {
                    $User_type ='user';
                    $user_role ='1';

                     $getUserInfoLastGroup = Group_Member::where('group_id',$current_group_id)->where('member_email', $userEmail)->first();

                  $access_limit = $getUserInfoLastGroup->access_limit;
                  $active_date = $getUserInfoLastGroup->active_date;
                  $access_qa   = $getUserInfoLastGroup->access_qa;

                  }

                  if($groupRoleIs == 'Individual_users')
                    {
                    $User_type ='user';
                    $user_role ='2';

                     $getUserInfoLastGroup = Group_Member::where('group_id',$current_group_id)->where('member_email', $userEmail)->first();

                  $access_limit = $getUserInfoLastGroup->access_limit;
                  $active_date = $getUserInfoLastGroup->active_date;
                  $access_qa   = $getUserInfoLastGroup->access_qa;

                  }
                

                  if($groupRoleIs == 'Administrator')
                  {
                    $User_type ='Administrator';
                    $user_role ='Administrator';
                    $access_limit = '1';
                    $active_date = null;
                    $access_qa  = '00';


                  }




                  Group_Member::where('group_id',$current_group_id)->where('member_email', $userEmail)->delete();

                
                  $group_members = new Group_Member();
                  $group_members->group_id = $movedGroupId;
                  $group_members->project_id = $project_id; 
                  $group_members->member_email = $userEmail; 
                  $group_members->user_type = $User_type;
                  $group_members->role = $user_role ;
                  $group_members->access_limit = $access_limit;
                  $group_members->active_date =  $active_date;
                  $group_members->access_qa = $access_qa;

                  $group_members->created_by = Auth::user()->id;
                  $group_members->updated_by = Auth::user()->id; 
                         
                  $group_members->save();


                  return "moveUser";


    }

    public function ChangeGroupName(Request $request){

      $project_id = $request->project_id;
      $GroupId = $request->group_id;
      $changedName = $request->ChangedGroupName;
      $authId = Auth::user()->id;

      Group::where('id',$GroupId)->update(['group_name'=>$changedName,'updated_by'=>$authId]);

      return "success";
      
    }

    public function ChangeGroupRole(Request $request){

      $project_id = $request->project_id;
      $ChangedRole = $request->ChangedRole;
      $GroupId = $request->group_id;

      if($ChangedRole == '1')
      {


          Group::where('id',$GroupId)->update(['group_for'=>'user','group_user_type'=>'Collaboration_users']);

      }elseif ($ChangedRole == '2'){

        Group::where('id',$GroupId)->update(['group_for'=>'user','group_user_type'=>'Individual_users']);
        
      }else{

         Group::where('id',$GroupId)->update(['group_for'=>'Administrator','group_user_type'=>'Administrator','access_limit'=>'1','active_date'=>null,'QA_access_limit'=>'0','collaboration_with'=>'all_group']);
      }
     
     return "success";

    }

 
      public function ChangeCollaborationSetting(Request $request){

          $project_id = $request->project_id;
          $collaborationWith = $request->updatedCollabVAlue;
          $group_id = $request->group_id;
          $userId = Auth::user()->id;

          Group::where('id',$group_id)->update(['collaboration_with'=>$collaborationWith]);


          // delete last collaborate groups

           Collaboration::where('group_id',$group_id)->delete();

          // add collaboration

            if($collaborationWith == 'own_group')
           {
                    $Collaboration = new Collaboration();

                    $Collaboration->group_id = $group_id;
                    $Collaboration->project_id = $project_id;
                    $Collaboration->collaboration_group_id = $group_id; 
                    $Collaboration->save();
           }


           if($collaborationWith == 'all_group')
           {
                 $getGroups = Group::where('project_id',$project_id)->pluck('id');
                 
                 foreach ($getGroups as $GroupId) {

                    $Collaboration = new Collaboration();

                    $Collaboration->group_id = $GroupId;
                    $Collaboration->project_id = $project_id;
                    $Collaboration->collaboration_group_id = $group_id; 
                    $Collaboration->save();
                     
                 }
           }

          if($collaborationWith == 'users_group')
           {

                 $getGroups = Group::where('project_id',$project_id)->where('group_user_type','Collaboration_users')->orWhere('group_user_type','Individual_users')->pluck('id');
                 
                 foreach ($getGroups as $GroupId) {

                    $Collaboration = new Collaboration();
                    $Collaboration->group_id = $GroupId;
                    $Collaboration->project_id = $project_id;
                    $Collaboration->collaboration_group_id = $group_id; 
                    $Collaboration->save();
                     
                 }
           }

           return "success";

      } 

    public function ChangeAccessRoomSetting(Request $request){

          $project_id = $request->project_id;
          $access_limit = $request->updatedsecurityValue1;
          $group_id = $request->group_id;
          $userId = Auth::user()->id;
          $active_date = '';

            if($access_limit == '1')
            {

             
              $access_limit = '1';
              $active_date = null;

            }else{

               $active_date = $access_limit;  
               $access_limit = '2';
               

            }


         Group::where('id',$group_id)->update(['access_limit'=>$access_limit,'active_date'=>$active_date]);
 
         return "success";

          //return $access_limit;
    }

    public function ChangeMemberAccessSetting(Request $request){

        $project_id = $request->project_id;
        $access_limit = $request->updatedsecurityValue1;
        $group_id = $request->group_id;
        $CurrentEmail = $request->CurrentEmail;
        $userId = Auth::user()->id;
        $active_date = '';

          if($access_limit == '1')
          {

           
            $access_limit = '1';
            $active_date = null;

          }else{

             $active_date = $access_limit;  
             $access_limit = '2';
             

          }


       Group_Member::where('group_id',$group_id)->where('member_email',$CurrentEmail)->where('project_id',$project_id)->update(['access_limit'=>$access_limit,'active_date'=>$active_date]);

       return "success";

        //return $access_limit;
    }

     public function ChangeQuesAnsSetting(Request $request){

          $project_id = $request->project_id;
          $access_ques_limit = $request->updatedQuestionValue;
          $group_id = $request->group_id;
          $userId = Auth::user()->id;


         Group::where('id',$group_id)->update(['QA_access_limit'=>$access_ques_limit]);
 
         return "success";

    }

     public function MembersChangeQuesAnsSetting(Request $request){

          $project_id = $request->project_id;
          $userEmail = $request->userEmail;
          $access_ques_limit = $request->updatedQuestionValue;
          $group_id = $request->group_id;
          $userId = Auth::user()->id;

          Group_Member::where('member_email',$userEmail)->where('group_id',$group_id)->where('project_id',$project_id)->update(['access_qa'=>$access_ques_limit]);
 
         return "success";

    }



}
