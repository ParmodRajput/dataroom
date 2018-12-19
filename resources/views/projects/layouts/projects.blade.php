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
    @include('projects.includes.header')
    @yield('content')
    <div class="footer_change">
    @include('projects.includes.footer')
    </div>
  </div>
  </div>
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
  <!-- End custom js for this page-->
  <script type="text/javascript">
    var windowHeight = $(window).height();
    var projectsHeight  =windowHeight-290;
   $('.search-container').css('height',projectsHeight);
   $('.search-container').css('overflow-y',"auto");

  $(document).ready(function(){
  $("#dashboardSearchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".search-container .content-block").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
  });

  $('.no_contract').click(function(){
     $('.industry_label').removeClass('hidden_label');
  });
  $('.contract').click(function(){
     $('.industry_label').addClass('hidden_label');
  });

   //Create new Data room//
     $(document).on('click','#Create_dataroom',function(){

        var token =$('#csrf-token').val();
        var company_name  = $('#company_name').val();
        var project_name  = $('#project_name').val();
        var server_location  = $('select.sever_location').val();
        var industry  = $('select.Industry').val();
        if (industry == '')
        {
           var industry  ="empty";
        }

        $.ajax({
              
              type:"POST",
              url:"{{ Url('/') }}/create_project",
              data:{
                _token : token,
                company_name : company_name,
                project_name : project_name,
                server_location : server_location,
                industry      : industry
              },  
              // multiple data sent using ajax//
              success: function (response) { 
                     
                     window.location.href = '{{url("/")}}/project/'+response+'/documents'; 
              }
          });

     });

 //end

// project delete
  $('#form-data').submit(function (e) {
       e.preventDefault();
         var project_id = $('#project_id').val();
         var project_name = $('#project_name').val();
         var company_name = $('#company_name').val();
        
        var token = $("input[name=_token]").val(); 
        
         var data = {project_id:project_id, project_name:project_name, company_name:company_name,_token:token};
       $.ajax({
                  type:"POST",
                  url:"{{ Url('/') }}/project/update",
                  data:data,  
              success: function (response) { 
                
                  if (response == "success")
                   {
                         swal("project deleted successfully", "success");
                         location.reload();
                  
                   }           
               }  
          }); 
          
        })

    });

  function deleteProject(id) {

    var token = $('#csrf-token').val();
    
     swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Project!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            type:"GET",
                            url:"{{ Url('/') }}/project/delete/"+id,
                           // multiple data sent using ajax//
                            success: function (response) {
                                   if (response == "success") {
                                     swal("project deleted successfully", "success");
                                    location.reload();
                                   }
                                 }  
                             });
                        } 
                     });
                 }

// update user information 

  $('#updateUserInfo').click(function(){
      var updated_name = $('#update_name').val();
      var updated_email = $('#update_email').val();
      var updated_phone = $('#update_phone').val();
      var token =$('#csrf-token').val();    
      
           $.ajax({
              type:"POST",
              url:"{{ Url('/') }}/updateUserInfo",
              data:{

                _token : token,
                updated_name : updated_name,
                updated_email : updated_email,
                updated_phone : updated_phone
              },   

              success: function (response) { 
                      if(response == 'success')
                      {

                        swal("Information updated successfully", "", "success");
                        location.reload();    
                      }
              }
      
      });
  });

// update password 
  
  $('#updateUserpassword').click(function(){
      var current_password = $('#current_password').val();
      var new_password = $('#new_password').val();
      var confirm_password = $('#confirm_password').val();
       var token =$('#csrf-token').val(); 

      $.ajax({
              type:"POST",
              url:"{{ Url('/') }}/updateUserpassword",
              data:{

                _token : token,
                current_password : current_password,
                new_password : new_password 
              },   
               success: function (response) { 
                      if(response == 'changePassword')
                      {

                        swal("Password updated successfully", "", "success");
                        location.reload();    
                      }
              }
            });


  });

  </script>
</body>

</html>