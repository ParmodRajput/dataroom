@extends('Admin.layouts.admin')
@section('content')
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> User Detail</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{ route('projectList',$user->id) }}">Project List</a></li>
        </ul>
      </div>
     <div class="row"> 
		<div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title"></h3>
            <div class="tile-footer">
				<div class="tile-body">Name: <strong>{{$user->name}} </strong></div>
				</br>
				<div class="tile-body">Email: <strong>{{$user->email}}</strong></div>
				</br>
				<div class="tile-body">Company: <strong>{{$user->company}}</strong></div>
				</br>
				<div class="tile-body">Email: <strong>{{$user->phone_no}}</strong></div>
				</br>
				<div class="tile-body">Registeration Date: <strong>{{$user->created_at}}</strong></div>
				</br>
				<div class="tile-body">Status: <strong>{{ ($user->is_active == 1) ? 'Enabled' : 'Disabled'}}</strong> <i style="color:Red">  (You can change status by clicking button below)</i></div>
				</br>
				<a href="{{ route('changeStatus',$user->id) }}" class="btn btn-primary">{{ ($user->is_active == 1) ? 'Disable' : 'Enable'}}</a>
			</div>
          </div>
        </div>
      </div> 
	  


@endsection