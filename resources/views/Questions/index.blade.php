@extends('layouts.app_ques_answer')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

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
						      <div class="new_filter">
						          <select>
						            <option>New</option>
						            <option>Last 24 hours</option>
						            <option>Last 48 hours</option>
						            <option>Last 7 days</option>
						            <option>Last 30 days</option>
						          </select>
						      </div>

						      <div class="search_document_Byname">
						          <input type="text" name="search_filter" class="search_filter">
						          <i class="fas fa-search"></i>
						      </div>
						   </div>
						   <div class="back_arrow_qa move_last_folder_qa">
						     {{$project_name}}
						   </div>
						</section>

						   <div class="upload_table">
						        <div class="row document_index_buttons"> 
						    <div class="btn_upload" permission ='1'>
						    <a  class="btn  document-btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-comment-o"></i>New Question
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
                		<span>To:</span>
			             <div class='reply_ques_docs_group'> 
			                 <select class="multipleSelectUsers" multiple name="language">
			                 </select>
			             </div>
			             <div class="reply_subject_section">
			                <span class="reply_subject_title">Subject:</span>
			                <input type="text" class="reply_subject">
			             </div>
			             <div class="reply_content_section">
				              <textarea class="reply_question_content" data-value="0" rows="6" cols="55"> 	
				              </textarea>
			             </div>
			         </div>
			         <div class="cancle_reply_type">
                        <i class="fas fa-trash-alt"></i>
			         </div>
			         <button class='question_reply_qa btn btn-success'>Reply</button>
                </div>
			</div>
		</div>	
	</div>
</div>
@endsection