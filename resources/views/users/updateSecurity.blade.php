@extends('projects.layouts.projects')
@section('content')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth acoount-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <h2 class="text-center mb-4">Change Your Password</h2>
            <div class="auto-form-wrapper">
              <form class="form-horizontal" role="form" id="changepassword" method="POST" action=#">
			    {{ csrf_field() }}
          <label>Current password</label>
                <input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>

              <div class="form-group">
                <div class="input-group">
                  <input type="Password" class="form-control" name="current_password" id="current_password">    <div style="display: none" id="alert_current_password"></div>
                  </div>
                </div>
                <label>New password</label>
                <div class="form-group">
                  <div class="input-group">
                    <input type="Password" class="form-control" id="new_password" value="" name ="new_password" >
                      <div style="display: none" id="alert_new_password"></div>
                  </div>
                </div>
                  <label>Confirm password</label>
                <div class="form-group">
                  <div class="input-group">
                    <input type="Password" value=""class="form-control" id="confirm_password" name="confirm_password" >
                      <div style="display: none" id="alert_confirm_password"></div>
                  </div>
                </div>
                
                <div class="form-group">
                  <input type="button" value="Save" class="btn btn-primary submit-btn btn-block" id="updateUserpassword">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

@endsection 