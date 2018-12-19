<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Permission;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function set_permission(Request $request){

        $getDocument_id  = $request->Document;

        $path =  storage_path()."/app/".$getDocument_id;

        $getPermissionId = $request->permission_array;

        $project_id  = $request->project_id;


        // if(is_dir($path))
        // {
        // 	$findDocId = document::where('path',$getDocument_id)->pluck('id');
        // 	$findInPermissionTable = permission::where('document_id',$findDocId)->where('group_id',$findDocId)->pluck('id');

        // 	print_r($findInPermissionTable);die();

        // }else{

        	
        // } 
        //   die();
        
    	$getDocument_id1 = document::where('path','LIKE',"%{$getDocument_id}%")->pluck('id');

        //delete all permission of the document.

				foreach ($getDocument_id1 as $getDocument_id12) {

				        $document_id = $getDocument_id12;

					    permission::where('document_id',$document_id)->where('project_id',$project_id)->delete(); 

					    } 

         //store all permission of the document.
            
    		foreach ($getDocument_id1 as $getDocument_id1) {

                $document_id = $getDocument_id1;


    		    $getPermissionId = $request->permission_array;

    		    if($getPermissionId == '')
    		    {
                    permission::where('document_id',$document_id)->delete();
    		    }else{

    		    	 	foreach ($getPermissionId as $getPermissionId) {
			        	
			        	  $getPermissionId1 = explode('/',$getPermissionId);
			        
			              $group_id      = $getPermissionId1['0'];

			              $permission_id =  $getPermissionId1['1'];

			              $findInPermissionTable = permission::where('document_id',$document_id)->where('group_id',$group_id)->pluck('id');

			              $count = count($findInPermissionTable);


			              if( $count == '0')
			              {
			              	   	// store permission entry

					              $Permission = new Permission();
					              $Permission->document_id = $document_id;
					              $Permission->project_id = $project_id ;
					              $Permission->group_id = $group_id ;
					              $Permission->permission_id = $permission_id;
					              $Permission->created_by = Auth::user()->id;
					              $Permission->updated_by = Auth::user()->id;
					              $Permission->save();

			              	    
			              }else{
                                  
					            permission::where('id',$findInPermissionTable)->update(['permission_id' => $permission_id,'updated_by'=>Auth::user()->id]);

			              }		               

			        }
    		    }
    		
    	 }

         return 'success';
    }


    // public function getPermission(Request $request){

    // 	$directory_url  = $request->directory_url;
    //     $getDocument_id = document::where('path',$directory_url)->pluck('id');

    //     print_r($getDocument_id);die();

    // }

}
