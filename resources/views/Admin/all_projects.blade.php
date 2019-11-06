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
                    <th>Project Name</th>
                    <th>Owner</th>
                    <th>Email</th>
                    <th>Current Status</th>
                  </tr>
                </thead>
                <tbody>
				@foreach ($projects as $userprojects)
					<tr>
						<td data-projectId="{{$userprojects->id}}">{{$userprojects->project_name}}</td>
						<td data-userId="{{$userprojects->user_id}}"> {{$userprojects->name}}</td>
						<td data-userId="{{$userprojects->user_id}}"> {{$userprojects->email}}</td>
						<td>
						   <input  data-project_id="{{$userprojects->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $userprojects->is_active ? 'checked' : '' }}>                     
						</td>
						
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
			//$('#sampleTable').DataTable();
			 $('#sampleTable').DataTable( {
					"order": [[ 1, "asc" ]]
				} );
		} );
		
		
	</script>
	<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var project_id = $(this).data('project_id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('changeStatusAjax') }}",
            data: {'status': status, 'project_id': project_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
@endsection