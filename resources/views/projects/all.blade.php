@extends('projects.layouts.projects')
@section('content')
<div class="content-wrapper all-projects">
        <!-- Content Header (Page header) -->
        <section class="content-header">
           <div class="modal-header">
            <h3 class="modal-title ng-binding">All Projects</h3>
           </div>
        </section>
        <div class="container all-projects-list">
            <fieldset>  
                <input type="text" id="dashboardSearchInput"  placeholder="Search">
                <button class="search" type="submit">Search</button>
            </fieldset>
            <div class="search-container">
                    <div class="content-block">    
                        <ul id="dashboard-items" class="projects-list">
                            <li class="dashboard-predefined-item add-new">
                                <a href="" target="_blank">
                                    <span class="text-box">
                                        <strong><a href="javascript:void(0)" data-toggle="modal" data-target="#create_project" >Create project <i class="fa fa-plus" aria-hidden="true"></i></a></strong>
                                    </span>
                                </a>
                            </li>
                        </ul> 
                </div>
      @foreach ($projects as $userprojects)
      
                <div class="content-block">    
                        <ul id="dashboard-items" class="projects-list">
                            <li class="dashboard-predefined-item">
                                <a href="javascript:;" target="_blank" onclick="deleteProject({{$userprojects->id}})">
                                    <span class="text-box">
                                     <div class="close">
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                     </div>
                                        <strong><a href="project/{{$userprojects->id}}/documents">{{$userprojects->project_name}}</a></strong>
                                    </span>
                                </a>
                            </li>
                        </ul> 
                </div>
            @endforeach
        </div>   
      </div>
</div>
@endsection 


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
<div class="center_section pop_center">
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
 <input type="text"  name ="company_name" id ="company_name" class="form-control" id="exampleInputEmail1" placeholder="Enter comapny">
</div>

<div class="input_pannel {{ $errors->has('project_name') ? ' has-error' : '' }}">
<label>New project name *</label>
 <input type="text" id ="project_name" name ="project_name" class="form-control"  placeholder="Project name">
</div>

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
<select class="Industry">
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
<select class="sever_location">
  <option></option>
  <option value="India" >India</option>
  <option value="Usa" >Usa</option>
  <option value="London" >London</option>
  <option value="NewYork" >NewYork</option>
  <option value="Canada" >Canada</option> 
</select>
</div>

</div>

<p>Additional Requirement</p>

</div>

<div class="center_inner">
<h3>Data room administrators</h3>

<div class="personal_detail_pannel">
<input type="text" value="" placeholder="{{ Auth::user()->email}}">
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

                                     