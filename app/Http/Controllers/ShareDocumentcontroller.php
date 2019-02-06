<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Permission;
use App\Project;
use App\User;
use App\Setting;
use App\Document;
use App\ShareDocument;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Mail;
use Excel;

class ShareDocumentcontroller extends Controller
{
    public function shareDocs(Request $request){

     $project_id = $request->project_id;
     $GetuserEmails = $request->userEmails;
     $userEmails = explode(',',$GetuserEmails);

     $durationTime = $request->durationTime;


     $registerValid = $request->registerValid;
     $printable = $request->printable;
     $downloadable = $request->downloadable;
     $DocumentId = $request->DocumentId;
     $time       = time();

     $SenderEmail = Auth::user()->email;
     $SenderName = Auth::user()->name;

    foreach ($DocumentId as $document) {

     foreach ($userEmails as $userEmail) {

         $SrDocument = new ShareDocument();
         $SrDocument->duration_time = $durationTime;
         $SrDocument->project_id = $project_id;
         $SrDocument->document_id = $document;
         $SrDocument->Shared_with = $userEmail;
         $SrDocument->Shared_by = $SenderEmail;
         $SrDocument->register_required = $registerValid;
         $SrDocument->printable = $printable;
         $SrDocument->downloadable = $downloadable;
         $SrDocument->access_token = $time;
         $SrDocument->save();


         $encryptedUserEmail = Crypt::encryptString($userEmail);
         $encryptedProjectId  = Crypt::encryptString($project_id);
         $registerRequired      = Crypt::encryptString($registerValid);

         $verifyUrl = url('/shareFile/'.$encryptedProjectId.'/'.$encryptedUserEmail.'/'.$registerRequired.'/'.$time);


               $data = array(

                          'name' => "Document Share By prodata",
                          'SenderEmail'=> $SenderEmail,
                          'SenderName' =>  $SenderName,
                          'verifyUrl'  => $verifyUrl,

                );

                Mail::send('mail.ShareDocumentEmail',$data, function ($message)use ($userEmail) {
                          $message->from('admin@prodata.com', 'Prodata room');
                          $message->to($userEmail)->subject('Share Document Email')->setBody("url('/')");

                });

     }

 }

     return "success";


    }

    public function CheckShareDocs(Request $request){

    	$authUserEmail ='';
        $checker = '';

        $project_id =  $request->route()->parameter('project_id');
        $decryptedProjectId = Crypt::decryptString($project_id);

        $userEmail =  $request->route()->parameter('userEmail');
        $decryptedUserEmail = Crypt::decryptString($userEmail);

        $registerChecker =  $request->route()->parameter('registerChecker');
        $decryptedRegisterChecker = Crypt::decryptString($registerChecker); 

        $time =  $request->route()->parameter('time');
        $current_date = date('Y-m-d');

        $DocumentFolder = [];
        $DocumentFile = [];

        if(Auth::user())
                    {
                        $authUserEmail = Auth::user()->email; 

                        if($decryptedUserEmail == $authUserEmail)
                        {
                            $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->get();

                            $checker = 'true';
                           

                        }else{

                        	 $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->get();
                        }

                        $GodataRoom = "projects";

                    }else{


                    	$getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->get();


                    	$GodataRoom = "register";
                    }

        foreach ($getShareableDocument as $getShareableDocument) {
       	
        	$Document = $getShareableDocument->document_id;
        	$GetProjectId = $getShareableDocument->project_id;
        	$access_token = $getShareableDocument->access_token;

               if($checker = 'true')
               {
                  $GetShareWithMeDocumentFolder = Document::where('id',$Document)->where('document_status','1')->first();

                  if($GetShareWithMeDocumentFolder == null)
                  {
                  	  $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail];	
                  }


                  $getShareWithMeDocumentFile = Document::where('id',$Document)->where('document_status','0')->first();

                  if($getShareWithMeDocumentFile == null)
                  {

                  	  $ShareWithMeDocumentFile = [];

                  }else{


                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail];
                  }


               }else{


               	 $GetShareWithMeDocumentFolder = Document::where('project_id',$decryptedProjectId)->where('document_status','1')->where('id',$Document)->get();


               	  if($GetShareWithMeDocumentFolder == null)
                  {
                  	  $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail];	
                  }


               	 $getShareWithMeDocumentFile = Document::where('project_id',$decryptedProjectId)->where('document_status','0')->where('id',$Document)->get();

	             if($getShareWithMeDocumentFile == null)
	                  {
	                  	  $ShareWithMeDocumentFile = [];

	                  }else{


	                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail];
	               }

               }

        	  if($GetShareWithMeDocumentFolder !== null)
                  {
                  	  array_push($DocumentFolder,$ShareWithMeDocumentFolder);
                  }


               if($getShareWithMeDocumentFile !== null)
                  {

              	     array_push($DocumentFile,$ShareWithMeDocumentFile);

              	  }


    }


        return view('Share.shareWithMe',compact('DocumentFolder','DocumentFile','GodataRoom'));

    }




//end

   
    public function ShowDocumentForAuth($project_id){
     
      $AuthEmail = Auth::user()->email;
      $encryptedUserEmail = Crypt::encryptString($AuthEmail);
      $encryptedProjectId  = Crypt::encryptString($project_id);
      $registerValid = '0';
      $registerRequired      = Crypt::encryptString($registerValid);
      $time ='0';

      return Redirect(url('/').'/shareFile/'.$encryptedProjectId.'/'.$encryptedUserEmail.'/'.$registerRequired.'/'.$time);
      
    }


    public function ViewDocument(Request $request){

        $project_id =  $request->route()->parameter('project_id');
        $encryptedUserEmail =  $request->route()->parameter('email');
        $userEmail = Crypt::decryptString($encryptedUserEmail);
        $access_token =  $request->route()->parameter('access_token');
        $document_id  = $request->route()->parameter('document_id');

        
        $SHRdoc = ShareDocument::where('project_id',$project_id)->where('project_id',$project_id)->where('Shared_with',$userEmail)->where('access_token',$access_token)->where('document_id',$document_id)->first();

        $downloadable = $SHRdoc['downloadable'];
        $printable = $SHRdoc['printable'];

     
        $getSetting = Setting::where('project_id',$project_id)->first();

        $watermark_text = $getSetting['watermark_text'];
        $watermark_color = $getSetting['watermark_color']; 


        $GetdocPath = Document::where('project_id',$project_id)->where('id',$document_id)->first();
  
        $doc_path = Storage::get($GetdocPath->path);

        $filePath =  $GetdocPath->path;

        $fullPath = storage_path().'/app/'.$filePath;

        $doc_name = $GetdocPath->document_name;

        $document_Data = base64_encode($doc_path);

        $getEditableExt = explode('/', $filePath);

        $getdocumementExtension = end($getEditableExt);
  
        $getExtension = explode('.', $getdocumementExtension);
       
        $Ext      = end($getExtension);

        // docx file

        $kv_texts = $this->kv_read_word($fullPath);

        if($kv_texts !== false) {   
          
           $docx_data = $kv_texts;

         }else{

           $docx_data = '';

         }

        return view('Share.viewSharedDoc',compact('document_Data','doc_name','Ext','filePath','docx_data','project_id','watermark_text','watermark_color','downloadable','printable'));

    }

    //end function


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

                return $kv_strip_texts;
         }

        //end function

}
//end class
