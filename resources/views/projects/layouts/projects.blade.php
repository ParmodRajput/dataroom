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
                if(response.validation_failed == true){
                   var arr = response.errors;
                   $.each(arr, function(index, value){
                       if (value.length != 0){
                         $("#alert_"+index).show();
                         $("#alert_"+index).html('<span class="help-block">'+ value +'</span>');
                         $("#"+index).click(function(){
                           $("#alert_"+index).hide();
                         });
                       }                        
                   });
                }else{

                  window.location.href = '{{url("/")}}/project/'+response+'/documents';

                }
                         
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
      if(updated_name && updated_phone){
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
                        $('.profile-text').html(updated_name);
                           
                      }
              }
      
      });

      }else{

        if(!updated_name){
            $("#alert_updated_name").show();
            $("#alert_updated_name").html('<span class="help-block"">Name is required</span>');
            $("#update_name").click(function(){
              $("#alert_updated_name").hide();
            });        

        }
        if(!updated_phone){
            $("#alert_updated_phone").show();
            $("#alert_updated_phone").html('<span class="help-block"">Name is required</span>');
            $("#update_phone").click(function(){
              $("#alert_updated_phone").hide();
            });        

        }        


      }   
      
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
                new_password : new_password,
                confirm_password:confirm_password,
              },   
               success: function (response) { 
                      if(response == 'changePassword')
                      {
                        swal("Password updated successfully", "", "success");
                        $('#changepassword').each(function(){
                            this.reset();
                        });                          
                      }
                      if(response.validation_failed == true){
                         var arr = response.errors;
                          $.each(arr, function(index, value){
                              if (value.length != 0){
                                $("#alert_"+index).show();
                                $("#alert_"+index).html('<span class="help-block">'+ value +'</span>');
                                $("#"+index).click(function(){
                                  $("#alert_"+index).hide();
                                });
                              }  
                                             
                          });
                      }
                      if(response.message == 'notmatchpassword'){
                          $("#alert_current_password").show();
                          $("#alert_current_password").html('<span class="help-block"">'+ response.errors +'</span>');
                          $("#current_password").click(function(){
                            $("#alert_current_password").hide();
                          });
                      } 
                       if(response.message == 'notmatchcomfirm'){
                          $("#alert_confirm_password").show();
                          $("#alert_confirm_password").html('<span class="help-block"">'+ response.errors +'</span>');
                          $("#confirm_password").click(function(){
                            $("#alert_confirm_password").hide();
                          });
                      }                     

              },
            });


  });

  </script>



<!--create project model-->

<div id="create_project" class="modal fade" role="dialog">
  <div class="modal-dialog new_data_room_setup">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <h3>NEW DATA ROOM</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="wrapper">
<div class="center_section pop_center">
<div class="center_inner">
<h2>Does your compnay have a signed contract with Prodataroom?</h2>
<div class="radio_btn_pannel">
<label>
<input type="radio" name="contract" class="contract" checked>
Yes, use existing contract
</label>

<label>
<input type="radio" name="contract" class="no_contract">
No
</label>
</div>

<p>Your Project will be set up in no time. You can start using your new project under the same contract terms right away</p>


</div>

<div class="center_inner">
<h3>Basic settings</h3>
<div class="basic_setting_input">

<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

<div class="input_pannel">
<label>Company name or contract number</label>
 <input type="text"  name ="company_name" id ="company_name" class="form-control" id="exampleInputEmail1" placeholder="Enter comapny">
</div>
<div id="alert_company_name" style="display: none"></div>
<div class="input_pannel {{ $errors->has('project_name') ? ' has-error' : '' }}">
<label>New project name *</label>
 <input type="text" id ="project_name" name ="project_name" class="form-control"  placeholder="Project name">
</div>
<div id="alert_project_name" style="display: none"></div>

 @if ($errors->has('project_name'))
                   <script>
                     $('#create_project').modal("show");
                   </script>
                    <span class="help-block-project">
                      <strong>{{ $errors->first('project_name') }}</strong>
                    </span>
 @endif
<div class="input_pannel industry_label hidden_label">
<label>Industry *</label>
<select class="Industry">
  <option></option>
  <option value="Business_Services">Business Services</option>
  <option value="Consumer">Consumer Goods</option>
  <option value="Distribution">Distribution</option>
  <option value="Health" >Health Care</option>
  <option value="Life">Life Sciences</option> 
  <option value="Materials">Materials</option>
  <option value="Real_estate">Real estate</option>
  <option value="Retail">Retail</option>
  <option value="Telecommunications">Telecommunications</option>
  <option value="Transportation">Transportation</option> 
</select>
</div>


<div class="input_pannel">
<label>Server location *</label>
<select class="sever_location" id="server_location">
  <option></option>
  <option value="India" >India</option>
  <option value="Usa" >Usa</option>
  <option value="London" >London</option>
  <option value="NewYork" >NewYork</option>
  <option value="Canada" >Canada</option> 
</select>
</div>
<div id="alert_server_location" style="display: none"></div>

</div>

<p>Additional Requirement</p>

</div>

<div class="center_inner">
<h3>Data room administrators</h3>

<div class="personal_detail_pannel">
<input type="text" value="" placeholder="{{ Auth::user()->email}}">
<p>Enter Personal Details</p>
</div>

</div>

<div class="create_btn">
<input value="Create" type="button" class="btn btn-success mr-2" id="Create_dataroom">
</div>


</div>

</div>
</div>
       </div>
     
    </div>

   </div>
</body>

</html>