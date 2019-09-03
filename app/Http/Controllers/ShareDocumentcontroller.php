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
use App\DeviceDetect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Mail;
use Excel;
use Browser;
use Carbon\Carbon;
use Location;
class ShareDocumentcontroller extends Controller
{
    public function shareDocs(Request $request){
     $project_id = $request->project_id;
     $GetuserEmails = $request->userEmails;
     $emailtitle = $request->EmailsTitle;
     $userEmails = explode(',',$GetuserEmails);
     $durationTime = $request->durationTime;

     if($durationTime == 1)
     {
       $durationTime = date('Y-m-d', strtotime(' +3 day'));

     }

     if($durationTime == 2)
     {
       $durationTime = date('Y-m-d', strtotime(' +7 day'));

     }

     if($durationTime == 3)
     {
       $durationTime = date('Y-m-d', strtotime(' +15 day'));

     }

     if($durationTime == 4)
     {
       $durationTime = date('Y-m-d', strtotime(' +30 day'));

     }
     $share_time = Carbon::now()->toDateTimeString();
     $registerValid = $request->registerValid;
     $printable = $request->printable;
     $downloadable = $request->downloadable;
     $DocumentId = $request->DocumentId;
     $time       = time();

     $SenderEmail = Auth::user()->email;
     $SenderName = Auth::user()->name;

    

     foreach ($userEmails as $userEmail) {
        foreach ($DocumentId as $document) {
         $SrDocument = new ShareDocument();
         $SrDocument->duration_time = $durationTime;
         $SrDocument->project_id = $project_id;
         $SrDocument->document_id = $document;
         $SrDocument->Shared_with = $userEmail;
         $SrDocument->Shared_by = $SenderEmail;
         $SrDocument->Shared_time =$share_time;
         $SrDocument->register_required = $registerValid;
         $SrDocument->printable = $printable;
         $SrDocument->downloadable = $downloadable;
         $SrDocument->email_title = $emailtitle;
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
                          'emailtitle'      =>$emailtitle,
                );

               

     }
      Mail::send('mail.ShareDocumentEmail',$data, function ($message)use ($SenderEmail,$userEmail) {
                          $message->from($SenderEmail, 'Prodata room');
                          $message->to($userEmail)->subject('Share Document Email')->setBody("url('/')");

                });

 }

     return "success";


    }

    public function CheckShareDocs(Request $request){

    	$authUserEmail ='';
        $checker = '';

        $project_id =  $request->route()->parameter('project_id');
        $decryptedProjectId = Crypt::decryptString($project_id);

        $project_id_share = $decryptedProjectId;

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

                        if($decryptedUserEmail == $authUserEmail){
                          if($time > '0'){
                            $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('duration_time', '>=', $current_date)->where('access_token',$time)->get();
                          }else{
                            $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('duration_time', '>=', $current_date)->get();
                          }
                          $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();
                          $checker = 'true';
                           

                        }else{

                        	 $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->get();
                          $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();
                        }

                        $GodataRoom = "projects";

                    }else{


                    	$getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->get();
                      $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();

                    	$GodataRoom = "register";
                    }

        foreach ($getShareableDocument as $getShareableDocument) {
       	
        	$Document = $getShareableDocument->document_id;
        	$GetProjectId = $getShareableDocument->project_id;
        	$access_token = $getShareableDocument->access_token;
          $sharedTime   = $getShareableDocument->created_at;

              if($checker = 'true')
               {
                  $GetShareWithMeDocumentFolder = Document::where('id',$Document)->where('document_status','1')->first();

                  if($GetShareWithMeDocumentFolder == null)
                  {
                  	  $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'path'=>$GetShareWithMeDocumentFolder['path'], 'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'Email'=>$userEmail,'sharedTime'=>$sharedTime];	
                  }

                  $getShareWithMeDocumentFile = Document::where('id',$Document)->where('document_status','0')->first();

                  if($getShareWithMeDocumentFile == null)
                  {

                  	  $ShareWithMeDocumentFile = [];

                  }else{


                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime];
                  }


               }else{


               	 $GetShareWithMeDocumentFolder = Document::where('project_id',$decryptedProjectId)->where('document_status','1')->where('id',$Document)->get();


               	  if($GetShareWithMeDocumentFolder == null)
                  {
                  	  $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime];	
                  }


               	 $getShareWithMeDocumentFile = Document::where('project_id',$decryptedProjectId)->where('document_status','0')->where('id',$Document)->get();

	             if($getShareWithMeDocumentFile == null)
	                  {
	                  	  $ShareWithMeDocumentFile = [];

	                  }else{

	                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime];
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

        return view('Share.shareWithMe',compact('DocumentFolder','DocumentFile','GodataRoom','project_id_share'));

    }




//end

   
    public function ShowDocumentForAuth($project_id){
      if (Auth::user()){
      $AuthEmail = Auth::user()->email;
      $encryptedUserEmail = Crypt::encryptString($AuthEmail);
      $encryptedProjectId  = Crypt::encryptString($project_id);
      $registerValid = '0';
      $registerRequired      = Crypt::encryptString($registerValid);
      $time ='0';

      return Redirect(url('/').'/shareFile/'.$encryptedProjectId.'/'.$encryptedUserEmail.'/'.$registerRequired.'/'.$time);
    }
    else
    {
     return redirect('/login');
    }
      
    }
    //Recents Share File
     public function ShowDocumentForRecentAuth($project_id){
     if (Auth::user()){
      $AuthEmail = Auth::user()->email;
      $encryptedUserEmail = Crypt::encryptString($AuthEmail);
      $encryptedProjectId  = Crypt::encryptString($project_id);
      $registerValid = '0';
      $registerRequired      = Crypt::encryptString($registerValid);
      $time ='0';

      return Redirect(url('/').'/shareFileRecents/'.$encryptedProjectId.'/'.$encryptedUserEmail.'/'.$registerRequired.'/'.$time);
      }
      else
      {
       return redirect('/login'); 
      }
    }


    public function ViewDocument(Request $request){


        $project_id =  $request->route()->parameter('project_id');
        $encryptedUserEmail =  $request->route()->parameter('email');
        $userEmail = Crypt::decryptString($encryptedUserEmail);
        $access_token =  $request->route()->parameter('access_token');
        $document_id  = $request->route()->parameter('document_id');

        $definer = $request->route()->parameter('definer');


        
        $SHRdoc = ShareDocument::where('project_id',$project_id)->where('project_id',$project_id)->where('Shared_with',$userEmail)->where('access_token',$access_token)->where('document_id',$document_id)->first();

        $downloadable = $SHRdoc['downloadable'];
        $printable = $SHRdoc['printable'];

     
        $getSetting = Setting::where('project_id',$project_id)->first();

        $watermark_text = $getSetting['watermark_text'];
        $watermark_color = $getSetting['watermark_color']; 

        if($definer == '34:34:8844.4')
        {
          $GetdocPath = Document::where('project_id',$project_id)->where('id',$document_id)->first();

        }else{
              
          $GetdocPath = Document::where('project_id',$project_id)->where('id',$definer)->first(); 
        }

  
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

          $ip  =$request->getClientIp(); //$this->get_client_ip();
          $geo = Location::get($ip);//geoip();
          $device = $this->deviceDetect();
          $device['ip_address'] =$ip;
          $device['location'] ='country:'.$geo->countryName.' region:'.$geo->regionName.' city:'.$geo->cityName;
          $device['latitude'] = $geo->latitude;
          $device['longitude'] =$geo->longitude;
          $device['project_id']= $project_id;
          $device['document_id']= $document_id;
          $device['time'] = \Carbon\Carbon::now();
          $device['share_documents_id'] =$SHRdoc['id'];
          $checkvalue = DeviceDetect::where('share_documents_id', '=',$SHRdoc['id'])->first();
          //Check the Share ID Exits or Not
         if($checkvalue){
            $checkvalue->update($device);
          }else{
             DeviceDetect::insert($device);
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
      

      public function GetSharedDoc(Request $request){

        $project_id = $request->project_id;

        $IndexOfFolder = [];
        $IndexOfFile = [];
        $getIndexOfFile =[];
        $getIndexOfFolder=[];
        $authEmail = Auth::user()->email;

        $getSharedBy = ShareDocument::where('Shared_by',$authEmail)
        ->where('project_id',$project_id)->groupBy('access_token')->get()->toArray();
        //echo"<pre>";print_r($getSharedBy);die;
        return $getSharedBy;
        
      }//function


       public function GetSharedDocsUser(Request $request){
         
         $project_id = $request->project_id;
         $dataDoc = $request->dataDoc;
         $authEmail = Auth::user()->email;
         $access_token = $request->access_token;


         $getSharedUsers = ShareDocument::where('Shared_by',$authEmail)->where('project_id',$project_id)->where('document_id',$dataDoc)->where('access_token',$access_token)->get();

         return $getSharedUsers;

       }//function

       public function GetSharedDocsUserPermission(Request $request){
           // echo"<pre>";print_r($request->all()); die;
         $project_id = $request->project_id;
         $dataUser = $request->dataUser;
         $authEmail = Auth::user()->email;
         $access_token = $request->access_token;


        $getSharedUsersPermission = ShareDocument::where('Shared_with',$dataUser)
                                    ->where('project_id',$project_id)
                                    ->where('access_token',$access_token)->first();
         // $Permission = json_encode($getSharedUsersPermission);
         //echo"<pre>";print_r($getSharedUsersPermission);die;                           
        $getFolder= DB::table('documents')->join('share_documents', 'documents.id', '=', 'share_documents.document_id')->where('documents.project_id', $project_id)->where('documents.deleted_by', '0')->where('documents.document_status', '1')->where('share_documents.access_token', $access_token)->where('Shared_with',$dataUser)
          ->select('documents.id as document_id','share_documents.id as shared_id','documents.path', 'documents.document_name', 'share_documents.access_token','share_documents.Shared_time')
        ->get()->toArray(); 

        $getFile = DB::table('documents')->join('share_documents', 'documents.id', '=', 'share_documents.document_id')->where('documents.project_id', $project_id)->where('documents.deleted_by', '0')->where('documents.document_status', '0')->where('share_documents.access_token', $access_token)->where('Shared_with',$dataUser)->select('documents.id as document_id','share_documents.id as shared_id', 'documents.path', 'documents.document_name', 'share_documents.access_token','share_documents.Shared_time')->get()->toArray(); 

        $Shared_data = ['folder_index' => $getFolder , 'file_index' => $getFile,'Permission'=>$getSharedUsersPermission];   
        //echo"<pre>";print_r($Shared_data); die;                       
         return $Shared_data;


       }

       public function GetSharedFoldersDoc(Request $request){

           $project_id = $request->project_id;
           $folderValue   = $request->folderValue;
           $sharedTime = $request->sharedTime;


           $ShareWithMeDocumentFolder = document::where('directory_url',$folderValue)->where('created_at', "<",$sharedTime)->where('project_id',$project_id )->where('document_status',1 )->get();


           $ShareWithMeDocumentFile = document::where('directory_url',$folderValue)->where('created_at', "<",$sharedTime)->where('project_id',$project_id )->where('document_status',0 )->get();


           $Under_data = ['folder_index'=>$ShareWithMeDocumentFolder ,'file_index'=>$ShareWithMeDocumentFile ];

           return $Under_data;

       }

       //update permission
      public function GetSharedDocUpdate(Request $request){
          $shared_with = $request->useremail;
          $access_token = $request->accesstoken;
          $project_id = $request->project_id;
          $registerValid = $request->registerValid;
          $printable = $request->printable;
          $downloadable =$request->downloadable;
          $SharedId = $request->SharedId;
          $duration = $request->durationTime;
          $current = Carbon::now();
          if($duration == 1){
            $durationTime = $current->addDays(3)->format('y-m-d');
          } else if($duration == 2){
            $durationTime = $current->addDays(7)->format('y-m-d');
          }else if($duration == 3){
            $durationTime = $current->addDays(15)->format('y-m-d');
          }else if($duration == 4){
            $durationTime = $current->addDays(30)->format('y-m-d');
          }else{
            $durationTime = $duration;
          }
          ShareDocument::where('Shared_with',$shared_with)
              ->where('access_token',$access_token)
              ->where('project_id',$project_id)
              ->update(['register_required' => $registerValid,'printable'=>$printable ,'downloadable'=>$downloadable,'duration_time'=>$durationTime]);
          return "success";
      }

       public function GetSharedDocLogAccess(Request $request){

          $project_id = $request->project_id;
          $document_id = $request->document_id;
          $access_token =$request->access_token;
          $shared_id = $request->shared_id;
          $file_detail= new \stdClass();
          $sharedata = ShareDocument::where('id', '=', $shared_id)->first();
          $device = DeviceDetect::where('share_documents_id', '=', $shared_id)->first();

            $file_detail->IP= '';
            $file_detail->location= '';
            $file_detail->latitude= '';
            $file_detail->longitude= '';
            $file_detail->user_agent= '';
            $file_detail->time_= '';
            $file_detail->date_ = '';

          if($device){
            $file_detail->IP=$device->ip_address;
            $file_detail->location= $device->location;
            $file_detail->latitude= $device->latitude;
            $file_detail->longitude= $device->longitude;
            $file_detail->user_agent= $device->user_agent;
            if($device->time !==''){
              $time =explode(' ',$device->time);
              $file_detail->time_ = $time[1];
              $file_detail->date_ = $time[0];
          }
          }

          $file_detail->duration_time= $sharedata->duration_time;

        //   $file_detail= DB::table('share_documents')
        //   ->join('device_detect', 'share_documents.id', '=', 'device_detect.share_documents_id')
        //   ->where('share_documents.id','=',$shared_id)
        //   ->select('device_detect.ip_address as IP','device_detect.location','device_detect.latitude','device_detect.longitude','device_detect.time','device_detect.user_agent','share_documents.duration_time','share_documents.register_required','share_documents.printable',
        // 'share_documents.downloadable')
        //   ->first();
          if($sharedata->register_required == '1'){
            $file_detail->register_required ='Yes';
          }else{
            $file_detail->register_required ='No';
          }
          if($sharedata->printable == '1'){
            $file_detail->printable ='Yes';
          }else{
            $file_detail->printable ='No';
          }
          if($sharedata->downloadable == '1'){
            $file_detail->downloadable ='Yes';
          }else{
            $file_detail->downloadable ='No';
          }

          return json_encode($file_detail);
         // echo"<pre>";print_r($file_detail);die;
       }


       // Function to get the client IP address
        // function get_client_ip() {
        //     $ipaddress = '';
        //     if (isset($_SERVER['HTTP_CLIENT_IP']))
        //         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        //     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        //         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        //     else if(isset($_SERVER['HTTP_X_FORWARDED']))
        //         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        //     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        //         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        //     else if(isset($_SERVER['HTTP_FORWARDED']))
        //         $ipaddress = $_SERVER['HTTP_FORWARDED'];
        //     else if(isset($_SERVER['REMOTE_ADDR']))
        //         $ipaddress = $_SERVER['REMOTE_ADDR'];
        //     else
        //         $ipaddress = 'UNKNOWN';
        //     return $ipaddress;
        // }
       function deviceDetect(){
        $device ='';
        if(Browser::isMobile()){
            $device ="mobile";
        }elseif(Browser::isTablet()){
            $device ="tablet";
        }elseif(Browser::isDesktop()){
            $device ="desktop computer";
        }elseif(Browser::isBot()){
            $device ="crawler/bot";
        }else{
           $device ='unknown';
        }

        
        $device_detail = array('user_agent' =>Browser::userAgent(),'browser'=>Browser::browserName(),"operator"=>Browser::platformName() ,'device'=>$device.' '.Browser::deviceFamily().' model:'.Browser::deviceModel());
       return $device_detail;

       }
    //Recents Share File
  public function CheckShareDocsRecents(Request $request){
  
      $authUserEmail ='';
        $checker = '';

        $project_id =  $request->route()->parameter('project_id');
        $decryptedProjectId = Crypt::decryptString($project_id);

        $project_id_share = $decryptedProjectId;

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
                            $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('duration_time', '>=', $current_date)->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())->get();
                            $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();
                            $checker = 'true';
                           

                        }else{

                           $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())->get();
                          $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();
                        }

                        $GodataRoom = "projects";

                    }else{


                      $getShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '>=', $current_date)->where('created_at', '>=', Carbon::now()->subDays(14)->toDateTimeString())->get();
                      $deleteShareableDocument = ShareDocument::where('Shared_with',$decryptedUserEmail)->where('access_token',$time)->where('duration_time', '<', $current_date)->delete();

                      $GodataRoom = "register";
                    }

        foreach ($getShareableDocument as $getShareableDocument) {
        
          $Document = $getShareableDocument->document_id;
          $GetProjectId = $getShareableDocument->project_id;
          $access_token = $getShareableDocument->access_token;
          $sharedTime   = $getShareableDocument->created_at;
              if($checker = 'true')
               {
                  $GetShareWithMeDocumentFolder = Document::where('id',$Document)->where('document_status','1')->first();

                  if($GetShareWithMeDocumentFolder == null)
                  {
                      $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'path'=>$GetShareWithMeDocumentFolder['path'], 'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'Email'=>$userEmail,'sharedTime'=>$sharedTime]; 
                  }

                  $getShareWithMeDocumentFile = Document::where('id',$Document)->where('document_status','0')->first();

                  if($getShareWithMeDocumentFile == null)
                  {

                      $ShareWithMeDocumentFile = [];

                  }else{


                     $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime];
                  }


               }else{


                 $GetShareWithMeDocumentFolder = Document::where('project_id',$decryptedProjectId)->where('document_status','1')->where('id',$Document)->get();


                  if($GetShareWithMeDocumentFolder == null)
                  {
                      $ShareWithMeDocumentFolder = [];

                  }else{

                      $ShareWithMeDocumentFolder = ['document_name'=>$GetShareWithMeDocumentFolder['document_name'],'document_id'=>$GetShareWithMeDocumentFolder['id'],'project_id'=>$GetShareWithMeDocumentFolder['project_id'],'access_token'=>$access_token,'document_id'=>$GetShareWithMeDocumentFolder['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime]; 
                  }


                 $getShareWithMeDocumentFile = Document::where('project_id',$decryptedProjectId)->where('document_status','0')->where('id',$Document)->get();

               if($getShareWithMeDocumentFile == null)
                    {
                        $ShareWithMeDocumentFile = [];

                    }else{

                       $ShareWithMeDocumentFile = ['document_name'=>$getShareWithMeDocumentFile['document_name'],'document_id'=>$getShareWithMeDocumentFile['id'],'project_id'=>$getShareWithMeDocumentFile['project_id'],'access_token'=>$access_token,'document_id'=>$getShareWithMeDocumentFile['id'],'Email'=>$userEmail,'sharedTime'=>$sharedTime];
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

        return view('Share.shareFileRecents',compact('DocumentFolder','DocumentFile','GodataRoom','project_id_share'));
  }
     

}
//end class
