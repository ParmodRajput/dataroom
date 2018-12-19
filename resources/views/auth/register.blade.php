<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pro Data Room</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css ')}}">
  <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vendor.bundle.addons.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('dist/img/avtar.jpg') }}" />
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
               <h2 class="text-center mb-4">Register</h2>
              <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
			    {{ csrf_field() }}

                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control" name="name" value="<?php if (isset($_SESSION["register_user_info"])):print_r($_SESSION["register_user_info"][0]); ?>
                      
                    <?php endif ?>"placeholder="Name">     
                    <div class="input-group-append">
                      <span class="input-group-text">
                       <i class="fa fa-user" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                   @if ($errors->has('name'))
                        <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                        </span>
                       @endif
                <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control" value="<?php if (isset($_SESSION["register_user_info"])):print_r($_SESSION["register_user_info"][1]); ?>
                      
                    <?php endif ?><?php if (isset($_SESSION["registerUser"])):print_r($_SESSION["registerUser"][0]); ?> <?php endif ?>" name ="email" placeholder="Email">
                  
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                  @if ($errors->has('email'))
                        <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                <div class="form-group {{ $errors->has('phone_no') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control"  name="phone_no" value="<?php if (isset($_SESSION["register_user_info"])):print_r($_SESSION["register_user_info"][2]); ?>
                      
                    <?php endif ?>" placeholder="Phone No">
                    
                    <div class="input-group-append">
                      <span class="input-group-text">
                       <i class="fa fa-phone" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                 @if ($errors->has('phone_no'))
                        <span class="help-block">
                          <strong>{{ $errors->first('phone_no') }}</strong>
                        </span>
                    @endif

          <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <input type="text" class="form-control" value="<?php if (isset($_SESSION["register_user_info"])):print_r($_SESSION["register_user_info"][3]); ?>
                      
                    <?php endif ?>" name="company" placeholder="company">
                    
                    <div class="input-group-append">
                      <span class="input-group-text">
                       <i class="far fa-building"></i>
                      </span>
                    </div>
                  </div>
                </div>
                 @if ($errors->has('company'))
                        <span class="help-block">
                          <strong>{{ $errors->first('company') }}</strong>
                        </span>
                    @endif
				
				 <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                   
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-key" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                 @if ($errors->has('password'))
                        <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <div class="input-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                    
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-check" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                  @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                  @endif
                 <!--<div class="form-group d-flex justify-content-center">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> I agree to the terms
                    </label>
                  </div>
                </div>-->
                <div class="form-group">
                  <input type="submit" value="register" class="btn btn-primary submit-btn btn-block">
                </div>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Already have an account ?</span>
                  <a href="{{url('/')}}/login" class="text-black text-small">Login</a>
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
  <!-- container-scroller -->
  <!-- plugins:js -->
    <script src="{{ asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('js/vendor.bundle.addons.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js')}}"></script>
  <script src="{{ asset('js/misc.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js')}}"></script>
  <!-- endinject -->
</body>

</html>