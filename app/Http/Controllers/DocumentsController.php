<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Report;
use App\User;
use App\Group;
use App\Setting;
use App\Delete_Doc;
use App\Question;
use App\QuesReply;
use App\Note;
use App\Permission;
use App\Document;
use App\Group_Member;
use App\FavDocument;
use Session;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response;
use ZipArchive;
session_start();
use Excel;

class DocumentsController extends Controller
{
  public $copy_status = false;
  public $copied_directory_name; 

 // get the tree structure of the all folder in documents //

 public function get_Folders($project_path)

 {
 
  $return = array();

  $project_folders = DB::table('documents')->select('path')->where('directory_url', '=', $project_path)->where('document_status','1')->get()->toArray();
 

      if ($project_folders) {
        foreach ($project_folders as $folder) {

           $folder_permission = $this->getSingleGroupsPermission($folder->path);

           $project_id =  Document::where('path',$folder->path)->pluck('project_id');

           $CurrentGroupUser = checkCurrentGroupUser($project_id);

           $folder_path_permission = $folder->path.'@?#'.$folder_permission;
           
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


 
// Get the All document in folder of the document//

public function getDocument($project_id)

{


  $project_id = $project_id;
  $project = Project::where('id', $project_id)->first();
  $folder_tree = array();
  $project_name = $project->project_slug;
  $projectCreaterId = $project->user_id; 

  // get groups of the project

  $groups = $this-> getAllGroups($project_id);
  
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

                  $folder_tree =  $this->get_Folders($projectFolderPath);

                  $projectFolderPermission = $this->getPermission($projectFolderPath);

                  if($projectFolderPermission == '')
                  {
                    $projectFolderPermission ='';
                  }
                  
                  $folder_file_tree =  $this->get_FoldersAndFiles($projectFolderPath);

                  return view('documents.index',compact('project_name','groups','projectFolderPermission','folder_tree','folder_file_tree','project_id','projectCreaterId','CurrentGroupUser'));

      }elseif($CurrentGroupUser == 'Collaboration_users' || $CurrentGroupUser == 'Individual_users'){
          

                  $projectFolderPath = 'public/documents/'.$project->user_id."/".$project->project_slug;

                  $document_id =  Document::where('path',$projectFolderPath)->pluck('id'); 

                  $folder_tree = $this->get_Folders($projectFolderPath);

                  $projectFolderPermission = $this->getSingleGroupsPermission($projectFolderPath);
                  
                  $folder_file_tree = $this->get_FoldersAndFiles($projectFolderPath);


              return view('documents.index',compact('project_name','groups','projectFolderPermission','folder_tree','folder_file_tree','project_id','projectCreaterId','CurrentGroupUser'));

    }else{
                   
            abort(403, 'Unauthorized action.');

         }


            if(isset($_SESSION["UserDocuments"])){

              $UserEmail = $_SESSION["UserDocuments"]; 
              $invitedUser = User::where('email',$UserEmail)->first();
              $invitedUserId = $invitedUser['id'];

            }

 
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

//second


public function getDocumentAction($project_id)

{

  $project_id = $project_id;
  $project = Project::where('id', $project_id)->first();
  $folder_tree = array();
  $project_name = $project->project_slug;
  $projectCreaterId = $project->user_id; 

  // get groups of the project

  $groups = $this-> getAllGroups($project_id);

  // Auth checked
  $authEmail = Auth::user()->email;
  $authId    = Auth::user()->id;
  $getProjectCreater = Project::find( $project_id);
  $projectCreater = $getProjectCreater->user_id;
  $group = Group_Member::where('member_email',$authEmail)->pluck('group_id');
  $groupProject = Group::find($group);
  $groupProjectId=array();

      foreach ($groupProject as  $group_id) 
      {
               
          $getGroupProject   =  $group_id->project_id;
          array_push($groupProjectId, $getGroupProject);

      }
          
      if(in_array($project_id, $groupProjectId)){

         $folder_tree =  $this->get_Folders('public/documents/'.$project->user_id."/".$project->project_slug);

         $folder_file_tree =  $this->get_FoldersAndFiles('public/documents/'.$project->user_id."/".$project->project_slug);

         $folderTree1 = folder_tree($folder_tree);

         $folder_file_tree1 = folder_file_tree($folder_file_tree);

        $Tree = ['folderTree'=>$folderTree1 , 'folder_file_tree'=>$folder_file_tree1 ];

        return $Tree;

          
      }else{
          
              if($authId == $projectCreater)
                {
                  $folder_tree =  $this->get_Folders('public/documents/'.$project->user_id."/".$project->project_slug);

                  $folder_file_tree =  $this->get_FoldersAndFiles('public/documents/'.$project->user_id."/".$project->project_slug);

                  $folderTree1 = folder_tree($folder_tree);

                  $folder_file_tree1 = folder_file_tree($folder_file_tree);

                  $Tree = ['folderTree'=>$folderTree1 , 'folder_file_tree'=>$folder_file_tree1 ];

                  return $Tree;

                }else{
                   abort(403, 'Unauthorized action.');
              }
            }


  if(isset($_SESSION["UserDocuments"])){

    $UserEmail = $_SESSION["UserDocuments"]; 
    $invitedUser = User::where('email',$UserEmail)->first();
    $invitedUserId = $invitedUser['id'];

  }
 
}


 // get Parent directory permission and store permission

 function AllActionStorePermission ($current_directory,$getCurrentDocumentId,$project_id){


          $document_id = document::where('path',$current_directory)->pluck('id');

          $findInPermissionTable = permission::where('document_id',$document_id)->where('project_id',$project_id)->get();
         
          foreach ($findInPermissionTable as $findInPermissionTable) {

                                $group_id = $findInPermissionTable->group_id;
                                $permission_id = $findInPermissionTable->permission_id;
                                $Permission = new Permission();
                                $Permission->document_id = $getCurrentDocumentId;
                                $Permission->project_id = $project_id ;
                                $Permission->group_id = $group_id ;
                                $Permission->permission_id = $permission_id;
                                $Permission->created_by = Auth::user()->id;
                                $Permission->updated_by = Auth::user()->id;
                                $Permission->save();
          }
 }
//end


//Create folder //
public function createFolder(Request $request) {

 //print_r($request->path);
 $authId    = Auth::user()->id;
 $current_directory = $request->path;
 $document_name     = $request->genrate_folder;
 $store_path        = $request->getPath;
 $project_id        = $request->project_id;
 $document_index    = $request->document_index;


 $folderCheckExit = $this->DocumentExitInDir($store_path);

  if($folderCheckExit == 'exits')
   {
      $get = 'exits';
      $folderLiseCount = $this->folderCheckExitsInDoc($store_path,$document_name,$current_directory,$get);

      $get_document_name = explode('/',$folderLiseCount);
      $store_path        = $folderLiseCount;
      $document_name     = end($get_document_name);
   }

 $getIndex =$this->getIndexOfDocument($project_id,$current_directory);

     if($getIndex == ''){

          $index = 1; 

      }else{

          $index = intval($getIndex)+1;

      }


  // storage 
 $directory = str_replace("public/","",$current_directory);   
 $path = Storage::disk('public')->makeDirectory($directory.'/'.$document_name);
 Storage::disk('public')->makeDirectory($directory.'/'.$document_name.'/thumbnail_img');
 
 $storeFolder = new Document();
 $storeFolder->project_id = $project_id;
 $storeFolder->doc_index = $index;  
 $storeFolder->document_name = $document_name;
 $storeFolder->path = $store_path;
 $storeFolder->directory_url = $current_directory;
 $storeFolder->document_status = '1';
 $storeFolder->type = '';
 $storeFolder->deleted_at = '0';
 $storeFolder->restored_at ='0';
 $storeFolder->uploaded_by = $authId;
 $storeFolder->updated_by  = $authId;
 $storeFolder->deleted_by  = '0';
 $storeFolder->restored_by = '0';
 $storeFolder->save();
 
 $getCurrentDocumentId = $storeFolder->id;
 
 // Save record

 $report = new Report();
 $report->action = '1';
 $report->document_path = $store_path;
 $report->Auth = $authId;
 $report->save();
 

 $this->AllActionStorePermission ($current_directory,$getCurrentDocumentId,$project_id);

 return $document_name; 
}



//upload files // 

public function uploadFile(Request $request) {

      $current_directory = $request->current_dir;
      $directory = str_replace("public/","",$current_directory);
      $project_id =$request->projects_id;
      $uploaded_by = Auth::user()->id;

      if ($request->hasFile('file')) {

          foreach ( $request->file as $file)
          {
              
              $filename = $file->getClientOriginalName();

              $checkFileIsExitIndir = $current_directory.'/'.$filename;
              
              $getFileExtenssion = explode('.', $filename);

              $FileExtenssion    = end($getFileExtenssion);

              $path = Storage::disk('public')->putFileAs($directory,$file, $filename);
              Storage::disk('public')->makeDirectory($directory.'/thumbnail_img');

              $fullPath = $current_directory.'/'.$filename;
  
              //create image thumbnail.
              $filepath  = storage_path()."/app/".$fullPath;

              $thumbpath =   storage_path()."/app/".$current_directory.'/thumbnail_img/'.$filename;

              $thumbnail_width = 250;

              $thumbnail_height = 178;

              $getType = explode('.',  $filename);
              $fileType = end($getType);

              if($fileType =='')
              {
                 $fileType="folder";

              }else{

                  if( $FileExtenssion == "jpg" || $FileExtenssion == "jpeg"  || $FileExtenssion == "png"){

                         $this->createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false);

                         $getThumbpath =  $current_directory.'/thumbnail_img/'.$filename;
                  } 

              }
              
              $getFileIsExits = document::where('path',$fullPath)->pluck('id');
              
              $getIndexing = $this->getIndexOfDocument ($project_id,$current_directory);
             

              if($getIndexing == ''){

                    $index = 1; 
                }else{

                    $index = $getIndexing+1;
                }

              // store upload document
              if(empty($getFileIsExits[0])) 
              {
                    $document = new document();
                    $document->project_id = $project_id;
                    $document->doc_index = $index;
                    $document->document_name  = $filename;    
                    $document->path = $fullPath;
                    $document->directory_url = $current_directory;
                    $document->document_status = '0';
                    $document->type = $fileType;
                    $document->deleted_at = '0';
                    $document->restored_at ='0';
                    $document->uploaded_by = $uploaded_by;
                    $document->updated_by  = $uploaded_by;
                    $document->deleted_by = '0';
                    $document->restored_by  = '0';
                    $document->save();

                    $getCurrentDocumentId = $document->id;
                    //save record

                    $report = new Report();
                    $report->action = '2';
                    $report->document_path = $fullPath;
                    $report->Auth = $uploaded_by;
                    $report->save();

                    $this->AllActionStorePermission ($current_directory,$getCurrentDocumentId,$project_id);

              }
              //end
            
          }    
      }

      return "upload";

 }

// show documents // 

public function showDocument(Request $request){

 $user_id = Auth::user()->id;
 $Doc_path = $request->directory_url;
 $project = Storage::directories($Doc_path);
 $allfiles = Storage::Files($Doc_path);
 $projects_id = $request->projects_id;

 $auth_email = Auth::user()->email;

 $GetUsers = Group_Member::where('project_id',$projects_id)->where('user_type','user')->get();

 $GetUsers1 = Group_Member::where('project_id',$projects_id)->where('user_type','user')->get()->toArray();

 $CurrentUserCount = count($GetUsers1);

        // verify project creater

        $getProjectCreaterId = checkCurrentGroupUser($projects_id);
        $group_id            = getAuthgroupId($projects_id);

          // get the all document indexing// 

        $IndexOfFolder = [];
      
        
        $getIndexOfFolder = Document::where('project_id', $projects_id)->where('directory_url', $Doc_path)->where('document_status', '1')->where('deleted_by', '0')->get();

          foreach ($getIndexOfFolder as $getIndexOfFolder){

                $path = $getIndexOfFolder->path;
                $document_name = $getIndexOfFolder->document_name;
                $getDocumentId = $getIndexOfFolder->id;
                $doc_index    = $getIndexOfFolder->doc_index;
                $getFolderId = $getIndexOfFolder->id;

                 //get the all fav document in this directory
         
                $getFavFolder = FavDocument::where('document_path',$path)->pluck('id');

                // $getFavFolder = $getFavFolder[0];

                $Folderpermission = Permission::where('document_id',$getDocumentId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                $FolderNote = Note::where('document_id',$getDocumentId)->where('user_id',$user_id)->pluck('id');

                $folder_ques = Question::where('document_id',$getDocumentId)->where('project_id',$projects_id)->pluck('id');

                // $Folderpermission = $Folderpermission[0];

                $Foldercount = count($Folderpermission);

                if($getProjectCreaterId == "Administrator"){ 

                     $Folderpermission  =  [];

                     $Folder_array =  ['doc_id'=>$getFolderId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];

                     array_push($IndexOfFolder,$Folder_array);

                }else{

                      if($Foldercount !== 0){

                           
                            $Folder_array =  ['doc_id'=>$getFolderId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];
                        

                           array_push($IndexOfFolder,$Folder_array);
                      
                      }

                }
              
          }


          //end

          //for file document.

          $IndexOfFile   = [];

          $getIndexOfFile = Document::where('project_id', $projects_id)->where('directory_url', $Doc_path)->where('document_status', '0')->where('deleted_by', '0')->get();


           foreach ($getIndexOfFile as $getIndexOfFile) {

                $path = $getIndexOfFile->path;
                $getFileId = $getIndexOfFile->id;
                $document_name = $getIndexOfFile->document_name;
                $doc_index    = $getIndexOfFile->doc_index;

                $Filepermission = Permission::where('document_id',$getFileId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                //get the all fav document in this directory
         
                $getFavFile = FavDocument::where('document_path',$path)->where('user_id', $user_id)->pluck('document_id'); 

                $FileNote = Note::where('document_id',$getFileId)->where('user_id',$user_id)->pluck('id');

                $file_ques = Question::where('document_id',$getFileId)->where('project_id',$projects_id)->pluck('id');

                $Filecount = count($Filepermission);

                if($getProjectCreaterId == "Administrator"){

                  $Filepermission  = [];

                  $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];

                   array_push($IndexOfFile,$File_array);

                }else{
                            

                  if($Filecount !== 0){


                        $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];
                           

                     array_push($IndexOfFile,$File_array);
                      
                  }

                }

          }

        
           $data = ['folder_index' => $IndexOfFolder , 'file_index' => $IndexOfFile,'CurrentUserCount'=>$CurrentUserCount,'ProjectUsers'=>$GetUsers];
 
  return $data;

}


public function getFolderAfterAction(Request $request) {
  $project_id = $request->project_id;
  $project_name = Project::where('id', $project_id)->value('project_name');

  $folder_tree = array();

  $folder_tree =  $this->get_Folders('public/documents/'.Auth::user()->id."/".$project_name);

  $output = folder_tree($folder_tree);
  return $output;

}

//delete documents

public function deleteDocument(Request $request)
{

 $DeletePath = $request->url;
 $projects_id = $request->projects_id;
 $user_id = Auth::user()->id;

 $k ='';

 foreach($DeletePath as $DeletePathOne)
 {

    $path =  storage_path()."/app/".$DeletePathOne;
    $getProjectPath = str_replace("public/documents/","",$DeletePathOne);
    $getFileName = explode('/',$getProjectPath);
    $firstPara = $getFileName[0];
    $secondPara = $getFileName[1];
    $docName = end($getFileName);
    $projects_id = $request->projects_id;

    if (is_dir($path)) {

          $timestamp = time();

          $getDocInFolder = document::where('path','LIKE',"%{$DeletePathOne}%")->update(['deleted_at' => $timestamp,'restored_at'=>'0' ,'deleted_by'=>'1']);

          // $getDocumentIdByFav = document::where('path',$DeletePathOne)->first();

          // $DeletedDocId = $getDocumentIdByFav->id;

          // FavDocument::where('document_id',$DeletedDocId)->delete(); 

          //$status = Storage::deleteDirectory($DeletePathOne);
          $recycleBinPath = "public/documents/".$firstPara.'/'.$secondPara."/RecycleBin/";
                    
          $curr_timestamp = date("d F Y H:i:s", $timestamp);

          $NewStoreRecyclebin = $recycleBinPath.$timestamp.'.'.$docName;

          Storage::move($DeletePathOne, $NewStoreRecyclebin);
          // $delete_document = document::where('path',$DeletePathOne)->delete();
          document::where('path',$DeletePathOne)->delete();

          // delete file name with time combination 
          $storeDeleteDocName = $timestamp.'.'.$docName;

          $recycle = new Delete_Doc();
          $recycle->deleted_folder = $storeDeleteDocName; 
          $recycle->deleted_file = ''; 
          $recycle->deleted_from =$DeletePathOne; 
          $recycle->document_status = '1';
          $recycle->deleted_by = Auth::user()->id; 
          $recycle->restored_by = "0"; 
          $recycle->deleted_time = $curr_timestamp; 
          $recycle->restored_time = "0"; 
          $recycle->project_id = $projects_id;
          $recycle->save();


          
          //save record

          $report = new Report();
          $report->action = '5';
          $report->document_path = $DeletePathOne;
          $report->Auth = Auth::user()->id;
          $report->save();

          $k = 0;

        }
      else{


          $recycleBinPath = "public/documents/".$firstPara.'/'.$secondPara."/RecycleBin/";
          
          $timestamp = time(); 

          $NewStoreRecyclebin = $recycleBinPath.$timestamp.'.'.$docName;

          Storage::move($DeletePathOne, $NewStoreRecyclebin);

          $ThumbnailPath = $this->CreateThumbnailPath($DeletePathOne);

          Storage::delete($ThumbnailPath);

          //$delete_document = document::where('path',$DeletePathOne)->delete();
           document::where('path',$DeletePathOne)->delete();

          // $getDocumentIdByFav = document::where('path',$DeletePathOne)->first();

          // $DeletedDocId = $getDocumentIdByFav->id;

          // FavDocument::where('document_id',$DeletedDocId)->delete(); 

          // delete file name with time combination 
          $storeDeleteDocName = $timestamp.'.'.$docName;

          $recycle = new Delete_Doc();
          $recycle->deleted_file = $storeDeleteDocName; 
          $recycle->deleted_folder = ''; 
          $recycle->deleted_from =$DeletePathOne; 
          $recycle->document_status = '0';
          $recycle->deleted_by = Auth::user()->id; 
          $recycle->restored_by = "0";  
          $recycle->deleted_time = $timestamp; 
          $recycle->restored_time = "0"; 
          $recycle->project_id = $projects_id;
          $recycle->save();


          $report = new Report();
          $report->action = '6';
          $report->document_path = $DeletePathOne;
          $report->Auth = Auth::user()->id;
          $report->save();

          $k = 1;
     }
 } 

}

// downoad the document //
public function download (Request $request){
 
  // $zip = new ZipArchive;
  $DocPath = $request->download;
  $path =  storage_path()."/app/".$request->download;
  $file = explode('/',$request->download);
  $file_name = end($file);

     if (!is_dir($path)) {
           $file = Storage::get($request->download);
          $mimetype = Storage::mimeType($request->download);
          $headers = array(
            'Content-Type'=> 'application/octet-stream',   
          );
         

          // save folder download record 
       if(Auth::user())
           {
 
              $report = new Report();
              $report->action = '26';
              $report->document_path = $DocPath;
              $report->Auth = Auth::user()->id;
              $report->save();

           }


           return response()->download($path,$file_name,$headers);

    }else{
  
            $headers = array(
              'Content-Type'=> 'application/octet-stream',   
            );
            $this->zipDir(storage_path()."/app/".$request->download,storage_path()."/app/".$request->download.".zip");

                $report = new Report();
                $report->action = '25';
                $report->document_path = $DocPath;
                $report->Auth = Auth::user()->id;
                $report->save();

            return response()->download(storage_path()."/app/".$request->download.".zip",$file_name.".zip",$headers);

        }
}


// move directory

public function move_documents(Request $request){
            
  $folderUrl  = $request->movedInFolder;
  $user_id    = Auth::user()->id;        
  $fileUrl    = $request->moveFile;

  $directoryPath = $request->directoryPath;
  $project_id = $request->projects_id;
  $get        = explode('/',$fileUrl);
  $file_name  = end($get);

  $getFilePathWithOutThumb = array_pop($get);
  $withOutThumb = implode('/',$get);
  $getExt     = explode('.',$file_name);
  $file_ext   = end($getExt);
  $new_path   = $folderUrl.'/'. $file_name;

      if($file_ext == 'jpg' || $file_ext == 'png' || $file_ext == 'jpeg')
      {
              $thumbnailPath = $withOutThumb.'/thumbnail_img/'.$file_name;
               $MoveThumbnail = $folderUrl.'/thumbnail_img/'.$file_name;

              // move thumbnail image .
              Storage::move($thumbnailPath,$MoveThumbnail);

      }

  Storage::move($fileUrl,$new_path);

  $getIndex = $this->getIndexOfDocument ($project_id,$folderUrl);

       if($getIndex == ''){

          $index = 1; 

      }else{

          $index = intval($getIndex)+1;
      }

                    $document = new document();
                    $document->project_id = $project_id;
                    $document->doc_index = $index;
                    $document->document_name  = $file_name;    
                    $document->path = $new_path;
                    $document->directory_url = $folderUrl;
                    $document->document_status = '0';
                    $document->type = $file_ext;
                    $document->deleted_at = '0';
                    $document->restored_at ='0';
                    $document->uploaded_by = $user_id;
                    $document->updated_by  = $user_id;
                    $document->deleted_by = '0';
                    $document->restored_by  = '0';
                    $document->save();




    

                // save rename record 
                    $report = new Report();
                    $report->action = '11';
                    $report->document_path = $fileUrl;
                    $report->Auth = Auth::user()->id;
                    $report->save();


  document::where('path',$fileUrl)->where('project_id',$project_id)->delete();

  return "moved";
}

 //Copy document //
public function copy_documents(Request $request){
    
    $lastCopied       = '';
    $user_id    = Auth::user()->id;   
    $projects_id = $request->projects_id;
    $pasted_directory = $request->pasted_directory;

    $copied_directory = $request->copied_directory;

    $get = explode('/',$copied_directory);
    $editableDocumentName = end($get);
    $src = storage_path()."/app/".$copied_directory;
    $DocDirectoryAfPaste = $pasted_directory.'/'. $editableDocumentName;
 
     if (is_dir($src)) {

        $dst = storage_path()."/app/".$pasted_directory.'/'. $editableDocumentName;
        $this->checkFolderIsExits($src,$dst,$projects_id,$pasted_directory);
        $this->copy_status = true;

        $report = new Report();
        $report->action = '12';
        $report->document_path = $copied_directory;
        $report->Auth = Auth::user()->id;
        $report->save();

        if ($this->copy_status = true) {    

          return 'copied folder';

         }

     }else{

        $this->copied_directory_name = end($get);
        $copied_directory_name = $this->copied_directory_name;
        $this->checkFileIsExits($copied_directory_name,$pasted_directory,$copied_directory,$projects_id);
            
          if ($this->copy_status = false) {
              return 'copied file';
         }

          $report = new Report();
          $report->action = '13';
          $report->document_path = $copied_directory;
          $report->Auth = Auth::user()->id;
          $report->save();

    }

}

// Renamed document//

public function rename_documents(Request $request){
    
    $editableDocumentName = $request->editableDocumentName;

    $editableDocumentUrl = $request->editableDocumentUrl;

    $renameDocumentFullPath = $request->renameDocumentFullPath;

    $extension = pathinfo($renameDocumentFullPath, PATHINFO_EXTENSION);

    $renameThumbnailImagePath = $request->renameThumbnailImagePath;

    $thumbnailOldPath = $editableDocumentUrl.'/thumbnail_img/'. $renameThumbnailImagePath;

    // $getEditableDocumementName = explode('/', $renameDocumentFullPath);

    // $getdocumementName    = end($getEditableDocumementName);
  
    // $getExtension = explode('.', $getdocumementName);

    // $count_document      = count($getExtension);

    // $extension      = end($getExtension);
    
    // $documentName   = array_shift($getExtension);

    if($extension == '')
    {
         
         $new_path = $editableDocumentUrl.'/'. $editableDocumentName;
         $document_name = $editableDocumentName;

          $report = new Report();
          $report->action = '3';
          $report->document_path = $renameDocumentFullPath;
          $report->Auth = Auth::user()->id;
          $report->save();
 
        
    }
    else{
           
         $new_path = $editableDocumentUrl.'/'.$editableDocumentName.'.'.$extension;
         $document_name = $editableDocumentName.'.'.$extension;

         if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' )
         {
                
                // change thumbnail 
                 $thumbnailPath = $editableDocumentUrl.'/thumbnail_img/'. $editableDocumentName.'.'.$extension;
                
                 Storage::move($thumbnailOldPath,$thumbnailPath);
         }


          $report = new Report();
          $report->action = '4';
          $report->document_path = $renameDocumentFullPath;
          $report->Auth = Auth::user()->id;
          $report->save();


    }
 

    $getDocInFolder = document::where('directory_url','LIKE',"%{$renameDocumentFullPath}%")->get();

       
    foreach ($getDocInFolder as $getDocInFolder) {

       $documentId = $getDocInFolder->id;
       $documentPath =  $getDocInFolder->path;
       $documentDirUrl = $getDocInFolder->directory_url;

       $updateDocumentPath = str_replace($renameDocumentFullPath, $new_path, $documentPath); 
       $updateDocumentDirUrl = str_replace($renameDocumentFullPath, $new_path, $documentDirUrl);

       document::where('path',$documentPath)->update(['path' => $updateDocumentPath,'directory_url'=>$updateDocumentDirUrl]);

       FavDocument::where('document_path',$documentPath)->update(['document_path' => $updateDocumentPath]);

    }  

    Storage::move($renameDocumentFullPath,$new_path);

    // get the all document in folder.

    document::where('path',$renameDocumentFullPath)->update(['document_name' =>$document_name, 'path' => $new_path]);
  
  FavDocument::where('document_path',$renameDocumentFullPath)->update(['document_path' => $new_path]);

    return 'rename';

}

// Create Zip file  //

public  function folderToZip($folder, &$zipFile, $exclusiveLength) { 
  $handle = opendir($folder); 
  while (false !== $f = readdir($handle)) { 
    if ($f != '.' && $f != '..') { 
      $filePath = "$folder/$f"; 
        // Remove prefix from file path before add to zip. 
      $localPath = substr($filePath, $exclusiveLength); 
      if (is_file($filePath)) { 
        $zipFile->addFile($filePath, $localPath); 
      } elseif (is_dir($filePath)) { 
          // Add sub-directory. 
        $zipFile->addEmptyDir($localPath); 

        $this->folderToZip($filePath, $zipFile, $exclusiveLength); 
      } 
    } 
  } 
  closedir($handle); 
} 

// Zip file 
  public function zipDir($sourcePath, $outZipPath) 
  { 
    $pathInfo = pathInfo($sourcePath); 
   
    $parentPath = $pathInfo['dirname']; 
    $dirName = $pathInfo['basename']; 

    $z = new ZipArchive(); 
    $z->open($outZipPath, ZIPARCHIVE::CREATE); 
    $z->addEmptyDir($dirName); 
    $this->folderToZip($sourcePath, $z, strlen("$parentPath/")); 
    $z->close(); 
  } 

  // checked the  file is exits in current folder
  public function checkFileIsExits($copied_directory_name,$pasted_directory,$copied_directory,$projects_id)
  {

    $user_id    = Auth::user()->id;   
    $exists = Storage::exists($pasted_directory."/".$copied_directory_name);
    $projects_id = $projects_id;
    $extension_copied_directory = explode('.',$copied_directory_name);
    $extension = end($extension_copied_directory);
    if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' )
    {
          $getThumbpath = explode('/', $copied_directory);
          $thumbnailName = end($getThumbpath);
          $replace_name ='thumbnail_img/'.$thumbnailName;
          $thumbnail_img_path = str_replace($thumbnailName,$replace_name,$copied_directory);

    }

    if($exists)
    {
      array_pop($extension_copied_directory);
      $copied_directory_withOut_ext = implode('.',$extension_copied_directory);

      $this->copied_directory_name= $copied_directory_withOut_ext."-copy.".$extension; 
      //print_r($this->copied_directory_name);die();
      $this->copy_status =false;
      $this->checkFileIsExits($this->copied_directory_name,$pasted_directory,
      $copied_directory,$projects_id);

      if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' )
       {

         $thumbnailPath = $pasted_directory.'/thumbnail_img/'.$this->copied_directory_name;
       }
 
    }else{ 

      $new_path = $pasted_directory.'/'. $this->copied_directory_name;
      $lastCopied = $this->copied_directory_name; 

      if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' )
     {
      $thumbnailPath = $pasted_directory.'/thumbnail_img/'.$lastCopied;
     }

      Storage::copy( $copied_directory, $new_path);
      if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' )
       {
         Storage::copy( $thumbnail_img_path, $thumbnailPath);
       }
       
      $getIndex =$this->getIndexOfDocument($projects_id,$pasted_directory);

       if($getIndex == ''){

            $index = 1; 

        }else{

            $index = intval($getIndex)+1;

        }

        $document = new document();

                    $document->project_id = $projects_id;
                    $document->doc_index = $index;
                    $document->document_name  = $lastCopied;    
                    $document->path = $new_path;
                    $document->directory_url = $pasted_directory;
                    $document->document_status = '0';
                    $document->type = $extension;
                    $document->deleted_at = '0';
                    $document->restored_at ='0';
                    $document->uploaded_by = $user_id;
                    $document->updated_by  = $user_id;
                    $document->deleted_by = '0';
                    $document->restored_by  = '0';
                    $document->save();


                    //set permission// 

                    $project_id = $projects_id;
                    $getCurrentDocumentId = $document->id;

                    $this->AllActionStorePermission ($pasted_directory,$getCurrentDocumentId,$project_id); 

          $this->copy_status =true;
        }
        
    }

    // check folder is exit in current folder

    public function checkFolderIsExits($src,$dst,$projects_id,$pasted_directory)
       {
          $projects_id = $projects_id;
          $exists = file_exists($dst);

          if($exists){

                 $this->copied_directory_name = $dst."-copy"; 
                 $this->copy_status = false;
                 $this->checkFolderIsExits($src,$this->copied_directory_name,$projects_id,$pasted_directory);
                 
          }  
          else{

            $this->Folder_copy($src,$dst,$projects_id,$pasted_directory);
            

          }
       }
        

 // folder copy //
   public function Folder_copy($src,$dst,$projects_id,$pasted_directory) { 


       $permission_pasted_dir = $pasted_directory;

       $user_id = Auth::user()->id;   
       $dir = opendir($src); 
       $projects_id = $projects_id;
       $pasted_directory = $pasted_directory;

       
       $getDocumentName = explode('/', $dst);
       $Document_name = end($getDocumentName);

       $store_path = storage_path().'/app/';

       $getPasteDocDirectory = str_replace($store_path,'',$dst);
        
       $DocumentName1  = explode('/', $getPasteDocDirectory);

       $Document_name2 = array_pop($DocumentName1);
   
       $directory_path =implode('/',$DocumentName1);

       @mkdir($dst); 

       $getIndex =$this->getIndexOfDocument($projects_id,$pasted_directory);

       if($getIndex == ''){

            $index = 1; 

        }else{

            $index = intval($getIndex)+1;

        }

                          $document = new document();
                          $document->project_id = $projects_id;
                          $document->doc_index = $index;
                          $document->document_name  = $Document_name;    
                          $document->path = $getPasteDocDirectory;
                          $document->directory_url = $directory_path;
                          $document->document_status = '1';
                          $document->type = '';
                          $document->deleted_at = '0';
                          $document->restored_at ='0';
                          $document->uploaded_by = $user_id;
                          $document->updated_by  = $user_id;
                          $document->deleted_by = '0';
                          $document->restored_by  = '0';
                          
                          if($Document_name != 'thumbnail_img')    
                          {
                                $document->save();

                                $project_id = $projects_id;
                                $getCurrentDocumentId = $document->id;

                                $this->AllActionStorePermission($permission_pasted_dir,$getCurrentDocumentId,$project_id); 
                          }

                          //set permission// 

                        
                          
                    

          while(false !== ( $file = readdir($dir)) ) { 

              if (( $file != '.' ) && ( $file != '..' )) { 

                  if ( is_dir($src . '/' . $file) ) {

                      $this->Folder_copy($src . '/' . $file, $dst . '/' . $file,$projects_id,$pasted_directory); 

                  } 
                  else { 

                      copy($src . '/' . $file,$dst . '/' . $file);

                      $store_path = storage_path().'/app/';
                      
                      $getPasteDocDirectory = str_replace($store_path,'',$dst);

                          $getIndex =$this->getIndexOfDocument($projects_id,$getPasteDocDirectory);

                                     if($getIndex == ''){

                                          $index = 1; 

                                      }else{

                                          $index = intval($getIndex)+1;

                                      }


                           $document = new document();

                            $document->project_id = $projects_id;
                            $document->doc_index = $index;
                            $document->document_name  = $file;    
                            $document->path = $getPasteDocDirectory.'/'. $file;
                            $document->directory_url = $getPasteDocDirectory;
                            $document->document_status = '0';
                            $document->type = '';
                            $document->deleted_at = '0';
                            $document->restored_at ='0';
                            $document->uploaded_by = $user_id;
                            $document->updated_by  = $user_id;
                            $document->deleted_by = '0';
                            $document->restored_by  = '0';

                            $document->save(); 


                            //set permission// 
                            
                            $project_id = $projects_id;
                            $getCurrentDocumentId = $document->id;

                            $this->AllActionStorePermission ($permission_pasted_dir,$getCurrentDocumentId,$project_id); 

                  } 
              } 
      } 

      closedir($dir); 
  } 


   // get the all document to extract folder zip.//

       public function get_Zip_Documents($zip_path,$project_id)

       {
        
        $return = array();
        $project_id = $project_id;
        $project_folders = Storage::directories($zip_path);
        $project_file = Storage::files($zip_path);
    
        $user_id  = Auth::user()->id;

        foreach ($project_file as $value) {

          $getIndex =$this->getIndexOfDocument($project_id,$zip_path); 
          $getFileName = explode('/',$value);
          $fileName  = end($getFileName);

          $getExtension = explode('.', $fileName);
          $FileExtension   = end($getExtension);

          if($FileExtension == 'jpg' || $FileExtension == 'jpeg' ||$FileExtension == 'png' )
              {

                // create thumbnail 

                 $thumbnail_width = 250;

                 $thumbnail_height = 178;

                 $filePathtoThumb = storage_path()."/app/".$value;

                 $getThumbpath =  $zip_path.'/thumbnail_img/'.$fileName;

                 $newThumbnailPath = storage_path()."/app/".$getThumbpath;

                 $this->createThumbnail($filePathtoThumb , $newThumbnailPath, $thumbnail_width, $thumbnail_height, $background=false);
               }

             if($getIndex == ''){

                  $index = 1; 

              }else{

                  $index = intval($getIndex)+1;

              }
 
             $document = new document();

                    $document->project_id = $project_id;
                    $document->doc_index = $index;
                    $document->document_name  = $fileName;    
                    $document->path = $value;
                    $document->directory_url = $zip_path;
                    $document->document_status = '0';
                    $document->type = 'dd';
                    $document->deleted_at = '0';
                    $document->restored_at ='0';
                    $document->uploaded_by = $user_id;
                    $document->updated_by  = $user_id;
                    $document->deleted_by = '0';
                    $document->restored_by  = '0';
                    $document->save();
         
            }
      
        if ($project_folders) {

          foreach ($project_folders as $folder) {
            
            $getFolderName = explode('/',$folder);
            $folderName  = end($getFolderName);

            if($folderName == 'thumbnail_img')
            {
               
            }else{

                  $getIndex =$this->getIndexOfDocument($project_id,$zip_path);

                  if($getIndex == ''){

                      $index = 1; 

                  }else{

                      $index = intval($getIndex)+1;
                  }

              // strore folder in zip's folder subfolder directory.

                        $document = new document();

                        $document->project_id = $project_id;
                        $document->doc_index = $index;
                        $document->document_name  = $folderName;    
                        $document->path = $folder;
                        $document->directory_url = $zip_path;
                        $document->document_status = '1';
                        $document->type = '';
                        $document->deleted_at = '0';
                        $document->restored_at ='0';
                        $document->uploaded_by = $user_id;
                        $document->updated_by  = $user_id;
                        $document->deleted_by = '0';
                        $document->restored_by  = '0';
                        $document->save();


                Storage::makeDirectory($folder.'/thumbnail_img');

            $return[$folder] = $this->get_Zip_Documents($folder,$project_id);
            }
         }
      }
        return $return;
 
      }
      

  //extract file// 
   public function extractDocument(Request $request)

   {

        $zip = new ZipArchive();
        $user_id  = Auth::user()->id;
        $extractDocumentPath = $request->extractDocumentPath ; 
        $getDirectoryName = explode('/',$extractDocumentPath);
        array_pop($getDirectoryName);
        $direcctoryName       = implode('/',$getDirectoryName);
        $path = storage_path()."/app/".$extractDocumentPath;
        $project_id  = $request->project_id;
      
       if($zip->open($path) == TRUE) 
       {

                    $dir_zip = trim($zip->getNameIndex(0), '/');

                    $getFolderName =  explode('/',$dir_zip);

                    $zipFolder = $getFolderName[0];
                 
                    $address = __DIR__;

                    $zipFolderFullPath = $direcctoryName.'/'.$zipFolder;

                    if(Storage::exists($zipFolderFullPath))
                     {
                        $get = 'exits';
                        $folderLiseCount = $this->folderCheckExitsInDoc($direcctoryName,$zipFolder,$direcctoryName,$get);

                        $get_document_name = explode('/',$folderLiseCount);
                        $store_path        = $folderLiseCount;
                        $document_name_exit     = end($get_document_name);

                        $zipFolder = $document_name_exit;

                        Storage::makeDirectory($folderLiseCount);

                        $zip->extractTo(storage_path()."/app/".$folderLiseCount);


                        $zip_path = storage_path()."/app/".$folderLiseCount;

                        $zipFolderFullPath = $folderLiseCount;

                     }else{

                                  $zip->extractTo(storage_path()."/app/".$direcctoryName);                                
                                  $zip_path = storage_path()."/app/".$direcctoryName;

                           }

                                  $zip->close();
                                  $getIndex =$this->getIndexOfDocument($project_id,$direcctoryName);

                                      if($getIndex == ''){

                                            $index = 1; 

                                        }else{

                                       $index = intval($getIndex)+1;

                                    }
                                    
                                  if($zipFolder !== 'thumbnail_img')  
                                  {
                                     $document = new document();

                                              $document->project_id = $project_id;
                                              $document->doc_index = $index;
                                              $document->document_name  = $zipFolder;    
                                              $document->path = $zipFolderFullPath;
                                              $document->directory_url = $direcctoryName;
                                              $document->document_status = '1';
                                              $document->type = '';
                                              $document->deleted_at = '0';
                                              $document->restored_at ='0';
                                              $document->uploaded_by = $user_id;
                                              $document->updated_by  = $user_id;
                                              $document->deleted_by = '0';
                                              $document->restored_by  = '0';
                                              $document->save();
                                  }

                                  Storage::makeDirectory($zipFolderFullPath.'/thumbnail_img');           
                                  
                                  $this->get_Zip_Documents($zipFolderFullPath,$project_id);

                                    $report = new Report();
                                    $report->action = '27';
                                    $report->document_path = $extractDocumentPath;
                                    $report->Auth = Auth::user()->id;
                                    $report->save();

                                  echo 'ok';

                    

       }
     else{
           echo 'failed';
      }
   }


   // create thumnail image 


   function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {

            list($original_width, $original_height, $original_type) = getimagesize($filepath);

            if ($original_width > $original_height) {
                $new_width = $thumbnail_width;
                $new_height = intval($original_height * $new_width / $original_width);
            } else {
                $new_height = $thumbnail_height;
                $new_width = intval($original_width * $new_height / $original_height);
            }
            $dest_x = intval(($thumbnail_width - $new_width) / 2);
            $dest_y = intval(($thumbnail_height - $new_height) / 2);

            if ($original_type === 1) {
                $imgt = "ImageGIF";
                $imgcreatefrom = "ImageCreateFromGIF";
            } else if ($original_type === 2) {
                $imgt = "ImageJPEG";
                $imgcreatefrom = "ImageCreateFromJPEG";
            } else if ($original_type === 3) {
                $imgt = "ImagePNG";
                $imgcreatefrom = "ImageCreateFromPNG";
            } else {
                return false;
            }

            $old_image = $imgcreatefrom($filepath);
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

            // figuring out the color for the background
            if(is_array($background) && count($background) === 3) {
              list($red, $green, $blue) = $background;
              $color = imagecolorallocate($new_image, $red, $green, $blue);
              imagefill($new_image, 0, 0, $color);
            // apply transparent background only if is a png image
            } else if($background === 'transparent' && $original_type === 3) {
              imagesavealpha($new_image, TRUE);
              $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
              imagefill($new_image, 0, 0, $color);
            }

            imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $imgt($new_image, $thumbpath);
            return file_exists($thumbpath);
       }

     public function displayImage(Request $request){

                      $getThumbpath = $request->get('image');

                      $thumbpathGet = Storage::get($getThumbpath);

                      $thumbpath_ret = new Response($thumbpathGet, 200);
                      return (new Response($thumbpathGet, 200));
                      // print_r( $thumbpath_ret);die();
             }


    public function getIndexOfDocument ($project_id,$current_directory){
       
       $getIndex  = Document::where('project_id',$project_id)->where('directory_url',$current_directory)->orderBy('doc_index', 'desc')->first();

       if($getIndex == '')  
       {
          return '';
       }else{
          return $getIndex->doc_index;
       }
        
    }

    public function DocumentExitInDir($fileName){

      if(Storage::exists($fileName))
              {
                   return "exits";

              }else{

                    return "not_exits";
              }
    }

    public function folderCheckExitsInDoc($checkFolderIsExitInDir,$folderName,$current_directory,$get){


       for ($i=2; $i<=1000; $i++) { 

          if($get == 'exits')
          {
              $getFolderName = explode(' ',$folderName);
              $count = count($getFolderName);

              if($count == '1')
              {
                 $folderNameNew = $folderName.'('.$i.')';

              }else{

                  $doFolder= end($getFolderName);
                  return $doFolder;
               }

              //$folderNameNew1 = $folderNameNew.'('.$i.')';
              $checkFolderIsExitInDirNew = $current_directory.'/'.$folderNameNew;
              $get =  $this->DocumentExitInDir($checkFolderIsExitInDirNew);

          }else{

            return $checkFolderIsExitInDirNew;

          }
         
       }

    }


      public function CreateThumbnailPath($filePath){
             
            $getThumbpathNew = explode('/', $filePath);

            $fileName =end($getThumbpathNew);

            $newThumbPath = array_pop($getThumbpathNew);

            $genrateThumbPath = implode('/',$getThumbpathNew);

            $getThumbpath = $genrateThumbPath.'/thumbnail_img/'.$fileName;

            return $getThumbpath;
            
           } 

  // get the project's group


    public function getAllGroups($project_id){

          $getGroups = Group::where('project_id',$project_id)->get();

          return $getGroups;
    }


    /// document view 


    public function documentView($project_id,$file_id){


       $getPath = Document::where('project_id',$project_id)->where('id',$file_id)->first();
       $userInGroup = getAuthgroupId($project_id); 
       $userRole = checkCurrentGroupUser($project_id);

       if($userRole == 'Administrator')
       {
          $DocPermission = '';

       }else{

         $getDocPermission = Permission::where('project_id',$project_id)->where('group_id',$userInGroup)->orWhere('document_id',$file_id)->first();
 
         $DocPermission = $getDocPermission->permission_id;
       }

       $getSetting = Setting::where('project_id',$project_id)->first();

       $watermark_view = $getSetting['watermark_view']; 
       $watermark_text = $getSetting['watermark_text'];
       $watermark_color = $getSetting['watermark_color'];
       $downloadable = $getSetting['downloadable'];
       $printable = $getSetting['printable'];
       $discussable = $getSetting['discussable'];

       $doc_path = Storage::get($getPath->path);

       $filePath =  $getPath->path;

       $fullPath = storage_path().'/app/'.$filePath;

       $doc_name = $getPath->document_name;

       $document_Data = base64_encode($doc_path);

       $getEditableExt = explode('/', $filePath);

       $getdocumementExtension = end($getEditableExt);
  
       $getExtension = explode('.', $getdocumementExtension);
       
       $Ext = end($getExtension);

       // docx file
       $kv_texts = $this->kv_read_word($fullPath);

       if($kv_texts !== false) {   
          
         $docx_data = $kv_texts;

        }
        else {

          $docx_data = '';
        }

          $report = new Report();
          $report->action = '7';
          $report->document_path = $filePath;
          $report->Auth = Auth::user()->id;
          $report->save();


       return view('documents.file_view',compact('document_Data','doc_name','Ext','filePath','docx_data','project_id','DocPermission','watermark_view','watermark_text','watermark_color','downloadable','printable','discussable'));

    }

    // get the docx file content

    function kv_read_word($input_file){ 

                 $kv_strip_texts = ''; 
                       $kv_texts = '';  
                if(!file_exists($input_file))
                {
                 
                  return false;

                } 
              
                $zip = zip_open($input_file);
                  
                if (!$zip || is_numeric($zip))
                {
                   return false;
                }
                
                while ($zip_entry = zip_read($zip)) {
                    
                  if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
                    
                  if (zip_entry_name($zip_entry) != "word/document.xml") continue;


                  $kv_texts .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    
                  zip_entry_close($zip_entry);
                  
                }
                
                zip_close($zip);
                 
                $kv_texts = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $kv_texts);


                $kv_texts = str_replace('</w:r></w:p>', "\r\n", $kv_texts);
                $kv_strip_texts = nl2br(strip_tags($kv_texts,''));
                //print_r($kv_strip_texts); die('here');

                return $kv_strip_texts;
              }


       public function SearchDocument(Request $request){

              $searchContent = $request->serachContent;
              $projects_id    = $request->project_id;
              $auth_email = Auth::user()->email;
              $user_id    = Auth::user()->id;

              $IndexOfFolder = [];

              $IndexOfFile   = [];


              // verify project creater

              $getProjectCreaterId = checkCurrentGroupUser($projects_id);
              $group_id            = getAuthgroupId($projects_id);

               
              $FindedDoc = document::where('document_name','LIKE',"{$searchContent}%")->where('project_id',$projects_id)->get();

              foreach ($FindedDoc as $FindedDoc){

                $Doc_path = $FindedDoc->path;

                      // get the all document indexing// 

                      $getIndexOfFolder = Document::where('project_id', $projects_id)->where('path', $Doc_path)->where('document_status', '1')->where('deleted_by', '0')->get();


                        foreach ($getIndexOfFolder as $getIndexOfFolder){

                              $path = $getIndexOfFolder->path;
                              $document_name = $getIndexOfFolder->document_name;
                              $getDocumentId = $getIndexOfFolder->id;
                              $doc_index    = $getIndexOfFolder->doc_index;

                               //get the all fav document in this directory
                       
                              $getFavFolder = FavDocument::where('document_id',$getDocumentId)->where('user_id', $user_id)->pluck('document_id');

                              // $getFavFolder = $getFavFolder[0];

                              $Folderpermission = Permission::where('document_id',$getDocumentId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                              $FolderNote = Note::where('document_id',$getDocumentId)->where('user_id',$user_id)->pluck('id');

                              $folder_ques = Question::where('document_id',$getDocumentId)->where('project_id',$projects_id)->pluck('id');

                              // $Folderpermission = $Folderpermission[0];

                              $Foldercount = count($Folderpermission);

                              if($getProjectCreaterId == "Administrator"){ 

                                   $Folderpermission  =  [];

                                   $Folder_array =  ['document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];

                                   array_push($IndexOfFolder,$Folder_array);

                              }else{

                                    if($Foldercount !== 0){


                                          $Folder_array =  ['document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];

                                         array_push($IndexOfFolder,$Folder_array);
                                    
                                    }

                              }
                            
                        }


                        //end

                        //for file document.

                       

                        $getIndexOfFile = Document::where('project_id', $projects_id)->where('path', $Doc_path)->where('document_status', '0')->where('deleted_by', '0')->get();


                         foreach ($getIndexOfFile as $getIndexOfFile) {

                              $path = $getIndexOfFile->path;
                              $getFileId = $getIndexOfFile->id;
                              $document_name = $getIndexOfFile->document_name;
                              $doc_index    = $getIndexOfFile->doc_index;

                              $Filepermission = Permission::where('document_id',$getFileId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                              //get the all fav document in this directory
                       
                              $getFavFile = FavDocument::where('document_id',$getFileId)->where('user_id', $user_id)->pluck('document_id'); 

                              $FileNote = Note::where('document_id',$getFileId)->where('user_id',$user_id)->pluck('id');

                              $file_ques = Question::where('document_id',$getFileId)->where('project_id',$projects_id)->pluck('id');


                              $Filecount = count($Filepermission);

                              if($getProjectCreaterId == "Administrator"){

                                $Filepermission  = [];

                                $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];

                                 array_push($IndexOfFile,$File_array);

                              }else{
                                          

                                if($Filecount !== 0){

                                      $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];
                                          

                                   array_push($IndexOfFile,$File_array);
                                    
                                }

                              }

                        }
            }  

           $data = ['folder_index' => $IndexOfFolder , 'file_index' => $IndexOfFile];

                       // Save record

           $report = new Report();
           $report->action = '15';
           $report->document_path = $projects_id;
           $report->Auth = $user_id;
           $report->save();
               

           return $data;

          

      }

     public function SearchFavDocument(Request $request){

              $projects_id    = $request->project_id;
              $auth_email = Auth::user()->email;
              $user_id    = Auth::user()->id;
              $getProjectCreaterId = checkCurrentGroupUser($projects_id);
              $group_id            = getAuthgroupId($projects_id);

              $IndexOfFile   = [];
              $IndexOfFolder = [];

              $getFavDocOfProject = FavDocument::where('project_id',$projects_id)->where('user_id',$user_id)->get();
            
                foreach ($getFavDocOfProject as $getFavDocOfProject) {
                      
                        $Doc_path = $getFavDocOfProject->document_path;

                        // get the all document indexing//

                        $getIndexOfFolder = Document::where('project_id', $projects_id)->where('path', $Doc_path)->where('document_status', '1')->where('deleted_by', '0')->get();


                          foreach ($getIndexOfFolder as $getIndexOfFolder){

                                $path = $getIndexOfFolder->path;
                                $document_name = $getIndexOfFolder->document_name;
                                $getDocumentId = $getIndexOfFolder->id;
                                $doc_index    = $getIndexOfFolder->doc_index;

                                 //get the all fav document in this directory
                         
                                $getFavFolder = FavDocument::where('document_path',$path)->where('user_id', $user_id)->pluck('document_id');

                                // $getFavFolder = $getFavFolder[0];

                                $Folderpermission = Permission::where('document_id',$getDocumentId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                                $FolderNote = Note::where('document_id',$getDocumentId)->where('user_id',$user_id)->pluck('id');

                                $folder_ques = Question::where('document_id',$getDocumentId)->where('project_id',$projects_id)->pluck('id');

                                // $Folderpermission = $Folderpermission[0];

                                $Foldercount = count($Folderpermission);

                                if($getProjectCreaterId == "Administrator"){ 

                                     $Folderpermission  =  [];

                                     $Folder_array =  ['document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];

                                     array_push($IndexOfFolder,$Folder_array);

                                }else{

                                      if($Foldercount !== 0){

                                           
                                            $Folder_array =  ['document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Folderpermission,'fav'=>$getFavFolder,'note'=>$FolderNote,'ques'=>$folder_ques];

                                           
                                        

                                           array_push($IndexOfFolder,$Folder_array);
                                      
                                      }

                                }
                              
                          }


                          //end

                          //for file document.

                          

                          $getIndexOfFile = Document::where('project_id', $projects_id)->where('path', $Doc_path)->where('document_status', '0')->where('deleted_by', '0')->get();


                           foreach ($getIndexOfFile as $getIndexOfFile) {

                                $path = $getIndexOfFile->path;
                                $getFileId = $getIndexOfFile->id;
                                $document_name = $getIndexOfFile->document_name;
                                $doc_index    = $getIndexOfFile->doc_index;

                                $Filepermission = Permission::where('document_id',$getFileId)->where('project_id',$projects_id)->where('group_id',$group_id)->pluck('permission_id');

                                //get the all fav document in this directory
                         
                                $getFavFile = FavDocument::where('document_path',$path)->where('user_id', $user_id)->pluck('document_id'); 

                                $FileNote = Note::where('document_id',$getFileId)->where('user_id',$user_id)->pluck('id');

                                $file_ques = Question::where('document_id',$getFileId)->where('project_id',$projects_id)->pluck('id');


                                $Filecount = count($Filepermission);
                                //print_r($Filecount);

                                if($getProjectCreaterId == "Administrator"){

                                  $Filepermission  = [];

                                  $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];

                                   array_push($IndexOfFile,$File_array);
                                   //print_r($IndexOfFile);

                                }else{
                                            

                                  if($Filecount !== 0){



                                        $File_array =  ['doc_id'=>$getFileId,'document_name'=>$document_name,'path'=>$path,'document_name'=>$document_name,'doc_index'=>$doc_index,'permission'=>$Filepermission,'fav'=>$getFavFile,'note'=>$FileNote,'ques'=>$file_ques];
                                           

                                     array_push($IndexOfFile,$File_array);
                                     //print_r($IndexOfFile);
                                      
                                  }

                                }

                          }
                   
                }

          // Save record

           $report = new Report();
           $report->action = '30';
           $report->document_path = $projects_id;
           $report->Auth = $user_id;
           $report->save();

           $data = ['folder_index' => $IndexOfFolder , 'file_index' => $IndexOfFile];
              return $data; 



      }

      //export records

      public function downloadExcel($type)
        {
            $data = User::select('name','email','phone_no','company')->get()->toArray();
                
            return Excel::create('allUsers', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download($type);
        }


}
