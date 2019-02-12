@extends('layouts.app_groups')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <div class="row document_content_index">
    <div class="user_gruoups_list col-md-6">
     <div class="display_groups">
        <div class="row group_block">
		    <div class="search_filter_document">
		        <div class="search_document_Byname">
		          <input type="text" name="group_search_filter" class="group_search_filter" id="search_doc_group">
		          <span id="go_search_group" onclick="getgroups()"><i class="fas fa-search"></i></span>
		        </div>
		    </div> 
            @if(checkUserType($project_name) == 'Administrator')
        	<div class="btn_upload InviteUsersByUp ">
           		 <button class='btn btn-primary InviteUsers' type='button' data-id=''><img src='{{url('/')}}/dist/img/invite1.png'></img> InviteUsers</button>
           </div>

            <div class="btn_upload">
                <button class="btn btn-success btn-block create_new_group" data-toggle="modal" data-target="#create_group"><img src='{{url('/')}}/dist/img/newGroup.png'></img>New Group
					<i class=""></i>
				</button>
            </div>

            @endif
            <div class="btn_upload">
                      <div class="btn-group">
                          <a class="btn  dropdown-toggle document-btn" data-toggle="dropdown" href="#">
                          <i class="fa fa-download" aria-hidden="true"></i> Export
                          </a>  
                              <ul class="dropdown-menu drop_new">
                                  <li>
                                    <a href="javascript:void(0)">
                                       <span class="pdf"><i class="far fa-file-pdf"></i> PDF</span>
                                    </a>
                                </li>
                                <li class="original_doc">
                                    <form action="{{url('/project/documents/download')}}" method='post'>
                                      <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
                                      <input type="hidden" value="public/documents/{{Auth::user()->id}}/{{$project_name}}" name="download">
                                      <input type="submit" value=
                                      "Original" name="submit">
                                    </form>
                                    <span class="download_project"><i class='fa fa-download' aria-hidden='true'></i> Original</span>
                                  </li>
                              </ul>
                      </div>
                </div>

                  @if(checkUserType($project_name) == 'Administrator')
                  <div class="btn_upload" data-toggle="modal" data-target="#document_permission_modal">
                     <a class="btn  document-btn1"><i class="fas fa-lock"></i> Permissions</a>
                  </div>

                  <div class="btn_group delete_group hidden">
                     <a class="btn delete-group-btn delete_items_groups " ><i class='fas fa-trash-alt'></i> Delete</a>           
                  </div>
                  @endif
              </div>

              <input type="hidden"  name ="project_id" class="form-control" id="project_id" value = "{{$project_id}}">

               <div class="table table-hover table-bordered table_color group_and_user_list">
                        <div class="check-box select_check_group"><form  action="#" method="post">
                        	
                        	<input type="checkbox" id='check_main_select' class="check-box-input-main">
                        	<span  class="main-user_list"><i class='fa fa-caret-down '></i></span>
                        </form> 
                              <span>Group / Name</span>
                        </div>
                              
                        <div class="group-role">
                               <span>Role</span> 
                        </div>
                        <div class="Invite-user-ac">
                           <span>Invite/Move user</span> 
                        </div>

                </div>

              	<div class="group_list">
			
		        </div>

         </div>
    </div>

  @if(checkUserType($project_name) == 'Administrator')
    <div class="indexing-group-user col-md-6">

    	<input type='hidden' id='checkGroupIdEditRole'>

		<div class="groupMemberDetail hidden" id="groupMemberDetail">
    		<div class="userTitle"></div>
    		<div class="userDetail">
			</div>	

    		<div class="role_userss">
    		 <button class="accordion">Role and Group<i class="fa fa-caret-down "></i>
              </button>
				<div class="panel">					
					<div class="group_member_role">	

					</div>
					<div class="edit_role_ofgroup_member hidden">
						<div class="member__settings-panel group_member-role-settings">
							<div class="form-horizontal ng-scope" style="">
								<div class="form-group member">
									<div class="center_inner ChangeGroupByinvite">
										<h2>Choose role and enter group name</h2>
										<div class="radio_btn_pannel">
										<label>
										<input type="radio" value="user" name="UserType" checked>
										User
										</label>

										<label>
										<input type="radio" value="Administrator" name="UserType">
										Administrator
										</label>

										</div>

										<div class="basic_setting_input">

												<div class="input_pannel_m_p UserRole_block">
												<label><strong>Role</strong></label>
												<label class="input_radio_new">
												<input type="radio" name="UserRole" value="1" checked>
												<i class="fa fa-user-plus"></i> Collaboration users
												</label>

												<label class="input_radio_new">
												<input type="radio" name="UserRole" value="2">
												<i class="fa fa-user-circle-o"></i> Individual users
												</label>
												</div>
												   
												<div class="input_pannel ">
												<label><strong>Group</strong></label>
							                       <select class="select_dynamic Select_groupOfUser" name="choose_group" id="ChooseGroupForChange">
											       </select>
												</div>

										</div>

									</div>
									<span class="btn btn-danger cancel_member_new_role">cancel</span>      
  									<span class="btn btn-primary apply_member_new_role">Apply</span> 
								</div>
							</div>
						</div>
					</div>
					<div>
						<span class="edit_group_member_role"><i class="fa fa-pencil"></i> edit</span>
					</div>			 
				</div>
			</div>	
			<div class="collaboration_setting_members">
    		 <button class="accordion">Security settings<i class="fa fa-caret-down "></i></button>
				<div class="panel">
				  <div class="members_collaboration_setting">

				  </div>
				  	<div class="update_member_security hidden">
                   		 <div class="radio_pannel">
							<div class="radio_text">
								<strong>Access to data room</strong>
							</div>
							<div class="radio_btns">
								<label> 
									<input type="radio" value="1" name="updateMamberSecuritySetting" checked="">Unlimited</label><br>

								<label> 
									<input type="radio" value="2" id="Mamber_access_limit_change" name="updateMamberSecuritySetting">
									Till date
								</label><br>
								<input type="date" name="validOnDate" class="validDateMembers hidden"> 
							</div>						
		    			</div>
		    			<div>
	    		            <span class="btn btn-danger member_cancel_edit_security"> cancel</span>
	    		            <span class=" btn btn-primary apply_member_change_security">Apply</span> 		    				
		    			</div>
				  	</div>
				 	<span class="edit_member_security"><i class="fa fa-pencil"></i> edit </span> 
				</div>
			</div>	
			<div class="ques_ans_groups">
    		 <button class="accordion">Q&A Setting <i class="fa fa-caret-down "></i></button>
				<div class="panel">
				  <div class="member_Ques_ans_setting">
				  </div>
					<div class="member_radio_pannel_setting hidden">
						<div class="radio_btns">
							<input type="hidden"  name ="userEmail" class="form-control" id="userEmail"  placeholder="Enter Group user email">	
							<label> 
								<input type="radio" value="0" name="access_member_Ques_ans1"><strong>None</strong>
							</label><br>

							<label>
							 	<input type="radio" value="1" name="access_member_Ques_ans1"><strong>View</strong>
							</label> <br>
							<span class="radio_down_content">View questions asked by users of own group</span>
							<label> 
								<input type="radio" value="2" name="access_member_Ques_ans1"><strong>Post to own group</strong>
						    </label><br>
						    <span class="radio_down_content">Communicate with users of own group</span>
							<label> 
								<input type="radio" value="3" name="access_member_Ques_ans1"><strong>Q&A coordinator</strong>
						    </label><br>
						    <span class="radio_down_content">Full access to Q&A section: view and reply to all questions, close and delete questions</span>						    
						</div>
						<div>
	    		            <span class="btn btn-danger member_cancel_ques_ans"> cancel </span>
    		            	<span class="btn btn-primary member_apply_ques_ans"> Apply</span>						
						</div>
    		        </div>
 				     <div class="edit_ques_ans_setting">
					  <span class="member_edit_ques_ans"><i class="fa fa-pencil"></i> edit</span>
    		        </div>   		        
				  </div>				  
			</div>
		</div>

    	<div class="listUsersGroups hidden">
    		<div class="GroupTitle"></div>
    		<div class="users_groups">
    		 <button class="accordion">Users <i class="fa fa-caret-down "></i></button>
				<div class="panel">
					<div class="group_user_listing">
						
					</div>
				</div>
			</div>	

    		<div class="role_groups">
    		 <button class="accordion">Role<i class="fa fa-caret-down "></i>
              </button>
				<div class="panel">
					<div class="group_user_role">	
					</div>
					<div class="edit_role_ofuser hidden">
						<div class="users__settings-panel group-role-settings"><div class="form-horizontal ng-scope" style=""><div class="form-group"><div class="radio col-xs-12 ng-scope" ><label><input type="radio" class="ng-pristine ng-untouched ng-valid ng-not-empty" name="role_change" value="1"> <span class="theme-radio"></span> <strong  class="ng-binding">Collaboration users</strong> <span class="help-block ng-binding">Access to: group members and their activity, personal and group notes, communication with group members and Q&amp;A coordinators</span></label></div><div class="radio col-xs-12 ng-scope"><label><input type="radio" class="ng-pristine ng-untouched ng-valid ng-not-empty" name="role_change" value="2"> <span class="theme-radio"></span> <strong class="ng-binding">Individual users</strong> <span class="help-block ng-binding">Access to: personal notes, own activity and communication with Q&amp;A coordinators </span></label></div><div class="radio col-xs-12 ng-scope"><label><input type="radio"  class="ng-pristine ng-untouched ng-valid ng-not-empty" name="role_change" value="3"> <span class="theme-radio"></span> <strong class="ng-binding">Full administrators</strong> <span class="help-block ng-binding" >Full rights: invite and manage users, view activity reports, manage permissions and Q&amp;A section</span></label></div></div></div></div>
					</div>
					<div class="edit_user_role_setting">
                        <span class="btn btn-danger cancel_new_role hidden">cancel</span>      
  						<span class="btn btn-primary apply_new_role hidden">Apply</span> 
    		 			<span class="edit_role"><i class="fa fa-pencil"></i> edit
    		            </span>
					</div>
				 
				</div>
			</div>	
			<div class="collaboration_setting_groups">
    		 <button class="accordion">Collaboration Setting <i class="fa fa-caret-down "></i></button>
				<div class="panel">
				   <div class="group_collaboration_setting">	
				   </div>
				   <div class="updated_group_collab hidden">
                     <select name="group_type_collaboration" class="collaboration_with_second_check" id="collaboration_with_second"></select>

				   </div>
				   <div class="edit_collab_setting_update">
					   <span class="edit_collab_setting"><i class="fa fa-pencil"></i> edit
	    		       </span>
	    		       <div class="hidden" style="margin: 10px 10px 10px 0px;" id="collab_btn">
    		            <span class="btn btn-danger cancel_edit_collab_setting"> cancel
    		            </span>	
    		             <span class="btn btn-primary apply_collab_setting"> Apply
	    		       </span> 
    		            </div>   		       
    		        </div>
				</div>
			</div>	
			<div class="security_setting_groups">       
    		 <button class="accordion">Security setting <i class="fa fa-caret-down "></i> </button>
				<div class="panel">
				  <div class="group_security_setting">

				  </div>
				  <div class="update_question_change hidden">
                     <div class="radio_pannel">
							<div class="radio_text">
								<strong>Access to data room</strong>
							</div>
								<div class="radio_btns">
								<label> 
									<input type="radio" value="1" name="updateGroupSecuritySetting" checked="">Unlimited</label><br>

								<label> <input type="radio" value="2" id="access_limit_till_change" name="updateGroupSecuritySetting">Till date</label><br>

								<input type="date" name="validOnDate" class="validOnDateChangeSec hidden"> 

							</div>
						</div>
				  </div>
				  <div class="security_setting_edit">
					  <span class="edit_security"><i class="fa fa-pencil"></i> edit
	    		      </span> 
	    		    <div class="hidden" id="change_security_btn">
    		            <span class="btn btn-danger cancel_edit_security"> cancel
    		            </span>	
    		            <span class=" btn btn-primary apply_change_security">Apply
	    		        </span> 
    		        </div>    		      
    		      </div>
				</div>
			</div>	
			<div class="ques_ans_groups">
    		 <button class="accordion">Q&A Setting <i class="fa fa-caret-down "></i></button>
				<div class="panel">
				  <div class="group_qa_setting">
				  </div>
					<div class="radio_pannel_setting_change hidden">
							<div class="radio_btns">
							<label> <input type="radio" value="0" name="access_Ques_ans1"><strong>No limit</strong></label><br>

							<label> <input type="radio" value="7" name="access_Ques_ans1"><strong>Per Week</strong><br>
							

							<label> <input type="radio" value="30" name="access_Ques_ans1"><strong>Per Month</strong><br>
		
							</div>

				     </div>
				     <div class="edit_ques_ans_setting">
					  <span class="edit_ques_ans"><i class="fa fa-pencil"></i> edit
    		            </span>
    		            <div class="hidden" id="edit_ques_ans_setting">
    		            <span class="btn btn-danger cancel_ques_ans"> cancel
    		            </span>
    		            <span class="btn btn-primary apply_ques_ans"> Apply
    		            </span>
    		        </div>
    		      </div>
				  </div>
				  
				</div>
			</div>		
    	 </div>
    </div>

    @endif
    
  </div>
  
</div>


<!--model for invite users-->
<div id="invite_users" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
	<div class="modal-dialog invite_new_user_block">

		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
				<h3>Invite User</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body scroll_invite_section">
			<div class="center_section">
				<div class="center_inner">
					<h2>Add New user to <i class="fa fa-user-plus"></i></h2>
                    
                    <form class="form-horizontal" role="form" id="invite_form" method="POST" action="{{url('/')}}/invite_users">
										{{ csrf_field() }}
					    <div class="dynamic_input">
							<input type="text"  name ="user_email" class="form-control" id="invite_users" data-role="tagsinput" placeholder="Enter email,use enter or comma to separate">
						</div>

						<div style="display: none;" id="alert_invite_users"></div>

						<div class="clearfix"></div>
						<input type="hidden"  name ="group_id" class="form-control" id="group_id"  placeholder="Enter Group Id">

						<input type="hidden" class="checkboxCount" id="checkboxCount" >
				</div>

				<div class="center_inner GroupByinvite">
					<h2>Choose role and enter group name</h2>
					<div class="radio_btn_pannel">
					<label>
					<input type="radio" value="user" name="forUser" checked>
					User
					</label>

					<label>
					<input type="radio" value="Administrator" name="forUser">
					Administrator
					</label>

					</div>

					<div class="basic_setting_input">

							<div class="input_pannel_m_p UserRole_block">
							<label><strong>Role</strong></label>
							<label class="input_radio_new">
							<input type="radio" name="user_role" value="1" checked>
							<i class="fa fa-user-plus"></i> Collaboration users
							</label>

							<label class="input_radio_new">
							<input type="radio" name="user_role" value="2">
							<i class="fa fa-user-circle-o"></i> Individual users
							</label>
							</div>
							   
							<div class="input_pannel ">
							<label><strong>Group</strong></label>
		                       <select class="select_dynamic Select_groupOfUser" name="choose_group" id="choose_group_dym">
						       </select>
							</div>

							<div style="display: none;" id="alert_choose_group_dym"></div>

					</div>

				</div>

				<input type="hidden"  name ="project_id" class="form-control" id="project_id" value = "{{$project_id}}">

				<div class="center_inner security_setting hidden">
					<h3>Security settings</h3>

					<div class="radio_pannel">
					<div class="radio_text"><strong>Access to data room</strong></div>
					<div class="radio_btns">
					<label> <input type="radio" value="1" name="access_limit" checked/>Unlimited</label><br>

					<label> <input type="radio" value="2" id="access_limit_date"  name="access_limit" />Till date</label><br>

					<input type="date" name="validOnDate" id="validOnDate" class="validOnDate hidden" > 

					</div>

					</div>

				</div>

				<div class="center_inner access_Ques_ans hidden">
					<h3>Access to Q&A </h3>

					<div class="radio_pannel">

					<div class="radio_btns">
					<label> <input type="radio" value ="0" name="access_Ques_ans" /><strong>None</strong></label><br>

					<label> <input type="radio" value ="1"  name="access_Ques_ans" /><strong>View</strong><br>
					<span class="radio_down_content">View questions asked by users of own group</span></label><br>

					<label> <input type="radio" value ="2"  name="access_Ques_ans" /><strong>Post to own group</strong><br>
					<span class="radio_down_content">Communicate with users of own group</span></label><br>

					<label> <input type="radio" value ="3"  name="access_Ques_ans" checked /><strong>Q&A coordinator</strong><br>
					<span class="radio_down_content">Full access to Q&A section: view and reply to all questions, close and delete questions</span></label><br>

					</div>

				     </div>
				 </div>

            </div>
		</div>
			<div class="modal-footer">
				<input value="Invite" id="invite_form_submit" type="submit" class="btn btn-success mr-2"> 

				<button type="button" class="btn btn-default" data-dismiss="modal">Close
				</button>
			</div>
		</form>
		</div>

	</div>
</div>

<!--model for create new group-->
<div id="create_group" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">

	<div class="modal-dialog create_user_new_group">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h3>NEW GROUP</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body scroll_group_section">
            	<div class="center_section">
						<div class="center_inner">
						<h2>Choose role and enter group name</h2>
						<form class="form-horizontal" role="form" id="group_form" method="POST" action="{{url('/')}}/create_group">
										{{ csrf_field() }}
						<div class="radio_btn_pannel" id="choose_user_block">
						<label>
						<input type="radio" name="userGroup" value="user"  class="choose_user1" checked>
						User
						</label>

						<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>

						<label>
						<input type="radio" name="userGroup" value="Administrator" class="choose_user2">
						Administrator
						</label>

						</div>

						<div class="basic_setting_input">
						<div class="input_pannel_m_p set_user_group_type_block" id="set_user_group_type_block">
						<label><strong>Role</strong></label>
						<label class="input_radio_new">
						<input type="radio" name="choose_user_type" value="Collaboration_users" class="choose_user_type1" checked>
						<i class="fa fa-user-plus"></i> Collaboration users
						</label>

						<label class="input_radio_new">
						<input type="radio" name="choose_user_type" value="Individual_users"  class="choose_user_type2">
						<i class="fa fa-user-circle-o"></i> Individual users
						</label>
						</div>
						   
						<div class="input_pannel_sec">
						<label><strong>Group</strong></label>
						<input type="text"  name ="group_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Group Name" required>

						<input type="hidden"  name ="project_id" class="form-control" id="project_id" value = "{{$project_id}}" placeholder="Enter Group Name">

						</div>

						</div>

						</div>

						<div class="center_inner collaboration_setting ">
						<h2>Collaboration settings</h2>

						<div class="basic_setting_input">

                        <div class="input_pannel">
						<label><strong>Collaboration with</strong></label>
						<select name="group_type_collaboration" class="group_type_collaboration" id="collaboration_with">
							
						</select>
						</div>

						<div class="input_pannel_m_p">
					<!-- 	<label><strong>Access to Reports</strong></label>
						<label class="input_radio_new">
						<input type="radio"> View own activity
						</label>

						<label class="input_radio_new">
						<input type="radio"> View activity of own group
						</label> -->
						</div>
						   	
						</div>

						</div>
						<div class="center_inner questions_limit">
						<h2>Q&A Settings</h2>

						 <div class="input_pannel">
							<label><strong>Group questions limit</strong></label>
							<select class="group_time_limit" name="group_time_limit">
								<option value="0" > No limit </option>
								<option value="7" > Per week </option>
								<option value="30"> Per month </option>
							</select>
						</div>
						<div class="input_pannel_m_p"></div>

						</div>

						<div class="center_inner security_setting">
								<h3>Security settings</h3>

								<div class="radio_pannel">
								<div class="radio_text"><strong>Access to data room</strong></div>
								<div class="radio_btns">
								<label> <input type="radio" value="1" name="access_limit" checked/>Unlimited</label><br>

								<label> <input type="radio" value="2" id="access_limit_date"  name="access_limit" />Till date</label><br>

								<input type="date" name="validOnDate" id="validOnDate" class="validOnDate hidden" > 

								</div>

								</div>

				        </div>
				</div>
			</div>
			<div class="modal-footer">

				<input value="Create" type="submit" class="btn btn-success mr-2"> 
			</form>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>



<!-- Document permission modal -->
<div id="document_permission_modal" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
  <div class="modal-dialog new_permission_setup">
  	<input type="hidden" id ='CheckUserChangePermission'>

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
           <h3>DOCUMENTS' PERMISSIONS</h3>
          <button type="button" class="close_permission_modal">&times;</button>
        </div>
        <div class="modal-body scroll_permission_section">         
          <div class="outer_box">
            <div class="outer_box_inner">
              <div class="left_section">
                <div class="select_group_and_user">
                  <ul>
                    <li><a href="#"><i class="fas fa-users"></i> Set By Groups</a></li>
                    <li><a href="#">Files and folders</a></li>
                  </ul>
                </div>
                <div class="folder_and_file_tree">
                   <ul class="folders"> 
                        <li>  
                          <div class="folder_tree">    
                            <ul id="tree3">
                              <li id="document_permission" class="document_permission" data-verify='1' data-permission="{{$projectFolderPermission}}"  <?php 
                                        if($CurrentGroupUser == 'Administrator')
                                        {
                                          echo "permission='none'";

                                        }else{

                                          if($projectFolderPermission == 1)
                                          {
                                             echo "permission='not'";

                                          }else{

                                             echo "permission=''";

                                          }

                                         
                                        }                                     
                                    ?> data-value="public/documents/{{$projectCreaterId}}/{{$project_name}}"><span class="document_name">{{$project_name}}</span>
                                <div class="folder_file_structure">

                                    <?php 
                                        if($CurrentGroupUser == 'Administrator')
                                        {
                                          echo folder_file_tree($folder_file_tree);
                                        }                                     
                                    ?>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                    </ul>                     
                </div>
              </div>

              <div class="right_table_section">
                <input type="hidden" id="current_permission_document">
              <div class="main_section">
              <div class="section1 currentFolderName">{{$project_name}}</div>
              <div class="section2"><i class='fas fa-upload'></i> Upload</div>
              <div class="section2"><i class='fas fa-download'></i> Download original</div>
              <div class="section2"><i class="fa fa-file-pdf-o"></i> Download pdf</div>
              <div class="section2"><i class="fa fa-print"></i>Print</div>
              <div class="section2"><i class='fas fa-lock'></i>Download encrypted file</div>
              <div class="section2"><i class='fas fa-eye'></i>View</div>
              <div class="section2"><i class='fas fa-eye'></i>Fence View</div>
              <div class="section2"><i class="fa fa-close"></i>None</div>
              </div>
          <div id="GoupPrForUsr">
              <div class="all_groups">
                <div class="new_user1">
                  <h3>All groups</h3>
                </div>
                <div class="all_groups_check">
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="1" data-id="" class="doc_permission1">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="2" data-id="" class="doc_permission2">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="3" data-id="" class="doc_permission3">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="4" data-id="" class="doc_permission4">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="5" data-id="" class="doc_permission5">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="6" data-id="" class="doc_permission6">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                    <div class="new_user2">
                      <label class="permission_input_check">
                        <input type="checkbox"  value="7" data-id="" class="doc_permission7">
                        <span class="checkmark"></span>
                      </label>
                    </div> 
                   <div class="permission_cancel_main new_user2 section2">
                      <i class="fa fa-close"></i>
                   </div>
                </div>
              </div>
          </div>
               

           @foreach($groups as $groups)

             <?php if($groups->group_user_type !== 'Administrator')
             {?>

              <div class="new_user_pannel" id="group{{$groups->id}}">
              <div class="new_user1"><b>{{$groups->group_name}}</b>/{{$groups->group_user_type}}</div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/1" class="doc_permission1 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/2" class="doc_permission2 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/3" class="doc_permission3 permission{{$groups->id}} ">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/4" class="doc_permission4 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/5" class="doc_permission5 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/6" class="doc_permission6 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="new_user2">
              <label class="permission_input_check">
                <input type="checkbox" name ="set_permission" data-id="{{$groups->id}}"  data-value="{{$groups->id}}/7" class="doc_permission7 permission{{$groups->id}}">
                <span class="checkmark"></span>
              </label>
              </div>
              <div class="permission_cancel new_user2 section2" group="{{$groups->id}}">
                 <i class="fa fa-close"></i>
              </div>
              </div>
            <?php }?>
         @endforeach 
              </div>

              </div>
              </div>
        </div>

    <div class="modal-footer">
       <button type="button" class="btn btn-success" id="permission_store" data-dismiss="modal">Apply</button>
    </div>
  </div>
     
  </div>

</div>

<!-- End -->


<!-- Create move user to group-->

<div id="MoveUser" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog create_folder">
    <input type='hidden'  name='copy_document' id='copy_document_directory'>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">MOVE TO GROUP</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body">

        <div class="form">
          <div id="directory_current">
            <form action="javascript:void(0)" id="folder_create" method="post" >
             <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
             <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />

             <input type="hidden" value="" class="document_indexing_count">
             
             <input type="hidden" name="slug_folder" class="slug_folder" />
             <input type="hidden" name="current_dir" class="current_dir" id="current_directory" 
             value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>
             <input type="hidden" name="project_dir" class="project_dir" id="project_directory" 
             value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>

             <input type="hidden" id="movedUserEmail">
             <input type="hidden" id="userCurrentGroupId">

             <select name="group_move_user" class="group_move_user"></select>

           </form>
         </div>
       </div>
     </div>
     <div class="modal-footer">

      <button type="button" name="submit" class="btn btn-primary UserMoveIngroup">Ok</button>
      
    </div>
  </div>
        
</div>
</div>
<!--end create folder-->



<!-- chanhge group name modal-->

<div id="ChangeGroupName" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog create_folder">
    <input type='hidden'  name='copy_document' id='copy_document_directory'>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rename Group Name</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body">

        <div class="form">
          <div id="directory_current">
            <form action="javascript:void(0)" id="folder_create" method="post" >
             <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
             <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />

             <input type="hidden" value="" class="document_indexing_count">
             
             <input type="hidden" name="slug_folder" class="slug_folder" />
             <input type="hidden" name="current_dir" class="current_dir" id="current_directory" 
             value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>
             <input type="hidden" name="project_dir" class="project_dir" id="project_directory" 
             value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>

             <input type="hidden" id="RenameGroupId">

             <input type="text" name="group_rename" class="group_rename_for">

           </form>
         </div>
       </div>
     </div>
     <div class="modal-footer">

      <button type="button" name="submit" class="btn btn-primary GroupNameRenameFor">Rename</button>
      
    </div>
  </div>
        
</div>
</div>
<!--end create folder-->


@endsection
@section('page_specific_script')

<script type="text/javascript">


	   $.fn.extend({
                      treed: function (o) {
                        
                        var MinusSign = 'glyphicon-triangle-bottom';
                        var PlusSign = 'glyphicon-triangle-right';
                        
                        if (typeof o != 'undefined'){
                          if (typeof o.openedClass != 'undefined'){
                          openedClass = o.openedClass;
                          }
                          if (typeof o.closedClass != 'undefined'){
                          closedClass = o.closedClass;
                          }
                        };
                        
                          //initialize each of the top levels
                          var tree = $(this);
                          if ( !tree.hasClass( "tree" )) {
                             tree.addClass("tree");
                          }
                         
                          // tree.find('li:not(:has(>.customspan))').prepend("<span class='inactive customspan'></i><i class='shuffle glyphicon " + PlusSign + "'></i><i class='indicator glyphicon " + closedClass + "'></span>");
                          
                          tree.find('li:not(:has(>.customspan))').has('ul').prepend("<span class='inactive customspan'></i><i class='shuffle glyphicon " + PlusSign + "'></i><i class='indicator glyphicon " + closedClass + "'></span>");

                          tree.find('li:not(:has(>.customspan))').prepend("<span class='inactive customspan'></i><i class='indicator glyphicon " + closedClass + "'></span>");
                          
                          tree.find('li').each(function () {

                              var branch = $(this); //li with children ul
                              if ( !branch.hasClass( "branch" )) {
                              
                              branch.addClass('branch');
                              branch.on('click', function (e) {

                                  if (this == e.target) {
                                  }
                              })
                              branch.find('ul').children().toggle();
                            }
                          });
                          //fire event from the dynamically added icon
                        tree.find('.branch .shuffle').each(function(){
                          $(this).unbind( "click" );
                          $(this).on('click', function () {

                             var list =  $(this).closest('li');
                             var icon = list.find('span').children('i:first');
                             var icon_next = list.find('span').children('.indicator:first');
                             icon.toggleClass(PlusSign + " " + MinusSign); 
                             icon_next.toggleClass(closedClass + " " + openedClass);
                             list.find('ul').children().toggle();

                          });
                        });
                          //fire event to open branch if the li contains an anchor instead of text
                          tree.find('.branch>a').each(function () {
                              $(this).on('click', function (e) {
                                  $(this).unbind( "click" );
                                  // $(this).closest('li').click();
                                  e.preventDefault();
                              });
                          });
                          //fire event to open branch if the li contains a button instead of text
                          tree.find('.branch>button').each(function () {
                              $(this).unbind( "click" );
                              $(this).on('click', function (e) {
                                  $(this).closest('li').click();
                                  e.preventDefault();
                              });
                          });
                      }
                  });


     getgroups();
     getAllGroups();
	// A $( document ).ready() block.
	$( document ).ready(function() {

		$('#tree3').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
         
         var clickEvent = $('.document_permission').find('span').first();
         var triggerEvent  = clickEvent.find('.shuffle').first();
         setTimeout(function(){ triggerEvent.trigger('click') },0);

		getAuthAllProjects();
         
        // Accordion
        var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) {
			    acc[i].addEventListener("click", function() {
			        this.classList.toggle("active");
			        var panel = this.nextElementSibling;
			        if (panel.style.display === "block") {
			            panel.style.display = "none";
			        } else {
			            panel.style.display = "block";
			        }
			    });
			}

			//end

        $('.Select_groupOfUser').select2();
        $('.group_type_collaboration').select2();
        $('.group_move_user').select2();


	});

	// display ALL groups.

	function getgroups() {

	var token = $('#csrf-token').val();
    var project_id = $('#project_id').val();
    var seachContant = $('#search_doc_group').val();
		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/get_allgroups",
            data:{
                _token : token,
                 project_id :project_id, 
                 seachContant :seachContant,
              },  

			success: function (response) { 

             
				   var html = "";
				   var html1 = "<option value='0'>Select group</option>";
				   var group_id = '';
				
					$.each( response, function( key, value) {
                      
                       var group_id = value.groups.id;
                       var GroupUserRole = value.groups.group_user_type;
                       var group_name = value.groups.group_name;
                       var permission  = value.groups.permission;
                       var group = group_id;


					  	html += "<div class='drop_box_document groups_list'><div class='document_index index-drop' ><div class='check-box select_check group_listing'>  <form  action='#' method='post'><input type='checkbox' class='check-box-input'  name='groups_select' data-group_type='"+GroupUserRole+"' data-per='"+permission+"' data-value='"+group_id+"'><span class=' toggle_user'>";
                             
                            if( value.users != '')
                            {
					  	     html+="<i class='fa fa-caret-down '></i>";
                            }
					        
					  	    html+="</span></form><a href='javascript:void(0)' data-value='"+group_id+"' id='' class='groups'>";

					  	    if(GroupUserRole == 'Administrator')
					  	    {
                                 html+="<img src='{{url('/')}}/dist/img/admin.png'></img>";

					  	    }else{
                                 
                                 html+="<img src='{{url('/')}}/dist/img/group.png'></img>";
					  	    }

					  	    html+= '  '+value.groups.group_name+"</a></div><div class='group-role-active'> <span>"+GroupUserRole+"</span> </div><div class='Invite-user-active'><a class='InviteUsers_icon' data-value='"+GroupUserRole+"' type='button' data-id='"+group_id+"'><img src='{{url('/')}}/dist/img/invite.png'></img></a></div></div></div><div class='users_list'>";

                        $.each( value.users, function( key, value){

                            html+="<div class='drop_box_document'><div class='document_index index-drop'><div class='check-box select_check user_listing'><form  action='#' method='post'><input type='checkbox' class='check-box-input' data-groupName ='"+group_name+"' data-value='"+value+"' data_group='"+group_id+"' name='users_select'></form><a href='javascript:void(0)' id='' class='groups'>"+value+"</a></div><span class='move_icon_user' data-value='"+value+"' data-toggle='modal' data-target='#MoveUser'><img src='{{url('/')}}/dist/img/moveUser.png'></img></span></div></div>";
                        });

                        html+="</div>";
					  	html1 += " <option value='"+group_id+"' data-value='"+GroupUserRole+"'>"+group_name+"</option>";


					});

                     
                    $('.group_list').html(html);
                    $('.Select_groupOfUser').html(html1);
                    $('.users_list').css('display','none');

                       
			}  
		}); 
    }

// create new group//

	$('#group_form').submit(function (e) {
		e.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/create_group",
			data:formData, 
			processData: false, 
			contentType: false,
			success: function (response) {  

				if (response !== "error")
				{
                     
                    var getDetails = response.split('?#');
                    
                    var group_name   = getDetails[0];
					var currentGroupId = getDetails[1];
					var group_user_type = getDetails[2];

					var lastGroup = parseInt(currentGroupId) - parseInt("1");

					$('#create_group').modal('hide'); 
                    getgroups();
                    getAllGroups();

                    $('#document_permission_modal').modal('show'); 

                    if(group_user_type !== 'Administrator')
                    {
                        

                    html='<div class="new_user_pannel" id="group'+currentGroupId+'"><div class="new_user1"><b>'+group_name+'</b>/'+group_user_type+'</div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/1" class="doc_permission1 permission'+currentGroupId+'"> <span class="checkmark"></span></label></div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/2" class="doc_permission2 permission'+currentGroupId+'"><span class="checkmark"></span></label></div> <div class="new_user2"> <label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/3" class="doc_permission3 permission'+currentGroupId+'"><span class="checkmark"></span> </label> </div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/4" class="doc_permission4 permission'+currentGroupId+'"> <span class="checkmark"></span> </label></div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/5" class="doc_permission5 permission'+currentGroupId+'"><span class="checkmark"></span></label> </div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/6" class="doc_permission6 permission'+currentGroupId+'"> <span class="checkmark"></span></label></div><div class="new_user2"><label class="permission_input_check"><input type="checkbox" name ="set_permission" data-id="'+currentGroupId+'"  data-value="'+currentGroupId+'/7" class="doc_permission7 permission'+currentGroupId+'"><span class="checkmark"></span></label></div><div class="permission_cancel new_user2 section2" group="'+currentGroupId+'"><i class="fa fa-close"></i> </div></div>';
 

                        var Checker = $("#group"+lastGroup).height();

                        if(Checker == undefined)
                        {

                        	 $('#GoupPrForUsr').append(html);

                        	 $('#document_permission_modal #group'+currentGroupId).css('background','#fff');

                        }else{
                           
                        	  $('#document_permission_modal #group'+lastGroup).append(html);

                              $('#document_permission_modal #group'+currentGroupId).css('background','#fff');
                        }
                        

                      }
				}           
			}  
		}); 

	});

 // invite user for group//

	$('#invite_form').submit(function (e) {

		e.preventDefault();
		var formData = new FormData(this);
		// $('.overlay_body').removeClass('hidden');

		$.ajax({

			type:"POST",
			url:"{{ Url('/') }}/invite_users",
			data:formData, 
			processData: false, 
			contentType: false,
			success: function (response) { 

				if(response.choose_group){
					//alert(response.errors.choose_group);
					var ema1 = response.choose_group;
					$("#alert_choose_group_dym").show();
					$("#alert_choose_group_dym").html('<span class="help-block">'+ ema1 +'</span>');
					$("#choose_group_dym").click(function(){
                       $("#alert_choose_group_dym").hide();
                     });

				}
				if(response.user_email){
					//alert(response.errors.user_email);
					var ema = response.user_email;
					$("#alert_invite_users").show();
					$("#alert_invite_users").html('<span class="help-block">'+ ema +'</span>');
					$("#invite_users").click(function(){
                       $("#alert_invite_users").hide();
                     });

				}

				if(response.alreadyExit == true){
						var email = response.errors;
                    //alert('Users with the following emails were already invited'+email);
						$("#alert_invite_users").show();
						$("#alert_invite_users").html('<span class="help-block"> Users with the following emails were already invited'+' '+ email +'</span>');
						$("#invite_users").click(function(){
                           $("#alert_invite_users").hide();
                         });                    
				} 
				
				if (response == "inviteSent")
				{
					$('#invite_users').modal('hide');
					swal("Invite Sent successfully","","success");
					getgroups();

					$('.listUsersGroups').addClass('hidden');

				}

			}  
			
		}); 
	});


 var windowHeight = $(window).height();
 var upload_table_height = windowHeight-40;
 var inviteModalheight = windowHeight-180;

 $('.upload_table').css("height",upload_table_height);
 $('.scroll_invite_section').css("height",inviteModalheight);
 $('.scroll_group_section').css("height",inviteModalheight);
 $('.scroll_permission_section').css("height",inviteModalheight);
 $('.listUsersGroups').css("height",windowHeight-110);
 


 $(document).on('click','.InviteUsersByUp',function(){

 	$('#invite_users').modal('show'); 

 })


 // 2 nov 2018 //

 $(document).on('click','.check-box-input-main',function(){

     $('input:checkbox').prop('checked', this.checked); 

     $('[data-group_type = "Administrator"]').prop('checked', false);


 });

 // select check box 
 $(document).on('click','input[type="checkbox"]', function() {

 	var group_type = $(this).data('group_type');

 
    var showDocWithDoc = '';

    var numberOfChecked = $('.groups_list input:checkbox:checked').length;

    var numberOfUserChecked = $('.users_list input:checkbox:checked').length;

    if(numberOfChecked == 1){

      	 var getGroupId = $(this).data('value');

         $('select[name="choose_group"]').find('option[value="'+getGroupId+'"]').attr("selected",'selected'); 
         $('.GroupByinvite').addClass('hidden');
      	 $('.checkboxCount').val(numberOfChecked);
      	 $('.listUsersGroups').removeClass('hidden');
      	 $('.security_setting').removeClass('hidden');
         $('.access_Ques_ans').removeClass('hidden');
         $('.EnterGroupByinvite').addClass('hidden');

      	  $.each($("input[name='groups_select']:checked"),function(){

      	  	       var group_id = $(this).data('value');
				   $('#group_id').val(group_id);
            
                   var token = $('#csrf-token').val();
                   var groupId = $(this).data('value');
                    
                        $.ajax({
                      
		                      type:"POST",
		                      url:"{{ Url('/') }}/groups/get_group_info",
		                      data:{
		                       _token : token,
		                      groupId : groupId,
		                      

		                        },  
		                        // multiple data sent using ajax//
		                        success: function (response) {
  
                                    var groupUsers  = response.userInfo;
                                    var groupInfo   = response.groupInfo;

                                    var user_html1 = '';

                                     $.each(groupUsers, function(key ,value) {

                                     	var userEmmail = value.member_email; 
                                     	user_html1 += "<h5> </h5><p>"+userEmmail+"</p>";
                                     
                                     });

                                    var group_html1 = ''; 
                                    var group_html2 = '';
                                    var group_html3 = ''; 
                                    var group_html4 = '';

                                    $.each(groupInfo, function(key ,value) {

                                        var GroupUserRole = value.group_user_type;
                                        var group_collaboration = value.collaboration_with;
                                        var group_security_setting = value.access_limit;
                                        var security_setting = '';
                                        var group_name = value.group_name;
                                        var group_id = value.id;


                                        var htmlGroupName ="<div class='GroupTitleFirst'>"+group_name+"</div><div class='edit_group_name' data-value="+group_id+" data-toggle='modal' data-target='#ChangeGroupName'><i class='fa fa-pencil'></i>Rename</div>";

                                        $('#checkGroupIdEditRole').val(group_id);

                                        $('#RenameGroupId').val(group_id);
                                        $('.group_rename_for').val(group_name);
                                        

                                        $('.GroupTitle').html(htmlGroupName);

                                        if(group_security_setting == 2)
                                        {
                                           var security_setting = value.active_date; 
                             			$("input[name='updateGroupSecuritySetting']").prop('checked', false);

                             			$("input[name='updateGroupSecuritySetting'][value='2']").prop('checked', true); 
                             			$(".validOnDateChangeSec").val(value.active_date);
                             			$(".validOnDateChangeSec").removeClass("hidden");                                           

                                        }else{

                                           var security_setting = 'Unlimited';
                             			$("input[name='updateGroupSecuritySetting']").prop('checked', false);

                             			$("input[name='updateGroupSecuritySetting'][value='1']").prop('checked', true);

                                        }

                                        var QA_setting = value.QA_access_limit;
                                        if(QA_setting == 0)
											{
												 var QA_limit = "No limit"; 
                             			$("input[name='access_Ques_ans1']").prop('checked', false);

                             			$("input[name='access_Ques_ans1'][value='0']").prop('checked', true);												 
											}

										if(QA_setting == 7)
											{
												 var QA_limit = "Weekly"; 
                             			$("input[name='access_Ques_ans1']").prop('checked', false);

                             			$("input[name='access_Ques_ans1'][value='7']").prop('checked', true);

											}
										if(QA_setting == 30)
											{
												 var QA_limit = "Monthly"; 
                             			$("input[name='access_Ques_ans1']").prop('checked', false);

                             			$("input[name='access_Ques_ans1'][value='30']").prop('checked', true);												 
											}
			
                                        
                        if(GroupUserRole == 'Collaboration_users'){

                           group_html1 +="<h5>Collaboration users</h5><p class=''>Access to: group members and their activity, personal and group notes, communication with group members and Q&A coordinators</p>"; 
                           

                           $("input[name='role_change']").prop('checked', false);

                           $("input[name='role_change'][value='1']").prop('checked', true);

                        }

					    if(GroupUserRole == 'Individual_users'){

                            group_html1 +="<h5>Individual users</h5><p class=''>Access to: personal notes, own activity and communication with Q&A coordinators</p>"; 

                             $("input[name='role_change']").prop('checked', false);

                             $("input[name='role_change'][value='2']").prop('checked', true);

                        }

                        group_html2 +="<h5>Collaboration with</h5><p>"+group_collaboration+"</p>"; 


                        group_html3 +="<h5>Access to data room</h5><p class=''>"+security_setting+"</p>";

                        group_html4+="<h5>Group questions limit</h5><p>"+QA_limit+"</p>";


                        if(GroupUserRole == 'Administrator')	
					    {
                           group_html1 +="<h5>Full administrators</h5><p class=''>Full rights: invite and manage users, view activity reports, manage permissions and Q&A section</p>";

                            $("input[name='role_change']").prop('checked', false);

                            $("input[name='role_change'][value='3']").prop('checked', true);


                           group_html2 = '';

                           group_html4 = '';
					    	
					    }

                    });
                                    if(user_html1 == '')
                                     	{                                        
                                             $('.users_groups').addClass('hidden');      
                                     	}else{
                                     		 $('.users_groups').removeClass('hidden'); 
                                     	}



                                    if(group_html2 == '')
                                     	{                                        
                                             $('.collaboration_setting_groups').addClass('hidden'); 
                                             $('.ques_ans_groups').addClass('hidden');   
                                                
                                     	}else{
                                     		 $('.collaboration_setting_groups').removeClass('hidden'); 
                                     		 $('.ques_ans_groups').removeClass('hidden'); 
                                     		 
                                     	}
 
                                    // group info
                                    $('.groupMemberDetail').addClass('hidden');
                                    $('.group_user_role').html(group_html1);
                                    $('.group_collaboration_setting').html(group_html2);
                                    $('.group_security_setting').html(group_html3);
                                    $('.group_qa_setting').html(group_html4);
                                      
                                     //group Users

                                     $('.group_user_listing').html(user_html1);
		                            }

		                       }); 


                 });

    } else if(numberOfChecked == 0)
      {
        
      	$('.delete_group').addClass('hidden');
      	$('.listUsersGroups').addClass('hidden');
      	// 21 nov

      	$('.EnterGroupByinvite').removeClass('hidden');
		$('.GroupByinvite').removeClass('hidden');
        $('.security_setting').addClass('hidden');
		$('.access_Ques_ans').addClass('hidden');

		var project_id = $('#project_id').val();

		$('.GroupTitle').html('');


      }else{

      	 $('.listUsersGroups').addClass('hidden');
      	 $('.groupMemberDetail').addClass('hidden');
      	 $('.delete_group').addClass('hidden'); 
      	 $('.delete_group').removeClass('hidden');
      	 $('.GroupByinvite').removeClass('hidden');

      	 $('.GroupTitle').html('');

      }




   if(numberOfUserChecked == 1){
   	 $('.delete_group').removeClass('hidden'); 

		$.each($("input[name='users_select']:checked"),function(){

	  	   //  var group_id = $(this).data('value');	   
           var token = $('#csrf-token').val();
           var userEmail = $(this).data('value');
           var gropuName = $(this).data('groupname');

           $('#userEmail').val(userEmail);
            var project_id = $('#project_id').val();

                	$.ajax({
              
                      type:"POST",
                      url:"{{ Url('/') }}/users/get_user_info",
                      data:{
                       _token : token,
                      userEmail : userEmail,
                      project_id:project_id,
                      

                        },  
                        // multiple data sent using ajax//
                        success: function (response) {

                            var groupUsers  = response.userInfo; 
                            var groupInfo   = response.groupInfo;
                            var user_html1 = '';
                            var user_html2 = '';
                            var user_html3 = '';
                            var user_html4 = '';

                            if(groupUsers.length !== 0 )
                            {
		                            $.each(groupUsers, function(key ,value) {

		                             	var userEmail = value.email; 
		                             	user_html1 += "<div class='row'><div class='col-md-6'>Name:</div> <div class='col-md-6'><p>"+value.name+"</p></div></div><div class='row'><div class='col-md-6'>Email:</div> <div class='col-md-6'><p>"+value.email+"</p></div></div><div class='row'><div class='col-md-6'>Phone No.:</div> <div class='col-md-6'><p>"+value.phone_no+"</p></div></div><div class='row'><div class='col-md-6'>Company:</div> <div class='col-md-6'><p>"+value.company+"</p></div></div>";
		                             
		                            });   
                            }else{
                            	    user_html1 += "<div class='row'><div class='col-md-6'>Email:</div> <div class='col-md-6'><p>"+userEmail+"</p></div></div>";

                            }

                         
							$('.listUsersGroups').addClass('hidden');
							$('.groupMemberDetail').removeClass('hidden'); 
                            $('.userDetail').html(user_html1);
                            
                            
                            
                            $.each(groupInfo, function(key ,value) {

                             	if(value.role == 1){
                             		user_html2 +="<div>Group: "+gropuName+"&nbsp;<p>(Collaboration users)</p></div>";
 									$("input[name='UserType']").prop('checked', false);
                            		$("input[name='UserType'][value='user']").prop('checked', true);

 									$("input[name='UserRole']").prop('checked', false);
                            		$("input[name='UserRole'][value='1']").prop('checked', true);                            		

                             	}else if(value.role == 2){
                             	   user_html2 +="<div>Group: "+gropuName+"&nbsp;<p>(Individual users)</p></div>";
 									$("input[name='UserType']").prop('checked', false);
                            		$("input[name='UserType'][value='user']").prop('checked', true);

 									$("input[name='UserRole']").prop('checked', false);
                            		$("input[name='UserRole'][value='2']").prop('checked', true);                            		

                             	}else{
                             		user_html2 +="<div>Group: "+gropuName+"&nbsp;<p>(Administrators)</p></div>";
 									$("input[name='UserType']").prop('checked', false);
                            		$("input[name='UserType'][value='Administrator']").prop('checked', true);

                             	}

                             	user_html2 +='<input type="hidden" name="CurrentRoleEmail" id="CurrentRoleEmail" value="'+value.member_email+'"/>';

								user_html2 +='<input type="hidden" name="CurrentRoleGroupId" id="CurrentRoleGroupId" value="'+value.group_id+'"/>';

                             	if(value.access_limit == 1){
                             		user_html3 += "<div><strong>Access to data room</strong>&nbsp;<p>Unlimted</p></div>";
 									$("input[name='updateMamberSecuritySetting']").prop('checked', false);
                            		$("input[name='updateMamberSecuritySetting'][value='1']").prop('checked', true);

                             	}else{
                             		user_html3 += "<div><strong>Access to data room</strong>&nbsp;<p>"+value.active_date+"</p></div>";
 									$("input[name='updateMamberSecuritySetting']").prop('checked', false);
                            		$("input[name='updateMamberSecuritySetting'][value='2']").prop('checked', true);
                            		$(".validDateMembers").val(value.active_date);
                            		$(".validDateMembers").removeClass("hidden");

                             	}
                             	if(value.access_qa == 0){
                             	user_html4 +="<div><strong>None</strong>&nbsp;<p></p></div>";
 								$("input[name='access_member_Ques_ans1']").prop('checked', false);
                            	$("input[name='access_member_Ques_ans1'][value='0']").prop('checked', true);                             	
                             	}else if(value.access_qa == 1){
                             	user_html4 +="<div><strong>View</strong>&nbsp;<p></p></div>";
 								$("input[name='access_member_Ques_ans1']").prop('checked', false);
                            	$("input[name='access_member_Ques_ans1'][value='1']").prop('checked', true);                             	
                             	}else if(value.access_qa == 2){
                             	user_html4 +="<div><strong>Post to own group</strong>&nbsp;<p></p></div>";
 								$("input[name='access_member_Ques_ans1']").prop('checked', false);
                            	$("input[name='access_member_Ques_ans1'][value='2']").prop('checked', true);                             	
                             	}else{
                             	user_html4 +="<div><strong>Q&A coordinator</strong>&nbsp;<p></p></div>";
 								$("input[name='access_member_Ques_ans1']").prop('checked', false);
                            	$("input[name='access_member_Ques_ans1'][value='3']").prop('checked', true);                             	
                             	}                             	                           	
                             
                            }); 

                            $('.group_member_role').html(user_html2);
                            $('.members_collaboration_setting').html(user_html3);
                            $('.member_Ques_ans_setting').html(user_html4);
                            
                             

                        }                              

                    }); 

		});






    }else if(numberOfChecked == 0){
        
      	$('.delete_group').addClass('hidden');
      	$('.groupMemberDetail').addClass('hidden');
      	// 21 nov

      	$('.EnterGroupByinvite').removeClass('hidden');
		$('.GroupByinvite').removeClass('hidden');
        $('.security_setting').addClass('hidden');
		$('.access_Ques_ans').addClass('hidden');

		var project_id = $('#project_id').val();

		$('.GroupTitle').html('');


      }else{

      	 $('.groupMemberDetail').addClass('hidden');
      	 $('.delete_group').addClass('hidden'); 
      	 $('.delete_group').removeClass('hidden');
      	 $('.GroupByinvite').removeClass('hidden');

      	 $('.GroupTitle').html('');

      }

  });

 $(document).on('change','.security_setting input:radio',function(){

    if ($(this).val() == "2") {
       
       $('.validOnDate').removeClass('hidden');

    }else{
       
       $('.validOnDate').addClass('hidden');
    }

 });




 $(document).on('change','input:radio',function(){

    if ($(this).val() == "Administrator") {
       
       $('.UserRole_block').addClass('hidden');
       
    } else{
 
        $('.UserRole_block').removeClass('hidden');
        
    }

 });


 $(document).on('change','#create_group input:radio',function(){

    if ($(this).val() == "Individual_users") {


       $('#create_group .security_setting').addClass('hidden');
       $('#create_group .questions_limit').addClass('hidden');
       $('#create_group .collaboration_setting').addClass('hidden');
       $('#create_group .set_user_group_type_block').removeClass('hidden');

    } else{
 
       $('#create_group .security_setting').removeClass('hidden');
       $('#create_group .questions_limit').removeClass('hidden');
       $('#create_group .collaboration_setting').removeClass('hidden');
       $('#create_group .set_user_group_type_block').removeClass('hidden');
    }

    if ($(this).val() == "Administrator") {

       $('#create_group .set_user_group_type_block').addClass('hidden');
       $('#create_group .security_setting').addClass('hidden');
       $('#create_group .questions_limit').addClass('hidden');
       $('#create_group .collaboration_setting').addClass('hidden');

    }else{
  	
       c
       $('#create_group .security_setting').removeClass('hidden');
       $('#create_group .questions_limit').removeClass('hidden');
       $('#create_group .collaboration_setting').removeClass('hidden');
    }

 });


 $(document).on('click','.InviteUsers_icon',function(){

 	    var group_id = $(this).data('id');
 	    var gropuRole = $(this).data('value');
 	    // $('.Select_groupOfUser option[value='+group_id+']').attr('selected','selected');

	 	$('input:checkbox').prop('checked', false);
	 	
	    $(this).parent().parent().find('.check-box-input').trigger( "click");
        var data_value = $(this).parent().parent().find('.check-box-input').data('value');

        var data_permission = $(this).parent().parent().find('.check-box-input').data('per');

	      if(gropuRole !== 'Administrator')
	       {

	        if(data_permission == 0)
	        {
	        	$('#document_permission_modal').modal('show');
	        	$('#CheckUserChangePermission').val('1');
	        	$('#document_permission_modal #group'+group_id).css('background','lightgray');
	        	$('#document_permission_modal #group'+group_id).addClass('founder_permission');
	     	 
	        }

	     }

       	$('.GroupByinvite').addClass('hidden');
	 	$('.security_setting').removeClass('hidden');
	 	$('.access_Ques_ans').removeClass('hidden');
	 	$('.EnterGroupByinvite').addClass('hidden');
	 	$('#invite_users').modal('show'); 


	 	var clickEvent = $('.document_permission').find('span').first();
        var triggerEvent  = clickEvent.find('.shuffle').first();
        setTimeout(function(){ triggerEvent.trigger('click') },0);
      
 });

 // delete group 


  $(document).on('click','.delete_items_groups',function(){
    
    var token = $('#csrf-token').val();
    var project_id = $('#project_id').val();

    var deletePath = [];
    var deleteUser = [];

    $.each($("input[name='groups_select']:checked"), function(e)
    {        
        
          deletePath.push($(this).data('value')); 

    });

    $.each($("input[name='users_select']:checked"), function(e)
    {        
        var userEmail = $(this).data('value'); 
        var group      =   $(this).attr('data_group');

        var add = group+"/"+userEmail;

        deleteUser.push(add); 

    });

          swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this file!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"{{ Url('/') }}/delete_group",
                            data:{
                              _token : token,
                               deletePath: deletePath,
                               deleteUser : deleteUser,
                               project_id: project_id,
                            },  

                            // multiple data sent using ajax//
                            success: function (response) {
                              
                                getgroups();

                                $("input[name='groups_select']").prop("checked","false");
                                $(".check-box-input-main").prop("checked","false");
                               
                             
                         }
                   });
              } 
       });
    
 });

    function getAuthAllProjects(){

  var token = $('#csrf-token').val();  

       $.ajax({
        type : "POST",
        url : "{{url('/')}}/check/projects",
        data : {     
          _token      : token,
        },
        success:function(response){

          var html ='<li class="btn-block new_data_room" data-toggle="modal" data-target="#create_project"><span class="new_room"><i class="fas fa-plus"></i></span> Create New Project<i class=""></i> </li>';

           $.each(response,function(key, value){

             html +="<div class='btn-block new_data_room'><span><i class='fas fa-circle'></i></span><a href='{{url('/')}}/project/"+value.id+"/documents'>"+value.project_name+"</a></div>";
                  
           });

         $('.list-unstyled').html(html);

        }
      });

 }


// $(document).on('click','.create_new_group',function(){

function getAllGroups(){

	var token = $('#csrf-token').val();
    var project_id = $('#project_id').val();    


		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/get_group_users",
            data:{
                _token : token,
                 project_id :project_id,
              },  

			success: function (response) { 

				    var html1 = "<option value='own_group'>Own group</option><option value='all_group'>All group</option><option value='users_group'>Users group</option>";

				    var html2 = '';
				
					$.each( response, function( key, value) {

                       var group_id = value.id;
                       var GroupUserRole = value.group_user_type;

					   html1 += "<option value='"+value.id+"'>"+value.group_name+"</option>";

					   html2+="<option value='"+value.id+"'>"+value.group_name+"</option>";

					});
                     
                    $('.group_type_collaboration').html(html1);
                    $('.collaboration_with_second_check').html(html1);
                    $('.group_move_user').html(html2);

                    

                       
			}  
		}); 
}
	
// });


	$(document).on('change','.GroupByinvite',function(){
		var token = $('#csrf-token').val();
	    var project_id = $('#project_id').val(); 
		var userOrAdmin = $("input[name='forUser']:checked").val();
	    var userType = $("input[name='user_role']:checked").val();
	    var role = '';
	    var html1 ='';
	    if(userOrAdmin == 'user'){

	    	if(userType == '1'){

	    		role ='Collaboration_users';

	    	}else{

				role ='Individual_users';

	    	}

	    }else{

			role ='Administrator';
	    }

		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/select_group_users",
            data:{
                _token : token,
                 project_id :project_id,
                 role :role,
              },  

			success: function (response) { 
		
					$.each( response, function( key, value) {

                       var group_id = value.id;
                       var GroupUserRole = value.group_user_type;

					   html1 += "<option value='"+value.id+"'>"+value.group_name+"</option>";

					  // html2+="<option value='"+value.id+"'>"+value.group_name+"</option>";

					});
                     
                    $('#choose_group_dym').html(html1);
                       
			}  
		});



	});

	$(document).on('change','.ChangeGroupByinvite',function(){
		var token = $('#csrf-token').val();
	    var project_id = $('#project_id').val(); 
		var userOrAdmin = $("input[name='UserType']:checked").val();
	    var userType = $("input[name='UserRole']:checked").val();
	    var role = '';
	    var html1 ='';
	    if(userOrAdmin == 'user'){

	    	if(userType == '1'){

	    		role ='Collaboration_users';

	    	}else{

				role ='Individual_users';

	    	}

	    }else{

			role ='Administrator';
	    }

		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/select_group_users",
            data:{
                _token : token,
                 project_id :project_id,
                 role :role,
              },  

			success: function (response) { 
		
					$.each( response, function( key, value) {

                       var group_id = value.id;
                       var GroupUserRole = value.group_user_type;

					   html1 += "<option value='"+value.id+"'>"+value.group_name+"</option>";

					  // html2+="<option value='"+value.id+"'>"+value.group_name+"</option>";

					});
                     
                    $('#ChooseGroupForChange').html(html1);
                       
			}  
		});



	});



$(document).on('click','.toggle_user',function(){
      
    $(this).parent().parent().parent().parent().next().toggle();

});

$(document).on('click','.main-user_list',function(){
      
    $('.users_list').toggle();

});

$('#hjgh').click(function(){


                      	var formData = new FormData();
                      	var token = $('#csrf-token').val();
			            formData.append('File', $('#file_input')[0].files[0], 'tesyts.docx');

								$.ajax({
								    url: 'https://v2.convertapi.com/convert/docx/to/pdf?Token=897897898979678',
								    data: formData,
								    processData: false,
								    contentType: false,  
								    method: 'POST',
								    success: function(data) {
								        console.log(data);
								}
						});  
               });

 $(document).ajaxSend(function(event, request, settings) {
      $('.overlay_body').removeClass('hidden');
    });

 $(document).ajaxComplete(function(event, request, settings) {
      $('.overlay_body').addClass('hidden');
    }); 

        //left side bar

         $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    $('.overlay').fadeOut();
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    $('.overlay').fadeIn();
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            //end   

            $(document).on('click','.new_data_room',function(){
               $('#dismiss').click();
            });



     //document_permission

     $(document).on('click','.document_permission',function(event){

     
        event.preventDefault();
        event.stopPropagation();


        $('#document_permission_modal input:checkbox').removeAttr('disabled'); 

           var token =$('#csrf-token').val();
           var directory_url = $(this).data("value");
           var folder = directory_url.split('/');
           var folder_name = folder.pop();

           $('#document_permission_modal input:checkbox').prop('checked', false);

           $('#current_permission_document').val(directory_url);
 
           $('.section1.currentFolderName').html(folder_name);

           var get_permission_doc = $(this).data('permission');

           var data_verify = $(this).data('verify');

           showPermission(get_permission_doc,data_verify);
          
     
     });        
   



   // display set permission.
     function showPermission(get_permission_doc,data_verify){
         
           var permission = get_permission_doc.split(",");

           $.each(permission,function(key ,value){

           var loatPermission = value.split('/');

           var loatP  = loatPermission['1'];


           if(loatP == 1 && data_verify == 0 )
           {
               $('#document_permission_modal input:checkbox').attr('disabled',"disabled");
           }

           var permission = value;

           $('[data-value = "'+permission+'"]').prop('checked', true);

           });
     }   


     function DocumentTree(token,project_id){

              $.ajax({
                              
                  type:"GET",
                    url:"{{ Url('/') }}/project/"+project_id+"/documents/action",

                   data:{
                    _token : token,
                    },  
                    // multiple data sent using ajax//
                    success: function (response) { 

                      var folderTree = response.folderTree;
                      var folder_file_tree = response.folder_file_tree;
                   
                     $('.folder_struture').html(folderTree);

                      $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

                     $('.folder_file_structure').html(folder_file_tree);

                     $('#tree3').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                         
                    }

         });
    
   }


    //permission module

   $(document).on('click','#document_permission_modal input[type="checkbox"]', function() {

      var id = $(this).data('id');

      if(id == '')
      {
        $('input:checkbox').not(this).prop('checked', false);

        var getPerClass = $(this).attr('class');
        var class_get = '.'+getPerClass;

        $('.new_user_pannel '+class_get).prop('checked', true);

      }else{

        var getGroupClass = '#group'+id;
        $(getGroupClass+'  input:checkbox').not(this).prop('checked', false);
        $('.all_groups input:checkbox').prop('checked', false);

      }

   });


   $(document).on('click','#permission_store',function(){

   	      var setPermissionAccess = $('.founder_permission input:checkbox:checked').length;

          var numberOfChecked1 = $('#document_permission_modal input:checkbox:checked').length;
      
          if(numberOfChecked1 == '0')
          { 
             alert('please select any permission of the document.');
          }

          var permission_array = [];

          $.each($("input[name='set_permission']:checked"),function(){ 

             permission_array.push($(this).data('value')); 

          });

         var Document = $('#current_permission_document').val();

         var project_id  = $('#project_id').val(); 

         var token = $('#csrf-token').val();  
         

          $.ajax({
                                
                    type:"POST",
                    url:"{{ Url('/') }}/set_permission",
                    data:{
                      _token : token,
                      permission_array   :  permission_array,
                      Document  :  Document,
                      project_id : project_id,

                      },  
                      // multiple data sent using ajax//
                      success: function (response) { 

                       if(response == 'success'){
                             
                            getgroups();

                            DocumentTree(token,project_id);

                            $('#CheckUserChangePermission').val('');

                        }
 
                      }

                });
                       
   });


   $(document).on('click','.permission_cancel',function(){

        var group_id =  $(this).attr('group');

        $('#group'+group_id+' input:checkbox' ).prop('checked', false);
        $('.all_groups input:checkbox' ).prop('checked', false);

   });

    $(document).on('click','.permission_cancel_main',function(){

     $('#document_permission_modal input:checkbox').prop('checked', false);

   });

    // set the permission

    $(document).on('click','.permission_docs',function(){
          
          var permission_doc = $(this).data('value');

          $('#document_permission_modal').modal('show');
          
          var triggerEvent  = $('.document_permission [data-value = "'+permission_doc+'"]').click();

    });


    $(document).on('click','[data-group_type = "Administrator"]',function(){
         
        if($('#check_main_select').prop("checked") == true){

        	    
            }else{

            	
            }
    	
    });

    $(document).on('click','.move_icon_user',function(){
        
           data_value = $(this).data('value');
           
           var current_group_id = $(this).parent().find('input:checkbox').attr('data_group');

           $('#userCurrentGroupId').val(current_group_id);

           $('#movedUserEmail').val(data_value);
           
           $(this).parent().find('input:checkbox').click();   
          

    });


     $(document).on('click','.UserMoveIngroup',function(){
          
         var movedGroupId =  $('.group_move_user').val();  
         var current_group_id =  $('#userCurrentGroupId').val();
         var project_id = $('#project_id').val();
         var userEmail  =$('#movedUserEmail').val();
         var token = $('#csrf-token').val();


				$.ajax({

					type:"POST",
					url:"{{ Url('/') }}/user/move_to_group",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 movedGroupId  : movedGroupId,
		                 userEmail  : userEmail,
		                 current_group_id : current_group_id,
		                
		              },  

					success: function (response) { 
					
						getgroups();

						$('#MoveUser').modal('hide');
						$('.display_groups input:checkbox').prop('checked', this.checked); 

					}

				});

     });


       $(document).on('click','.checkmark',function(){
           
           $('#CheckUserChangePermission').val('1');

       });

       $(document).on('click','.close_permission_modal',function(){

        	var checker =  $('#CheckUserChangePermission').val();
        	if(checker == 1){
                 
                 alert('Do you want to apply set permission ?');

        	}else{

        		$('#document_permission_modal').modal('hide');
        	}

       });


       $(document).on('click','.edit_role',function(){

       	 $(this).addClass('hidden');
       	 $('.edit_role_ofuser').removeClass('hidden');
       	 $('.apply_new_role').removeClass('hidden');
       	 $('.cancel_new_role').removeClass('hidden');

       	 $('.group_user_role').addClass('hidden');

       	 var groupId =  $('#checkGroupIdEditRole').val();

       	 $(this).addClass('hidden');

       });

       $(document).on('click','.edit_group_member_role',function(){

       	 $(this).addClass('hidden');
       	 $(".group_member_role").addClass('hidden');      	 
       	 $('.edit_role_ofgroup_member').removeClass('hidden');
       	 
       });

       $(document).on('click','.cancel_member_new_role',function(){
           
           $('.edit_group_member_role').removeClass('hidden');
           $(".group_member_role").removeClass('hidden'); 
           $('.edit_role_ofgroup_member').addClass('hidden');

       });       

       $(document).on('click','.cancel_new_role',function(){
           
           $('.group_user_role').removeClass('hidden');
           $('.edit_role').removeClass('hidden');
           $('.apply_new_role').addClass('hidden');
           $(this).addClass('hidden');
           $('.edit_role_ofuser').addClass('hidden');

       });

       $(document).on('click','.apply_new_role',function(){

           var token = $('#csrf-token').val();
           var ChangedRole = $("input[name='role_change']:checked").val();
           var project_id = $('#project_id').val();
           var group_id = $('#RenameGroupId').val();

           $.ajax({

			type:"POST",
			url:"{{ Url('/') }}/change_groupRole",
            data:{
                _token : token,
                 project_id :project_id, 
                 ChangedRole : ChangedRole,
                 group_id : group_id,
              },  

			success: function (response){

				if(response == 'success')
				{
					getgroups();
					$('.listUsersGroups').addClass('hidden');
					$('.edit_role_ofuser').addClass('hidden');

					$('.group_user_role').removeClass('hidden');
		            $('.edit_role').removeClass('hidden');
		            $('.apply_new_role').addClass('hidden');
		            $('.cancel_new_role').addClass('hidden');
		            
		           
				}

			}

         });


            
       });

       $(document).on('click','.apply_member_new_role',function(){

         var movedGroupId =  $('#ChooseGroupForChange').val();  
         var current_group_id =  $('#CurrentRoleGroupId').val();    
         var userEmail  =$('#CurrentRoleEmail').val();
         var project_id = $('#project_id').val();
         var token = $('#csrf-token').val();

				$.ajax({

					type:"POST",
					url:"{{ Url('/') }}/user/move_to_group",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 movedGroupId  : movedGroupId,
		                 userEmail  : userEmail,
		                 current_group_id : current_group_id,
		                
		              },  

					success: function (response) { 
					
					getgroups();
					
					$('.display_groups input:checkbox').prop('checked', this.checked);
				    $('.listUsersGroups').addClass('hidden'); 
				    $('.update_member_security').addClass('hidden');
				    $('.members_collaboration_setting').removeClass('hidden');
				    $('#change_security_btn').addClass('hidden');
				    $('.edit_member_security').removeClass('hidden');
			

					}

				});


            
       });

   $(document).on('click','.GroupNameRenameFor',function(){


     var token = $('#csrf-token').val();
     var project_id = $('#project_id').val();
     var group_id = $('#RenameGroupId').val();
     var ChangedGroupName = $('.group_rename_for').val();

		$.ajax({

			type:"POST",
			url:"{{ Url('/') }}/change_groupName",
            data:{
                _token : token,
                 project_id :project_id, 
                 group_id   : group_id,
                 ChangedGroupName : ChangedGroupName,
              },  

			success: function (response){


				if(response == 'success')
				{
					$('#ChangeGroupName').modal('hide');
				    getgroups();
				    $('.GroupTitleFirst').html(ChangedGroupName);
				}

			 }

			});

    });

       
     

      $(document).on('click','.selection',function(){
 			$("#alert_choose_group_dym").hide();
      });

      $(document).on('click','.edit_collab_setting',function(){

 			$('.updated_group_collab').removeClass('hidden');
 			$('.group_collaboration_setting').addClass('hidden');
 			$(this).addClass('hidden');
 			//$('.apply_collab_setting').removeClass('hidden');
 			//$('.cancel_edit_collab_setting').removeClass('hidden');
 			$('#collab_btn').removeClass('hidden');
 			


       });

  $(document).on('click','.apply_collab_setting',function(){

  	 var updatedCollabVAlue  = $('#collaboration_with_second').val();
  	 var project_id = $('#project_id').val();
  	 var group_id = $('#checkGroupIdEditRole').val();
     var token = $('#csrf-token').val();

     $.ajax({

					type:"POST",
					url:"{{ Url('/') }}/update/collaboration_setting",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 group_id : group_id,
		                 updatedCollabVAlue  : updatedCollabVAlue,
		               
		              },  

					success: function (response) { 

						//alert(response);

						getgroups();
						
						$('.display_groups input:checkbox').prop('checked', this.checked);
						$('.listUsersGroups').addClass('hidden'); 
						$('.updated_group_collab').addClass('hidden');
 			            $('.group_collaboration_setting').removeClass('hidden');
 			            $('.edit_collab_setting').removeClass('hidden');
 			            $('#collab_btn').addClass('hidden');
				

					}

				});


    });


 $(document).on('click','.security_setting_edit .edit_security',function(){

     $('.update_question_change').removeClass('hidden');
     $('.group_security_setting').addClass('hidden');
     $('#change_security_btn').removeClass('hidden');
     
     $('.edit_security').addClass('hidden');

 });
  
 $(document).on('click','.edit_member_security',function(){

     $('.update_member_security').removeClass('hidden');
     $('.members_collaboration_setting').addClass('hidden');   
     $('.edit_member_security').addClass('hidden');

 });


$(document).on('change','.security_setting_groups input:radio',function(){

    if ($(this).val() == "2") {
       
       $('.validOnDateChangeSec').removeClass('hidden');

    }else{
       
       $('.validOnDateChangeSec').addClass('hidden');
    }

 });

$(document).on('change','.collaboration_setting_members input:radio',function(){

    if ($(this).val() == "2") {
       
       $('.validDateMembers').removeClass('hidden');

    }else{
       
       $('.validDateMembers').addClass('hidden');
    }

 });


  $(document).on('click','.apply_change_security',function(){

  	 var updatedsecurityValue  = $("input[name='updateGroupSecuritySetting']:checked").val();

  	 if(updatedsecurityValue == '1')
  	 {
  	 	var updatedsecurityValue1 = 1;

  	 }else{

          var updatedsecurityValue1 = $('.validOnDateChangeSec').val();

  	 }

  	 var project_id = $('#project_id').val();
  	 var group_id = $('#checkGroupIdEditRole').val();
     var token = $('#csrf-token').val();

     $.ajax({

					type:"POST",
					url:"{{ Url('/') }}/update/access_setting",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 group_id : group_id,
		                 updatedsecurityValue1  : updatedsecurityValue1,
		               
		              },  

					success: function (response) { 

						getgroups();
						
						 $('.display_groups input:checkbox').prop('checked', this.checked);
					     $('.listUsersGroups').addClass('hidden'); 
					     $('.update_question_change').addClass('hidden');
					     $('.group_security_setting').removeClass('hidden');
					     //$('#change_security_btn').addClass('hidden');
					     $('.edit_security').removeClass('hidden');
				

					}

				});


    });

  $(document).on('click','.apply_member_change_security',function(){

  	 var updatedsecurityValue  = $("input[name='updateMamberSecuritySetting']:checked").val();

  	 if(updatedsecurityValue == '1')
  	 {
  	 	var updatedsecurityValue1 = 1;

  	 }else{

          var updatedsecurityValue1 = $('.validDateMembers').val();

  	 }

  	 var project_id = $('#project_id').val();
  	 var group_id = $('#CurrentRoleGroupId').val();
  	 var CurrentEmail = $('#CurrentRoleEmail').val();
     var token = $('#csrf-token').val();
 		$.ajax({

				type:"POST",
				url:"{{ Url('/') }}/update/member/access_setting",
	            data:{
	                _token : token,
	                 project_id :project_id, 
	                 group_id : group_id,
	                 updatedsecurityValue1  : updatedsecurityValue1,
	                 CurrentEmail :CurrentEmail,
	               
	              },  

				success: function (response) { 

					getgroups();
					
					 $('.display_groups input:checkbox').prop('checked', this.checked);
				     $('.listUsersGroups').addClass('hidden'); 
				     $('.update_member_security').addClass('hidden');
				     $('.members_collaboration_setting').removeClass('hidden');
				     $('#change_security_btn').addClass('hidden');
				     $('.edit_member_security').removeClass('hidden');
			

				}

			});


    });


 $(document).on('click','.edit_ques_ans',function(){


     $('.radio_pannel_setting_change').removeClass('hidden');
     //$('.apply_ques_ans').removeClass('hidden');
     $('.group_qa_setting').addClass('hidden');
	//$('.cancel_ques_ans').removeClass('hidden');
     $('#edit_ques_ans_setting').removeClass('hidden');
     $(this).addClass('hidden');

 });

  $(document).on('click','.member_edit_ques_ans',function(){


     $('.member_radio_pannel_setting').removeClass('hidden');
     $('.member_Ques_ans_setting').addClass('hidden');
     $(this).addClass('hidden');

 });


$(document).on('click','.apply_ques_ans',function(){

  	 var updatedQuestionValue  = $("input[name='access_Ques_ans1']:checked").val();
  	 var project_id = $('#project_id').val();
  	 var group_id = $('#checkGroupIdEditRole').val();
     var token = $('#csrf-token').val();

     $.ajax({

					type:"POST",
					url:"{{ Url('/') }}/update/quesAns_setting",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 group_id : group_id,
		                 updatedQuestionValue  : updatedQuestionValue,
		               
		              },  

					success: function (response) { 

						getgroups();
						
						$('.display_groups input:checkbox').prop('checked', this.checked);

					    $('.listUsersGroups').addClass('hidden'); 
					    $('#edit_ques_ans_setting').addClass('hidden');
					   // $('.apply_ques_ans').addClass('hidden');
                        $('.group_qa_setting').removeClass('hidden');
                        $('.radio_pannel_setting_change').addClass('hidden');
                        $('.edit_ques_ans').removeClass('hidden');

					}

				});


    });

$(document).on('click','.member_apply_ques_ans',function(){

  	 var updatedQuestionValue  = $("input[name='access_member_Ques_ans1']:checked").val();
  	 var project_id = $('#project_id').val();
  	 var userEmail = $('#userEmail').val();
  	 var group_id =$('#CurrentRoleGroupId').val();
     var token = $('#csrf-token').val();
     $.ajax({

					type:"POST",
					url:"{{ Url('/') }}/member/quesAns_setting",
		            data:{
		                _token : token,
		                 project_id :project_id, 
		                 group_id : group_id,
		                 userEmail: userEmail,
		                 updatedQuestionValue  : updatedQuestionValue,
		               
		              },  

					success: function (response) { 

						getgroups();
						
						$('.display_groups input:checkbox').prop('checked', this.checked);

					    $('.listUsersGroups').addClass('hidden'); 

					    $('.member_Ques_ans_setting').removeClass('hidden');
					    $('.member_edit_ques_ans').removeClass('hidden');
					    $('.member_radio_pannel_setting').addClass('hidden');
                        //$('.radio_pannel_setting_change').addClass('hidden');
                        //$('.edit_ques_ans').removeClass('hidden');

					}

				});


    });


  $(document).on('click','.cancel_edit_collab_setting',function(){
			$('.updated_group_collab').addClass('hidden');
			$('.group_collaboration_setting').removeClass('hidden');
			$('.edit_collab_setting').removeClass('hidden');
			$('#collab_btn').addClass('hidden');
  });

  $(document).on('click','.cancel_edit_security',function(){

			$('.update_question_change').addClass('hidden');
			$('.group_security_setting').removeClass('hidden');
			$('.edit_security').removeClass('hidden');			
			$('#change_security_btn').addClass('hidden');

  });

    $(document).on('click','.cancel_ques_ans',function(){
			$('.radio_pannel_setting_change').addClass('hidden');
			$('.edit_ques_ans').removeClass('hidden');	
			$('.group_qa_setting').removeClass('hidden');		
			$('#edit_ques_ans_setting').addClass('hidden');
    });

    $(document).on('click','.member_cancel_edit_security',function(){			
		$('.update_member_security').addClass('hidden');
		$('.members_collaboration_setting').removeClass('hidden'); 
		$('.edit_member_security').removeClass('hidden');
    });

  $(document).on('click','.member_cancel_ques_ans',function(){

			$('.member_radio_pannel_setting').addClass('hidden');
			$('.member_Ques_ans_setting').removeClass('hidden');			
			$('.member_edit_ques_ans').removeClass('hidden');
  });

</script>
@endsection