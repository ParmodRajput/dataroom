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
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fastselect.min.css') }}">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

 <!--  icon cdn date 18 oct 2018 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
  <!-- end -->

   <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('dist/img/') }}" />

  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fastselect/0.7.3/fastselect.standalone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
 
</head>
<body>
  <div class="container-scroller">
    @include('includes.header')
	<!-- partial -->
	
   @yield('content')

	</div>
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
 <!--  <script src="{{ asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('js/vendor.bundle.addons.js')}}"></script> -->

<!--   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript"> $.noConflict();</script>

  <script src="{{ asset('js/off-canvas.js')}}"></script>
  <script src="{{ asset('js/misc.js')}}"></script>
  
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js')}}"></script>

          <script type="text/javascript">

                    $('.table_section.document_scroll').addClass('document_scroll_done');
                    $('#delete_items_documents').hide(); 

                    $.fn.extend({
                      treed: function (o) {
                        
                        var MinusSign = 'glyphicon-triangle-bottom';
                        var PlusSign = 'glyphicon-triangle-right';
                        
                        if (typeof o != 'undefined'){
                          if (typeof o.openedClass != 'undefined'){
                          openedClass = o.openedClass;
                          }
                          if (typeof o.closedClass != 'undefined'){
                          closedClass = o.closedClass;
                          }
                        };
                        
                          //initialize each of the top levels
                          var tree = $(this);
                          if ( !tree.hasClass( "tree" )) {
                             tree.addClass("tree");
                          }
                         
                          // tree.find('li:not(:has(>.customspan))').prepend("<span class='inactive customspan'></i><i class='shuffle glyphicon " + PlusSign + "'></i><i class='indicator glyphicon " + closedClass + "'></span>");
                          
                          tree.find('li:not(:has(>.customspan))').has('ul').prepend("<span class='inactive customspan'></i><i class='shuffle glyphicon " + PlusSign + "'></i><i class='indicator glyphicon " + closedClass + "'></span>");

                          tree.find('li:not(:has(>.customspan))').prepend("<span class='inactive customspan'></i><i class='indicator glyphicon " + closedClass + "'></span>");
                          
                          tree.find('li').each(function () {

                              var branch = $(this); //li with children ul
                              if ( !branch.hasClass( "branch" )) {
                              
                              branch.addClass('branch');
                              branch.on('click', function (e) {

                                  if (this == e.target) {
                                  }
                              })
                              branch.find('ul').children().toggle();
                            }
                          });
                          //fire event from the dynamically added icon
                        tree.find('.branch .shuffle').each(function(){
                          $(this).unbind( "click" );
                          $(this).on('click', function () {

                             var list =  $(this).closest('li');
                             var icon = list.find('span').children('i:first');
                             var icon_next = list.find('span').children('.indicator:first');
                             icon.toggleClass(PlusSign + " " + MinusSign); 
                             icon_next.toggleClass(closedClass + " " + openedClass);
                             list.find('ul').children().toggle();

                          });
                        });
                          //fire event to open branch if the li contains an anchor instead of text
                          tree.find('.branch>a').each(function () {
                              $(this).on('click', function (e) {
                                  $(this).unbind( "click" );
                                  // $(this).closest('li').click();
                                  e.preventDefault();
                              });
                          });
                          //fire event to open branch if the li contains a button instead of text
                          tree.find('.branch>button').each(function () {
                              $(this).unbind( "click" );
                              $(this).on('click', function (e) {
                                  $(this).closest('li').click();
                                  e.preventDefault();
                              });
                          });
                      }
                  });



    $(document).ready(function(){

                  getAuthAllProjects();

                  //fast select for select users

                  $('.multipleSelectUsers').fastselect();

                   var window_width = $(window).width();
                   var window_height = $(window).height();

                    $('.all_action').css('height',window_height-90);
                    $('.report_display_main').css('height',window_height-90);
                    $('.content-wrapper').css('height',window_height-90);

                    $('#tree4').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                  
                    var clickEvent1 = $('.reports_record').find('#Report1');
                    setTimeout(function(){ clickEvent1.trigger('click') },10);

                    $('.document_scroll_done').css('height',window_height-210);

                    var getProjectPath = $('.document_permission').first().data('value');

                    $('.reports_record #project_path').val(getProjectPath);

                 });  

   

    $(document).ajaxSend(function(event, request, settings) {
      $('.overlay_body').removeClass('hidden');
    });

    $(document).ajaxComplete(function(event, request, settings) {
      $('.overlay_body').addClass('hidden');
    }); 

            //left side bar

         $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    $('.overlay').fadeOut();
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    $('.overlay').fadeIn();
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });

            //end    

           
  function getAuthAllProjects(){

  var token = $('#csrf-token').val();  

       $.ajax({
        type : "POST",
        url : "{{url('/')}}/check/projects",
        data : {     
          _token      : token,
        },
        success:function(response){

          var html ='<li class="btn-block new_data_room" data-toggle="modal" data-target="#create_project"><span class="new_room"><i class="fas fa-plus"></i></span> Create New Project<i class=""></i></li>';

           $.each(response,function(key, value){

             html +="<div class='btn-block new_data_room'><span><i class='fas fa-circle'></i></span><a href='{{url('/')}}/project/"+value.id+"/documents'>"+value.project_name+"</a></div>";
                  
           });

         $('.list-unstyled').html(html);

        }
      });

 }


 $(document).on('click','#Report1',function(){

  $('.group_list_reports').removeClass('hidden');
  $('.folder_and_file_tree_qa').addClass('hidden');
  $('.report_display').addClass('hidden');
  $('.all_action').addClass('hidden'); 
  $('.all_action input[type="checkbox"]').prop('checked',false);
  $('.groups_check_record input[type="checkbox"]').prop('checked',false);
  $('.groupAndUsers').addClass('hidden');
  

 });


 $(document).on('click','#Report3',function(){

  var clickEvent = $('.document_permission').find('span').first();
  var triggerEvent  = clickEvent.find('.shuffle').first();
  setTimeout(function(){ triggerEvent.trigger('click') },0);


  $('.folder_and_file_tree_qa').removeClass('hidden');
  $('.group_list_reports').addClass('hidden');
  $('.all_action').addClass('hidden');
  $('.report_display').addClass('hidden'); 
  $('.all_action input[type="checkbox"]').prop('checked',false);
  $('.groups_check_record input[type="checkbox"]').prop('checked',false);
  $('.groupAndUsers').addClass('hidden');


 });

$(document).on('click','#Report4',function(){

    getGroupAndUser();
    
    $('.groupAndUsers').removeClass('hidden');
    $('.folder_and_file_tree_qa').addClass('hidden');
    $('.all_action').addClass('hidden');
    $('.report_display').addClass('hidden'); 
    $('.all_action input[type="checkbox"]').prop('checked',false);
    $('.groups_check_record input[type="checkbox"]').prop('checked',false);
    $('.group_list_reports').addClass('hidden');

 });

$(document).on('click','#Report5',function(){

    $('.groupAndUsers').addClass('hidden');
    $('.group_list_reports').removeClass('hidden');
    $('.folder_and_file_tree_qa').addClass('hidden');
    $('.all_action').addClass('hidden');
    $('.report_display').addClass('hidden'); 
    $('.all_action input[type="checkbox"]').prop('checked',false); 
    $('.groups_check_record input[type="checkbox"]').prop('checked',false);

});

$(document).on('click','#Report6',function(){

    $('.report_display').addClass('hidden'); 
    $('.all_action').removeClass('hidden');
    $('.group_list_reports').addClass('hidden');
    $('.folder_and_file_tree_qa').addClass('hidden');
    $('.all_action input[type="checkbox"]').prop('checked',false);
    $('.groups_check_record input[type="checkbox"]').prop('checked',false);
    $('.groupAndUsers').addClass('hidden');


});

  $(document).on('click','#all_action_check',function(){

     $('.all_action input:checkbox').prop('checked', this.checked); 

  });


  $(document).on('click','#all_group_check',function(){

     $('.group_list_reports input:checkbox').prop('checked', this.checked); 

  });


// display action

  $(document).on('click','.all_action input[type="checkbox"]', function() {

    var numberOfChecked = $('.all_action input:checkbox:checked').length;

    if(numberOfChecked !== 0)
    {
            
            var data_value = [];

            $.each($('.all_action input:checkbox:checked'), function(e)
            {        
                
                  data_value.push($(this).data('value')); 

            });

            $('.report_display').removeClass('hidden');

            var doc = $('.project_name_report').val();

            getAllActionReport(doc,data_value);


      }else{
             
             $('.report_display').addClass('hidden'); 
      }


  });



  // group action

 $(document).on('click','.groups_check_record input[type="checkbox"]', function() {

    var numberOfChecked = $('.groups_check_record input:checkbox:checked').length;

    var project_id = $('.project_id_report').val();

    var project_name = $('.project_name_report').val();

    if(numberOfChecked !== 0)
    {

            var data_value = [];

            $.each($('.group_report_status input:checkbox:checked'), function(e)
            {        
                
                  data_value.push($(this).data('value')); 

            });


            var token = $('#csrf-token').val();  

            var html = '';

               $.ajax({

                type : "POST",
                url : "{{url('/')}}/get_group/report",
                data : {     
                  _token       : token,
                  project_id   : project_id,
                  data_value   : data_value,
                  project_name : project_name,

                },
                success:function(response){

                  $.each(response,function(key,value){

                    html+="<div class='group_overview'><div class='group_overview_first'> <div class='group_overview_sfert'><h4>"+value.group_name+"</h4></div><div class='group_overview_overall'><h5>OverAll</h5></div></div><div class='group_overview_second'><div class='sfert_dis'><h4>Users invited:</h4></div><div class='overall_dis'>"+value.invitedUser+"</div></div><div class='group_overview_second'><div class='sfert_dis'><h4>Users logged in:</h4></div><div class='overall_dis'>"+value.loginUser+"</div></div><div class='group_overview_second'><div class='sfert_dis'><h4>Documents permitted:</h4></div><div class='overall_dis'>"+value.permittedDoc+"</div></div><div class='group_overview_second'><div class='sfert_dis'><h4>Questions posted:</h4></div><div class='overall_dis'>"+value.GroupPosted+"</div></div></div>";

                  });


                  $('.report_display').html(html);
                  $('.report_display').removeClass('hidden');

                   
                }

            });

    }else{

      $('.report_display').addClass('hidden');

       }

  });

   // folder and file module for get the action reports

  $(document).on('click','.document_permission', function(event) {

        event.preventDefault();
        event.stopPropagation(); 
        
        $('.document_permission').children("span").removeClass("docActive"); 
        $(this).children("span").addClass("docActive");
  
        var doc = $(this).data('value');

        var data_value = "0";

        getAllActionReport(doc,data_value);

        $('.report_display').removeClass('hidden');


 });


      // get the all action of the report module.

      function getAllActionReport(doc,data_value)

          {
                    var project_id = $('.project_id_report').val();

                    var project_path = $('.reports_record #project_path').val();

                    var project_name = doc;

                    var token = $('#csrf-token').val();  

                    var html = "<div class='indexingOfReports col-md-12'><div class='auther_main col-md-4'><h4>Author</h4></div><div class='action_main col-md-3'><h4>Action</h4></div> <div class='description_main col-md-3'><h4>Description</h4></div><div class='time_at_main col-md-2'><h4>Date and time</h4></div></div>";

                       $.ajax({

                        type : "POST",
                        url : "{{url('/')}}/get_action",
                        data : {     
                          _token       : token,
                          project_id   : project_id,
                          data_value   : data_value,
                          project_name : project_name,
                          project_path : project_path,

                        },
                        success:function(response){
                        
                          $.each(response,function(key,value){

                           var author = value.auther;
                           var action = value.action;
                           var document_action = value.document;
                           var time = value.time;


                           html+="<div class='report_list col-md-12'><div class='auther_detail col-md-4'>"+author+"</div><div class='action_type col-md-3'>"+action+"</div><div class='description col-md-3'>"+document_action+"</div><div class='time_at col-md-2'>"+time+"</div></div>";
                         
                          });

                          $('.report_display').html(html);

                        }

                      });
          }


          function getGroupAndUser(){

              var token = $('#csrf-token').val();
              var project_id = $('.project_id_report').val();
            
              $.ajax({
                type:"POST",
                url:"{{ Url('/') }}/get_allgroups",
                      data:{
                          _token : token,
                           project_id :project_id,       
                        },  

                success: function (response) { 

                      var html = '<div class="table table-hover table-bordered table_color group_and_user_list"><div class="check-box select_check_group">  <input type="hidden" class="check-box-input-main"><span class="main-user_list"><i class="fa fa-caret-down "></i></span><span>All groups</span></div></div>';
                    
                      $.each( response, function( key, value) {
                                  
                                   var group_id = value.groups.id;
                                   var GroupUserRole = value.groups.group_user_type;
                                   var group_name = value.groups.group_name;
                                   var permission  = value.groups.permission;


                          html += "<div class='drop_box_document groups_list'><div class='document_index index-drop' ><div class='check-box select_check group_listing'>  <form  action='#' method='post'><input type='hidden' class='check-box-input'  name='groups_select' data-group_type='"+GroupUserRole+"' data-per='"+permission+"' data-value='"+group_id+"'><span class=' toggle_user'>";
                                         
                                        if( value.users != '')
                                        {
                               html+="<i class='fa fa-caret-down '></i>";
                                        }
                              
                              html+="</span></form><a href='javascript:void(0)' data-value='"+group_id+"' id='' class='groups'><i class='fas fa-user-cog'></i> "+value.groups.group_name+"</a></div></div></div><div class='users_list'>";

                                    $.each( value.users, function( key, value){

                                        html+="<div class='drop_box_document'><div class='document_index index-drop' ><div class='check-box select_check user_listing'><form  action='#' method='post'><input type='hidden' class='check-box-input'  name='users_select'></form>";

                                        if(GroupUserRole == 'Administrator')
                                        {
                                          html+='<i class="fas fa-user-shield"></i>';

                                        }else{

                                          html+="<i class='fa fa-user' aria-hidden='true'></i>";
                                        }   

                                        html+=" <a href='javascript:void(0)' id='' class='groups'>"+value+"</a></div></div></div>";
                                    });

                                    html+="</div>";

                                                          
                              });

                           $('.groupAndUsers').html(html);  

                    }


                });

          }


        $(document).on('click','.toggle_user',function(){
      
              $(this).parent().parent().parent().parent().next().toggle();

        });

        $(document).on('click','.main-user_list',function(){
      
          $('.users_list').toggle();

        });
         
         // Setting save

        // $(document).on('.water_mark_setting_down .watermark_setting_save','click',function(){
        //       alert('sdfsdfsd');
        // });




</script>

  <!-- End custom js for this page-->
  @yield('page_specific_script')

</body>
      <!--  open -->
 <div class="overlay_body hidden">

          <div class="loader14">
              <div class="loader-inner">
                  <div class="box-1"></div>
                  <div class="box-2"></div>
                  <div class="box-3"></div>
                  <div class="box-4"></div>
              </div>
              <span class="text">loading</span>
          </div>
  </div>

   <!--  close -->
</html>
  
  