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
              <table class="table table-hover table-bordered" id="userDetailTable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Projects</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
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
			$('#userDetailTable').DataTable({
            "aaSorting": [],
            "processing": true,
            "serverSide": true,
            "stateSave" : true,
            "ajax": {
                "url": APP_URL+"/admin/users",
                "type": "POST",
                "data":{
                  "_token": "{{ csrf_token() }}",
                  "type":"{{ $type }}"
                }
            },
            "columns": [
                { "name": "name" },
                { "name": "email" },
                { "name": "phone_no" },
                { "name": "company" },
                { "name": "projects",orderable: false,searchable:false },
                { className: "action_btns", "name": "actions",orderable: false,searchable:false }
            ],
            "columnDefs": [
                { orderable: false, targets: -1 }
            ]
        });
		});
	</script>
@endsection