<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Document;
use App\Note;
use App\DeviceDetect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;


class NotesController extends Controller
{
	public function createNotes (Request $request){
       
         $projects_id = $request->projects_id;
        
         $documentPath = $request->documentPath;
         $content = $request->NotesContent;
         $priority = $request->notesPriority;
         $user_id = Auth::user()->id;
         $getDocumentID = Document::where('path',$documentPath)->where('project_id',$projects_id)->first();
         
         $DocumentID =  $getDocumentID->id;
         $timestamp = time();

         $create = new Note();
         $create->document_id = $DocumentID;
         $create->content = $content;                                               
         $create->user_id = $user_id;
         $create->project_id = $projects_id ;
         $create->priority = $priority;
         $create->time = $timestamp;
         $create->updated_time ='';  
         $create->created_by = $user_id;  
         $create->updated_by = $user_id;   
   
         $create->save();
              
         return 'create';     

	}

	public function GetDocumentNotes (Request $request){
         $return_value =array();
         $note = '';
		   $projects_id  = $request->projects_id;
         $documentPath = $request->documentPath;
         $user_id = Auth::user()->id;
         $getDocumentID = Document::where('path',$documentPath)->where('project_id',$projects_id)->first();
         $DocumentID =  $getDocumentID->id;
        
         $getNoteContent = Note::where('document_id',$DocumentID)->where('project_id',$projects_id)->where('user_id',$user_id)->first();
         $share_view = DeviceDetect::where('document_id','=',$DocumentID)->where('project_id','=',$projects_id)->first()->orderBy('time', 'DESC')->take(5)->get();
         //print_r($share_view); die('here');
         if(!empty($getNoteContent))
         {
         	$noteContent = $getNoteContent->content;
         	$noteCreateAt = $getNoteContent->time;
         	$note = [$noteContent ,$noteCreateAt];

         }
         $return_value = array('note'=>$note,'share_view'=> $share_view);
       return $return_value;
         //$return_value = ['content'=> $noteContent , 'time' => $noteCreateAt];

	}

	public function DeleteDocumentNotes (Request $request){

		 $projects_id  = $request->projects_id;
         $timeNote = $request->timeNote;
           
         Note::where('project_id',$projects_id)->where('time',$timeNote)->delete(); 
         return "deleteNote" ;
	}

	public function EditDocumentNotes(Request $request){
         
         $projects_id  = $request->projects_id;
         $content = $request->NotesContent;
         $time    = $request->time;
         $user_id = Auth::user()->id;
         $updated_time = time();
          
         Note::where('project_id',$projects_id)->where('time',$time)->where('user_id', $user_id)->update(['content' => $content,'updated_by' => $user_id,'updated_time' => $updated_time]); 

         return "update";           
	}

	       
}
