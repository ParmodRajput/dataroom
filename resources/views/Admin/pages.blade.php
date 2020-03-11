@extends('Admin.layouts.admin')
@section('content')
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All pages</h1>
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
                    <th>Page Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
      				@foreach ($pages as $page)
      					<tr>
      						<td>{{$page->name}}</td>
                  <td class=" action_btns">
                    <a href="{{url($page->name)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="{{url('admin/edit'.$page->name.'page')}}">Edit</a>
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