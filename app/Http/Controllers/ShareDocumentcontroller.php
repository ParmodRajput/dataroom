<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Permission;
use App\Project;
use App\User;
use App\Document;
use App\ShareDocument;
use Illuminate\Support\Facades\Crypt;
use Mail;

class ShareDocumentcontroller extends Controller
{
    public function shareDocs(Request $request){

     $project_id = $request->project_id;
     $userEmails = $request->userEmails;
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

                        	return view('error.page1');
                        }

                    }else{


                    	$getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->get();
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

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_path'=>$GetShareWithMeDocumentFolder['path'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail];	
                  }


                  $getShareWithMeDocumentFile = Document::where('id',$Document)->where('document_status','0')->first();

                  if($getShareWithMeDocumentFile == null)
                  {

                  	  $ShareWithMeDocumentFile = [];

                  }else{


                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_path'=>$getShareWithMeDocumentFile['path'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail];
                  }


               }else{


               	 $GetShareWithMeDocumentFolder = Document::where('project_id',$decryptedProjectId)->where('document_status','1')->where('id',$Document)->get();


               	  if($GetShareWithMeDocumentFolder == null)
                  {
                  	  $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_path'=>$GetShareWithMeDocumentFolder['path'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail];	
                  }


               	 $getShareWithMeDocumentFile = Document::where('project_id',$decryptedProjectId)->where('document_status','0')->where('id',$Document)->get();

	             if($getShareWithMeDocumentFile == null)
	                  {
	                  	  $ShareWithMeDocumentFile = [];

	                  }else{


	                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_path'=>$getShareWithMeDocumentFile['path'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail];
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

        return view('Share.shareWithMe',compact('DocumentFolder','DocumentFile'));

    }

   
    public function ShowDocumentForAuth(Request $request){

        print_r('sdfsdf');die();

    }


    public function ViewDocument(Request $request){

        dd('dfsdf');

    }


    
}
