<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\User;
use App\Group;
use App\Delete_Doc;
use App\Note;
use App\Question;
use App\QuesReply;
use App\Permission;
use App\Document;
use App\Group_Member;
use App\FavDocument;
use Mail;
use Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response;

use Illuminate\Http\Request;

class QuestionsController extends Controller
{
     public function create_Question(Request $request){

      $validator = Validator::make($request->all(), [
                  'users' => 'required',
                  'subject' => 'required',
                  'ques_content' => 'required'
      ]);

      if ($validator->fails()) {
          $errors = $validator->getMessageBag()->toArray();
          return response()->json(['validation_failed'=>true,'errors'=>$errors]);   
      } else{

    	$doc_path = $request->doc_path;
    	$get_document_id = Document::where('path',$doc_path)->first();
    	$doc_name= $get_document_id->document_name;
      $Auth_id = Auth::user()->id;
    	$document_id = $get_document_id->id; 
    	$project = $request->project_name; 
    	$project_id = $request->project_id;
    	$subject = $request->subject;
    	$ques_content = $request->ques_content;
    	$users_email = $request->users;
    	$time = time();

      $users_email1 = implode(',', $users_email);

                   // store question
            $Question = new Question();

            $Question->document_id = $document_id;
            $Question->project_id = $project_id;
            $Question->subject = $subject;
            $Question->ques_content = $ques_content;
            $Question->send_by = $Auth_id;
            $Question->send_to = $users_email1;
            $Question->priority = '0';
            $Question->time = $time;
            $Question->created_by = $Auth_id;
            $Question->updated_by = $Auth_id;
            $Question->save();

            // for redirect to the questions 
 
            $QuestionRedirecturl = url('/')."/project/".$project_id."/question";

        foreach ($users_email as $users_email) {

   
		        // send mail 

		        $data = array(

	            'name' => "Invite To Prodata room By prodata.com",
	            'email' => $users_email,
	            'sender_email' => Auth::user()->email,
	            'project'=> $project,
	            'subject'=>$subject,
	            'document_name'=>$doc_name,
              'QuestionRedirecturl' => $QuestionRedirecturl,
              

	            );

	            Mail::send('mail.question_answer_email',$data, function ($message) use($users_email) {
	                $message->from('admin@prodata.com', 'Prodata room');
	                $message->to($users_email)->subject('New post to discussion
	                ')->setBody("url('/')");

	            });


        }
 
        return "send_question";

      }
    
    }


    public function getQuestions($project_id){


        $project_id = $project_id;
        $project = Project::where('id', $project_id)->first();

        $projectCreaterId = $project->user_id;
        $project_name = $project->project_slug;

    	 $projectFolderPath = 'public/documents/'.$projectCreaterId."/".$project_name;

    	 $folder_file_tree =  $this->get_FoldersAndFiles($projectFolderPath);

        return view('Questions.index',compact('project_name','folder_file_tree','project_id','projectCreaterId'));

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

    public function getAllQuestions(Request $request){

      $Question_array = [];	
      $Question_sec_array = [];

      $auth_email = Auth::user()->email;
      $auth_id = Auth::user()->id;
      
      $project_id = $request->project_id;

      $getUserRollForProject = checkCurrentGroupUser($project_id);

      $directory_url = $request->directory_url;

      $getDocument_id = Document::where('path','LIKE',"%{$directory_url}%")->get();

      // get path related documents questions

      foreach ($getDocument_id as $getDocument_id) {

        $document_id = $getDocument_id->id;


        $Questdata = Question::where('document_id',$document_id)->where('project_id',$project_id)->pluck('send_to')->toArray();

        foreach ($Questdata as $Questdata) {
         
          $certi_id = explode(",",$Questdata);

          if(in_array($auth_email,$certi_id)){

               $getQuestion = Question::where('document_id',$document_id)->where('project_id',$project_id)->where('send_to',$Questdata)->get();
          

          }else{

             $getQuestion =[];


          }

          foreach ($getQuestion  as $getQuestion){

             $document_id = $getQuestion->document_id; 

             $getDocument_name = Document::where('id',$document_id)->first();

           //document name
           $documet_name = $getDocument_name->document_name;

             //subject
           $subject = $getQuestion->subject;

             //question id
           $question_id =$getQuestion->id;

           //question content
           $ques_content = $getQuestion->ques_content;
           $time = $getQuestion->time;
           // date
           $date = date('M/d/Y H:i:s', $time );
           $sender_id = $getQuestion->send_by;
           $getSenderName = User::where('id',$sender_id)->first();
             // sender name
           $sender_name = $getSenderName->name;
           // sender email
             $sender_email = $getSenderName->email;

             $getSenderGroup = Group_Member::where('member_email',$sender_email)->where('project_id',$project_id)->first(); 

             $sendergroup_id = $getSenderGroup['group_id'];

             $GetGroupName = group::where('id',$sendergroup_id)->where('project_id',$project_id)->first();

             // group_name 
             $groupName = $GetGroupName['group_name'];

             $Question_array1 = ['sender_email'=>$sender_email,'question_id'=>$question_id,'document_name'=>$documet_name,'group_name'=>$groupName , 'sender_name'=>$sender_name,'date'=>$date,'subject'=>$subject , 'content'=>$ques_content];

             array_push($Question_array,$Question_array1);

         }

        }


        $getQuestion1 = Question::where('document_id',$document_id)->where('project_id',$project_id)->where('send_by',$auth_id)->get(); 


        foreach ($getQuestion1  as $getQuestion1){

           $document_id = $getQuestion1->document_id; 

           $getDocument_name = Document::where('id',$document_id)->first();

	       //document name
	       $documet_name = $getDocument_name->document_name;

         //question id
         $question_id =$getQuestion1->id;

           //subject
	       $subject = $getQuestion1->subject;

	       //question content
	       $ques_content = $getQuestion1->ques_content;
	       $time = $getQuestion1->time;
	       // date
	       $date = date('M/d/Y H:i:s', $time );

	       $sender_id = $getQuestion1->send_by;

	       $getSenderName = User::where('id',$sender_id)->first();
           // sender name
	       $sender_name = $getSenderName->name;
	       // sender email
           $sender_email = $getSenderName->email;

           $getSenderGroup = Group_Member::where('member_email',$sender_email)->where('project_id',$project_id)->first();

           $sendergroup_id = $getSenderGroup->group_id;

           $GetGroupName = group::where('id',$sendergroup_id)->where('project_id',$project_id)->first();

           // group_name 
           $groupName = $GetGroupName['group_name'];


           $Question_array2 = ['question_id'=>$question_id,'document_name'=>$documet_name,'group_name'=>$groupName , 'sender_name'=>$sender_name,'date'=>$date,'subject'=>$subject , 'content'=>$ques_content];

           array_push($Question_sec_array,$Question_array2);

       }


      $Question_array_main = ['question_to'=>$Question_array,'question_by'=>$Question_sec_array];
       	
      }

      return $Question_array_main;

    }



    //find searched question

    
 public function GetSearchedQues(Request $request){

      $project_id = $request->project_id;
      $fieldContent = $request->field_content;
      $auth_id = Auth::user()->id;
      $auth_email = Auth::user()->email;

      $Question_array_main = [];

      $Question_array = []; 
      $Question_sec_array = [];

      $getDocument_id = Question::where('subject','LIKE',"{$fieldContent}%")->get();

      // get path related documents questions

      foreach ($getDocument_id as $getDocument_id) {

        $document_id = $getDocument_id->id;
        
        $Questdata = Question::where('id',$document_id)->where('project_id',$project_id)->pluck('send_to')->toArray();

        foreach ($Questdata as $Questdata) {
         
          $certi_id = explode(",",$Questdata);

          if(in_array($auth_email,$certi_id)){

               $getQuestion = Question::where('id',$document_id)->where('project_id',$project_id)->where('send_to',$Questdata)->get();
          

          }else{

             $getQuestion =[];


          }

          foreach ($getQuestion  as $getQuestion){

             $document_id = $getQuestion->document_id; 

             $getDocument_name = Document::where('id',$document_id)->first();

           //document name
           $documet_name = $getDocument_name->document_name;

             //subject
           $subject = $getQuestion->subject;

             //question id
           $question_id =$getQuestion->id;

           //question content
           $ques_content = $getQuestion->ques_content;
           $time = $getQuestion->time;
           // date
           $date = date('M/d/Y H:i:s', $time );
           $sender_id = $getQuestion->send_by;
           $getSenderName = User::where('id',$sender_id)->first();
             // sender name
           $sender_name = $getSenderName->name;
           // sender email
             $sender_email = $getSenderName->email;

             $getSenderGroup = Group_Member::where('member_email',$sender_email)->first(); 
             $sendergroup_id = $getSenderGroup->group_id;

             $GetGroupName = group::where('id',$sendergroup_id)->first();

             // group_name 
             $groupName = $GetGroupName->group_name;

             $Question_array1 = ['question_id'=>$question_id,'document_name'=>$documet_name,'group_name'=>$groupName , 'sender_name'=>$sender_name,'date'=>$date,'subject'=>$subject , 'content'=>$ques_content];

             array_push($Question_array,$Question_array1);

         }


        }


        $getQuestion1 = Question::where('id',$document_id)->where('project_id',$project_id)->where('send_by',$auth_id)->get(); 


        foreach ($getQuestion1  as $getQuestion1){

           $document_id = $getQuestion1->document_id; 

           $getDocument_name = Document::where('id',$document_id)->first();

         //document name
         $documet_name = $getDocument_name->document_name;

         //question id
         $question_id =$getQuestion1->id;

           //subject
         $subject = $getQuestion1->subject;

         //question content
         $ques_content = $getQuestion1->ques_content;
         $time = $getQuestion1->time;
         // date
         $date = date('M/d/Y H:i:s', $time );

         $sender_id = $getQuestion1->send_by;

         $getSenderName = User::where('id',$sender_id)->first();
           // sender name
         $sender_name = $getSenderName->name;
         // sender email
           $sender_email = $getSenderName->email;

           $getSenderGroup = Group_Member::where('member_email',$sender_email)->first(); 
           $sendergroup_id = $getSenderGroup->group_id;

           $GetGroupName = group::where('id',$sendergroup_id)->first();

           // group_name 
           $groupName = $GetGroupName->group_name;


           $Question_array2 = ['question_id'=>$question_id,'document_name'=>$documet_name,'group_name'=>$groupName , 'sender_name'=>$sender_name,'date'=>$date,'subject'=>$subject , 'content'=>$ques_content];

           array_push($Question_sec_array,$Question_array2);

       }

        //print_r($Question_sec_array);
      $Question_array_main = ['question_to'=>$Question_array,'question_by'=>$Question_sec_array];
        
      }

      return $Question_array_main;

 }

    //question reply store


    public function sendReply(Request $request){


        $authEmail = Auth::user()->email;
        $project_id  = $request->project_id;
        $users_email = $request->send_to;
        $reply_subject = $request->reply_subject; 
        $reply_content  = $request->reply_content;
        $question_id = $request->question_id;
        $get_time = time();
        $time = date('M/d/Y H:i:s', $get_time);
        $project_name = $request->project_name;
        $doc_name = $request->document_name;

        $QuestionRedirecturl = url('/')."/project/".$project_id."/question";


        $users_email1 = implode(',', $users_email);

        $reply = new QuesReply();

            $reply->question_id = $question_id;
            $reply->reply_subject = $reply_subject;
            $reply->reply_content = $reply_content;
            $reply->reply_status = '0';
            $reply->project_id = $project_id;
            $reply->reply_by = $authEmail; 
            $reply->reply_to = $users_email1; 
            $reply->time = $time;
            $reply->save();
            

        foreach ($users_email as $users_email) {
        
          
            $data = array(

              'name' => "Invite To Prodata room By prodata.com",
              'email' =>  $users_email,
              'sender_email' => Auth::user()->email,
              'project'=> $project_name,
              'subject'=>$reply_subject,
              'document_name'=>$doc_name,
              'QuestionRedirecturl' => $QuestionRedirecturl,

              );

              Mail::send('mail.question_answer_email',$data, function ($message) use($users_email) {
                  $message->from('admin@prodata.com', 'Prodata room');
                  $message->to($users_email)->subject('New post to discussion
                  ')->setBody("url('/')");

            });

          }//end foreach


          return "reply_sent";

     }//end function


     // get alll reply

     public function GetAllReply(Request $request){

      $project_id = $request->project_id;
      $question_id = $request->question_id;

      $getReply = QuesReply::where('question_id',$question_id)->where('project_id',$project_id)->get();

     return $getReply; 

     }

     public function deleteReply(Request $request){

       $project_id = $request->project_id;
       $reply_id = $request->reply_id;

      QuesReply::where('id',$reply_id)->where('project_id',$project_id)->delete();

      return "delete";

     }

     public function deleteQuestions(Request $request){


       $project_id = $request->project_id;
       $question_id = $request->question_id;

       foreach ($question_id as $question_id) {

        Question::where('id', $question_id)->where('project_id',$project_id)->delete();
         
       }
 
      return "Delete_ques";

     }

}
