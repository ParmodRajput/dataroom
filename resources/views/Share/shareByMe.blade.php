@extends('layouts.app_groups')
@section('content')

<style>
	

		*:focus{
		    outline: none;
			box-shadow: none;
			border: none;
		}

		.left-one {
		    /*float: left;*/
		   /* width: 30%;*/
		    padding-left: 15px;
		}

		.left-one label {
		    width: 100%;
		    display: block;
		    background: #fbfbfb;
		    padding: 10px;
		    margin-bottom: 8px;
		    border: 1px solid #f3f3f3;
		    border-radius: 4px;
		    cursor: pointer;
		}

		.left-one label input[type="checkbox"], .left-one label input[type="radio"] {
		    margin-right: 5px;
		}

		.left-one.set-value span {font-weight: bold;margin-bottom: 6px;display: block;}

		.left-one.set-value li {
		    padding-bottom: 15px;
		}
</style>

<div class="padding_top_users"></div>
 <div class="list-panel row">
 	<div class="header_title"><h4>Shared By Me</h4></div>
 	<input type="hidden" id='project_id' value="{{$project_id}}">
 	<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>
 	<div class="col-md-12">
	<div class="left-one col-md-4 shared_Doc_listing">
		<ul>
		    <li>
			<label><input type="checkbox"/> Folder Name Androi</label>
			</li>
			
		</ul>
	</div><!--left one close-->
		
		<div class="left-one col-md-4">
		<ul>
		<li>
			<label><input type="checkbox"/> Folder Name Androi</label>
			</li>
			
			<li>
			<label><input type="checkbox"/> Folder Name</label>
			</li>
			
			<li>
			<label><input type="checkbox"/> Folder Androi</label>
			</li>
			
			<li>
			<label><input type="checkbox"/> Androi Folder Name </label>
			</li>
			
			<li>
			<label><input type="checkbox"/> Set Folder</label>
			</li>
		</ul>
		</div><!--left one close-->
		
		<div class="left-one set-value col-md-4">
		<ul>
		<li>
			<span>Registeration Required</span>
			<label><input type="radio"/> Yes</label>
			<label><input type="radio"/> No</label>
			</li>
			
			<li>
			<span>Printable</span>
			<label><input type="radio"/> Yes</label>
			<label><input type="radio"/> No</label>
			</li>
			
			<li>
			<span>Downloadable</span>
			<label><input type="radio"/> Yes</label>
			<label><input type="radio"/> No</label>
			</li>
		</ul>
		</div><!--left one close-->
		
		</div>
	</div><!--list panel close-->

	<script type="text/javascript">

		$(document).ready(function(){
                  
                  getAllSharedDocByAuth();
                  

                  function getAllSharedDocByAuth(){

                  	var project_id = $('#project_id').val();
                    var token =$('#csrf-token').val();
                    var html = '';
                  	
                  	$.ajax({
                         
                         type:"POST",
                         url : "{{url('/')}}/sharedDoc/",
                         data:{

                         	project_id : project_id,
                         	_token     :token,

                         },
                         success: function (response) { 
                     
                          var getfolders = response.folder_index;

                          var getfiles = response.file_index;


			                if(getfolders == '' && getfiles == '')
			                {

			                  html +="<div class='emplty_box_drag_drop'><span class='drag_document_img'><img src='{{asset("dist/img/icon-blue.png")}}'></span><span class='drag_document_texts'>Drag and Drop files here to upload</span></div>";

			                 
			                }else{

			                	 $.each(getfolders,function(key ,value){
;
			                	 	var doc_name = value.document_name;
			                	 	var doc_path = value.path;

			                	 	html+='<ul><li><label><input type="checkbox" data-value='+doc_path+'/>'+doc_name+'</label></li></ul>';

			                	 });

			                	$.each(getfiles,function(key ,value){

                                  $.each(value,function(key ,value){



			                	 	var doc_name = value.document_name;
			                	 	var doc_path = value.path;

			                	 	alert(doc_path);

			                	 	html+='<ul><li><label><input type="checkbox" data-value='+doc_path+'/>'+doc_name+'</label></li></ul>';

			                	 });

                                  });
			                }


			             }//success



			            });//ajax

                  }//function


           });//dom


	</script>
@endsection