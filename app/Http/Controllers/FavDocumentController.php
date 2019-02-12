<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Document;
use App\FavDocument;

use Illuminate\Support\Facades\Auth;

class FavDocumentController extends Controller
{
  public function makeFavDocument(Request $request){

  	    
         $projects_id = $request->projects_id;
         $document_val = $request->document_val;
         $directory_url = $request->directory_url;

         $user_id = Auth::user()->id;

         $getDocumentID = Document::where('path',$document_val)->where('project_id',$projects_id)->first();
         

         $DocumentID =  $getDocumentID->id;
         $document_path = $getDocumentID->path;

         $timestamp = time();

         if(!empty($DocumentID))
         {

         	$get = FavDocument::where('document_id',$DocumentID)->where('project_id',$projects_id)->where('user_id',$user_id)->first(); 

         	 if(empty($get))
         	 {

         	  $fav = new FavDocument();
	           $fav->document_id = $DocumentID;
               $fav->document_path = $document_path;
	           $fav->user_id = $user_id ;
	           $fav->project_id = $projects_id;
               $fav->directory_url = $directory_url;
	           $fav->time       = $timestamp;
	           $fav->save(); 

	            return "makeFav";
                
         	 }else{

         	 	FavDocument::where('document_id',$DocumentID)->where('project_id',$projects_id)->where('user_id',$user_id)->delete(); 

         	 	return "makeUnFav";
         	 }
         	
        }
    
  }   


}
