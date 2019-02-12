@extends('layouts.app_blank')
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
			<input type="hidden" class='project_id_report' value="{{$project_id}}">
			<input type='hidden' class='project_name_report' value='{{$project_name}}'>
      <input type="hidden" id ="project_path">

			<input type="hidden" class='auth_name' value='{{ Auth::user()->name }}'>

			<div class="col-md-2">
					<div class="left_section">
						<h3 class='title_report'>Reports</h3>
						<ul>
							<li id='Report1'><i class="material-icons">search</i><a href="#overview">Groups overview</a></li>
							<li id='Report3'><i class="fa fa-folder-open" style='font-size: 20px;'></i><a href="#files-folders">Files and folders</a></li>
							<li id='Report4'><i class="material-icons">group</i><a href="#groups-users">Groups and users</a></li>
							<li id='Report5'><i class="material-icons">chat</i><a href="#ques-activity">Q&A activity</a></li>
							<li id='Report6'><i class="material-icons">history</i><a href="#action">History of all actions</a></li>
			
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
                			       <input type='checkbox' name='report_check' id='all_group_check'><h5>All Group</h5>
                			   </div> 
                			</li>
                      <div class="group_report_status">
                			@foreach($getGroups as $getGroups)
                			 <li>
                			 	<div class="listofgroup">
                			       <input type='checkbox' name='report_check_group' data-value='{{$getGroups->id}}'><h5>{{$getGroups->group_name}}</h5>
                			   </div> 
                			 </li>
                         @endforeach
                       </div>
                        </ul>
                	</div>
                </div>
                <div class="groupAndUsers hidden">
                </div>
                <div class='all_action hidden'>
                  <div class='actions_check_record'>
                    <h4>All Action</h4>
                     <ul class='action_list'>
                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='0' id='all_action_check' name='report_check_action'><h5>All Action</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='1' name='report_check_action'><h5>Folder creation</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='2' name='report_check_action'><h5>File uploading</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='3' name='report_check_action'><h5>Folder rename</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='4' name='report_check_action'><h5>File rename</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='5' name='report_check_action'><h5>Folder deletion</h5>
                         </div> 
                      </li>


                       <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='6' name='report_check_action'><h5>File deletion</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='7' name='report_check_action'><h5>File viewing</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='8' name='report_check_action'><h5>PDF downloading</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='9' name='report_check_action'><h5>Folder restoring</h5>
                         </div> 
                      </li>


                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='10' name='report_check_action'><h5>File restoring</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='11' name='report_check_action'><h5>File moving</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='12' name='report_check_action'><h5>Copy Folder</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='13' name='report_check_action'><h5>Copy File</h5>
                         </div> 
                      </li>


                       <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='14' name='report_check_action'><h5>Room creation</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='16' name='report_check_action'><h5>File permission applying</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='17' name='report_check_action'><h5>Folder permission applying</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='18' name='report_check_action'><h5>Question deletion</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='19' name='report_check_action'><h5>Group deletion</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='20' name='report_check_action'><h5>User invitation</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='21' name='report_check_action'><h5>User deletion</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='22' name='report_check_action'><h5>User group editing</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='23' name='report_check_action'><h5>Creating Q&A question</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='24' name='report_check_action'><h5>Report viewing</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='25' name='report_check_action'><h5>Folder downloading</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='26' name='report_check_action'><h5>File downloading</h5>
                         </div> 
                      </li>

                      <li>
                        <div class="list_of_type">
                             <input type='checkbox' data-value='27' name='report_check_action'><h5>zip Extracting</h5>
                         </div> 
                      </li>

                    </ul>

                  </div>

                </div>
	      </div>
	<div class="report_display_main col-md-6">
    <div class='report_display row'>
      <div class='container_indexingOfReports row'>
      </div>
    </div>

    <div class="group_overview">

    </div>

  </div>

@endsection


