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

           //$getExtenstion = explode('.',$name1);

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

                 //$Extenstion = explode('.',$key);
                 //$getExtenstion =  end($Extenstion);
                 $getExtenstion = pathinfo($key, PATHINFO_EXTENSION);

                  $output .= '<li data-permission="'.$document_permission.'" data-verify="0" data-value="'. $key.'" class="document_permission" ><span class="document_file_name inactive customspan">';

                 if($getExtenstion == 'jpg' || $getExtenstion == 'jepg' || $getExtenstion == 'png' || $getExtenstion == 'pdf' || $getExtenstion == 'xlsx' || $getExtenstion == 'xls' || $getExtenstion == 'xlsb' || $getExtenstion == 'zip' || $getExtenstion == 'docx'){

                   //print_r($getExtenstion);die();

                   if($getExtenstion == 'jpg' || $getExtenstion == 'png' || $getExtenstion == 'jepg'){
                       $output .= '<i class="fa fa-photo"></i>';
                   }

                   if($getExtenstion == 'pdf')
                   {
                      $output .= '<i class="fas fa-file-pdf"></i>';
                   }
                   if($getExtenstion == 'xlsx' || $getExtenstion == 'xls' || $getExtenstion == 'xlsb')
                   {
                      $output .= '<i class="fas fa-file-excel"></i>';
                   }   
                   if($getExtenstion == 'zip')
                   {
                      $output .= '<i class="far fa-file-archive"></i>';
                   }                                      

                 }else{

                     $output .= '<i class="far fa-file"></i>';
                 }

                  $output .=' '.$name.'</span>';

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



    function checkUserType($project_name){
      if (Auth::user()){
        $authEmail = Auth::user()->email;

        $project_id = Project::where('project_slug',$project_name)->pluck('id');

        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        $getCurrentGroupUser = Group::where('id',$CurrentGroupId)->first();

        $CurrentGroupUser = $getCurrentGroupUser->group_user_type;

        return  $CurrentGroupUser;
      }
      else{
        return redirect('/login');
      }

    }


    function checkCurrentGroupUser($project_id){

      if (Auth::user()) {
       $authEmail = Auth::user()->email;
      }

        



        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        $getCurrentGroupUser = Group::where('id',$CurrentGroupId)->first();

        $CurrentGroupUser = $getCurrentGroupUser->group_user_type;

        return  $CurrentGroupUser;

    }

    function getAuthgroupId($project_id){
          if (Auth::user()) {
       $authEmail = Auth::user()->email;
      }
        

        $getCurrentGroupId = Group_Member::where('project_id',$project_id)->where('member_email',$authEmail)->first();

        $CurrentGroupId = $getCurrentGroupId->group_id;

        return $CurrentGroupId;

    }

    function getTotalUserOftheProject($project_id){


     $getCurrentGroupId = Group_Member::where('project_id',$project_id)->get();

     return $getCurrentGroupId;


    }

?>