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
	<div class="col-md-12">
	  <div class="tile">
	    <h3 class="tile-title">User Information</h3>
	    <div class="tile-body col-md-6">
	    	<form method="POST" id="userdetail" action="{{route('userdetailpost',$user->id)}}">
	    		 @csrf
	        <div class="form-group">
	          <label class="control-label">Name</label>
	          <input class="form-control" type="text" placeholder="Name" name="name" value="{{$user->name}}">
	        </div>
	        <div class="form-group">
	          <label class="control-label">Email</label>
	          <input class="form-control" type="email" placeholder="Email" name="email" value="{{$user->email}}">
	        </div>
	        <div class="form-group">
	          <label class="control-label">Company</label>
	          <input class="form-control" type="text" placeholder="Company Name"name="company" value="{{$user->company}}">
	        </div>
	        <div class="form-group">
	          <label class="control-label">Password</label>
	          <input class="form-control" type="password" placeholder="Password"name="password" value="">
	        </div>
	        <div class="form-group">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
            </div>
	      </form>
	    </div>
	  </div>
	</div>
</div> 
@endsection