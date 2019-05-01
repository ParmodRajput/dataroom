<!doctype html>
<html>
<head>
<style>
.icon-div{
    text-align: center;
    padding: 10px;
    color: #8080807d;
    margin-bottom: 10px;	
}
</style>
<meta charset="utf-8">
<title>Pro Dataroom</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">
	<link href="{{ asset('css/share_module/style.css') }}" rel="stylesheet" media="screen"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<div class="main-div">
		<header class="header-top">
			<a class="logo" href=""><img src="{{url('/')}}/dist/img/Share_module_logo.png" alt="logo"/></a><section><input placeholder="Search Here..." type="text"/><span><a href=""><i class="fas fa-address-book"></i></a><a href=""><i class="fas fa-bell"></i></a></span></section>
		</header>
	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<div class="left-bar">
			<ul>
				<li>Menu</li>
				@auth
				<li><a href="{{url('/')}}/{{$GodataRoom}}">Go to Dataroom</a></li>
				@endauth
				<li><a href="{{url('/')}}/sharedFile/{{$project_id_share}}/">Shared with me</a></li>
				<li><a href="{{url('/')}}/sharedBy_me/{{$project_id_share}}/">Shared By me</a></li>
				<li><a href="{{url('/')}}/shareRecents/{{$project_id_share}}/"><span><i class="far fa-clock"></i></span> Recent</a></li>
			</ul>
		</div><!--left bar close-->
		
		<div class="right-bar">
			<div class="section-box folders">
				<h6>Folders</h6>
			  <ul class="share_document_folder">

				@foreach($DocumentFolder as $DocumentFolder)
					<li class='sharedFolder' data-doc_id="{{$DocumentFolder['document_id']}}" data-shared_time ="{{$DocumentFolder['sharedTime']}}" data-projectid = "{{$DocumentFolder['project_id']}}" data-access="{{$DocumentFolder['access_token']}}" data-email="{{$DocumentFolder['Email']}}" data-value ="{{$DocumentFolder['path']}}" id='sharedFolder'>
						<a href="javascript:;"><span><i class="fas fa-folder"></i><b>{{$DocumentFolder['document_name']}}</b></span>
						</a>
					</li>
				@endforeach
				</ul>
			</div>
			
			<div class="section-box">
				<h6>Files</h6>
				<ul class="share_document_file">
					@foreach($DocumentFile as $DocumentFile)
				
					 <?php $fileExt = pathinfo($DocumentFile['document_name'], PATHINFO_EXTENSION);?>
						<li>
							<a class='overview_shared_document' href="{{url('/')}}/Overview/{{$DocumentFile['access_token']}}/{{$DocumentFile['project_id']}}/{{$DocumentFile['Email']}}/{{$DocumentFile['document_id']}}/34:34:8844.4" target="_blank">
								@if($fileExt =='pdf')
								<div class="icon-div">
									<i class="fas fa-file-pdf fa-7x" aria-hidden="true"></i>
								</div>
								@elseif($fileExt == 'jpeg' || $fileExt =='jpg' || $fileExt =='png')
								<div class="icon-div">
									<i class="fas fa-file-image fa-7x"></i>
								</div>
								@else
								<div class="icon-div">
									<i class="fas fa-file fa-7x"></i>
								</div>												
								@endif
								<div>								
									<span style="word-break: break-word;">
										<i class="fas fa-file"></i>
										<b>{{$DocumentFile['document_name']}}</b>
									</span>
								</div>
							</a>
						</li>	
					@endforeach				
				</ul>
			</div>
		</div><!--right bar close-->
	</div><!--main div close-->
</body>
<script type="text/javascript">
	$(document).ready(function(){

        // $(document).on('click','.overview_shared_document',function(){

        //    var vlaue1 = $(this).data('value');
        //    alert(value1);

        // });

        $(document).on('click','#sharedFolder',function(){
            
           var docId = $(this).data('doc_id'); 
           var folderValue = $(this).data('value');
           var project_id   = $(this).data('projectid');
           var token = $('#csrf-token').val();  
           var sharedTime = $(this).data('shared_time');
           var access =  $(this).data('access');
           var email =  $(this).data('email');

           var html = '';
           var html1 = '';

        $.ajax({

	              type : "POST",
	              url : "{{url('/')}}/GetShared/FoldersDoc",
	              data : {     

	                _token       : token,
	                project_id   : project_id,
	                folderValue  : folderValue,
	                sharedTime   : sharedTime,

	              },
	              success:function(response){

	                  var getfolders = response.folder_index;

                      var getfiles = response.file_index;


			                if(getfolders == '' && getfiles == '')
			                {

			                  html +="<div class='emplty_box_drag_drop'><span class='drag_document_img'><img src='{{asset("dist/img/icon-blue.png")}}'></span><span class='drag_document_texts'>Empty</span></div>";

			                 
			                }else{

			                	 $.each(getfolders,function(key ,value){

			                	 	var doc_name = value.document_name;
			                	 	var doc_path = value.path;
			                	 	var project_id = value.project_id;

			                	 	html+='<li class="sharedFolder" data-doc_id='+docId+' data-shared_time ="'+sharedTime+'" data-projectid = '+project_id+'  data-email='+email+' data-access='+access+' data-value ='+doc_path+' id="sharedFolder"><a href="javascript:;"><span><i class="fas fa-folder"></i><b>'+doc_name+'</b></span></a></li>';
			                	
			                	 });

			                	$.each(getfiles,function(key ,value){

			                	 	var doc_name = value.document_name;
			                	 	var doc_path = value.path;
			                	 	var doc_id   = value.id;
			                	 	var project_id = value.project_id;
	

			                	 	html1+='<li><a class="overview_shared_document" href="{{url('/')}}/Overview/'+access+'/'+project_id+'/'+email+'/'+docId+'/'+doc_id+'" target="_blank"><span><i class="fas fa-file"></i><b>'+doc_name+'</b></span></a></li>';

			                	    });

			                }


                           $('.share_document_folder').html(html);
                           $('.share_document_file').html(html1);

	              }

             });

        });

	});

</script>
</html>
