@extends('layouts.app')
@section('content')
<!-- right click oprn the popup window for document -->
<div class="rightClickPopUpWithOutValue">
   <div class='drop-menu_option'>
      <ul  class='context-menu_list_document'>
         <li class='ng-scope' >
            <a href='{{Url("/")}}/project/{{$project_id}}/documents' target="_blank">
               <i>
                  <i class="fas fa-external-link-alt"></i>Open in new browser tab
            </a>
         </li>
         <input type="hidden"  id="CurrentUrltildf">
         <li  class='ng-scope copy_url_document'>
         <a href='javascript:void(0)'></i>
         <i class="fas fa-link"></i>
         Copy Link</a>
         </li>
         <li class='ng-scope paste'>
            <a href='javascript:void(0)' class='In_paste_document'></i> <i class='fas fa-paste'></i> Paste
            </a>
         </li>
      </ul>
   </div>
</div>
<!--  rigth click open the option popup for more action of document. -->
<div class='right_click drop-holder'>
   <input type="hidden" class="checkToActionPopValue">
   <div class='drop-menu'>
      <ul  class='context-menu_list'>
         <li class='ng-scope new_tab'>
            <a href='{{Url("/")}}/project/{{$project_id}}/documents' target="_blank">
               <i>
                  <i class="fas fa-external-link-alt"></i> Open in new browser tab
            </a>
         </li>
         <li class='ng-scope view_doc_file'>
         <a href='javascript:void(0)' target="_blank"></i><i class='fas fa-eye'></i> view</a>
         </li> 
         <li   class='ng-scope history_of_action'>
            <a href='{{ Url("/")}}/project/{{$project_id}}/reports' target="_blank"></i><i class="fas fa-history"></i>History of Action</a>
         </li>
         <li   class='ng-scope history_of_action'>
            <a href='javascript:;' data-toggle="modal" data-target="#ShareDoc"></i><i class="fa fa-share-alt" aria-hidden="true"></i>Share</a>
         </li>
         <li   class='ng-scope question_create_doc'>
            <a href='javascript:void(0)'></i><i class="fa fa-comment-o"></i> New Question</a>
         </li>
         <li class='ng-scope download' >
            <a href='javascript:void(0)'>
               </i> <i class='fas fa-download'></i> Download<span class='download_file'>
               <form action='{{url('/project/documents/download')}}' method='post'>
               <input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>
               <input type='hidden' name='download' id="down-document">
               <input type='submit' name='submit'>
               </input>
               </form>
               </span>
         </li>
         <li class='ng-scope paste' >
         <a href='javascript:void(0)' class='In_paste_document'></i><i class='fas fa-paste'></i> Paste</a>
         </li>
         <li class='ng-scope' >
            <a href='javascript:void(0)' class='copied_document' ></i><i class="fa fa-clone" aria-hidden="true"></i> Copy</a>
         </li>
         <li class='ng-scope' data-toggle='modal' data-target='#renameDocument' >
            <a href='javascript:void(0)' class='rename_document'></i><i class="far fa-edit"></i> Rename</a>
         </li>
         <li class='ng-scope extract'>
            <a href='javascript:void(0)' class='extractDocument'></i> <i class="far fa-file-archive"></i> Extract here
            </a>
         </li>
         <li class='ng-scope' >
            <a href='javascript:void(0)' ></i><span class='delete_item'> <i class='fas fa-trash-alt'></i> Delete</span>
            </a>
         </li>
      </ul>
   </div>
</div>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="row document_content_index">
      <input type="hidden" class="single_select_doc" id="single_select_doc">
      <input type="hidden" id ='CheckUserChangePermission'>
      <input type="hidden" value='{{Auth::user()->email}}' id ='AuthEmailOfProject'>
      <input type="hidden"  id ='currentUserCount'>
      <div class="document_index_contentable col-md-9">
         <div class="menu_option_block">
            <section class="content-header">
               <div class="search_filter_document">
                  <div class="fav_filter">
                     <span><i class="fa fa-star-o"></i></span>
                  </div>
                  <!--       <div class="new_filter">
                     <select>
                     <option>New</option>
                     <option>Last 24 hours</option>
                     <option>Last 48 hours</option>
                     <option>Last 7 days</option>
                     <option>Last 30 days</option>
                     </select>
                     </div> -->
                  <div class="search_document_Byname">
                     <input type="text" name="search_filter" class="search_filter" id='search_doc_content'>
                     <span id='go_search_doc'><i class="fas fa-search"></i></span>
                  </div>
               </div>
               <div class="searchTextAndCurrentDirectory">
                  <div class="back-arrow move_last_folder">
                     {{$project_name}}
                  </div>
                  <div class="filteredTextContent hidden">
                     <div class="text_filter"></div>
                     <span class="icon_close_filter"><i class="fa fa-times" aria-hidden="true"></i></span>
                  </div>
            </section>
            <!-- <iframe src="http://docs.google.com/gview?url={{url('public/16 wdfsdfsd_Index.pdf')}}&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
               -->
            <div class="upload_table">
            <div class="row document_index_buttons"> 
            <div class="btn_upload upload_doc_upload" permission ='1'>
            <a  class="btn  document-btn" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-upload " aria-hidden="true"></i> Upload
            </a> 
            </div>
            <div class="btn_upload" permission ='1'>
            <a  class="btn  folder document-btn1" data-toggle="modal" data-target="#genrate_folder"> <i class="fa fa-plus" aria-hidden="true"></i> Create Folder</a>
            </div>
            <div class="btn_upload" permission ='2'> 
            <div class="btn-group">
            <a class="btn  dropdown-toggle document-btn" data-toggle="dropdown" href="#">
            <i class="fa fa-download" aria-hidden="true"></i> Download
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
            @if($CurrentGroupUser == 'Administrator')
            <div class="btn_upload">
            <a class="btn  document-btn1 doc_permission_modal"><i class="fas fa-lock"></i> Permissions</a>
            </div>
            @endif  
            <div class="delete_items hideDeleteBtn" permission = "3">
            <a class="btn delete_items_documents " ><i class='fas fa-trash-alt'></i> Delete</a>           
            </div>
            <div class="share_items">
            <a class="btn share_items_documents hidden " data-toggle="modal" data-target="#ShareDoc"><i class="fas fa-share-alt"></i> Share</a>           
            </div>
            </div>
            <div class="btn-export">
            <a href="{{ url('/') }}/downloadExcel/xlsx" class="btn btn_export_doc"><i class="fa fa-table"></i> Export</a>
            </div>
            <div class="btn-dote hidden">
            <a class="btn btn_dote_doc" >. . .</a>
            </div>
            <div class="row document_index_recycle_bin hidden"> 
            <div class="btn_deleteAllBackup">
            <a  class="btn  document-btn ">
            <i class='fas fa-trash-alt'></i> Empty Recycle bin
            </a> 
            </div>
            <div class="btn_restore_recycle_doc">
            <a  class="btn  folder document-btn1"> <i class="fas fa-undo"></i> Restore</a>
            </div>
            <div class="btn_delete_doc_recycle hideDeleteBtn">
            <a class="btn document-btn delete_recycle_documents " ><i class='fas fa-trash-alt'></i> Delete</a>           
            </div>
            <div class="btn_upload">
            <!-- <a class="btn document-btn" id="">...</a>   -->         
            </div>
            </div>
            </div>
            <div class="table_section document_scroll">
            <div class="table table-hover table-bordered table_color ">
            <div class="check-box select_check_new"><form  action="#" method="post"><input type="checkbox" class="check-box-input-main"></form> 
            <span class="index-and-name">Index and name</span>
            </div>
            <div class="fav_docs">
            <span><i class="fa fa-star-o"></i></span>
            </div>
            <div class="notes_docs black_notes">
            <span><i class="fa fa-thumb-tack"></i></span>
            </div>
            <div class="ques_ans_docs black_ques_ans">
            <span><i class="fa fa-comment-o"></i></span>
            </div>
            <div class="permission_docs black_permission">
            <span><i class='fa fa-lock' aria-hidden='true'></i></span>
            </div>
            </div>
            <div class="table table-hover table-bordered table_color recycle_bin hidden">
            <div class="check-box select_check_recycle"><form  action="#" method="post"><input type="checkbox" class="check-box-input-main" ></form> 
            <span class="index-and-name">Index and name</span>
            </div>
            <div class="delete_from">
            <span>Delete_from</span>
            </div>
            <div class="delete_time">
            <span>Delete_time</span>
            </div>
            </div>           
            <div id="document_index_content" >
            <div class="drop_box_document">
            <div class="document_index index-drop droppable ui-droppable notMoveInDiv" id='upFolerTogo'>
            <div class="doc_index_list">
            <h4> 
            <div class="upone" onclick="upone_folder();">
            <i class="fas fa-arrow-up custom upone-folder" ></i>
            <div class="back-arrow">{{$project_name}}</div>
            </div>
            </h4>
            </div>
            </div>
            </div>
            <div class="documents_index_section">
            <div class="indexing" ></div>
            </div>
            </div>
            <div class="choose_file_upload overlay"  id="overlay"><form action="upload_file" method="post"  id ="AllUploadFiles" enctype="multipart/form-data"  files ="true" >
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="projects" class="project_name"  id='getProject_name'value="{{$project_name}}"/>
            <input type="hidden" name="projects_id" class="projects_id"  value="{{$project_id}}" />
            <input type="hidden" name="current_dir" class="current_dir_down" id="current_directory" value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>
            <div class="selected_file_uploaded"><input type="file" name="file[]" id="file_name" multiple required />
            <div class="bottom_position">
            <span>
            <img src="{{ asset('dist/img/white_upload_cloud.png') }}" border="0" alt="img">
            </span>
            <div class="drop_document">Drop Documents Here</div>
            </div>
            </div><input type="submit" value="Upload" name="upload_file" class="btn btn-success hidden" id="submit_upload_file"></form></div>
            </div>
            </div>
         </div>
         <div class="col-md-3 document_view_block">
            <input type="hidden" id="checkNotesAlreadyCreate" value="0">
            <input type="hidden" id="current_directory_project" value="public/documents/{{Auth::user()->id}}/{{$project_name}}">
            <div class="aside-bar-holder">
               <div class="doc_details">
                  <p class="checked_doc_details"></p>
               </div>
               <div class="file_view_aside"></div>
               <div class="create_notes_get hidden">
                  <p>NOTES</p>
                  <div class="create_new_notes_get">
                     <span class="create_note_aside "> <i class="fa fa-pencil"></i> <a href="javascript:void(0)"> Add new</a></span>
                     <span class="close_note_aside hidden">Cancel</span>
                  </div>
               </div>
               <div class="file_name_aside"></div>
               <div class="notes_aside">
                  <!--  <div class="notes_aside_3 hidden">
                     <textarea class="notes_aside_text3" data-value ="3" placeholder="Enter text here..." rows="6" cols="28"></textarea>
                     <button class="submit_note3_doc">Add</button>
                     </div>
                     <div class="notes_aside_2 hidden">
                     <textarea class="notes_aside_text2" data-value ="2" placeholder="Enter text here..." rows="6" cols="28" ></textarea>
                     <button class="submit_note2_doc">Add</button>
                     </div> -->
                  <div class="notes_aside_1 hidden"></div>
               </div>
               <div class="shareview"></div>
            </div>
         </div>
      </div>
      <input type="hidden" name="projects" class="project_name"  value="{{$project_name}}" />
   </div>
   <!-- Create new Folder Model-->
   <div id="genrate_folder" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
      <div class="modal-dialog create_folder">
         <input type='hidden'  name='copy_document' id='copy_document_directory'>
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Create Folder</h4>
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
                        <input type="text"  id="folder_created" name="create_folder"  placeholder="Enter folder name" class="created_folder" />
                        <input type="button" value="create" name="submit" class="submit_folder" >
                     </form>
                     <div id="alert_create_folder" style="display: none"></div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!--end create folder-->
   <!--upload file model-->
   <div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
      <div class="modal-dialog modal_upload">
         <!-- Modal content-->
         <div class="modal-content upload_file_pannel">
            <div class="modal-header ">
               <h4 class="modal-title ">Upload Documents</h4>
               <p class="folder_to_upload">to folder : {{$project_name}}  </p>
               <span id="total_file"></span>
               <button type="button" class="upload_folder_close close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body scroll_upload_section">
               <div class="form">
                  <div class="directory_location">
                     <form action="upload_file" method="post"  id ="Allfiles"enctype="multipart/form-data"  files ="true" >
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />  
                        <input type="hidden" name="projects_id" class="projects_id" id="project_id_doc" value="{{$project_id}}" />
                        <input type="hidden" name="current_dir" class="current_dir" id="current_directory" value="public/documents/{{Auth::user()->id}}/{{$project_name}}"/>
                        <div class="choose_file_upload">
                           <div class="choose_upload_document">
                              <input type="file" name="file[]" id="file" multiple required />
                              <input type="submit" value="Upload" name="upload" class="btn btn-success hidden" id="submit_create_post">
                     </form>
                     <span>
                     <img src="{{ asset('dist/img/folder.png') }}" border="0" alt="img">
                     Drop Documents Here
                     </span>
                     </div>   
                     </div>
                     <div class="file_status">
                        <div class="row upload_file_details">
                           <div class="col-md-12 uplod_head_details">
                              <div class="col-md-6">
                                 <h4>Name</h4>
                              </div>
                              <div class="col-md-4">
                                 <h4>File Size</h4>
                              </div>
                              <div class="col-md-2">
                                 <h4>Status</h4>
                              </div>
                           </div>
                        </div>
                        <div id="fileDetails"></div>
                     </div>
                     <div class='choose_here_upload '>
                        <button class='choose_around_file hidden btn btn-success'>Choose here</button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer upload_modal_check hidden">
               <div id="progress-div">
                  <div id="progress-bar"></div>
               </div>
               <div id="targetLayer"></div>
               <input type="submit" value="Upload"  class="btn btn-success changedFileTarget" id="Upload_files">
            </div>
         </div>
      </div>
   </div>
</div>
<!--end upload file -->
<!-- rename folder and file modal
   -->
<div id="renameDocument" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
   <div class="modal-dialog create_folder">
      <input type='hidden'  name='copy_document' id='copy_document_directory'>
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">RENAME</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
         </div>
         <div class="modal-body">
            <div class="form">
               <div id="directory_current">
                  <form action="javascript:void(0)" id="document_rename_form" method="post" >
                     <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                     <input type="hidden" id="renameDocumentUrl" class="renameDocumentUrl">
                     <input type="hidden" id="renameDocumentFullPath" class="renameDocumentFullPath">
                     <input type="text"  id="renameDocumentContent"  name="renameDocument" class="renameDocument" />
                  </form>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <input type="button" value="Ok" name="submit" id="submit_rename_document"class="btn btn-success">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
</div>
<!-- end rename modal -->
<!-- Document permission modal -->
<div id="document_permission_modal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
   <div class="modal-dialog new_permission_setup">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h3>DOCUMENTS' PERMISSIONS</h3>
            <button type="button" class="close_permission_modal">&times;</button>
         </div>
         <div class="modal-body scroll_permissionDoc_section">
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
                                       ?> data-value="public/documents/{{$projectCreaterId}}/{{$project_name}}">
                                       <span class="document_name">{{$project_name}}</span>
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
            <button type="button" class="btn btn-success" id="permission_store">Apply</button>
         </div>
      </div>
   </div>
</div>
<!-- End -->
<!-- Question modal -->
<div id="genrate_question" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
   <div class="modal-dialog create_question">
      <input type='hidden'  name='copy_document' id='copy_document_directory'>
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title">NEW QUESTION</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
         </div>
         <div class='related_question_by'>
            <span>Related To:</span>
            <span class='related_question'></span>
         </div>
         <div class="modal-body">
            <div class="form">
               <div id="directory_current">
                  <form action="javascript:void(0)" id="create_question_answer" method="post" >
                     <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                     <input type="hidden" name="slug_folder" class="slug_folder" />
                     <input type="hidden" name="doc_path" id="doc_path_directory"/>
                     <div class='ques_ans_docs_group'>
                        <span class="to_user">To:</span>     
                        <select class="multipleSelect" id="users" multiple name="language">
                           <option selected value="{{Auth::user()->email}}">Q&A coordinators</option>
                        </select>
                     </div>
                     <div style="display:none;" id="alert_users"></div>
                     <div class="subject_section">
                        <span class="subject_title">Subject:</span>
                        <input type="text" class="question_subject" id="subject">
                     </div>
                     <div style="display: none;" id="alert_subject"></div>
                     <div class="question_content_section">
                        <textarea class="question_content" data-value="0" rows="10" cols="55" id="ques_content"></textarea>
                     </div>
                     <div style="display: none;" id="alert_ques_content"></div>
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
<!-- End -->
<!-- invite Users open if have no group for invite the user. -->
<div id="AddUserToInvite" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
   <div class="modal-dialog yet_PermissionFuser">
      <input type='hidden'  name='copy_document' id='copy_document_directory'>
      <!-- Modal content-->
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title">DOCUMENTS' PERMISSIONS</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
         </div>
         <div class="modal-body">
            <div class="section">
               <img src="{{asset('/dist/img/')}}/permission_img.png" alt="img" />
               <h3>You have no users to assign permissions yet</h3>
               <a class="invite" href="{{url('/')}}/project/{{$project_id}}/users">Invite</a>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- End -->
<!-- Share Document modal -->
<div id="ShareDoc" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
   <div class="modal-dialog invite_new_user_block">
      <input type='hidden'  name='copy_document' id='copy_document_directory'>
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h3>Share Document</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body share_modal_sec">
            <div class="center_section">
               <div class="center_inner">
                  <h2>Share With Users <i class="fa fa-user-plus"></i></h2>
                  <div class="dynamic_input">
                     <input type="text"  name ="user_email" class="form-control shareDocUsers" data-role="tagsinput" placeholder="Enter email,use enter or comma to separate">
                     <div class="error_email hidden" style='color:red'>Please Enter Valid Email</div>
                  </div>
               </div>
               <div class="center_inner">
                  <h2>Title</h2>
                  <div class="dynamic_title">
                     <input type="text"  name ="email_title" class="form-control shareDocEmailTitle" data-role="emailtitle" placeholder="Enter  Title">
                     <div class="error_email hidden" style='color:red'>Please Enter Title</div>
                  </div>
               </div>
               <div class="center_inner view_duration">
                  <h3>View Duration</h3>
                  <div class="radio_pannel">
                     <div class="radio_btns" style='width:20%'>
                        <label>
                        <input name="view_duration_e" value='1' type="radio" checked /><strong>Next 3 days</strong>
                        </label>
                        <label>
                        <input type="radio" value='2' name="view_duration_e"/><strong>Next 7 days</strong>
                        </label>
                        <label>
                        <input type="radio" value='3' name="view_duration_e"/><strong>Next 15 days</strong>
                        </label>
                        <label>
                        <input type="radio" value='4' name="view_duration_e" /><strong>Next 1 Month</strong>
                        </label>
                        <label>
                        <input type="radio"  value='5'name="view_duration_e"/><strong>Custom Date</strong>
                        </label>
                     </div>
                     <div class="custom_date hidden">
                        <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                           <input class="form-control" id="duration_time_val" type="text" readonly />
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <div class="center_inner Registration_required ">
                  <h3>Registration Required</h3>
                  <div class="radio_pannel">
                     <div class="radio_btns">
                        <label>
                        <input type="radio" name="Registration" value='1' id="viewed_doc" checked><strong>Yes</strong><br>
                        <span class="radio_down_content">View document with registration</span>
                        </label>
                        <label>
                        <input type="radio" name="Registration" value='0' ><strong>No</strong><br>
                        <span class="radio_down_content">View document without registration</span>
                        </label>
                     </div>
                  </div>
               </div>
               <br>
               <div class="center_inner Printable ">
                  <h3>Printable</h3>
                  <div class="radio_pannel">
                     <div class="radio_btns">
                        <label>
                        <input type="radio" name="Printable" value='1' id="viewed_doc" checked><strong>yes</strong><br><span class="radio_down_content">Document print accessiable</span>
                        </label>
                        <label>
                        <input type="radio" name="Printable" value='0' ><strong>No</strong><br>
                        <span class="radio_down_content">Document print not accessiable</span>
                        </label>
                     </div>
                  </div>
               </div>
               <div class="center_inner Downloadable ">
                  <h3>Downloadable</h3>
                  <div class="radio_pannel">
                     <div class="radio_btns">
                        <label>
                        <input type="radio" name="Downloadable" value='1' id="viewed_doc" checked><strong>Yes</strong><br>
                        <span class="radio_down_content">Document download accessiable</span>
                        </label>
                        <label>
                        <input type="radio" name="Downloadable" value='0' ><strong>No</strong><br>
                        <span class="radio_down_content">Document not download accessiable</span>
                        </label>
                     </div>
                  </div>
               </div>
               <br>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id='shareDocForUsers' class="btn btn-primary">Share</button>
         </div>
         </form>
      </div>
   </div>
</div>
<!-- End -->
@endsection