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
           <a href="javascript:;" target="_blank" onclick="deleteProject({{$userprojects->id}})">
                       <div class="close">
                           <i class="fa fa-window-close" aria-hidden="true"></i>
                       </div>
                   </a>                                                      
                   <ul id="dashboard-items" class="projects-list" onclick="location.href='project/{{$userprojects->id}}/documents';">
                       <li class="dashboard-predefined-item" >
                           <span class="text-box">                                
                               <strong><a href="project/{{$userprojects->id}}/documents">{{$userprojects->project_name}}</a></strong>
                           </span>     
                       </li>
                   </ul> 
               </div>
            @endforeach
        </div>   
      </div>
</div>
@endsection 

