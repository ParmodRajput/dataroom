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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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

                   $('.main_question_container').css('height',window_height-190);

                    $('#tree4').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

                    var clickEvent = $('.document_permission').find('span').first();
                    var triggerEvent  = clickEvent.find('.shuffle').first();
                    setTimeout(function(){ triggerEvent.trigger('click') },0);

                    $('.document_scroll_done').css('height',window_height-210);

                 });  

                AutoLoadUsersForSelect();

 
                 $(document).on('click','.document_permission',function(event){

                        event.preventDefault();
                        event.stopPropagation(); 

                        $('.delete_items').addClass('hidden');

                        $('.reply_section').addClass('hidden');

                        var directory_url = $(this).data("value");

                        $('.related_to_doc').val(directory_url);

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

                    var authEmail = $('#AuthEmailOfProject').val();

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
 
                                  if(value.sender_email = authEmail)
                                  {
                                    html +="";
                                  }else{


                                    html +="<div class='question_list_qa' data-ques_id='"+value.question_id+"' data-subject='"+value.subject+"' data-content='"+value.content+"' data-sender_name ='"+value.sender_name+"' data-status='0'  data-date='"+value.date+"' data-document_name='"+value.document_name+"'><div class='check_input'><input type='checkbox' name='ques_check' class='question_check' data-ques_id='"+value.question_id+"'></div><div class='question_containor'><div class='question_containor_fir'><h5 class='send_by'>"+value.sender_name+"("+value. group_name+")</h5><p class='ques_subject'>"+value.subject+"</p><p class='related_to'><h6>Related to:</h6> "+value.document_name+"</p></div></div><div class='question_containor_sec'><span class='date'>"+value.date+"</span><div class='note_ques_status'><button class='waiting_reply'>Awaiting reply</button></div></div></div>";

                                    }

                                 });

                                 $.each(response.question_by,function(key,value){

                        
                                   html +="<div class='question_list_qa' data-ques_id='"+value.question_id+"' data-subject='"+value.subject+"' data-content='"+value.content+"' data-sender_name='"+value.sender_name+"' data-status='1'  data-date='"+value.date+"' data-document_name='"+value.document_name+"'><div class='check_input'><input type='checkbox' name='ques_check' class='question_check' data-ques_id='"+value.question_id+"'></div><div class='question_containor'><div class='question_containor_fir'><h5 class='send_by'>"+value.sender_name+"("+value. group_name+")</h5><p class='ques_subject'>"+value.subject+"</p><p class='related_to'><h6>Related to:</h6> "+value.document_name+"</p></div></div><div class='question_containor_sec'><span class='date'>"+value.date+"</span><div class='note_ques_status'><button class='in_progress_ques'>In Progress</button></div></div></div>";


                                   });

                                  $('.indexing_qu').html(html);

                              }
                    
                            });

                    }



      // // Accordion

      // var acc = document.getElementsByClassName("accordion");
      // var i;

      // for (i = 0; i < acc.length; i++) {
      //     acc[i].addEventListener("click", function() {
      //         this.classList.toggle("active");
      //         var panel = this.nextElementSibling;
      //         if (panel.style.display === "block") {
      //             panel.style.display = "none";
      //         } else {
      //             panel.style.display = "block";
      //         }
      //     });
      // }

      // //end

      $(document).on('click','.question_list_qa',function(){


         $('.delete_items').removeClass('hidden');
         $('.reply_editor').addClass('hidden'); 
         $('.reply_answer').removeClass('hidden'); 
         
        var html ='';

        $('.indexing_qu input:checkbox').prop('checked', false);
        $(this).find('input:checkbox').prop('checked', true);

        $('.reply_section').removeClass('hidden');
        $('.action_button').click();

        var subject = $(this).data('subject');
        var content = $(this).data('content');
        var sender_name = $(this).data('sender_name');
        var date = $(this).data('date');
        var document_name = $(this).data('document_name');
        var get_status = $(this).data('status');
        var question_id = $(this).data('ques_id');
        var project_id  = $('.project_id_qu').val();

        $('.reply_question_id').val(question_id);


        if(get_status == 0)
        {
          html +="<button class='waiting_reply'>Awaiting reply</button>";

        }else{

          html +="<button class='in_progress_ques'>In progress</button>";
        }

        $('.right_header').html(html);

        $('.main_question_section .sender_name').html(sender_name);
        $('.main_question_section .subject_ques').html(subject);
        $('.main_question_section .date_section').html(date);
        $('.main_question_section .content_ques').html(content);
        $('.header_subject').html(subject);
        $('.relate_header .doc_name_header').html(document_name);
        $('.reply_document_name').val(document_name);

        // get the all reply of the question 

        
        getReplies(project_id,question_id);


      });

      // get the all reply of the question


       function getReplies(project_id,question_id){

          var token = $('#csrf-token').val(); 

          $.ajax({
            type : "POST",
            url : "{{url('/')}}/reply_get",
            data : {
              project_id : project_id,
              question_id : question_id,
              _token      : token,

            },
            success:function(response){
               
              var html ='';
                
              $.each(response,function(key, value){

                var reply_user = value.reply_by;
                var get_reply_user = reply_user.split("@");
                var length = get_reply_user.length;
                var get_reply_to = value.reply_to;

                var reply_to = get_reply_to.split(',');


                if(length !== 1);
                {
                    var reply_user = get_reply_user[0];
                }

                  html +="<button class='ques_ans_list action_button'><input type='hidden' id='reply_qu_id' value="+value.id+" ><div class='question_block_up'><div class='question_block_first'><H4 class='reply_sender_name'>"+reply_user+"</H4><p class='reply_subject_ques'>"+value.reply_subject+"</p><p class='reply_to'>To: "+get_reply_to+"</p></div><div class='question_block_second'><div class='question_action_move'><span class='reply_all_ques'><i class='fa fa-reply-all'></i></span> <span class='frwd_ques' data-for_subject="+value.reply_subject+" data-for_content="+value.reply_content+"><i class='fa fa-share'></i></span></div><div class='remove_question'><i class='fa fa-times-circle'></i></div><p class='reply_date_section'>"+value.time+"</p></div></div><div class='question_block_bottom'><p class='reply_content_ques'>"+value.reply_content+"</p></div></button>";
                      
              });

              $('.replied_container').html(html);

            }

          });  
      }


      $(document).on('click','.action_button',function(){

          $('.reply_editor').addClass('hidden');
          $('.reply_answer').removeClass('hidden');

      });

     
      // reply module

      $('.reply_answer').click(function(){

          $(this).addClass('hidden');
          $('.reply_editor').removeClass('hidden');


      });

      $('.cancle_reply_type').click(function(){

          $('.reply_editor').addClass('hidden');

          $('.reply_answer').removeClass('hidden');
      })


      // Reply question

      $(document).on('click','.question_reply_qa',function(){
      
        var token = $('#csrf-token').val();
        var project_id  = $('.project_id_qu').val();
        var send_to = $('.multipleSelectUsers').val();

        var reply_subject = $('.reply_subject').val(); 
        var reply_content  = $('.reply_question_content').val();
        var question_id =  $('.reply_question_id').val();
        var project_name = $('.project_name_qu').val();
        var document_name = $('.reply_document_name').val();
        var auth_name =  $('.auth_name').val();
        var time = new Date();
       // alert(reply_content);
        if(send_to && reply_subject && reply_content){
         $.ajax({
            type : "POST",
            url : "{{url('/')}}/reply_send",
            data : {

              project_id : project_id,
              send_to    : send_to,
              reply_subject : reply_subject,
              reply_content : reply_content,
              question_id   : question_id,
              project_name : project_name,
              document_name : document_name,
              _token      : token,

            },

            success:function(response){

              
              var html1 = '<button class="answere_by_me">Answered by Me</button>';

              if(response == 'reply_sent')
              {


                 getReplies(project_id,question_id);

                 
              }

              $(".question_check:checked").parent().parent().find('.question_containor_sec .note_ques_status').html(html1);

              $('.right_header').html(html1);
              $('.reply_subject').val('');
              $('.reply_question_content').val('');

            }

        });

        }else{
         // alert("gfdgfdgfdg");
          if(send_to == ''){
           // alert("users");
          $('#alert_reply_user').show().html('<span class="help-block">Please select users</span>');

             $('#reply_user').click (function(){

                 $('#alert_reply_user').hide();

             });

          }  

          if(reply_subject == ''){
           // alert("users");
          $('#alert_reply_subject').show().html('<span class="help-block">Please enter subjet</span>');

             $('#reply_subject').click (function(){

                 $('#alert_reply_subject').hide();

             });

          } 

          if(reply_content == ''){
           // alert("users");
          $('#alert_reply_content').show().html('<span class="help-block">Please enter content</span>');

             $('#reply_content').click (function(){

                 $('#alert_reply_content').hide();

             });

          }                     
          


        }
         
      });

      $(document).on('click','.remove_question',function(){

        var token = $('#csrf-token').val();

        var reply_id = $('#reply_qu_id').val();
        var project_id  = $('.project_id_qu').val();
        var question_id = $('.reply_question_id').val();

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this question!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                       
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('/')}}/reply_delete",
                                    data : {

                                      project_id : project_id,
                                      reply_id    : reply_id,     
                                      _token      : token,

                                    },

                                    success:function(response){

                                         if(response == 'delete')
                                         {
                                            getReplies(project_id,question_id);
                                            $('.check-box-input-main input:checkbox').prop('checked', false);

                                         }

                                    }
                               });
                  } 
              });
     });

    // $(document).on('click','.frwd_ques',function(){


    // });   


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

           $(document).on('click','.new_data_room',function(){
              $('#dismiss').click();
           });
           

          $(document).on('click','.check-box-input-main',function(){

             if ($(this).prop('checked')==true){ 

               $('.indexing_qu input:checkbox').prop('checked', true);
               $('.delete_items').removeClass('hidden');

            }else{
              
               $('.indexing_qu input:checkbox').prop('checked', false);
               $('.delete_items').addClass('hidden');
            }

           });


          //delete question
 
          $(document).on('click','.delete_items',function(){

                var token = $('#csrf-token').val();
                var project_id  = $('.project_id_qu').val();

                var deleteQues = [];

                $.each($("input[name='ques_check']:checked"), function(e)
                {        
   
                      deleteQues.push($(this).data('ques_id')); 

                });


              swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this question!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"{{ Url('/') }}/delete_question",
                            data:{
                              _token : token,
                               question_id: deleteQues,
                               project_id : project_id
                            },  

                            // multiple data sent using ajax//
                            success: function (response) {
                               
                              if(response =='Delete_ques')
                              {
                                var dir = $('.current_dir_qa').val();

                                var token =$('#csrf-token').val(); 

                                ques_display(token,dir);

                                $('.delete_items').addClass('hidden');

                              }

                             }
                     });
                  } 
              });

          });


   $(document).on('click','.frwd_ques',function(e){
   
      $('.reply_editor').removeClass('hidden');
      $('.reply_answer').addClass('hidden');

      var content = $(this).data('for_content');
      var subject = $(this).data('for_subject');

      $('.reply_subject').val(subject);
      $('.reply_question_content').val(content);

       e.preventstop();
      
   });


   function AutoLoadUsersForSelect(){

    var project_id  = $('.project_id_qu').val();
    var token = $('#csrf-token').val(); 
    var AuthEmail = $('#AuthEmailOfProject').val();

              $.ajax({
            type : "POST",
            url : "{{url('/')}}/project_users",
            data : {
              project_id : project_id,
              _token      : token,
            },
            success:function(response){

              var html ='<option selected value="'+AuthEmail+'">Q&A coordinators</option>';

               $.each(response,function(key, value){

                 html +=" <option value="+value+">"+value+"</option>";
                      
               });

               $('.multipleSelectUsers').html(html);
           
            }

           });
   }


    
     $(document).on('click','.reply_all_ques',function(e){
   
      $('.reply_editor').removeClass('hidden');
      $('.reply_answer').addClass('hidden');


      $('.reply_subject').val('');
      $('.reply_question_content').val('');

       e.preventstop();
      
   });


  $(document).on('click','.send_question',function(){

    // $('#genrate_question').modal('hide');

     var doc_path =  $('.related_to_doc').val();
     var project_id  = $('.project_id_qu').val();
     var token = $('#csrf-token').val(); 
     var users = $('.ques_ans_docs_group .multipleSelectUsers').val();
     var subject = $('.question_subject').val();
     var ques_content  = $('.question_content').val();
     var project_name  = $('.project_name_in').val();
     var directory_url = $('.current_dir_qa').val();
     //alert(doc_path);
     if(users && subject && ques_content){
             $.ajax({

                type : "POST",
                url : "{{url('/')}}/send_question",
                data : {
                  _token       : token,
                  doc_path     : doc_path,
                  project_id   : project_id,
                  users        : users,
                  subject      : subject,
                  ques_content : ques_content,
                  project_name : project_name,

                },

              success:function(response){
                
                  if(response == 'send_question'){

                     ques_display(token,directory_url);
                     $('.question_subject').val('');
                     $('.question_content').val('');
                     $('#genrate_question').modal('hide');

                  }
                }

               }); 
     }else{

          if(users == ''){
           // alert("users");
          $('#alert_user_select').show().html('<span class="help-block">Please select users</span>');

             $('#user_select').click (function(){

                 $('#alert_user_select').hide();

             });

          }

          if(subject == ''){
          //  alert("subject");
           $('#alert_question_subject').show().html('<span class="help-block">Please enter subject</span>');
          
             $('#question_subject').click (function(){

                 $('#alert_question_subject').hide();

             });         
          }   

          if(ques_content == ''){
           // alert("ques_content");
           $('#alert_question_content').show().html('<span class="help-block">Please enter content</span>');
          
             $('#question_content').click (function(){

                 $('#alert_question_content').hide();

             });          
          }

     }

   });


    $(document).on('click','.search_filter_btn',function(){

     var directory_url = $('.current_dir_qa').val();

     var project_id  = $('.project_id_qu').val();

     var field_content  = $('.search_filter').val();

     $('.filteredTextContent').removeClass('hidden');

     $('.text_filter').html(field_content);

     $('.move_last_folder_qa').addClass('hidden');

     var token = $('#csrf-token').val(); 

     $.ajax({

        type : "POST",
        url : "{{url('/')}}/search/question",
        data : {
          _token       : token,
          project_id   : project_id,
          field_content : field_content,

        },

      success:function(response){

        var html1 ='';
        
        $.each(response.question_to,function(key,value){
 
                      html1 +="<div class='question_list_qa' data-ques_id='"+value.question_id+"' data-subject='"+value.subject+"' data-content='"+value.content+"' data-sender_name='"+value.sender_name+"' data-status='0'  data-date='"+value.date+"' data-document_name='"+value.document_name+"'><div class='check_input'><input type='checkbox' name='ques_check' class='question_check' data-ques_id='"+value.question_id+"'></div><div class='question_containor'><div class='question_containor_fir'><h5 class='send_by'>"+value.sender_name+"("+value. group_name+")</h5><p class='ques_subject'>"+value.subject+"</p><p class='related_to'><h6>Related to:</h6> "+value.document_name+"</p></div></div><div class='question_containor_sec'><span class='date'>"+value.date+"</span><div class='note_ques_status'><button class='waiting_reply'>Awaiting reply</button></div></div></div>";

        });
                   

         $.each(response.question_by,function(key,value){
                        
          html1 +="<div class='question_list_qa' data-ques_id='"+value.question_id+"' data-subject='"+value.subject+"' data-content='"+value.content+"' data-sender_name='"+value.sender_name+"' data-status='1'  data-date='"+value.date+"' data-document_name='"+value.document_name+"'><div class='check_input'><input type='checkbox' name='ques_check' class='question_check' data-ques_id='"+value.question_id+"'></div><div class='question_containor'><div class='question_containor_fir'><h5 class='send_by'>"+value.sender_name+"("+value. group_name+")</h5><p class='ques_subject'>"+value.subject+"</p><p class='related_to'><h6>Related to:</h6> "+value.document_name+"</p></div></div><div class='question_containor_sec'><span class='date'>"+value.date+"</span><div class='note_ques_status'><button class='in_progress_ques'>In Progress</button></div></div></div>";


        });
          //           // alert(html);

        $('.indexing_qu').html(html1);


      }

    });


   });




  function getAuthAllProjects(){

  var token = $('#csrf-token').val();  

       $.ajax({
        type : "POST",
        url : "{{url('/')}}/check/projects",
        data : {     
          _token      : token,
        },
        success:function(response){

          var html ='<li class="btn-block new_data_room" data-toggle="modal" data-target="#create_project"><span class="new_room"><i class="fas fa-plus"></i></span> Create New Project<i class=""></i> </li>';

           $.each(response,function(key, value){

             html +="<div class='btn-block new_data_room'><span><i class='fas fa-circle'></i></span><a href='{{url('/')}}/project/"+value.id+"/documents'>"+value.project_name+"</a></div>";
                  
           });

         $('.list-unstyled').html(html);

        }
      });

 }



 $(document).on('click','.icon_close_filter',function(){

    var token = $('#csrf-token').val(); 
    var directory_url = $('.current_dir_qa').val(); 
    ques_display(token,directory_url);

    $('.filteredTextContent').addClass('hidden');

    $('.move_last_folder_qa').removeClass('hidden');

    $('.search_filter').val('');


 });



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
  
  