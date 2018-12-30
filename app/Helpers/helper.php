<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Group;
use App\Delete_Doc;
use App\Note;
use App\Permission;
use App\Document;
use App\Group_Member;
use App\FavDocument;
 
if (!function_exists('folder_tree')) {
    
    function folder_tree($folder_tree,$count = 0)
    {
          $output = '<ul>';


        foreach($folder_tree as $key => $value){ 

            $key1 = explode('@?#',$key);

            $key = $key1[0];

            $document_permission = end($key1);    

            $new =  explode("/",  $key);
            $name1 =  end($new);
            
            $name2 = substr($name1,0,12);
            $length = strlen($name1); 

            if($length >=20)
            {
               $name = $name2.' . . .'; 

            }else{
               
               $name =$name2;
            }

            $get = in_array('RecycleBin',$new);
            $checkThumbnailFolder = in_array('thumbnail_img',$new);

            if($get == "1" ||  $checkThumbnailFolder == "1" || $document_permission == '')
           {
                 $output .= '';  
           }else{
               
                 $output .= '<li id="projects" data-value="'. $key.'" data-permission="'.$document_permission.'" class="projects" ><span class="document_name">'. $name.'</span>';  
           }

            if(!empty($value)){
                $output .=  folder_tree($value);
            }
            $output .= '</li>';
    }   
    $output .= '</ul>';

    return $output;
 
}


  function folder_file_tree($folder_file_tree,$count=0)
    {

      $output = '<ul>';
        foreach($folder_file_tree as $key => $value){ 

            $key1 = explode('@?#',$key);
            $key = $key1[0];

            $document_permission = end($key1);

            $new =  explode("/",  $key);
            $name1 =  end($new);
            
            $name2 = substr($name1,0,20);
            $length = strlen($name1); 

            if($length >=20)
            {
               $name =$name2.' . . .'; 

            }else{
               
               $name =$name2;
            }


            $getFile = explode('.', $name);
            $isFile = count($getFile);

            $get = in_array('RecycleBin',$new);
            $checkThumbnailFolder = in_array('thumbnail_img',$new);
           if($get == "1" ||  $checkThumbnailFolder == "1")
           {
                 $output .= '';  
           }else{
                
                 if($isFile == '1')
                 {
                    $output .= '<li data-permission="'.$document_permission.'" data-verify="0" data-value="'. $key.'" class="document_permission" ><span class="document_folder_name">'. $name.'</span>';  

                 }else{

                    $output .= '<li data-permission="'.$document_permission.'" data-verify="0" data-value="'. $key.'" class="document_permission" ><span class="  document_file_name">'. $name.'</span>';
                 }
                
           }

            if(!empty($value)){
                
                $output .=  folder_file_tree($value);
            }
            $output .= '</li>';
    }  

     $output .= '</ul>';

    return $output;
 
    }
}

    function checkUserType($project_name){

        $authEmail = Auth::user()->email;

        $project_id = Project::where('project_name',$project_name)->pluck('id');

        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        $getCurrentGroupUser = Group::where('id',$CurrentGroupId)->first();

        $CurrentGroupUser = $getCurrentGroupUser->group_user_type;

        return  $CurrentGroupUser;

    }


    function checkCurrentGroupUser($project_id){

        $authEmail = Auth::user()->email;

        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        $getCurrentGroupUser = Group::where('id',$CurrentGroupId)->first();

        $CurrentGroupUser = $getCurrentGroupUser->group_user_type;

        return  $CurrentGroupUser;

    }

    function getAuthgroupId($project_id){

        $authEmail = Auth::user()->email;

        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        return $CurrentGroupId;

    }

?>