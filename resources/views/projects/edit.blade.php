@extends('projects.layouts.projects')
@section('content')
<div class="content-wrapper all-projects">

<form class="form-horizontal" id="form-data">
	{{ csrf_field() }}
	<input type="hidden" id="project_id" name ="project_id" class="form-control"  placeholder="Project name" value="{{$project->id}}" disabled>
	<div class="form-group">
		<label for="exampleInputPassword1">Company Name *</label>
		<input type="text" id="company_name" name ="company_name" class="form-control"  placeholder="Project name" value="{{$project->company_name}}" disabled>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Project Name *</label>
		<input type="text" id="project_name" name ="project_name" class="form-control"  placeholder="Project name" value="{{$project->project_name}}">
	</div>
	<input value="Update" type="submit" class="btn btn-success mr-2"> 
</form>
</div>
@endsection