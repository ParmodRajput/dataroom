@extends('layouts.app_report')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

<!-- 	 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
     <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />

     <input type="hidden" name="projects" class="project_name_in"  value="{{$project_name}}"/>

     <input type="hidden" name="slug_folder" class="slug_folder" />

     <input type="hidden" name="current_dir" class="current_dir" id="current_directory" value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/> -->
     

	<div class="row">
		<div class="reports_record col-md-12">
		    <input type="hidden" class='current_dir_qa'>
			<input type="hidden" class='project_id_qu' value="{{$project_id}}">
			<input type='hidden' class='project_name_qu' value='{{$project_name}}'>

			<input type="hidden" class='auth_name' value='{{ Auth::user()->name }}'>

			<div class="col-md-2">
					<div class="left_section">
						<h3 class='title_report'>Reports</h3>
						<ul>
							<li id='Report1'><i class="material-icons">search</i><a href="#overview">Groups overview</a></li>
							<li id='Report2'><i class="material-icons">lock</i><a href="#access">Folder access</a></li>
							<li id='Report3'><i class="fa fa-folder-open"></i><a href="#3">Files and folders</a></li>
							<li id='Report4'><i class="material-icons">group</i><a href="#4">Groups and users</a></li>
							<li id='Report5'><i class="material-icons">chat</i><a href="#5">Q&A activity</a></li>
							<li id='Report6'><i class="material-icons">history</i><a href="#">History of actions</a></li>
							<li id='Report7'><a href="#">Over files and folders</a></li>
							<li id='Report8'><a href="#">Over users and groups</a></li>
							<li id='Report9'><a href="#">Over permissions</a></li>
							<li id='Report10'><a href="#">All actions</a></li>

						</ul>
					</div>	
		    </div>
			<div class="document_index_contentable col-md-4">
			 <div class="folder_and_file_tree_qa hidden">
				    <div class="select_group_and_user_qa">
	                    <b>Files and folders</b>
	                </div>
                   <ul class="folders"> 
                        <li>  
                          <div class="folder_tree_qa">    
                            <ul id="tree4">
                              <li id="document_permission" class="document_permission" data-value="public/documents/{{$projectCreaterId}}/{{$project_name}}"><span class="document_name">{{$project_name}}</span>
                                <div class="folder_file_structure">
                                    <?php 
                                      echo folder_file_tree($folder_file_tree);    
                                    ?>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                    </ul>                     
                </div>
                <div class="group_list_reports hidden">
                	<div class='groups_check_record'>
                		<h4>Groups</h4>
                		<ul class='group_list'>
                			<li>
                				<div class="listofgroup">
                			       <input type='checkbox' name='report_check_group'><h5>All Group</h5>
                			   </div> 
                			</li>
                			@foreach($getGroups as $getGroups)
                			 <li>
                			 	<div class="listofgroup">
                			       <input type='checkbox' name='report_check_group'><h5>{{$getGroups->group_name}}</h5>
                			   </div> 
                			 </li>
                            @endforeach
                        </ul>
                	</div>
                </div>
	      </div>
	<div class="col-md-6">
          
    </div>

@endsection


