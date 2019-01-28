<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link href="{{ asset('dist/css/frontend/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

</head>

<body>
<div class="wrapper">

<div class="header">
<div class="header_fixed">
@include('frontend/includes.header')
</div>
</div>
@yield('content')
<div class="footer_pannel">
@include('frontend/includes.footer')
</div>

</div>



<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
   $(window).scroll(function() { 
var scroll = $(window).scrollTop(); 
var header = $('.header');
if (scroll > 50) { 
header.addClass("addedSticky"); 
} else { 
header.removeClass("addedSticky"); 
} 
}); 

   $(document).ready(function(){
   	     $('.account_info').click(function(){
      	        $('.account_list-iteam').toggle();
          });

         $('#Set_Up_My_Dataroom').click(function(){
     
            var token =$('#csrf-token').val();
            var error = 0;

            var fullName = $('.full_name').val();
            var company = $('.company').val();
            var about_prodata = $('select.about_prodata').val();
         	  var enterEmail = $('.email').val();
            var checkerEmail = isValidEmailAddress(enterEmail);

           	var enterPhone = $('.phone').val();
          	var enterProject = $('.project').val();
            var errors = "<p class='error_check_red' style='color:red;'>Please fill in the required field.</p>";

         	if(fullName == '')
         	{
               
	           $('.check_int1').html(errors);
	           error=1;

         	}else{

                $('.check_int1').html('');
                error=0;
               
           }

          if(checkerEmail == false || enterEmail == '')
            {

                $('.check_int2').html(errors);
                error=1;

           }else{

                $('.check_int2').html('');
                error=0;
           }


         	if(enterPhone == '')
         	{
              
	           $('.check_int3').html(errors);
	             error=1;

         	}else{

            $('.check_int3').html('');
            error=0;
            

          }

         	if(company == '')
         	{
         	
	           $('.check_int4').html(errors);
	             error=1;
         	}else{
            $('.check_int4').html('');
             error=0;
          }

         	if(about_prodata == null)
         	{
              
	           $('.check_int5').html(errors);
	             error=1;
         	}else{
            $('.check_int5').html('');
             error=0;
          }

         	if(enterProject == '')
         	{
         	  
	           $('.check_int6').html(errors);
	             error=1;
         	}else{

             $('.check_int6').html('');
              error=0;
              
          }

         	if(error == 0 )
         	{


         	 $.ajax({
              type:"POST",
              url:"{{ Url('/validation/info') }}",
              data:{

                _token : token,
                enterEmail : enterEmail,
                enterPhone : enterPhone,
                enterProject:enterProject
              },   
              success: function (response) { 
              
              var valid = jQuery.inArray(1, response);
              
	              	if(valid !== -1)
	              	{
	              	   
	                   var check1 = response[0];
	                   var check2= response[1];
	                   var check3 = response[2];
	                   $('.check_int3').empty();
	                   $('.check_int2').empty();
                     $('.check_int6').empty();

	                  
	                   if(check1 == 1)
	                   {
	                   	 if(enterEmail !== '')
	                   	 {
	                   	 	 var error1 = "<p style='color:red;' >This email already exits. Please enter unique email</p>";
	                   	     $('.check_int2').html(error1);
	                   	       error=1;
	                   	 }
	                    
	                   }
	                   if(check2 == 1)
	                   { 
                           if(enterPhone !== '')
         	                {	                   	 
		                   	var error2 = "<p style='color:red;' >Phone no is already in use. Please enter a unique phone no.<p>";
		                   	$('.check_int3').html(error2);
		                   	  error=1;
		                   }
	                   }

	                  if(check3 == 1)
	                   {
	                   	 if(enterProject !== '')
         	                 {
			                   	var error3 = "<p style='color:red;' >The chosen project name is already in use. Please enter a unique name.</p>";
			                   	$('.check_int6').html(error3);
			                   	  error=1;

		                    }
                              
	                   }
	              	}
	              	if(!error == 1)
                          {
                              if(checkerEmail == true ){
                                $('.get_qoute').removeClass('hidden_get_qoute');
                              }
                              
          	 	                $('.right_popup_content').addClass('hidden_get_qoute');
          	 	                $('.left_popup_content').addClass('hidden_get_qoute');
	              	
                          }

	              }

             });
         	}

      	 	
      	 
      	 });


         $('#Get_a_Quote').click(function(){

          var token = $('#csrf-token').val();
            // informations
         	var fullName = $('.full_name').val();
         	var email = $('.email').val();
         	var phone  = $('.phone').val();
         	var company = $('.company').val();
         	var project = $('.project').val();
         	var about_prodata  = $(".about_prodata").val();
         	var project_type  = $("select.project_type ").val();
         	var Project_strat_date  = $("select.Project_strat_date").val();
         	var project_duration  = $("select.project_duration").val();
          var preferred_payment  = $("select.preferred_payment").val();
          var quote_for  = $("select.quote_for").val();
          var errors = "<p class='error_check_red' style='color:red;' >Please fill in the required field.</p>";
          var error = 0 ;

            if(project_type == null)
         	{
	           $('.check_int7').html(errors);
	           error=1;
         	}
          
         	if(Project_strat_date == null)
         	{
         	  
	           $('.check_int8').html(errors);
	             error=1;
         	}
         	if(project_duration == null)
         	{
              
	           $('.check_int9').html(errors);
	             error=1;
         	}
         	if(preferred_payment == null)
         	{
         	  
	           $('.check_int10').html(errors);
	             error=1;
         	}
         	if(quote_for == null)
         	{
         	  
	           $('.check_int11').html(errors);
	             error=1;
         	}

            if(error == 0)
            {

                swal("Thank you!", "We will set up your branded data room within 5 minutes. prodata sales team will get in touch with you shortly.", "success");
                         
                 $('#setup_dataroom').modal('hide');

            	$.ajax({

                  type:"POST",
                  url:"{{ Url('/') }}/setup_dataroom",
                  data:{
                    _token : token,
                      fullName: fullName, 
                      email :email, 
                      phone: phone, 
                      company  :company,
                      project: project, 
                      about_prodata :about_prodata, 
                      project_type: project_type ,
                      Project_strat_date  :Project_strat_date ,
                      project_duration: project_duration ,
                      preferred_payment  :preferred_payment , 
                      quote_for : quote_for
                    },  

                  // multiple data sent using ajax//
                  success: function (response) {
                  	
                  	if(response == "success")
                  	{

                  	    

                  	}
                  	

                  	
                  }

              });
            }
              

         })
           
      	 $('.open_data_setup').click(function(){
            $('.get_qoute').addClass('hidden_get_qoute');
            $('.right_popup_content').removeClass('hidden_get_qoute');
      	 	$('.left_popup_content').removeClass('hidden_get_qoute');
      	 });

   });

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

</script>
</body>
</html>
