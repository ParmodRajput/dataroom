@extends('projects.layouts.projects')
@section('content')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth acoount-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <h2 class="text-center mb-4">Personal Info</h2>
            <div class="auto-form-wrapper">
              <form class="form-horizontal" role="form" method="POST" action=#">
			    {{ csrf_field() }}
                <input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" id="update_name"placeholder="Name">
                   
                    <div class="input-group-append">
                      <span class="input-group-text">
                       <i class="fa fa-user" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div style="display: none" id="alert_updated_name"></div>
                <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control" id="update_email" value="{{ Auth::user()->email }}" name ="email" placeholder="Email" readonly>
                  
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                  <div style="display: none" id="alert_update_email"></div>
                <div class="form-group {{ $errors->has('phone_no') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" value="{{ Auth::user()->phone_no}}"class="form-control" id="update_phone" name="phone_no" placeholder="Phone No">
                    
                    <div class="input-group-append">
                      <span class="input-group-text">
                       <i class="fa fa-phone" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
              <div style="display: none" id="alert_updated_phone"></div>               
                <div class="form-group">
                  <input type="button" value="Save" class="btn btn-primary submit-btn btn-block" id="updateUserInfo">
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