@extends('layouts.app_ques_answer')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

	 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
     <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />

     <input type="hidden" name="projects" class="project_name_in"  value="{{$project_name}}"/>
      <input type="hidden" value='{{Auth::user()->email}}' id ='AuthEmailOfProject'>

     <input type="hidden" name="slug_folder" class="slug_folder" />

     <input type="hidden" name="current_dir" class="current_dir" id="current_directory" value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>
     

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" class='current_dir_qa'>
			<input type="hidden" class='project_id_qu' value="{{$project_id}}">
			<input type='hidden' class='project_name_qu' value='{{$project_name}}'>

			<input type="hidden" class='auth_name' value='{{ Auth::user()->name }}'>

			<div class="col-md-3">
			    <div class="folder_and_file_tree_qa">
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
		    </div>
			<div class="document_index_contentable col-md-4">
					<div class="menu_option_block">
						   
						    <section class="content-header">
						   
						    <div class="search_filter_document">
						   <!--    <div class="new_filter">
						          <select>
						            <option>New</option>
						            <option>Last 24 hours</option>
						            <option>Last 48 hours</option>
						            <option>Last 7 days</option>
						            <option>Last 30 days</option>
						          </select>
						      </div> -->

						      <div class="search_document_Byname">
						          <input type="text" name="search_filter" class="search_filter" placeholder="Search by question subject">
						          <span class="search_filter_btn">
						          <i class="fas fa-search"></i>
						      </span>
						      </div>
						   </div>
						   <div class="back_arrow_qa move_last_folder_qa">
						     {{$project_name}}
						   </div>
						   <div class="filteredTextContent hidden">
						       <div class="text_filter"></div>
						       <span class="icon_close_filter"><i class="fa fa-times" aria-hidden="true"></i></span>
						    </div>
						</section>

						   <div class="upload_table">
						        <div class="row document_index_buttons"> 
						    <div class="ques_create_new" permission ='1'>
						    <a  class="btn  document-btn" data-toggle="modal" data-target="#genrate_question"><i class="fa fa-comment-o"></i>New Question
						    </a> 
						    </div>
						    <div class="btn_upload hidden" permission ='1'>
						    <a class="btn  folder document-btn1" data-toggle="modal" data-target="#genrate_folder">Priority</a>
						    </div>
				            <div class="delete_items hidden" permission = "3">
				             <a class="btn delete_items_documents " ><i class='fas fa-trash-alt'></i></a>
				            </div>
				              </div>
				                <div class="btn-export">
				                  <a class="btn btn_export_doc" ><i class="fa fa-table"></i> Export</a>
				                </div>

				                 <div class="btn-dote hidden">
				                  <a class="btn btn_dote_doc" >. . .</a>
				                </div>
				         </div>

	              <div class="table_section document_scroll">
	        
	                    <div class="table table-hover table-bordered table_color ">
	                        <div class="check-box select_check_new">
	                            <form  action="#" method="post">
	                             	<input type="checkbox" class="check-box-input-main">
	                             </form> 
	                             <span class="index-and-name">priority</span>
	                        </div>
	                    </div>         
	                    <div id="document_index_content" >
	                            <div class="documents_index_section">
	                                <div class="indexing_qu">
	                                	
	                                </div>
	                        </div>     				               
				    </div>
			</div>
			
		</div>
	</div>
	<div class="col-md-5">
		<div class='reply_section hidden'>
			<input type="hidden" class='reply_question_id'>
			<input type='hidden' class='reply_document_name'>
			<div class='reply_header'>
			<div class='header_left'>
				<h4 class='header_subject'></h4>
				<div class='relate_header'><span>Related to:</span><p class='doc_name_header'></p></div>
			</div>
			<div class='right_header'>

			</div>
		</div>
		<div class="main_question_container">
			<div class='reply_question_section'>
				<div class="main_question_section">
			    	<button class="ques_ans_list action_button"> 
			    		<div class='question_block_up'>
			    			<div class='question_block_first'>
			    		        <H4 class='sender_name'></H4>
                                <p class='subject_ques'></p>
                                <p class="to"></p>
                             </div>
                             <div class='question_block_second'>
                                <div class='question_action_move'><span class='reply_all_ques'><i class='fa fa-reply-all'></i></span> <span class='frwd_ques'><i class='fa fa-share'></i></span></div><div class='remove_question'></div>   
			    		        <p class="date_section"></p>
			    		    </div>
			    		</div>
			    		<div class='question_block_bottom'>
			    		    <p class='content_ques'></p>
			    		</div>
			    	</button>
				</div>
				<div class='replied_content_block'>	
					<div class='replied_container'>
						<!--  reply answer here -->
					</div>
				</div>
			</div>
			<div class='reply_answer_section'>
                <div class="reply_answer">
                	<p clas='click_here_reply'>
                		<i class="fa fa-pencil"></i> Click Here to reply
                	</p>
                </div>
                <div class="reply_editor hidden">
                   <div class="reply_center">
                		<div class='reply_ques_docs_group' id="reply_user"> 
                			 <span class='reply_to'>To:</span>
			                 <select class="multipleSelectUsers" multiple name="language">
			                 	<option selected value="{{Auth::user()->email}}">Q&A coordinators</option>
			                 </select>
			             </div>
			             <div style="display: none;" id="alert_reply_user"></div>

			             <div class="reply_subject_section">
			                <span class="reply_subject_title">Subject:</span>
			                <input type="text" class="reply_subject" id="reply_subject">
			             </div>

			             <div style="display: none;" id="alert_reply_subject"></div>

			             <div class="reply_content_section">
				              <textarea class="reply_question_content" id ="reply_content" data-value="0" rows="6" cols="55"> 	
				              </textarea>
			             </div>

			             <div style="display: none;" id="alert_reply_content"></div>
			         </div>
			         <div class="cancle_reply_type">
                        <i class="fas fa-trash-alt"></i>
			         </div>
			         <button class='question_reply_qa btn btn-success'>Send</button>
                </div>
			</div>
		</div>
		</div>	
	</div>
</div>


<div id="genrate_question" class="modal fade" role="dialog">
  <div class="modal-dialog create_question">
    <input type='hidden'  name='copy_document' id='copy_document_directory'>
    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title">NEW QUESTION</h4>
        <div class="related_question_by">
          <span>Related To:</span>
          <span class="back_arrow_qa move_last_folder_qa"></span>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body">
        <div class="form">
          <div id="directory_current">
            <form action="javascript:void(0)" id="create_question_answer" method="post" >

             <input type="hidden" name="doc_path" id="doc_path_directory"/>
             <input type='hidden' class='related_to_doc'>
             <div class='ques_ans_docs_group' id="user_select">

              <span class="to_user">To:</span>       
              <select class="multipleSelectUsers" multiple name="language"><option selected value="{{Auth::user()->email}}">Q&A coordinators</option></select>
             </div>
             <div style="display: none;" id="alert_user_select"></div>

             <div class="subject_section">
                <span class="subject_title">Subject:</span>
                <input type="text" class="question_subject" id="question_subject">
             </div>

             <div style="display: none;" id="alert_question_subject"></div>

             <div class="question_content_section">
              <textarea class="question_content" id="question_content" data-value="0" rows="10" cols="55"></textarea>
             </div>

             <div style="display: none;" id="alert_question_content"></div>
           </form>
         </div>
       </div>
     </div>
    <div class="modal-footer">
    	
      <input type="button" value="Send" name="submit" class="send_question">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    </div>
  </div>
        
</div>
</div>
@endsection


