 <nav id="sidebar">
								<div id="dismiss">
										<i class="glyphicon glyphicon-arrow-left"></i>
								</div>

								<div class="sidebar-header">
										<h3>All Project</h3>
								</div>

								<ul class="list-unstyled components">
									 <li class="btn-block new_data_room" data-toggle="modal" data-target="#create_project"><span class="new_room"><i class="fas fa-plus"></i></span> Create New Project
												<i class=""></i>
									 </li>
								
								 </ul>
</nav>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	<input type="hidden" id="gett_shared_doc" value='{{$project_id}}'>

			<div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
											
				<a class="navbar-brand brand-logo" href="{{url('/')}}">
					<img src="{{url('/')}}/dist/img/prodata_logo.png" alt="logo" />
				</a>
				<a class="navbar-brand brand-logo-mini" href="index.html">
					<img src="{{url('/')}}/dist/img/avatar5.png" alt="logo" />
				</a>

				 <span id="sidebarCollapse"><i class="fas fa-align-left"></i></span>
			</div>
			<div class="navbar-menu-wrapper d-flex align-items-center">
				<ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
					<li class="nav-item">
						<a href="JavaScript:;" class="nav-link project_name">
							 <B>{{$project_name}}</B> 
						</a>
					</li>
					<li class="nav-item">
						<a href="{{url('/')}}/project/{{$project_id}}/documents" class="nav-link"><i class="far fa-file"></i>Documents</a>
					</li>
					@if(checkUserType($project_name) !== 'Individual_users')
						<li class="nav-item ">
							<a href="{{url('/')}}/project/{{$project_id}}/users" class="nav-link">
								<i class="material-icons">&#xe7ef;</i> Users</a>
						</li>

					<li> 

				    <li class="nav-item ">
							<a href="{{url('/')}}/project/{{$project_id}}/questions" class="nav-link">
								<i class="fa fa-comments" aria-hidden="true"></i>Q&A</a>
				    </li>

				    @endif

					<li class="nav-item ">
							<a href="{{url('/')}}/project/{{$project_id}}/reports" class="nav-link">
								<i class="fa fa-pie-chart"></i>Reports</a>
					</li>

					<li class="nav-item" id='Pro_ShareableDocument'>
							<a href="{{url('/')}}/sharedFile/{{$project_id}}/" class="nav-link">
							<i class="fa fa-paperclip" aria-hidden="true"></i>Share with me</a>
					</li>
					<div class="nav-link">
							
					</div>
					</li>  
				</ul>

				<ul class="navbar-nav navbar-nav-right header-menu">
				     <li class="nav-item dropdown d-none d-xl-inline-block" >
					   <div data-toggle="dropdown" aria-hidden="true">  	
						  <span class="profile-text"><i class="fas fa-cog"></i></span>
						   <i class="fa fa-caret-down down-arrow"></i>
						</div>

					<div class="dropdown-menu list-iteam">
						<ul>
							<li><a href="{{url('/')}}/project/{{$project_id}}/documents/setting/watermark" ><span><i class="fa fa-cogs"></i></span>General Setting</a></li>
							<li><a href="{{url('/')}}/project/{{$project_id}}/documents/setting/watermark"><span><i class="fa fa-hashtag"></i></span>Watermark Setting</a></li>

							<li><a href="{{url('/')}}/sharedBy_me/{{$project_id}}/"><i class="fa fa-retweet" aria-hidden="true"></i>Shared by me</a></li>

						</ul>    
					</div>
					</li>

					<li class="nav-item dropdown d-none d-xl-inline-block" >
                     <div data-toggle="dropdown" aria-hidden="true">
					 <i class="fas fa-user"></i>
					 <span class="profile-text">@if(Auth::user()){{ Auth::user()->name }}@endif</span>
					 <i class="fa fa-caret-down down-arrow"></i>
					</div>

						<div class="dropdown-menu list-iteam">
							<ul>
								<li><a href="{{url('/')}}/account" ><i class="fa fa-info-circle" aria-hidden="true"></i>My Personal Info</a></li>
								<li><a href="{{url('/')}}/account/security" ><i class="fa fa-cogs"></i>My Security Setting</a></li>
								<li><a href="{{url('/')}}/projects" ><i class="fa fa-ellipsis-h" aria-hidden="true"></i>All projects</a></li>
								<li><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
										{{ csrf_field() }}
										<input type="submit" name="submit" value ="logout">
								</form>
							</li> 
							 </ul>    

						</div>
					</li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="mdi mdi-menu"></span>
				</button>
			</div>
		</nav>
		
<!--create project model-->

<div id="create_project" class="modal fade" role="dialog">
	<div class="modal-dialog new_data_room_setup">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
			 <h3>NEW DATA ROOM</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
					<div class="wrapper">
<div class="center_section">
<div class="center_inner">
<h2>Does your compnay have a signed contract with Prodataroom?</h2>
<div class="radio_btn_pannel">
<label>
<input type="radio" name="contract" class="contract" checked>
Yes, use existing contract
</label>

<label>
<input type="radio" name="contract" class="no_contract">
No
</label>
</div>

<p>Your Project will be set up in no time. You can start using your new project under the same contract terms right away</p>


</div>

<div class="center_inner">
<h3>Basic settings</h3>
<div class="basic_setting_input">

<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

<div class="input_pannel">
<label>Company name or contract number</label>
 <input type="text"  name ="company_name" id ="company_name" class="form-control" id="exampleInputEmail1" placeholder="Enter comapny" required>
</div>
<div    style="display: none;" id="alert_company_name"></div>
<div class="input_pannel {{ $errors->has('project_name') ? ' has-error' : '' }}">
<label>New project name *</label>
 <input type="text" id ="project_name" name ="project_name" class="form-control"  placeholder="Project name" required>
</div>
<div style="display: none;" id="alert_project_name"></div>
 @if ($errors->has('project_name'))
									 <script>
										 $('#create_project').modal("show");
									 </script>
										<span class="help-block-project">
											<strong>{{ $errors->first('project_name') }}</strong>
										</span>
 @endif
<div class="input_pannel industry_label hidden_label">
<label>Industry *</label>
<select class="Industry" required>
	<option></option>
	<option value="Business_Services">Business Services</option>
	<option value="Consumer">Consumer Goods</option>
	<option value="Distribution">Distribution</option>
	<option value="Health" >Health Care</option>
	<option value="Life">Life Sciences</option> 
	<option value="Materials">Materials</option>
	<option value="Real_estate">Real estate</option>
	<option value="Retail">Retail</option>
	<option value="Telecommunications">Telecommunications</option>
	<option value="Transportation">Transportation</option> 
</select>
</div>


<div class="input_pannel">
<label>Server location *</label>
<select class="sever_location" id="server_location" required>
	<option></option>
	<option value="India" >India</option>
	<option value="Usa" >Usa</option>
	<option value="London" >London</option>
	<option value="NewYork" >NewYork</option>
	<option value="Canada" >Canada</option> 
</select>
</div>
<div style="display: none;" id="alert_server_location"></div>
</div>

<p>Additional Requirement</p>

</div>

<div class="center_inner">
<h3>Data room administrators</h3>

<div class="personal_detail_pannel">
<input type="text" value="" placeholder="@if (Auth::user()){{ Auth::user()->email}}@endif">
<p>Enter Personal Details</p>
</div>

</div>

<div class="create_btn">
<input value="Create" type="button" class="btn btn-success mr-2" id="Create_dataroom">
</div>


</div>

       </div>
      </div>
</div>
		 
</div>

	 </div>
	 <div class="overlay"></div>
	
<!-- 	<script type="text/javascript">
		
		  // get 


  $(document).on('click','#Pro_ShareableDocument',function(){
 
    var project_id = $('#gett_shared_doc').val();
    var token = $('#csrf-token').val();  
  
        $.ajax({

              type : "POST",
              url : "{{url('/')}}/Auth/getShareable/Document",
              data : {     
                _token      : token,
                project_id   : project_id,
              },
              success:function(response){

               alert(response);

              }

          });   
   
  });

</script> -->