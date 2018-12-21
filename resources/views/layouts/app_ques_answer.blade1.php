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

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

 <!--  icon cdn date 18 oct 2018 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
 
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

                   var window_width = $(window).width();
                   var window_height = $(window).height();

                    $('#tree4').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

                    var clickEvent = $('.document_permission').find('span').first();
                    var triggerEvent  = clickEvent.find('.shuffle').first();
                    setTimeout(function(){ triggerEvent.trigger('click') },0);

                    $('.indexing_qu').css('height',window_height-230);

                 });  


                 $(document).on('click','.document_permission',function(event){

                        event.preventDefault();
                        event.stopPropagation(); 

                        var directory_url = $(this).data("value");

                        var current_directory = $('.current_dir_qa').val(directory_url);

                        var token =$('#csrf-token').val(); 

                        ques_display(token,directory_url);
                  
                      });



                 // question display

                 function ques_display(token,directory_url){

                    $('.document_view_block').removeClass('hidden');

                    var project_id = $('.project_id_qu').val();

                    var directory_url = $('.current_dir_qa').val();

                    var folder = directory_url.split('/');

                    var folder_name = folder.pop();

                    $('.back_arrow_qa').html(folder_name);
                    
                    var html="";
                    var box = $('.indexing_qu');
                  
                      $.ajax({
                              
                              type:"POST",
                              url:"{{ Url('/') }}/show_questions",
                              data:{
                                  _token : token,
                                  directory_url: directory_url,
                                  project_id   :project_id
                              },  
                              // multiple data sent using ajax//
                              success: function (response) {  

                                 $.each(response.question_to,function(key,value){

                                    html +="<div class='question_list_qa'><div class='check_input'><input type='checkbox' class='question_check'></div><h5 class='send_by'>"+value.sender_name+"</h5>("+value. group_name+") <span class='date'>"+value.date+"</span><p class='ques_subject'>"+value.subject+"</p><button class='awaiting' style='color:red;'>Awaiting reply</button><p class='related_to'><h6>Related to:</h6> "+value.document_name+"</p></div>";

                                   });


                                 $.each(response.question_by,function(key,value){

                        
                                    html +="<div class='question_list_qa'><div class='check_input'><input type='checkbox' class='question_check'></div><h5 class='send_by'>"+value.sender_name+"</h5>("+value. group_name+") <span class='date'>"+value.date+"</span><p class='ques_subject'>"+value.subject+"</p><button class='awaiting' style='color:green;'>In progress</button><p class='related_to'><h6>Related to:</h6>  "+value.document_name+"</p></div>";

                                   });

                                  $('.indexing_qu').html(html);

                              }
                    
                            });

                    }

        </script>
  <!-- End custom js for this page-->
  @yield('page_specific_script')
</html>
  
  