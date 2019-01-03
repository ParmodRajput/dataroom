@extends('layouts.app_ques_answer')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

<!-- 	 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
     <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />

     <input type="hidden" name="projects" class="project_name_in"  value="{{$project_name}}"/>

     <input type="hidden" name="slug_folder" class="slug_folder" />

     <input type="hidden" name="current_dir" class="current_dir" id="current_directory" value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/> -->
     

	<div class="row">
		<div class="col-md-12">
	<!-- 		<input type="hidden" class='current_dir_qa'>
			<input type="hidden" class='project_id_qu' value="{{$project_id}}">
			<input type='hidden' class='project_name_qu' value='{{$project_name}}'>

			<input type="hidden" class='auth_name' value='{{ Auth::user()->name }}'> -->

			<div class="col-md-3">
			 
		    </div>
			<div class="document_index_contentable col-md-4">
			 <div class="folder_and_file_tree_qa">
				    <div class="select_group_and_user_qa">
	                    <b>Files and folders</b>
	                </div>
                   <ul class="folders"> 
                        <li>  
                          <div class="folder_tree_qa">    
                            <ul id="tree4">
                              <li id="document_permission" class="document_permission" data-value="public/documents//{{$project_name}}"><span class="document_name">{{$project_name}}</span>
                                <div class="folder_file_structure">
                                   
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                    </ul>                     
                </div>
	      </div>
	<div class="col-md-5">
	
</div>

@endsection


