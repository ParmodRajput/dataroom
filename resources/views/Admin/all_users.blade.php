@extends('Admin.layouts.admin')
@section('content')
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Users</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"></li>
        </ul>
      </div>
    
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Projects</th>
                    <th>Current Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
				@foreach($users_list as $data)
                  <tr>
                    <td>{{ $data -> name}}</th></td>
                    <td>{{ $data -> email}}</th></td>
                    <td>{{ $data -> phone_no}}</th></td>
                    <td>{{ $data -> company}}</th></td>
                    <td><a href="{{ route('projectList',$data->id) }}">Projects</a></th></td>
                    <td>{{ ($data->is_active == 1) ? 'Enabled' : 'Disabled'}}</td>
                    <td><a href="{{ route('detail',$data->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>
				@endforeach
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
		
	<script src="{!! asset('js/admin/plugins/jquery.dataTables.min.js') !!}"></script>
	<script src="{!! asset('js/admin/plugins/dataTables.bootstrap.min.js') !!}"></script>
	
	
	
	<script type="text/javascript">
		$(document).ready( function () {
			$('#sampleTable').DataTable();
		} );
	</script>
@endsection