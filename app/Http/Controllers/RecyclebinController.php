<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delete_Doc;
use App\Project;
use App\Report;
use App\User;
use App\Note;
use App\Document;
use App\Group_Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;

class RecyclebinController extends Controller
{
    public function getdeletedDoc (Request $request){
 
    	$projects_id = $request->projects_id;
        $GetDelFolder = Delete_Doc::where('project_id','=', $projects_id)->Where('deleted_folder','!=','')->pluck('deleted_folder','deleted_from');

        
        $GetDelFile  =  Delete_Doc::where('project_id','=', $projects_id)->Where('deleted_file','!=','')->pluck('deleted_file','deleted_from','deleted_time');
          
        $GetDelDocument = ['folder' => $GetDelFolder, 'file'=> $GetDelFile];

        return $GetDelDocument;
    }

    public function deleteRecycleBinDoc(Request $request){

        $projects_id = $request->projects_id;
        $GetDelFolder = Delete_Doc::where('project_id',$projects_id)->delete();
        document::where('project_id',$projects_id)->where('deleted_by','1')->delete();

        $project_directory =  $request->project_directory;
        $recycleBinFolderDir = $project_directory."/RecycleBin";
        
        Storage::deleteDirectory($recycleBinFolderDir);
        Storage::makeDirectory($recycleBinFolderDir);
      
        return "success";

    }

     public function restoreRecycleBinDoc (Request $request){

      $user_id = Auth::user()->id;
     	$projects_id = $request->projects_id;
      $restoreDocPath = $request->restorePath;


         foreach ($restoreDocPath as  $restoreDocPath) {

                $DocIdentify = $restoreDocPath['Identify'];

                $NewPath = $restoreDocPath['Rpath'];

                $usePath = $restoreDocPath['Rpath'];

                $OldPath = $restoreDocPath['Cpath'];

                $getRecycleDocName = explode('/',$OldPath);

                $deleteEntry = end($getRecycleDocName);

                $RemovedGet = explode('.',$deleteEntry);

                $count = sizeof( $RemovedGet);

                $getdocumentName = explode('/',$NewPath);

                $document_Name = end($getdocumentName);

                $getCurrentDir = array_pop($getdocumentName);

                $CurrentDir = implode("/",$getdocumentName);

                // create index and alise of the document

                       $folderCheckExit = $this->DocumentExitInDir($NewPath);

                              if($folderCheckExit == 'exits')
                               {

                                  $get = 'exits';
                                  $folderLiseCount = $this->folderCheckExitsInDoc($NewPath,$document_Name,$CurrentDir,$get);

                                  $get_document_name = explode('/',$folderLiseCount);
                                  $NewPath        = $folderLiseCount;
                                  $document_Name     = end($get_document_name);

                               }
                               
                             $getIndex =$this->getIndexOfDocument($projects_id,$CurrentDir);

                                 if($getIndex == ''){

                                      $index = 1; 

                                  }else{

                                      $index = intval($getIndex)+1;
                                  }

                $CheckDocIsFolderAsFile = Delete_Doc::where('deleted_file',$deleteEntry)->delete();

   
                if($DocIdentify == '1')
                {

                     $deletedTime = $restoreDocPath['deleted_time'];

                     Delete_Doc::where('deleted_folder',$deleteEntry)->delete();

                     $getDocInFolder = document::where('deleted_at','LIKE',"%{$deletedTime}%")->get();

                      if($getDocInFolder !=='')
                      {
                            foreach ($getDocInFolder as $getDocInFolder) {

                             $documentId = $getDocInFolder->id;
                             $documentPath =  $getDocInFolder->path;
                             $documentDirUrl = $getDocInFolder->directory_url;

                             $updateDocumentPath = str_replace($usePath, $NewPath, $documentPath); 
                             $updateDocumentDirUrl = str_replace($usePath, $NewPath, $documentDirUrl);

                             document::where('path',$documentPath)->update(['path' => $updateDocumentPath,'directory_url'=>$updateDocumentDirUrl]);
                          } 
                      }


                      $document = new document();
                            $document->project_id = $projects_id;
                            $document->doc_index = $index;
                            $document->document_name  = $document_Name;    
                            $document->path = $NewPath;
                            $document->directory_url = $CurrentDir;
                            $document->document_status = '1';
                            $document->type = '';
                            $document->deleted_at = '0';
                            $document->restored_at ='0';
                            $document->uploaded_by = $user_id;
                            $document->updated_by  = $user_id;
                            $document->deleted_by  = '0';
                            $document->restored_by  = '0';
                            $document->save();


                            Document:: where('path','LIKE',"%{$NewPath}%")->where('project_id',$projects_id)->update(['deleted_by'=>'0']);

                            $report = new Report();
                            $report->action = '9';
                            $report->document_path = $NewPath;
                            $report->Auth = Auth::user()->id;
                            $report->save();


                }else{
                     
                     
                      Delete_Doc::where('deleted_file',$deleteEntry)->delete();

                      $document = new document();
                            $document->project_id = $projects_id;
                            $document->doc_index = $index;
                            $document->document_name  = $document_Name;    
                            $document->path = $NewPath;
                            $document->directory_url = $CurrentDir;
                            $document->document_status = '0';
                            $document->type = '';
                            $document->deleted_at = '0';
                            $document->restored_at ='0';
                            $document->uploaded_by = $user_id;
                            $document->updated_by  = $user_id;
                            $document->deleted_by = '0';
                            $document->restored_by  = '0';
                            $document->save();

                            $report = new Report();
                            $report->action = '10';
                            $report->document_path = $NewPath;
                            $report->Auth = Auth::user()->id;
                            $report->save();

                            
                }
                              
                Storage::move($OldPath,$NewPath);

                $storagePath = storage_path()."/app/".$NewPath;


                if (is_dir($storagePath)) {

                }
                else{
                      
                       $FileExtension = $this->getExtension($NewPath);

                       if($FileExtension == 'jpg' || $FileExtension == 'jpeg' ||$FileExtension == 'png' ){

                                 $thumbnail_width = 250;

                                 $thumbnail_height = 178;

                                 $genrateThumbPath = $this->CreateThumbnailPath($NewPath);

                                 $getThumbpath = storage_path()."/app/".$genrateThumbPath;

                                 $filePathtoThumb = storage_path()."/app/".$NewPath;

                                 $this->createThumbnail($filePathtoThumb , $getThumbpath, $thumbnail_width, $thumbnail_height, $background=false); 
                       }
                          
                }

         }
         return "restore";

     }

     // delete document in recycleBin
     public function deleteRecycleBinSelectedDoc(Request $request){
     	
     	$projects_id = $request->projects_id;
     	$deleteDocPath = $request->deletePath;

      foreach ($deleteDocPath as  $deleteDocPath) {

      	        $NewPath = $deleteDocPath['Rpath'];

                $OldPath = $deleteDocPath['Cpath'];

                $DocIdentify = $deleteDocPath['Identify'];

                $getRecycleDocName = explode('/',$OldPath);

                $deleteEntry = end($getRecycleDocName);

                $RemovedGet = explode('.',$deleteEntry);

                $count = sizeof($RemovedGet);


                if($DocIdentify == 0)
                {

                	 Delete_Doc::where('project_id',$projects_id)->where('deleted_file',$deleteEntry)->delete();

                   Storage::delete($OldPath);
                	
                }else{

                     Delete_Doc::where('project_id',$projects_id)->where('deleted_folder',$deleteEntry)->delete();

                     Document:: where('path','LIKE',"%{$NewPath}%")->where('project_id',$projects_id)->where('restored_by','0')->delete();

                     Storage::deleteDirectory($OldPath);
                }
           
                     
      }
        return "Delete";


     }


     // check document exits in document

    public function getIndexOfDocument ($project_id,$current_directory){
       
       $getIndex  = Document::where('project_id',$project_id)->where('directory_url',$current_directory)->orderBy('doc_index', 'desc')->first();
           
       if($getIndex == '')  
       {
          return '';
       }else{
          return $getIndex->doc_index;
       }
        
    }



     //  restored document to store in database by using indexing..

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

                 $getDocIs = explode('.',$folderName);
                 $countDoc = count($getDocIs);

                 $ext = end($getDocIs);
                 $getDocWithOutExt = array_pop($getDocIs);
                 $DocWithOutExt    = implode('',$getDocIs);

                     if($countDoc == '1')
                     {
                        $folderNameNew = $folderName.'('.$i.')';
                        
                     }else{
                           
                        $folderNameNew = $DocWithOutExt.'('.$i.').'.$ext;
                        
                     }
                 
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

       public function CreateThumbnailPath($filePath){
             
            $getThumbpathNew = explode('/', $filePath);

            $fileName =end($getThumbpathNew);

            $newThumbPath = array_pop($getThumbpathNew);

            $genrateThumbPath = implode('/',$getThumbpathNew);

            $getThumbpath = $genrateThumbPath.'/thumbnail_img/'.$fileName;

            return $getThumbpath;

           } 


          public function getExtension($filePath){

                    $getFileExtension  = explode('/',$filePath);
                    $getFileExtension1 = end($getFileExtension);
                    $getFileExtension2 = explode('.',$getFileExtension1);
                    $FileExtension     = end($getFileExtension2);

                    return $FileExtension;

          }

}



