@extends('Admin.layouts.admin')
@section('content')
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Project List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{ route('detail',last(request()->segments())) }}">User Details</a></li>
        </ul>
      </div>
     <div class="row">
		@if(count($projects) > 1) 
		@foreach ($projects as $userprojects)
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{$userprojects->project_name}}</h3>
            <div class="tile-footer">
				<div class="tile-body">Current status of Project is: <strong>{{ ($userprojects->is_active == 1) ? 'Enable' : 'Disable'}}</strong></div>
				<a href="{{ route('changeProjectStatus',$userprojects->id) }}" class="btn btn-primary">{{ ($userprojects->is_active == 1) ? 'Disable' : 'Enable'}}</a>
			</div>
          </div>
        </div>
		@endforeach
		@else 
		<div class="col-lg-4">
            <div class="bs-component">
              <div class="alert alert-dismissible alert-danger">
                <button class="close" type="button" data-dismiss="alert">×</button><strong>No Project found for this user!</strong>
              </div>
            </div>
          </div>
	   @endif

@endsection