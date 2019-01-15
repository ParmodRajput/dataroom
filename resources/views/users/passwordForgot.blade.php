<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pro Data Room</title>

  <link rel="shortcut icon" href="{{ asset('dist/img/prodats_logo.png') }}" />
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
  
</head>
<body>
  <div class="container-scroller">
<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            
        <div class="row w-100">

          <div class="col-lg-4 mx-auto">

            <div class="auto-form-wrapper">
                  <h3 class="wel">Forgot passwprd</h3>
         <h4 class="wel-text"> Please enter your email</h4>
              <form class="form-horizontal" role="form" method="POST" action="{{url('/')}}/forgotpassword">
                {{ csrf_field() }}
                <div class="form-group  {{ $errors->has('project_name') ? ' has-error' : '' }}" >
                  <label class="label">email </label>
                  <div class="input-group">
                    <input type="text"  name="email" class="form-control" placeholder="Email">
                   
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                      </span>
                    </div>
                  </div>
                </div>
                  @if (isset($message))
                        <span class="help-block">
                          <strong>{{ $message }}</strong>
                        </span>
                    @endif
                <div class="form-group">
                  <input type="submit" value="submit" class="btn btn-primary submit-btn btn-block">
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