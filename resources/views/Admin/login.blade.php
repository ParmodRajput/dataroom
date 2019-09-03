<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/admin/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - prodata Admin</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Pro-dataroom</h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('adminLogin') }}">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control admin_email" type="text" name='email' placeholder="Email" autofocus>
          </div>
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control admin_password" name='password' type="password" placeholder="Password">
          </div>
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container"> 
            <button type="submit" class="btn btn-primary btn-block login_administrator"><i class="fa fa-sign-in fa-lg fa-fw "></i>SIGN IN</button>
          </div>
        </form>
        <form class="forget-form" action="index.html">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/admin/jquery-3.2.1.min.js"></script>
    <script src="js/admin/popper.min.js"></script>
    <script src="js/admin/bootstrap.min.js"></script>
    <script src="js/admin/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/admin/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });

      // $(document).on('click','.login_administrator',function(){

      //   var email = $('.admin_email').val();
      //   var password = $('.admin_password').val();
      //   var token = $('#csrf-token').val();

      //   $.ajax({
                      
      //             type:"POST",
      //             url:"{{ Url('/') }}/admin/login",
      //             data:{
      //              _token : token,
      //              email : email,
      //              password : password,
      //           },  
      //               // multiple data sent using ajax//
      //             success: function (response) 
      //             {

      //                alert(response);

      //             }

      //         });

      // });

    </script>
  </body>
</html>