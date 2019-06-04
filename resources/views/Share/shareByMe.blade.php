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
		    margin-right: 10px;
		}

		.left-one.set-value span {font-weight: bold;margin-bottom: 6px;display: block;}

		.left-one.set-value li {
		    padding-bottom: 15px;
		}

		.left-one.col-md-4.shared_Doc_listing i {
           font-size: 18px;
        }

        .left-one.col-md-4.shared_Doc_listing {
		   
		    background: #E0E0E0;
		    padding-top: 19px;
        }
        .shared_Doc_listing{
        	overflow-y: scroll;
        }

        .shared_User_permission{

        	overflow-y: scroll;
        }
        .shared_User_permission li {
		    font-weight: bold;
		}

</style>

<div class="padding_top_users"></div>
	 <div class="list-panel row">
	 	<div class="header_title"><h4>Shared Document</h4></div>
	 	<input type="hidden" id='project_id' value="{{$project_id}}">
	 	<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>
		 	<div class="col-md-12">
				<div class="left-one col-md-4 shared_Doc_listing"></div><!--left one close-->
					
				<div class="left-one col-md-4 shared_User_listing">

				</div><!--left one close-->
					
				<div class="left-one set-value col-md-4 shared_User_permission hidden">	</div><!--left one close-->
				
			</div>
	</div><!--list panel close-->

	<script type="text/javascript">

		$(document).ready(function(){
                  
                  getAllSharedDocByAuth();

                  var windowHeight = $(window).height();

                  $('.shared_Doc_listing').css('height',windowHeight-115);
                  $('.shared_User_permission').css('height',windowHeight-115);
                  

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
                         	$.each(response,function(key ,value){
                              	var Shared_time = value.Shared_time;
		                	 	var doc_name = value.document_name;
		                	 	var document_id = value.document_id;
		                	 	var share_id   = value.id;
		                	 	var data_access = value.access_token;

		                	 	html+='<ul><li class="select_shared" data-access="'+data_access+'" data-value="'+document_id+'"><label><input type="checkbox" data-value='+share_id+'"/>'+Shared_time+'</label></li></ul>';
                              });
                        	$('.shared_Doc_listing').html(html);
			             }//success


			       	});//ajax

                  }//function

		          $(document).on('click','.select_shared',function(){

		              $('.shared_Doc_listing input:checkbox').prop('checked', false);
		              $(this).find('input:checkbox').prop('checked', true);
		              $('.shared_User_permission').addClass('hidden');

		              var dataDoc = $(this).data('value');
		              var project_id = $('#project_id').val();
		              var access_token = $(this).data('access');
                      var token =$('#csrf-token').val();
                      var html = '';
                      $.ajax({
                         
                         type:"POST",
                         url : "{{url('/')}}/GetSharedUser/",
                         data:{

                         	project_id : project_id,
                         	dataDoc   : dataDoc,
                         	access_token : access_token,
                         	_token     :token,

                         },
                         success: function (response) { 
                         		var html ='<div><h5>Shared with</h5></div><div>';
                              $.each(response,function(key ,value){

                              	var userEmail = value.Shared_with;
                              	var access_token = value.access_token;

                              	html+='<ul><li class="selectSharedUser" data-value="'+userEmail+'"data-access="'+access_token+'"><label><input type="checkbox"/>'+userEmail+'</label></li></ul>';

                              });
                              	html+='</div><div class="shared_User_file_listing"></div>';
                             $('.shared_User_listing').html(html);

                         }

                     });
                        
		          });//ajax



		          $(document).on('click','.selectSharedUser',function(){

		              $('.shared_User_listing input:checkbox').prop('checked', false);
		              $(this).find('input:checkbox').prop('checked', true);
		              $('.shared_User_permission').addClass('hidden');

		              var dataUser= $(this).data('value');
		              var project_id = $('#project_id').val();
		              var access_token = $(this).data('access');
                      var token =$('#csrf-token').val();
                      var html = '';
                       
                      //get permission


                      $.ajax({
                         
                         type:"POST",
                         url : "{{url('/')}}/GetSharedUser/Permissions/",
                         data:{

                         	project_id : project_id,
                         	dataUser   : dataUser,
                         	access_token : access_token,
                         	_token     :token,

                         },
                         success: function (response) { 
                         	var permission_ = response.Permission;

                         	var duration_time = permission_.duration_time;
                         	var register_required = permission_.register_required;
                          	var printable = permission_.printable;
                          	var downloadable = permission_.downloadable;
                         	const endDate = permission_.created_at;
							const startDate   = duration_time;
							const timeDiff  = (new Date(startDate)) - (new Date(endDate));
							const days      = timeDiff / (1000 * 60 * 60 * 24);

                         	var getfolders = response.folder_index;
                          	var getfiles = response.file_index;
                          	var html ='<div><h5>Shared file</h5></div><div>';
	                          	if(getfolders == '' && getfiles == ''){
				                	html +="<div class='emplty_box_drag_drop'><span class='drag_document_img'><img src='{{asset("dist/img/icon-blue.png")}}'></span><span class='drag_document_texts'>You have no any shared document.</span></div>";
				                }else{
				                	$.each(getfolders,function(key ,value){
		                              	var Shared_time = value.Shared_time;
				                	 	var doc_name = value.document_name;
				                	 	var document_id = value.document_id;
				                	 	var share_id   = value.shared_id;
				                	 	var data_access = value.access_token;

		                                html+='<ul><li class="select_shared_file" data-access="'+data_access+'" data-value="'+document_id+'"><label><input type="checkbox" data-value="'+share_id+'"/><i class="fa fa-folder-o"></i> '+doc_name+'</label></li></ul>';
                              		});
				                	
                              		$.each(getfiles,function(key ,value){
		                              	var Shared_time = value.Shared_time;
				                	 	var doc_name = value.document_name;
				                	 	var document_id = value.document_id;
				                	 	var share_id   = value.shared_id;
				                	 	var data_access = value.access_token;

		                                html+='<ul><li class="select_shared_file" data-access="'+data_access+'" data-value="'+document_id+'"><label><input type="checkbox" data-value="'+share_id+'"/><i class="fa fa-file-o"></i> '+doc_name+'</label></li></ul>';
                              		});
				                }

                                html+='<div><h5>Permissions</h5></div><ul><li class="view_duration_e"><span>View Duration</span><label><input name="view_duration_edit" type="radio"/ value="1"';
                                var Customduration = true;
                                if(days >= 2.0 && days <= 3){
                                  html+='checked';
                                  Customduration =false;
                                }
                                html+='>Next 3 days</label><label><input type="radio" name="view_duration_edit" value="2"/';
                                if(days >= 6.0 && days <= 7){
                                  html+='checked';
                                  Customduration =false;
                                }
                                html+='>Next 7 days</label><label><input type="radio" name="view_duration_edit" value="3"/';
                                if(days >= 14.0 && days <= 15){
                                  html+='checked';
                                  Customduration =false;
                                }
                                html+='>Next 15 days</label><label><input type="radio" name="view_duration_edit" value="4"';
                                if(days >= 29.0 && days <= 30){
                                  html+='checked';
                                  Customduration =false;
                                }
                                html+='/>Next 1 Month</label><label><input type="radio" name="view_duration_edit" value="5"';
                                if(Customduration ==true){
                                	html+='checked />Custom Date</label></li><div class="custom_date"><div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd"><input value="'+duration_time+'" class="form-control" id="duration_time_val" type="date"/><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div></div>';
                                }else{
                                	html+='/>Custom Date</label></li><div class="custom_date hidden"><div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd"><input class="form-control" id="duration_time_val" type="date"/><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div></div>';
                                }
                                if(register_required == 1)
	                              {
	                                   html+='<li class="register_required_edit"><span>Registeration Required</span><label><input name="register_required_edit" value="1" type="radio" checked/> Yes</label><label><input name="register_required_edit" value="0" type="radio"/> No</label></li>';
	                              }else{

	                              	html+='<li  class="register_required_edit"><span>Registeration Required</span><label><input name="register_required_edit" value="1" type="radio" /> Yes</label><label><input value="0" type="radio" name="register_required_edit"checked /> No</label></li>';

	                              }

	                              if(printable == 1)
	                              {
	                                   html+='<li  class="print_edit"><span>Printable</span><label><input name="print_edit"  value="1" type="radio" checked/> Yes</label><label><input value="0" name="print_edit"  type="radio"/> No</label></li>';
	                              }else{

	                              	html+='<li  class="print_edit"><span>Printable</span><label><input value="1" name="print_edit" type="radio"/> Yes</label><label><input value="0" name="print_edit" type="radio" checked/> No</label></li>';

	                              }
	                              if(downloadable == 1)
	                              {
	                                   html+='<li class="download_edit"><span>Downloadable</span><label><input name="download_edit"  value="1"  type="radio" checked/> Yes</label><label><input name="download_edit"  value="0" type="radio"/> No</label></li></ul>';
	                              }else{

	                              	html+='<li  class="download_edit"><span>Downloadable</span><label><input name="download_edit" value="0"  type="radio" /> Yes</label><label><input value="0" name="download_edit" type="radio" checked/> No</label></li></ul>';

	                              }

	                              html+='<button class="permission_shareDoc_update btn btn-primary">Update</button>';

				                html+='</div>';
				                //console.log(html);
                              $('.shared_User_file_listing').html(html);


                         }


                     });
                        
		          });//ajax

			$(document).on('click','.select_shared_file',function(){
				//alert('dhjs');
				$('.shared_User_file_listing input:checkbox').prop('checked', false);
		   		$(this).find('input:checkbox').prop('checked', true);
		        $('.shared_User_permission').removeClass('hidden');

		              var document_id= $(this).data('value');
		              var project_id = $('#project_id').val();
		              var access_token = $(this).data('access');
                      var token =$('#csrf-token').val();
                      var shared_id = $(this).find('input:checkbox').data('value');
                      var html='';
			        $.ajax({

			              type : "POST",
			              url : "{{url('/')}}/share/documents/logaccess",
			              data : {  

			                _token        : token,
			                project_id    : project_id,
			                document_id  : document_id,
			                access_token : access_token,
			                shared_id      : shared_id,

			              },
			              success:function(response){
			              	var obj = jQuery.parseJSON(response);
			              	html = '<div> View Detail</div><ul><li>Date : '+obj.date_+'</li><li>Time : '+obj.time_+'</li<li>IP : '+obj.IP+'</li><li>Location : '+obj.location+'</li><li>Latitude : '+obj.latitude+'</li><li>Longitude : '+obj.longitude+'</li><li>Device Detail : '+obj.user_agent+'</li></ul>';

			              	$('.shared_User_permission').html(html);
			              }

			         });
               
            });

            //update permission
            $(document).on('click','.permission_shareDoc_update',function(){
            	var userdetail = $('.selectSharedUser').find('input[type="checkbox"]:checked');
            	var useremail = $(userdetail).closest('.selectSharedUser').data('value');
            	var accesstoken = $(userdetail).closest('.selectSharedUser').data('access');

            	var DurationGet  = $("input[name='view_duration_edit']:checked").val();

			    if(DurationGet == 5)
			    {
			       var durationTime = $('#duration_time_val').val();

			    }else{

			       var durationTime = DurationGet;
			    }

            	var project_id = $('#project_id').val();
            	var token =$('#csrf-token').val();
            	var registerValid = $("input[name='register_required_edit']:checked"). val();
			    var printable = $("input[name='print_edit']:checked"). val();
			    var downloadable = $("input[name='download_edit']:checked"). val();
			        $.ajax({
			              type : "POST",
			              url : "{{url('/')}}/share/documents/update",
			              data : {
			              	useremail     :  useremail,
			              	accesstoken   :  accesstoken,
			                _token        : token,
			                project_id    : project_id,
			                durationTime  : durationTime,
			                registerValid : registerValid,
			                printable     : printable,
			                downloadable  : downloadable,
			              },
			              success:function(response){
			              	if (response == "success") {
                                swal("updated successfully", "", "success");
                            }else{
                            	 swal("something wrong", "", "error");
                            }
		              }
			         });               
            });

			$(document).on('click','input[name="view_duration_edit"]',function(){
				if($(this).is(':checked') && $(this).val() == '5'){
					$('.custom_date').removeClass('hidden');
				}else{
					$('.custom_date').addClass('hidden');
				}

			});

        });//document

	</script>
@endsection