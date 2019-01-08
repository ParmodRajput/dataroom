@extends('layouts.app_groups')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
  <div class="row document_content_index">
    <div class="user_gruoups_list col-md-6">
     <div class="display_groups">
        <div class="row group_block">
          
            @if(checkUserType($project_name) == 'Administrator')
        	<div class="btn_upload InviteUsersByUp ">
           		 <button class='btn btn-primary InviteUsers' type='button' data-id=''>InviteUsers</button>
           </div>

            <div class="btn_upload">
                <button class="btn btn-success btn-block create_new_group" data-toggle="modal" data-target="#create_group">New Group
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
                        	
                        	<input type="checkbox" class="check-box-input-main">
                        	<span  class="main-user_list"><i class='fa fa-caret-down '></i></span>
                        </form> 
                              <span>Group / Name</span>
                        </div>
                              
                        <div class="group-role">
                               <span>Role</span> 
                        </div>
                        <div class="Invite-user-ac">
                           <span><i class='fa fa-user-plus' aria-hidden='true'></i></span> Invite user
                        </div>

                </div>

              	<div class="group_list">
			
		        </div>

         </div>
    </div>

  @if(checkUserType($project_name) == 'Administrator')
    <div class="indexing-group-user col-md-6">
    	<div class="list_group_user hidden">
    		<div class="users_groups">
    		 <button class="accordion">Users <i class="fa fa-caret-down "></i> <span class="edit_user"><i class="fa fa-pencil"></i> edit
    		 </span></button>
				<div class="panel">
					<div class="group_user_listing">
						
					</div>
				</div>
			</div>	

    		<div class="role_groups">
    		 <button class="accordion">Role<i class="fa fa-caret-down "></i><span class="edit_role"><i class="fa fa-pencil"></i> edit
    		 </span></button>
				<div class="panel">
					<div class="group_user_role">
						
					</div>
				 
				</div>
			</div>	
			<div class="collaboration_setting_groups">
    		 <button class="accordion">Collaboration Setting <i class="fa fa-caret-down "></i><span class="edit_collab_setting"><i class="fa fa-pencil"></i> edit
    		 </span></button>
				<div class="panel">
				   <div class="group_collaboration_setting">	
				   </div>
				</div>
			</div>	
			<div class="security_setting_groups">       
    		 <button class="accordion">Security setting <i class="fa fa-caret-down "></i> <span class="edit_security"><i class="fa fa-pencil"></i> edit
    		 </span> </button>
				<div class="panel">
				  <div class="group_security_setting">

				  </div>
				</div>
			</div>	
			<div class="ques_ans_groups">
    		 <button class="accordion">Q&A Setting <i class="fa fa-caret-down "></i><span class="edit_ques_ans"><i class="fa fa-pencil"></i> edit
    		 </span></button>
				<div class="panel">
				  <div class="group_qa_setting">
						
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
						<div class="clearfix"></div>
						<input type="hidden"  name ="group_id" class="form-control" id="group_id" value = "" placeholder="Enter Group Id">

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
						<div class="input_pannel_m_p" id="set_user_group_type_block">
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
						<input type="text"  name ="group_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Group Name">

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

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
           <h3>DOCUMENTS' PERMISSIONS</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                   <div class="permission_cancle_main new_user2 section2">
                      <i class="fa fa-close"></i>
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
              <div class="permission_cancle new_user2 section2" group="{{$groups->id}}">
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
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button>
       <button type="button" class="btn btn-success" id="permission_store" data-dismiss="modal">Apply</button>
    </div>
  </div>
     
  </div>

</div>

<!-- End -->


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


	});

	// display ALL groups.

	function getgroups() {

	var token = $('#csrf-token').val();
    var project_id = $('#project_id').val();

		$.ajax({
			type:"POST",
			url:"{{ Url('/') }}/get_allgroups",
            data:{
                _token : token,
                 project_id :project_id, 
              },  

			success: function (response) { 

             
				   var html = "";
				   var html1 = "<option value='0'>Select group</option>";
				
					$.each( response, function( key, value) {
                      
                       var group_id = value.groups.id;
                       var GroupUserRole = value.groups.group_user_type;
                       var group_name = value.groups.group_name;
                       var permission  = value.groups.permission;


					  	html += "<div class='drop_box_document groups_list'><div class='document_index index-drop' ><div class='check-box select_check group_listing'>  <form  action='#' method='post'><input type='checkbox' class='check-box-input'  name='groups_select' data-group_type='"+GroupUserRole+"' data-per='"+permission+"' data-value='"+group_id+"'><span class=' toggle_user'>";
                             
                            if( value.users != '')
                            {
					  	     html+="<i class='fa fa-caret-down '></i>";
                            }
					        
					  	    html+="</span></form><a href='javascript:void(0)' data-value='"+group_id+"' id='' class='groups'>"+value.groups.group_name+"</a></div><div class='group-role-active'> <span>"+GroupUserRole+"</span> </div><div class='Invite-user-active'><a class='InviteUsers_icon' type='button' data-id='"+group_id+"'><i class='fa fa-user-plus' aria-hidden='true'></i></a></div></div></div><div class='users_list'>";

                        $.each( value.users, function( key, value){

                            html+="<div class='drop_box_document'><div class='document_index index-drop' ><div class='check-box select_check user_listing'><form  action='#' method='post'><input type='checkbox' class='check-box-input'  name='users_select'></form><i class='fa fa-user' aria-hidden='true'></i> <a href='javascript:void(0)' id='' class='groups'>"+value+"</a></div></div></div>";
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

				if (response == "success")
				{
					$('#create_group').modal('hide'); 
					// swal("group created successfully","", "success");
                    getgroups();
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

				
				if (response == "inviteSent")
				{
					$('#invite_users').modal('hide');
					swal("Invite Sent successfully","","success");
					getgroups();

					$('.list_group_user').addClass('hidden');

				}else{

                    alert('Users with the following emails were already invited ' +response);
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


    var showDocWithDoc = '';

    var numberOfChecked = $('.user_gruoups_list input:checkbox:checked').length;

      if(numberOfChecked == 1)
      {

      	 var getGroupId = $(this).data('value');

         $('select[name="choose_group"]').find('option[value="'+getGroupId+'"]').attr("selected",'selected');
         
         $('.GroupByinvite').addClass('hidden');
      	 $('.delete_group').removeClass('hidden'); 
      	 $('.checkboxCount').val(numberOfChecked);

      	 $('.list_group_user').removeClass('hidden');

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

                                        if(group_security_setting == 2)
                                        {
                                           var security_setting = value.active_date;  
                                        }else{

                                           var security_setting = 'Unlimited';
                                        }

                                        var QA_setting = value.QA_access_limit;
                                        if(QA_setting == 0)
											{
												 var QA_limit = "No limit"; 
											}

										if(QA_setting == 7)
											{
												 var QA_limit = "Only 7 days"; 
											}
										if(QA_setting == 30)
											{
												 var QA_limit = "1 Month "; 
											}
											
                                        
                        if(GroupUserRole == 'Collaboration_users'){

                           group_html1 +="<h5>Collaboration users</h5><p class=''>Access to: group members and their activity, personal and group notes, communication with group members and Q&A coordinators</p>"; 

                        }else if(GroupUserRole == 'Admintrator')	
					    {
                           group_html1 +="<h5>Full administrators</h5><p class=''>Full rights: invite and manage users, view activity reports, manage permissions and Q&A section</p>";  
					    	
					    }else{

                            group_html1 +="<h5>Individual users</h5><p class=''>Access to: personal notes, own activity and communication with Q&A coordinators</p>"; 

                        }

                        group_html2 +="<h5>Collaboration with</h5><p>"+group_collaboration+"</p>"; 


                        group_html3 +="<h5>Access to data room</h5><p class=''>till "+security_setting+"</p>";

                        group_html4+="<h5>Group questions limit</h5><p>"+QA_limit+"</p>";

                    });
 
                                    // group info
                                    $('.group_user_role').html(group_html1);
                                    $('.group_collaboration_setting').html(group_html2);
                                    $('.group_security_setting').html(group_html3);
                                    $('.group_qa_setting').html(group_html4);
                                      
                                     //group Users

                                     $('.group_user_listing').html(user_html1);

		                            }

		                       }); 


                 });

      }
      else if(numberOfChecked == 0)
      {
        
      	$('.delete_group').addClass('hidden');
      	$('.list_group_user').addClass('hidden');
      	// 21 nov

      	$('.EnterGroupByinvite').removeClass('hidden');
		$('.GroupByinvite').removeClass('hidden');
        $('.security_setting').addClass('hidden');
		$('.access_Ques_ans').addClass('hidden');


		var project_id = $('#project_id').val();


      }else{

      	 $('.list_group_user').addClass('hidden');
      	 $('.delete_group').addClass('hidden'); 
      	 $('.delete_group').removeClass('hidden');
      	 $('.GroupByinvite').removeClass('hidden');

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


 $(document).on('change','input:radio',function(){
        
    if ($(this).val() == "Individual_users") {
       
       $('#create_group .security_setting').addClass('hidden');
       $('#create_group .questions_limit').addClass('hidden');
       $('#create_group .collaboration_setting').addClass('hidden');

    } else{
 
       $('#create_group .security_setting').removeClass('hidden');
       $('#create_group .questions_limit').removeClass('hidden');
       $('#create_group .collaboration_setting').removeClass('hidden');
    }

 });


 $(document).on('click','.InviteUsers_icon',function(){

	 	$('input:checkbox').prop('checked', false);
	 	$('#invite_users').modal('show'); 
	    $(this).parent().parent().find('.check-box-input').trigger( "click");
        var data_value = $(this).parent().parent().find('.check-box-input').data('value');

        var data_permission = $(this).parent().parent().find('.check-box-input').data('per');

        if(data_permission == 0)
        {
        	$('#document_permission_modal').modal('show');

        }

       	$('.GroupByinvite').addClass('hidden');
	 	$('.security_setting').removeClass('hidden');
	 	$('.access_Ques_ans').removeClass('hidden');
	 	$('.EnterGroupByinvite').addClass('hidden');
      
 });

 // delete group 


  $(document).on('click','.delete_items_groups',function(){
    
    var token = $('#csrf-token').val();
    var project_id = $('#project_id').val();

    var deletePath = [];

    $.each($("input[name='groups_select']:checked"), function(e)
    {        
        
          deletePath.push($(this).data('value')); 

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
                               project_id: project_id,
                            },  

                            // multiple data sent using ajax//
                            success: function (response) {
                              
                             if (response = "deleteGroup") {

                                getgroups();

                                $("input[name='groups_select']").prop("checked","false");
                                $(".check-box-input-main").prop("checked","false");
                               
                             }
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
				
					$.each( response, function( key, value) {

                       var group_id = value.id;
                       var GroupUserRole = value.group_user_type;

					   html1 += " <option value='"+value.id+"'>"+value.group_name+"</option>";

					});
                     
                    $('.group_type_collaboration').html(html1);

                       
			}  
		}); 
}
	
// });

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
                             
                            swal("permission set successfully", "", "success");

                            getgroups();

                            DocumentTree(token,project_id);

                        }
 
                      }

                });
                       
   });


   $(document).on('click','.permission_cancle',function(){

        var group_id =  $(this).attr('group');

        $('#group'+group_id+' input:checkbox' ).prop('checked', false);
        $('.all_groups input:checkbox' ).prop('checked', false);

   });

    $(document).on('click','.permission_cancle_main',function(){

     $('#document_permission_modal input:checkbox').prop('checked', false);

   });

    // set the permission

    $(document).on('click','.permission_docs',function(){
          
          var permission_doc = $(this).data('value');

          $('#document_permission_modal').modal('show');
          
          var triggerEvent  = $('.document_permission [data-value = "'+permission_doc+'"]').click();

    });



</script>
@endsection