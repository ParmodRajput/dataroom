@extends('layouts.app_ques_answer')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" class='current_dir_qa'>
			<input type="hidden" class='project_id_qu' value="{{$project_id}}">
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
	<div class="col-md-5">fgfsdf</div>	
</div>
@endsection