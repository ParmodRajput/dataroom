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
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <!--  icon cdn date 18 oct 2018 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  <!-- end -->
<style type="text/css">button#myBtn {
    background-color: #18cad7!important;
    color: #fff;
}</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('dist/img/') }}" />
</head>
<body>
  <div class="container-scroller">
    @include('includes.header')
  <!-- partial -->
    <div class="container-fluid page-body-wrapper">
  @include('includes.side')
  <div class="main-panel">
   @yield('content')
   
  </div>
  </div>
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('js/vendor.bundle.base.js')}}"></script>
  <script src="{{ asset('js/vendor.bundle.addons.js')}}"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fastselect/0.7.3/fastselect.standalone.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

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
      }
      
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

</script>
</body>

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

<!-- get document script -->

<script>
$(document).ready(function(){

        getUserForSelectQues();
        getAuthAllProjects();


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


        $(".folder_index").resizable();
        $(".left_section").resizable();
        
        check_status = 1;
        response_status = '';
        // Document details
         var GetFolderName = $('.content-wrapper .project_name').val();
         var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetFolderName+"";
         $('.checked_doc_details').html(showDocWithDoc); 


        $(this).bind('click', function(){
               hideRightClickPopup();
               $('.rightClickPopUpWithOutValue').css("display", "none");
    });
                     
    project_name =  "<?php echo $project_name ?>";
         $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
         
         $('#tree3').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

            var clickEvent = $('.projects').find('span').first();
            var triggerEvent  = clickEvent.find('.shuffle').first();
            setTimeout(function(){ triggerEvent.trigger('click') }, 0);

            var token =$('#csrf-token').val();
            var directory_url= $('.projects').first().data("value");
            data_display(token,directory_url);  


   //click open folders
    $(document).on('click','.projects',function(event){

      $('.table.table-hover.table-bordered.table_color').removeClass('hidden');
      $('.table.table-hover.table-bordered.table_color.recycle_bin').addClass('hidden');
      $('.upload_table .document_index_buttons ').removeClass('hidden');
      $('.upload_table .document_index_recycle_bin').addClass('hidden');
     
      $('.drop_box_document input:checkbox').prop('checked', false);
      $(this).parent().parent().find('input:checkbox').click();

        $('.ui-droppable').removeClass('hidden');
        var getPermission = $(this).data('permission');
        var checkPermission = $(this).attr('permission');

        $('.filteredTextContent').addClass('hidden');
        $('.back-arrow.move_last_folder').removeClass('hidden');

          
         if( checkPermission == '')
         {
             $('[permission="1"]').addClass('hidden'); 
             $('[permission="2"]').addClass('hidden');
         } 


         if(getPermission == '1')
          {
              $('[permission="1"]').removeClass('hidden'); 
              $('[permission="2"]').removeClass('hidden'); 
              $('[permission="3"]').removeClass('hidden'); 

          }

         if( getPermission == '2' || getPermission == '3' || getPermission == '4' || getPermission == '5')
          {

              $('[permission="1"]').addClass('hidden'); 
              $('[permission="2"]').removeClass('hidden'); 
              $('[permission="3"]').addClass('hidden'); 
            
          }

          if(getPermission == '6' || getPermission == '7' )
          {
             $('[permission="1"]').addClass('hidden'); 
             $('[permission="2"]').addClass('hidden');
             $('[permission="3"]').addClass('hidden'); 
          }

          
          $('.projects#projects').addClass('verifyCheck');
          $('.projects').children("span").removeClass("active");
          $(this).children("span").addClass("active");
          var indexDoc = $(this).data('index');
          $('.document_indexing_count').val(indexDoc);


        event.preventDefault();
        event.stopPropagation(); 

        // if (this == event.target ) {
        var directory_url = $(this).data("value");
 
        getLastUrl(directory_url);
        
        var current_directory = $('#directory_current .current_dir').val(directory_url);
        //set value in current direcory for upload document by first way
        $('.directory_location #current_directory ').val(directory_url);

       //set value in current direcory for upload document by second way
        $('.current_dir_down').val(directory_url);

        //bydefault
        $('#current_directory_project').val(directory_url);

        var token =$('#csrf-token').val(); 
        data_display(token,directory_url);
      // }
  
      });


    $(document).on('click','.doc_index_list a',function(){

         var getPermission1 = $(this).data('permission');

         if(getPermission1 == 1 || getPermission1 == '')
         {
            
             $('.upload_table').removeClass('hidden');

         }else{

             $('.upload_table').addClass('hidden');
         }
 
    });


    //document_permission

     $(document).on('click','.document_permission',function(event){

        event.preventDefault();
        event.stopPropagation();


        $('#document_permission_modal input:checkbox').removeAttr('disabled'); 

           var token =$('#csrf-token').val();
           var directory_url = $(this).data("value");
           var folder = directory_url.split('/');
           var folder_name = folder.pop();

           $('#document_permission_modal input:checkbox').prop('checked', false);

           $('#current_permission_document').val(directory_url);
 
           $('.section1.currentFolderName').html(folder_name);

           var get_permission_doc = $(this).data('permission');

           var data_verify = $(this).data('verify');

           showPermission(get_permission_doc,data_verify);
          
          //  $.ajax({
              
          //     type:"POST",
          //     url:"{{ Url('/') }}/display_set_permission",
          //     data:{
          //       _token : token,
          //       directory_url : directory_url,
               
          //     },  
          //     // multiple data sent using ajax//
          //     success: function (response) { 
                     
          //           alert(response);
          //     }
          // });

     });

      $(document).on('click','.close_permission_modal',function(){

          var checker =  $('#CheckUserChangePermission').val();
          if(checker == 1){
                 
                 alert('Do you want to apply set permission ?');

          }else{

            $('#document_permission_modal').modal('hide');
          }

       });
    
   // trigger main project folder on reload. 

        var clickEvent1 = $('.document_permission').find('span').first();
        var triggerEvent1  = clickEvent1.find('.shuffle').first();
        setTimeout(function(){ triggerEvent1.trigger('click') },0);
        var getPermissionOnPopUp = $('.document_permission').first().data('permission');
        var checkPermission = $('.document_permission').first().attr('permission');
        // alert(getPermissionOnPopUp);

        $('.projects').first().attr("data-permission",getPermissionOnPopUp);
        $('.projects').first().attr("permission",checkPermission);

   //end

   // display set permission.
     function showPermission(get_permission_doc,data_verify){
         
           var permission = get_permission_doc.split(",");

           $.each(permission,function(key ,value){

           var loatPermission = value.split('/');

           var loatP  = loatPermission['1'];



           if(loatP == 1 && data_verify == 0 )
           {
               $('#document_permission_modal input:checkbox').attr('disabled',"disabled");

           }

           var permission = value;

           $('[data-value = "'+permission+'"]').prop('checked', true);

           });
     }   

     
   //Create new Data room

    $('.no_contract').click(function(){
       $('.industry_label').removeClass('hidden_label');
    });
    $('.contract').click(function(){
       $('.industry_label').addClass('hidden_label');
    });


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


  // Create folder//
   $(document).on('click','.submit_folder',function(event){
    
           var path = $('#current_directory').val();
           var project_id = $('.projects_id').val();
           var project_name = $('.project_name').val();
           var get_genrate_folder = $('#folder_created').val();
           
           if(get_genrate_folder !== ''){

              if(/^[a-zA-Z0-9-_ ]*$/.test(get_genrate_folder) == true){


                       var document_index = $('.document_indexing_count').val();
                       var genrate_folder = get_genrate_folder.replace(/[^a-zA-Z0-9]/g, '_');
                       var getPath = path+"/"+genrate_folder; 
                       var box = $('.indexing');
                       var folder = $('#tree2');
                       
                       var html="";
                       var html1="";
                       var token =$('#csrf-token').val();
                       
                        $.ajax({
                              type:"POST",
                              url:"{{ Url('/') }}/create_folder/new_folder",
                              data:{
                                _token : token,
                                 project_id : project_id,
                                 genrate_folder : genrate_folder,
                                 path: path,
                                 document_index : document_index,
                                 getPath     : getPath
                              },  
                          success: function (response) {  

                            if(response !== 'error')
                              { 
                      
                                if (!$('[data-value = "'+path+'"]').find('ul').length) {
                                     
                                    $('[data-value = "'+path+'"]').append('<ul> </ul>');
                                }

                                html1 +="<li id='projects' data-value='"+getPath+"'class='projects'><span class='doucment_name'>"+response+"</span></li>";
                             
                                  // $('[data-value = "'+path+'"]').find('ul').eq(0).append(html1);
                                   $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                                  var directory_url= path;

                                  DocumentTree(token,project_id);

                                  data_display(token,directory_url);



                              }
                      }   
                   });   

              }else{

                   $('#alert_create_folder').show().html('<span class="help-block">Not allowed special characters  </span>');
                   $('#folder_created').click (function(){
                   $('#alert_create_folder').hide(); 
                   });               

              }
                       
 
           }else{
                 //alert('Please enter folder name');
                 $('#alert_create_folder').show().html('<span class="help-block">Please enter folder name</span>');
                 $('#folder_created').click (function(){
                 $('#alert_create_folder').hide();
                 });
           }
   
    }); 
   
  
  // get ALL select files details //
    function FileDetails(getId) {

      $('.choose_file_upload.overlay').hide();
      $('#fileDetails').html('');
      $('.row.upload_file_details').show();
      $('.choose_upload_document').hide();
        // GET THE FILE INPUT.
        var fi = document.getElementById(getId);
          $('#myModal').modal("show");
          $("#progress-bar").width('0%');

      // THE TOTAL FILE COUNT.
            document.getElementById('total_file').innerHTML =
                '<b>Total Files: <b>' + fi.files.length + '</b></br >';
        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0) {

            // RUN A LOOP TO CHECK EACH SELECTED FILE.
            for (var i = 0; i <= fi.files.length - 1; i++) {

                var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
                var sizeF = fi.files.item(i).size; 

                var bytes = sizeF;

                var fsize = formatBytes(bytes);

                // SHOW THE EXTRACTED DETAILS OF THE FILE.
                document.getElementById('fileDetails').innerHTML =
                    document.getElementById('fileDetails').innerHTML + '<div class="row"><div class="col-md-12 "><div class="upload_details_index"><div class="col-md-6"><p>' +fname + '</p></div><div class="col-md-4"><p>' + fsize + '</p></div><div class="col-md-2"><p>X</p></div></div></div></div>';
            }
        }

    }


       function formatBytes(bytes) {
                    if(bytes < 1024) return bytes + " Bytes";
                    else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KB";
                    else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MB";
                    else return(bytes / 1073741824).toFixed(3) + " GB";
                };

    $(document).on('change','input:file',function(){

      $('.upload_modal_check').removeClass('hidden');
      $('.choose_around_file').addClass('hidden');
      

       var getId = $(this).attr('id');
       if(getId == 'file')
         {
          $('.changedFileTarget').attr('id','Upload_files_up');
         }else{
          $('.changedFileTarget').attr('id','Upload_files_down');
         }
       
       FileDetails(getId); 
       $('.changedFileTarget').show();
       $('#fileDetails').show();
       $('.file_status').show();

    })


    //Upload file using ajax
    
    $(document).on('submit','#Allfiles,#AllUploadFiles',function(event){

          var document_index = $('.document_indexing_count').val();
          $('.choose_file_upload.overlay').hide();
          event.preventDefault();
          var token = $("input[name=_token]").val(); 
          var path = $('.current_dir').val(); 
          var projects_id = $('.directory_location #project_id_doc').val();
          var project_id  = $('.directory_location #project_id_doc').val();   
          var formData = new FormData(this);
          var box = $('.indexing');
          var html="";
          var bar = $('.bar');
          var percent = $('.percent');
          var status = $('#status');
          $("#progress-bar").width('0%');
          var value = $('#file').val();

         $.ajax({
              type:"POST",
              url:"{{ Url('/upload_file')}}",
              data:formData,
              cache : false,
              processData: false,
              contentType: false,

         xhr: function(){
         var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              $("#progress-bar").width(percentComplete*100 + '%');
              $("#progress-bar").html('<div id="progress-status">' + percentComplete*100 +' %</div>');
             
             }
           
         }, false);
         
      return xhr;
    },

                success: function(response){ 

                 if(response == 'upload')
                 {  
                  $('.overlay_body').addClass('hidden');

                 swal("file uploaded successfully", "", "success");

                 $('.table_section.document_scroll').addClass('document_scroll_done');            
                    $.ajax({
                  type:"POST",
                  url:"{{ Url('/') }}/show_documents",
                  data:{
                    _token : token,
                    directory_url: path,
                    projects_id   : projects_id
                  },  
                  // multiple data sent using ajax//
                  success: function (response) {

                  //update documents trees

                  DocumentTree(token,project_id);

                var getfolder = response.folder_index;
                var getfiles = response.file_index;

                if(getfolder == '' && getfiles == '')
                {

                 html +="<div class='emplty_box_drag_drop'><span class='drag_document_img'><img src='{{asset("dist/img/icon-blue.png")}}'></span><span class='drag_document_texts'>Drag and Drop files here to upload</span></div>";
                
                }else{

                        $.each(getfolder,function(key ,value){

                          var document_name1 = value.document_name;
                          var path           = value.path;
                          var permission     = value.permission;
                          var fav            = value.fav;
                          var note           = value.note;
                          var ques           = value.ques;
                          var folder_id        = value.doc_id;

                          
                          var index         = value.doc_index;
                          var element1 = document_name1.substr(0, 45);

                          var count  = element1.length;

                          if(count >= 40)
                          {
                            var document_name  = element1+' . . .'; 
                          }
                          else{

                             var document_name  = element1;
                          }
                          
                          
                          if(document_index == '')
                          {
                            DocumentIndex = index;
                          }else{

                            DocumentIndex = document_index+'.'+index;
                          }
                         

                              html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' value="+document_name+" data-doc_id ='"+folder_id+"' data-type ='1' data-permission='"+permission+"' data-value="+path+" name='documents_select' ></form></div><h4><a href='javascript:void(0)' data-permission='"+permission+"' data-value='"+path+"' data-index='"+DocumentIndex+"' class='projects'><i class='fa fa-folder-o'></i> "+DocumentIndex+"&nbsp; &nbsp;"+document_name+"</a></h4></div><div class='icons-doc'>";

                              if(fav == '')
                              {
                                 html+="<div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div>";

                               }else{

                                 html+="<div class='fav_docs' data-value='"+path+"' style='visibility:visible'><span><i class='fa fa-star-o'></i></span></div>";

                               }

                              if(note == ''){

                                html+="<div class='notes_docs  hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div>";

                              }else{
                                
                                 html+="<div class='notes_docs' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-thumb-tack'></i></span></div>";
                              }
                               

                              if(ques == ''){

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-ques='0' data-value='"+path+"' ><span><i class='fa fa-comment-o'></i></span></div>";

                                           }else{

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans 'data-ques='1' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-comment-o'></i></span></div>";

                                           }

                               if(permission == ''){

                                          html+="<div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div>";

                                         }

                                         if(permission == '1')
                                         {

                                          html+="<div class='upload_doc_permis' data-value='"+path+"'><span><i class='fas fa-upload'></i></span></div>";
                                         }

                                         if(permission == '2')
                                         {

                                          html+="<div class='download_doc_permis' data-value='"+path+"'><span><i class='fas fa-download'></i></span></div>";
                                         }

                                          if(permission == '3')
                                         {

                                          html+="<div class='download_pdf_permis' data-value='"+path+"'><span><i class='fa fa-file-pdf-o'></i></span></div>";
                                         }

                                          if(permission == '4')
                                         {

                                          html+="<div class='print_doc_permis' data-value='"+path+"'><span><i class='fa fa-print'></i></span></div>";
                                         }
                                         if(permission == '5')
                                         {

                                          html+="<div class='encrypt_doc_permis' data-value='"+path+"'><span><i class='fas fa-lock'></i></span></div>";
                                         }
                                         if(permission == '6')
                                         {

                                          html+="<div class='view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                         }
                                         if(permission == '7')
                                         {

                                          html+="<div class='fence_view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                         }
                                         
                                          html+="</div></div></div>";

                                          });

                  $.each(getfiles,function(key ,value){
 
                              
                      var document_name = value.document_name;
                      var path          = value.path;
                      var index         = value.doc_index;
                      var permission     = value.permission;
                      var fav           = value.fav;
                      var note           = value.note;
                      var file_id        = value.doc_id;
                      var ques           = value.ques;


                        if(document_index == '')
                        {
                          DocumentIndex = index;
                        }else{

                          DocumentIndex = document_index+'.'+index;
                        }
                                  
                                      var myarr = document_name.split("/");
                                      var getElement = myarr.pop();
                                      //get file is jpg an png 

                                      var n =  document_name.lastIndexOf(".");
                                      var length  = document_name.length;
                                      var Ext = document_name.substring(n+1, length);

                                      var element1 = getElement.substr(0, 45);

                                      var count  = element1.length;

                                      if(count >= 40)
                                      {
                                        var element  = element1+' . . .'; 
                                      }
                                      else{

                                         var element  = element1;
                                      }

                                    
                                        html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' data-doc_id ='"+file_id+"' data-type ='0' value='"+element+"' data-permission='"+permission+"' data-value='"+path+"'></form></div><h4><a href='javascript:void(0)' value='"+path+"' data-permission='"+permission+"' data-doc_id ='"+file_id+"' data-value='"+path+"' data-index='"+DocumentIndex+"' id='"+path+"' class='drap doc_view_file'>";

                                         if(Ext == 'jpg' || Ext == 'png' || Ext =='jpeg')
                                           {

                                                 html+="<i class='fa fa-photo'></i>";

                                           }else if(Ext == 'zip'){

                                                 html+="<i class='far fa-file-archive'></i>";

                                           }else{
                                                
                                                html+="<i class='far fa-file'></i>";
                                           }


                                        html+= DocumentIndex+"&nbsp; &nbsp;"+element+"</a></h4></div><div class='icons-doc'>";

                                        if(fav == '')
                                              {
                                                 html+="<div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div>";

                                               }else{

                                                 html+="<div class='fav_docs' data-value='"+path+"' style='visibility:visible'><span><i class='fa fa-star-o'></i></span></div>";

                                               }

                                        if(note == ''){

                                            html+="<div class='notes_docs  hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div>";

                                          }else{
                                            
                                             html+="<div class='notes_docs' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-thumb-tack'></i></span></div>";
                                          }
                                        
                                        if(ques == ''){

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-ques='0'  data-value='"+path+"' ><span><i class='fa fa-comment-o'></i></span></div>";

                                           }else{

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-ques='1' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-comment-o'></i></span></div>";

                                           }

                                       if(permission == ''){

                                        html+="<div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div>";

                                       }

                                       if(permission == '1')
                                       {

                                        html+="<div class='upload_doc_permis' data-value='"+path+"'><span><i class='fas fa-upload'></i></span></div>";
                                       }

                                       if(permission == '2')
                                       {

                                        html+="<div class='download_doc_permis' data-value='"+path+"'><span><i class='fas fa-download'></i></span></div>";
                                       }

                                        if(permission == '3')
                                       {

                                        html+="<div class='download_pdf_permis' data-value='"+path+"'><span><i class='fa fa-file-pdf-o'></i></span></div>";
                                       }

                                        if(permission == '4')
                                       {

                                        html+="<div class='print_doc_permis' data-value='"+path+"'><span><i class='fa fa-print'></i></span></div>";
                                       }
                                       if(permission == '5')
                                       {

                                        html+="<div class='encrypt_doc_permis' data-value='"+path+"'><span><i class='fas fa-lock'></i></span></div>";
                                       }
                                       if(permission == '6')
                                       {

                                        html+="<div class='view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                       }
                                       if(permission == '7')
                                       {

                                        html+="<div class='fence_view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                       }
                                       
                                        html+="</div></div></div>";


                          });

                       }//blank


                    box.html(html);
                    $('#Allfiles')[0].reset();
                    $('#myModal').modal('hide');
                    $('.file_status').hide();
                    $('.changedFileTarget').hide();
                    
                    //$('#progress-div').addClass('reset');
                    $(".table_section").find(".index-drag").addClass("draggable");
                    $(".draggable").draggable({ helper : "clone"});
                    $(".table_section").find(".index-drop").addClass("droppable");

                    $(".droppable").droppable({
                          
                        drop: function( event, ui ) {
                              
                               var movedInFolder= $( this ).find('a').data('value');
                               $(ui.draggable).css('display','none');
                               var moveFile = $(ui.draggable).find('a').data('value');
                               var directoryPath = $('#current_directory_project').val();
                               var projects_id = $('.directory_location #project_id_doc').val();
                               //alert(moveFile);
                               $.ajax({
                                   type:"POST",
                                   url:"{{ Url('/') }}/move_documents",
                                   data:{
                                    _token : token,
                                    movedInFolder: movedInFolder,
                                    moveFile     : moveFile,
                                    projects_id  : projects_id,
                                    directoryPath : directoryPath

                                    }, 

                                    error: function (request, error) {                                  
                                        alert("File already exists at directory");
                                        data_display(token,directoryPath);
                                    },

                                    success:function(response){
                                      
                                      if(response == 'moved')
                                      {
                                         //swal("file moved successfully", "", "success");
                                         
                                      }
                                    } 

                            });
                         }
                   });
                 }
              }); 
                      
            }
          },
          error: function (error) {
            swal("Something Wrong", "error");
            location.reload();
          }

        });
     }); 

  // Delete folder and file 
   $(document).on('click','.delete_item',function(event){


          var paths = [];
          var token = $('#csrf-token').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var directory_url  =  $('.directory_location #current_directory').val(); 

          var path = $(this).data('value');
          paths.push(path); 

          swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"{{ Url('/') }}/delete_document",
                            data:{
                              _token : token,
                               url: paths,
                               projects_id : projects_id
                            },  

                            // multiple data sent using ajax//
                            success: function (response) {
                                   
                                    if (response != "error") {
                                      $('[data-value = "'+path+'"]').remove();
                                      swal(response+" deleted successfully", "", "success");

                                    }
  
                                  data_display(token,directory_url)
                             }
                     });
                  } 
              });
          
        
       });
   }); 

//show lastUrl
    function getLastUrl(directory_url){
      var html2="";
      var folder = directory_url.split('/');
           var folder_name = folder.pop();
           //alert(folder_name);
           html2+= folder_name;


           $('.back-arrow').html(html2);
     
    }


  // go to back folder 
      function upone_folder() {
        
        // for indexing

        var path1 =  $('.document_indexing_count').val();
        var n1 = path1.lastIndexOf(".");
        var documentIndex = path1.substring(0, n1);

        $('.document_indexing_count').val(documentIndex);
   
        // for directory
        var path =  $('.directory_location #current_directory ').val();  
        var root_path =  "<?php echo 'public/documents/'.Auth::user()->id ?>/"+project_name;
        var n = path.lastIndexOf("/");
        var token = $('#csrf-token').val();
        var directory_url = path.substring(0, n);

        var GetDestination = directory_url.split('/');
        var DestinationName = GetDestination[GetDestination.length-1];

        $('.checked_doc_details').html('<i class="fa fa-folder-o"></i>'+DestinationName);
        $('.create_notes_get').addClass('hidden');
        $('.notes_aside_text1').addClass('hidden');
        $('.submit_note1_doc').addClass('hidden');
        $('.note1_doc_delete').addClass('hidden');
        $('.file_view_aside').addClass('hidden'); 

        if (path != root_path) {
            data_display(token,directory_url);
            $(' #current_directory ').val(directory_url);  
         getLastUrl(directory_url);
        }
     }  
 

   // display data function
   function data_display(token,directory_url){

    
    $('.document_view_block').removeClass('hidden');
    $('.fav_filter').removeClass('hidden');
    $('.new_filter').removeClass('hidden');
    var projects_id = $('.directory_location #project_id_doc').val();
    var document_index = $('.document_indexing_count').val();  
    var html="";
    var html2 ="";
    var box = $('.indexing');
  
      $.ajax({
              
              type:"POST",
              url:"{{ Url('/') }}/show_documents",
              data:{
                  _token : token,
                  directory_url: directory_url,
                  projects_id   :projects_id
              },  
              // multiple data sent using ajax//
              success: function (response) { 
                GetDocumentInfoByResponse(response,document_index,directory_url);
                $('.notMoveInDiv').droppable("disable");       
              }
        });//ajax
   }

    function GetDocumentInfoByResponse(response,document_index,directory_url){

                var html="";
                var html2 ="";
                var html3 ="";
                var html4 = '';
                var box = $('.indexing');
                var user = '';

                  //first inner array

                var getfolder = response.folder_index;

                var getfiles = response.file_index;

                var currentUserCount = response.CurrentUserCount;

                var ProjectUsers  = response.ProjectUsers;


                $.each(ProjectUsers,function(key,value){
                  

                  html4+='<option value="'+value.member_email+'">'+value.member_email+'</option>';

                });

                $('#currentUserCount').val(currentUserCount);

                $('.doc_permission_modal').attr('data_user',currentUserCount);

                if(getfolder == '' && getfiles == '')
                {

                  html +="<div class='emplty_box_drag_drop'><span class='drag_document_img'><img src='{{asset("dist/img/icon-blue.png")}}'></span><span class='drag_document_texts'>Drag and Drop files here to upload</span></div>";

                 // html3 +='<div class="doc_index_list"><h4> <div class="upone" onclick="upone_folder();"><i class="fas fa-arrow-up custom upone-folder" ></i><div class="back-arrow"></div></div></h4></div>'; 

                 // $('#upFolerTogo').html(html3);

                 // getLastUrl(directory_url);
                 
                }else{

                          
                   $.each(getfolder,function(key ,value){
                          var document_name1 = value.document_name;
                          var path           = value.path;
                          var permission     = value.permission;
                          var fav            = value.fav;
                          var note           = value.note;
                          var ques           = value.ques;
                          var folder_id        = value.doc_id;
                          
                          var index         = value.doc_index;
                          var element1 = document_name1.substr(0, 45);

                          var count  = element1.length;

                          if(count >= 40)
                          {
                            var document_name  = element1+' . . .'; 
                          }
                          else{

                             var document_name  = element1;
                          }

                          if(document_index == '')
                          {
                            DocumentIndex = index;
                          }else{

                            DocumentIndex = document_index+'.'+index;
                          }
                         
                              html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' value="+document_name+" data-type ='1' data-doc_id ='"+folder_id+"' data-permission='"+permission+"' data-value="+path+" name='documents_select' ></form></div><h4><a href='javascript:void(0)' data-permission='"+permission+"' data-value='"+path+"' data-index='"+DocumentIndex+"' class='projects'><i class='fa fa-folder-o'></i> "+DocumentIndex+"&nbsp; &nbsp;"+document_name+"</a></h4></div><div class='icons-doc'>";

                              if(fav == '')
                              {
                                 html+="<div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div>";

                               }else{

                                 html+="<div class='fav_docs' data-value='"+path+"' style='visibility:visible'><span><i class='fa fa-star-o'></i></span></div>";

                               }

                              if(note == ''){

                                html+="<div class='notes_docs  hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div>";

                              }else{
                                
                                 html+="<div class='notes_docs' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-thumb-tack'></i></span></div>";
                              }
                               
                            if(ques == ''){

                               html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-ques='0' data-user='"+user+"' data-value='"+path+"' ><span><i class='fa fa-comment-o'></i></span></div>";

                             }else{

                                html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-user='"+user+"' data-ques='1' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-comment-o'></i></span></div>";

                             }

                               if(permission == ''){

                                          html+="<div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div>";

                                         }

                                         if(permission == '1')
                                         {

                                          html+="<div class='upload_doc_permis' data-value='"+path+"'><span><i class='fas fa-upload'></i></span></div>";
                                         }

                                         if(permission == '2')
                                         {

                                          html+="<div class='download_doc_permis' data-value='"+path+"'><span><i class='fas fa-download'></i></span></div>";
                                         }

                                          if(permission == '3')
                                         {

                                          html+="<div class='download_pdf_permis' data-value='"+path+"'><span><i class='fa fa-file-pdf-o'></i></span></div>";
                                         }

                                          if(permission == '4')
                                         {

                                          html+="<div class='print_doc_permis' data-value='"+path+"'><span><i class='fa fa-print'></i></span></div>";
                                         }
                                         if(permission == '5')
                                         {

                                          html+="<div class='encrypt_doc_permis' data-value='"+path+"'><span><i class='fas fa-lock'></i></span></div>";
                                         }
                                         if(permission == '6')
                                         {

                                          html+="<div class='view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                         }

                                         if(permission == '7')
                                         {
                                          html+="<div class='view_doc_permis_open' data-value='"+path+"'><span><img src='{{url('/')}}/dist/img/fance.png'></img></span></div>";

                                         }
                                         
                                          html+="</div></div></div>";

                                          });

                                    

                $.each(getfiles,function(key ,value){
 
                              
                      var document_name = value.document_name;
                      var path          = value.path;
                      var index         = value.doc_index;
                      var permission     = value.permission;
                      var fav           = value.fav;
                      var note           = value.note;
                      var file_id        = value.doc_id;
                      var ques           = value.ques;
                      

                        if(document_index == '')
                        {
                          DocumentIndex = index;
                        }else{

                          DocumentIndex = document_index+'.'+index;
                        }

                                      var myarr = document_name.split("/");
                                      var getElement = myarr.pop();
                                      //get file is jpg an png 

                                      var n =  document_name.lastIndexOf(".");
                                      var length  = document_name.length;
                                      var Ext = document_name.substring(n+1, length);

                                      var element1 = getElement.substr(0, 45);

                                      var count  = element1.length;

                                      if(count >= 40)
                                      {
                                        var element  = element1+' . . .'; 
                                      }
                                      else{

                                         var element  = element1;
                                      }

                                    
                                        html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' data-doc_id ='"+file_id+"' data-type ='0' value='"+element+"' data-permission='"+permission+"' data-value='"+path+"'></form></div><h4><a href='javascript:void(0)' value='"+path+"' data-permission='"+permission+"' data-doc_id ='"+file_id+"' data-value='"+path+"' data-index='"+DocumentIndex+"' id='"+path+"' class='drap doc_view_file'>";

                                         if(Ext == 'jpg' || Ext == 'png' || Ext =='jpeg')
                                           {
                                                 html+="<i class='fa fa-photo'></i>";

                                           }else if(Ext == 'zip'){

                                                 html+="<i class='far fa-file-archive'></i>";

                                           }else{

                                                 if(Ext == 'pdf'){

                                                   html+="<i class='fas fa-file-pdf'></i>";
                                                 }else{

                                                     html+="<i class='far fa-file'></i>";
                                                 }
 
                                           }


                                        html+= DocumentIndex+"&nbsp; &nbsp;"+element+"</a></h4></div><div class='icons-doc'>";

                                        if(fav == '')
                                              {
                                                 html+="<div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div>";

                                               }else{

                                                 html+="<div class='fav_docs' data-value='"+path+"' style='visibility:visible'><span><i class='fa fa-star-o'></i></span></div>";

                                               }

                                        if(note == ''){

                                            html+="<div class='notes_docs  hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div>";

                                          }else{
                                            
                                             html+="<div class='notes_docs' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-thumb-tack'></i></span></div>";
                                          }
                                        
                                        if(ques == ''){

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans' data-ques='0' data-value='"+path+"' ><span><i class='fa fa-comment-o'></i></span></div>";

                                           }else{

                                              html+="<div class='ques_ans_docs hidden_icon black_ques_ans'  data-ques='1' data-value='"+path+"' style='visibility:visible;'><span><i class='fa fa-comment-o'></i></span></div>";

                                           }

                                       if(permission == ''){

                                        html+="<div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div>";

                                       }

                                       if(permission == '1')
                                       {

                                        html+="<div class='upload_doc_permis' data-value='"+path+"'><span><i class='fas fa-upload'></i></span></div>";
                                       }

                                       if(permission == '2')
                                       {

                                        html+="<div class='download_doc_permis' data-value='"+path+"'><span><i class='fas fa-download'></i></span></div>";
                                       }

                                        if(permission == '3')
                                       {

                                        html+="<div class='download_pdf_permis' data-value='"+path+"'><span><i class='fa fa-file-pdf-o'></i></span></div>";
                                       }

                                        if(permission == '4')
                                       {

                                        html+="<div class='print_doc_permis' data-value='"+path+"'><span><i class='fa fa-print'></i></span></div>";
                                       }
                                       if(permission == '5')
                                       {

                                        html+="<div class='encrypt_doc_permis' data-value='"+path+"'><span><i class='fas fa-lock'></i></span></div>";
                                       }
                                       if(permission == '6')
                                       {

                                        html+="<div class='view_doc_permis' data-value='"+path+"'><span><i class='fas fa-eye'></i></span></div>";
                                       }
                                       
                                       if(permission == '7')
                                         {
                                          html+="<div class='view_doc_permis_open' data-value='"+path+"'><span><img src='{{url('/')}}/dist/img/fance.png'></img></span></div>";

                                         }
                                       
                                        html+="</div></div></div>";


                          });

                       }//blank

                          box.html(html);
                          $('.shareDocUsers').html(html4);
                       

                          $('#folder_create')[0].reset();
                          $('#genrate_folder').modal('hide'); 
                          $('.choose_upload_document').removeClass("beat");
                          $(".table_section").find(".index-drag").addClass("draggable");
                          $(".draggable").draggable({ helper : "clone"});

                          $(".table_section").find(".index-drop").addClass("droppable");

                              // drag and move document 
                              $(".droppable").droppable({
                                    
                                  drop: function( event, ui ) {
                                        
                                         var movedInFolder= $( this ).find('a').data('value');
                                         $(ui.draggable).css('display','none');
                                         var moveFile = $(ui.draggable).find('a').data('value');
                                         var directoryPath = $('#current_directory_project').val();
                                         var projects_id = $('.directory_location #project_id_doc').val();

                                         var token = $('#csrf-token').val();
                                         //alert(moveFile);
                                         $.ajax({
                                             type:"POST",
                                             url:"{{ Url('/') }}/move_documents",
                                             data:{
                                              _token : token,
                                              movedInFolder: movedInFolder,
                                              moveFile     : moveFile,
                                              projects_id  : projects_id,
                                              directoryPath : directoryPath

                                              }, 

                                              error: function(xhr, status, error) {

                                                var err = eval("(" + xhr.responseText + ")");
                                                var error_massage = err.message;

                                                alert(error_massage);
                                                data_display(token,directoryPath);

                                              },

                                              success:function(response){
                                                
                                                if(response == 'moved')
                                                {
                                                   //swal("file moved successfully", "", "success");
                                                   
                                                }
                                              } 

                                      });
                               }
                       });
            
    }
    

   // right click on document// 
    $(document).on('contextmenu','.documents_index_section .document_index' ,function(e) {

          $('.drop_box_document input:checkbox').prop('checked', false);
          e.preventDefault();

          $('.rightClickPopUpWithOutValue').css("display","none");

          var rightClickPositionLeft = e.pageX;

          var rightClickPositionTop  = e.pageY-63;

          var menuHeight=$('.right_click.drop-holder').height();
          //alert(e.pageY);

          //var comformHeight = windowHeight-e.pageY;
         var comformHeight = windowHeight-menuHeight;

          if(e.pageY >= comformHeight+20) {
            
          rightClickPositionTop  = e.pageY-285;

           var arrow = e.pageY-25;

             $('.right_click.drop-holder').addClass("arrow");

          }else{

            $('.right_click.drop-holder').removeClass("arrow");

          }

          var value = $(this).find('a').data('value'); 

          $('.checkToActionPopValue').val(value);

          var file_id = $(this).find('input:checkbox').data('doc_id');

          var DocumentType = $(this).find('input:checkbox').data('type');

          if(DocumentType == 1)
          {
            $('.view_doc_file').addClass('hidden');

          }else{
            
            $('.view_doc_file').removeClass('hidden');
          }

          var project_id  = $('.directory_location #project_id_doc').val();

          $(this).find('input:checkbox').trigger("click");

          //$('.right_click.drop-holder').css("top" ,rightClickPositionTop);
          //$('.right_click.drop-holder').css("left",rightClickPositionLeft);

          $('.right_click.drop-holder').css({"display":"block","top":rightClickPositionTop,"left":rightClickPositionLeft});

          $('.view_doc_file a').attr('href',"{{ Url('/') }}/file_view/"+project_id+"/Open_viewer/" +file_id ,
          '_blank');

          var getfileAndFolder = value.split('/');
          var fileAndFolder    = getfileAndFolder.pop();
          var checkFileAndFolder = fileAndFolder.split('.');
          var getZipFile         = checkFileAndFolder.pop();
          var count = checkFileAndFolder.length;

         $('#down-document').val(value);
         $('.copied_document').data('value',value);
         $('.delete_item').data('value',value);
         $('.rename_document').data('value',value);
         $('.In_paste_document').data('value',value);
         $('.extractDocument').data('value',value);

        if(getZipFile == 'zip')
        {
          $('.extract').show();
        }else{
          $('.extract').hide();
        }


        var paste_permit = $('#copy_document_directory').val(); 

        if( paste_permit != '')
        {
           if(count == '1')
           {
            $('li.ng-scope.paste').css("display", "none");
          }else{
            $('li.ng-scope.paste').css("display", "block");
          }
           
           
        }
       
        return false;

    });

       $(document).on('contextmenu','.menu_option_block' ,function(e)
        {
        

         hideRightClickPopup();
         var value = $('#current_directory').val();
         
         $('.copied_document').data('value',value);
         $('.In_paste_document').data('value',value);
           
          var rightClickPositionLeft = e.pageX;
          var rightClickPositionTop  = e.pageY;
          
          $('.rightClickPopUpWithOutValue').css("top",rightClickPositionTop);
          $('.rightClickPopUpWithOutValue').css("left",rightClickPositionLeft);

           e.preventDefault();
           var getClass = $(this).attr('class');  
           $('.rightClickPopUpWithOutValue').css("display", "block");
          
           var paste_permit = $('#copy_document_directory').val(); 
            if( paste_permit == '')
            {
               $('li.ng-scope.paste').css("display", "none");
            }
            else{
              $('li.ng-scope.paste').css("display", "block");
            }
          
       });

    //end

    //extract document 

    $(document).on('click','.extractDocument',function(){
      
       var extractDocumentPath = $(this).data('value');
       var token =$('#csrf-token').val();
      var project_id = $('.directory_location #project_id_doc').val();

          $.ajax({
              
              type:"POST",
              url:"{{ Url('/') }}/extractDocument",
              data:{
                _token : token,
                extractDocumentPath: extractDocumentPath,
                project_id   : project_id,
              },  
              // multiple data sent using ajax//
              success: function (response) { 

                if(response == 'exits')
                {
                     alert('Directory already exit in folder');

                }else{

                   var directory_url = $('#current_directory').val();
                   var token =$('#csrf-token').val(); 
                   data_display(token,directory_url);
                }
              }

            });

   });
   
  //copy document

   $(document).on('click','.copied_document',function(){
    var copied_document = $(this).data('value');
    $('#copy_document_directory').val(copied_document);
    hideRightClickPopup();
    
   });
   //end

    
  // document paste event
  $(document).on('click','.In_paste_document',function(){

     var pasted_directory = $(this).data('value');
     var copied_directory = $('#copy_document_directory').val();
     var projects_id = $('.directory_location #project_id_doc').val();
     var token = $('#csrf-token').val();

     $.ajax({
              type:"POST",
              url:"{{ Url('/') }}/copy_documents",
              data:{

                _token : token,
                pasted_directory : pasted_directory,
                copied_directory : copied_directory,
                projects_id      : projects_id

              },   
              success: function (response) { 
                  
                       var directory_url = $('#current_directory').val();
                       var token =$('#csrf-token').val(); 
                       data_display(token,directory_url);
              }

     })
     hideRightClickPopup();
  });
//end

  //hide right click popup on documents
    function hideRightClickPopup(){

      $('.right_click.drop-holder').css("display", "none");

    }
 
  //rename document
      $(document).on ('click','.rename_document',function(e) {

          var renameDocument = $(this).data('value');

          var renameDocumentsplit = renameDocument.split("/");

          var renameDocumentName  = renameDocumentsplit.pop();

          $('#renameDocumentContent').data('value',renameDocumentName);
          
          //get rename file extension
          var getExtension = renameDocumentName.lastIndexOf(".");

          var extension = renameDocumentName.substring(getExtension+1, renameDocumentName.length);

          var renameDocumentNamewithOutExt = renameDocumentName.substring(0, getExtension); 

          //get document url with out document name.
          var n = renameDocument.lastIndexOf("/");

          var directory_url = renameDocument.substring(0, n);

          if(getExtension == '-1')
          {
            $('#renameDocumentContent').val(renameDocumentName);
           
          }else{

            $('#renameDocumentContent').val(renameDocumentNamewithOutExt);

          }
          
          $('#renameDocumentUrl').val(directory_url);
          $('#renameDocumentFullPath').val(renameDocument);

      });

      $(document).on ('click','#submit_rename_document',function(e) {
       
        var editableDocumentName1 = $('#renameDocumentContent').val();

        var editableDocumentName = editableDocumentName1.replace(/[^A-Z0-9]+/ig, "_");; 


       var editableDocumentUrl  = $('#renameDocumentUrl').val();

       var renameThumbnailImagePath = $('#renameDocumentContent').data('value');

       var renameDocumentFullPath = $('#renameDocumentFullPath').val();

       var token = $('#csrf-token').val();  

         $.ajax({
                  type:"POST",
                  url:"{{ Url('/') }}/rename_documents",
                  data:{

                    _token : token,
                    editableDocumentName     : editableDocumentName,
                    editableDocumentUrl      : editableDocumentUrl,
                    renameDocumentFullPath   : renameDocumentFullPath,
                    renameThumbnailImagePath : renameThumbnailImagePath

                  },   
                  success: function (response) { 

                    if(response == 'rename'){

                      $('#renameDocument').modal('hide');

                       var directory_url = $('#current_directory').val();
                       var token =$('#csrf-token').val(); 
                       data_display(token,directory_url);
                       swal("documents rename successfully", "", "success");

                    }
                }

         });

          
      });

  //end rename 


  /*view file function*/

  //   $(document).on ('click','.lightbox_trigger',function(e) {
    
  //   //prevent default action (hyperlink)
  //   e.preventDefault();

  //  if ($('#lightbox').length > 0) { // #lightbox exists
  //   var src = "{{route('getentry')}}";
    
  //     //placefg href as img src value
  //     $('#content').html('<img src="'+"{{route('getentry')}}"+'"/>');
        
  //     //show lightbox window - you could use .show('fast') for a transition
  //     $('#lightbox').show();
  //   }

  // });
 //end

 //get window height

 var windowHeight = $(window).height();
 var documentIndexScrollHeight= windowHeight-208;
 var popUpOverlayHeight       = windowHeight-264;
 var indexingHeight           = windowHeight-323; 

 
 $('.choose_file_upload.overlay').css('height',popUpOverlayHeight);
 $('.choose_file_upload.overlay').css('border',"3px solid #18cad7");

 $('.table_section.document_scroll').css("height", documentIndexScrollHeight);
 $('.indexing').css("height",indexingHeight);

 $('.scroll_upload_section').css('height',windowHeight-210);
 $('.scroll_permissionDoc_section').css('height',windowHeight-170);

 $('.share_modal_sec').css('height',windowHeight-150);





 //get the file name and path //
$('.btn_upload').click(function(){

     $('.choose_upload_document').removeClass('beat');
     $("#progress-bar").width('0%');
     $('.row.upload_file_details').hide();
     $('.choose_upload_document').show();
     $('#total_file').html('');
     $('input.changedFileTarget').hide();    
})


$('.choose_upload_document').on('dragover',function(event){
     toggleFun();

  });

function toggleFun() {
  if (!($('.choose_upload_document').hasClass("beat"))) {
    $('.choose_upload_document').addClass('beat');
  } else {
    $('.choose_upload_document').removeClass("beat");
  }
}

$('.upload_folder_close.close').click(function () {

   $('.table_section.document_scroll').addClass('document_scroll_done');
   $('.emplty_box_drag_drop').show();
   $('#fileDetails').html('');
   $('.submit_create_post').hide();
   $('.choose_upload_document').removeClass("beat");
   $('#overlay').hide();
});


// drop file in folder structure//


$(document).on('dragenter','.table_section.document_scroll',function(){
    
    $('.table_section.document_scroll').removeClass('document_scroll_done');
    $('#overlay').show();
    $('.choose_file_upload.overlay').show();
    $('.emplty_box_drag_drop').hide();
    
});

$(document).on('dragleave','#overlay',function(){
   
    $('.table_section.document_scroll').addClass('document_scroll_done');
    $('.choose_file_upload.overlay').hide();
    $('.emplty_box_drag_drop').show();

});

$(document).on('click','.changedFileTarget',function(){

  var getId = $('.changedFileTarget').attr('id');
   if(getId == 'Upload_files_up')
   {
     $('#submit_create_post').click();
     
   }else{
     $('#submit_upload_file').click();
   }

});

$('#myModal').on('hidden.bs.modal', function () {

   $('#AllUploadFiles')[0].reset();
   $('#fileDetails').html('');

});
 
  //Show selected doc details 

  $(document).on('click','.document_index_contentable input[type="checkbox"]', function() {

    var showDocWithDoc = '';

    var numberOfChecked = $('.document_index_contentable input:checkbox:checked').length;

      if(numberOfChecked == 1)
      {         
          // var ffd  = $('.notes_aside_text1').val();
          // alert(ffd);
          var noteDocPath = $(this).data('value');

          $('.close_note_aside').addClass('hidden');
          $('.create_note_aside').removeClass('hidden');
          $('#single_select_doc').val(noteDocPath);
          $('.delete_items').removeClass('hideDeleteBtn'); 
          $('.share_items_documents').removeClass('hidden');
          $('.btn_delete_doc_recycle').removeClass('hideDeleteBtn');  

          $.each($("input[name='documents_select']:checked"),function(){
            
                  var value_document= $(this).val();

                  var data_value = $(this).data('value');
                  
                  var getThumbnailImage = data_value.split("/");

                  var ThumbnailImageName = getThumbnailImage.pop();
                   
                  var ThumbWithPath = 'thumbnail_img/'+ThumbnailImageName;

                  var thumbnailPath = data_value.replace(ThumbnailImageName,ThumbWithPath);
 
                  getNotesDetailsForDocument(data_value);

                  var getExt = data_value.split(".");

                  var getDocumentTitle = getExt.pop();
                  
                  var getDocLength = getExt.length;

                  var token = $('#csrf-token').val();  

                    if(getDocumentTitle == "jpg" || getDocumentTitle == "png" || getDocumentTitle == "jpeg")
                     {

                          var html11  = '<img src="{{url('/')}}/display/image/?image='+thumbnailPath+'"> </img>';

                          $('.file_view_aside').removeClass('hidden');  

                          var showDocWithDoc ="<i class='fa fa-photo'></i>" +value_document+"";
                          
                     }
                     else if(getDocumentTitle == 'zip')
                     {
                          
                          var showDocWithDoc ="<i class='far fa-file-archive'></i> "+value_document+"";
                          $('.file_view_aside').html('');  
              
                     }else{

                            if(getDocLength == '0'){
                                    
                                   var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +value_document+"";
                                   $('.file_view_aside').html('');  
                            }else{

                                  var showDocWithDoc ="<i class='fa fa-file' aria-hidden='true'></i> " +value_document+""; 
                                  $('.file_view_aside').html(''); 

                            }
                     }

                  $('.create_notes_get').removeClass('hidden');
                  $('.checked_doc_details').html(showDocWithDoc);
                  $('.file_view_aside').html(html11);

          });
              
      }else if(numberOfChecked == 0)
        {

             $('.btn_delete_doc_recycle').addClass('hideDeleteBtn'); 
             var GetDocumentName = $('#getProject_name').val();
             var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetDocumentName+"";
             $('.checked_doc_details').html(showDocWithDoc);
             $('.create_notes_get').addClass('hidden');
             $('.notes_aside_text1').addClass('hidden');
             $('.note1_doc_delete').addClass('hidden');
             $('.file_view_aside').html('');
             $('.notes_aside_1').html('');
             $('.submit_note1_doc').addClass('hidden');
             $('.share_items_documents').addClass('hidden');
             $('.delete_items').addClass('hideDeleteBtn'); 


        }else
          {
              var GetDocumentName = 'Selected:  folders, files';
              $('.checked_doc_details').html(GetDocumentName);
              $('.create_notes_get').addClass('hidden');
              $('.notes_aside_text1').addClass('hidden');
              $('.submit_note1_doc').addClass('hidden');
              $('.note1_doc_delete').addClass('hidden');
              $('.file_view_aside').addClass('hidden'); 
              
          }
 });
//end 


// Select CheckBox Event 
$(document).on('click','.check-box-input-main',function(){

     $('.document_index_contentable input:checkbox').prop('checked', this.checked);

    
});

//end

// uncheck event 
//   $(document).on('change','input:checkbox:not(:checked)',function(){
 
//       var getDoc = [];

//       $.each($("input[name='documents_select']:checked"), function(){            
//             getDoc.push($(this).val());
//       });
//        final = getDoc;
//       var numberOfChecked = $('input:checkbox:checked').length;
      
//       var gf = $(this).val();
     
//       if(numberOfChecked == 0)
//       {
//          $('.delete_items').addClass('hideDeleteBtn'); 

//       }else{

//          $('input:checkbox checked').find(a).val();
//       }

      
//   }); 
// 

 $(document).on('click','.delete_items_documents',function(){
    
    var token = $('#csrf-token').val();
    var directory_url  =  $('.directory_location #current_directory ').val();
    var projects_id = $('.directory_location #project_id_doc').val();
    
    var deletePath = [];

    $.each($("input[name='documents_select']:checked"), function(e)
    {        
        
          deletePath.push($(this).data('value')); 

    });
    
          swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this file!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"{{ Url('/') }}/delete_document",
                            data:{
                              _token : token,
                               url: deletePath,
                               projects_id : projects_id
                            },  

                            // multiple data sent using ajax//
                            success: function (response) {
                               //alert(response);
                                if (response != "error") {

                                     $.each( deletePath,function( key, value ) {

                                     $('[data-value = "'+value+'"]').remove();

                                  });

                                    swal(response+" deleted successfully", "", "success");
                                } 
                              
                               data_display(token,directory_url);
                               $('input:checkbox').prop('checked', false);
                               $('.delete_items').addClass('hideDeleteBtn'); 
                 $('.btn_delete_doc_recycle').addClass('hideDeleteBtn'); 
                 var GetDocumentName = $('#getProject_name').val();
                 var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetDocumentName+"";
                 $('.checked_doc_details').html(showDocWithDoc);
                 $('.create_notes_get').addClass('hidden');
                 $('.notes_aside_text1').addClass('hidden');
                 $('.note1_doc_delete').addClass('hidden');
                 $('.file_view_aside').html('');
                 $('.notes_aside_1').html('');
                 $('.submit_note1_doc').addClass('hidden');
                             }
                     });
                  } 
              });
     
 });

 // show and hide the fav and notes permision icons in documens index

 $(document).on('mouseover','.drop_box_document', function(){
    
    $(this).find('.fav_docs').removeClass('hidden_icon');
    $(this).find('.notes_docs').removeClass('hidden_icon');
    $(this).find('.ques_ans_docs').removeClass('hidden_icon');
    $(this).find('.permission_docs').removeClass('hidden_icon');
   
 });

$(document).on('mouseleave','.drop_box_document', function(){

    $(this).find('.fav_docs').addClass('hidden_icon');
    $(this).find('.notes_docs').addClass('hidden_icon');
    $(this).find('.ques_ans_docs').addClass('hidden_icon');
    $(this).find('.permission_docs').addClass('hidden_icon');
 });

 // recycle Bin 
 $(document).on('click','#RecycleBin',function(){

        
        //filter hide
        $('.filteredTextContent').addClass('hidden');
        $('.back-arrow.move_last_folder').removeClass('hidden');
        $('.document_view_block').addClass('hidden');
        $('.fav_filter').addClass('hidden');
        $('.new_filter').addClass('hidden');

        $('.back-arrow').html('Recycle Bin');
        $('.doc_index_list h4 .upone').addClass('hidden');
       
        $('.table.table-hover.table-bordered.table_color').addClass('hidden');
        $('.table.table-hover.table-bordered.table_color.recycle_bin').removeClass('hidden');
        $('.row.document_index_recycle_bin').removeClass('hidden');
        $('.row.document_index_buttons').addClass('hidden');

        var token =$('#csrf-token').val();
        var projects_id = $('.directory_location #project_id_doc').val();
        GetDeletedDocument (token,projects_id);

 });


  $(document).on('click','.projects.branch.verifyCheck', function(){
         
        $('.doc_index_list h4 .upone').removeClass('hidden'); 
        $('.table.table-hover.table-bordered.table_color').removeClass('hidden');
        $('.table.table-hover.table-bordered.table_color.recycle_bin').addClass('hidden');
        $('.row.document_index_buttons').removeClass('hidden');
        $('.row.document_index_recycle_bin').addClass('hidden');
        $('.doc_index_list h4 .upone').removeClass('hidden');
        
  });

  // Remove all recycle bin doc
  $(document).on('click','.btn_deleteAllBackup',function(){

     var token =$('#csrf-token').val();
     var projects_id = $('.directory_location #project_id_doc').val();
     var project_directory =  $('#project_directory').val();

      swal({
                title: "Are you sure?",
                text: "Do you really want to empty recycle bin permanently?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
     
                        $.ajax({
                                
                                type:"POST",
                                url:"{{ Url('/') }}/recycle/document/delete",
                                data:{
                                  _token : token,
                                  projects_id : projects_id,
                                  project_directory :project_directory

                                  },  
                                  // multiple data sent using ajax//
                                  success: function (response) { 
                                     if(response == 'success'){
                                       swal("Delete successfully ", "", "success");
                                       GetDeletedDocument(token,projects_id);
                                     }
                                  }
                                    
                              });
                      }
             });

    });

 // restore document

  $(document).on('click','.btn_restore_recycle_doc',function(){
    
          var token = $('#csrf-token').val();
          var directory_url  =  $('.directory_location #current_directory ').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var project_id = $('.directory_location #project_id_doc').val();
          var project_directory =  $('#project_directory').val();
          
          var restorePath = [];
          var docIdentify = '';

              $.each($("input[name='recycle_documents_select']:checked"), function(e)
              {        

                    var restore_path = $(this).data('value');
                    var current_path = $(this).val();
                    var delete_time = $(this).data('time');
                    var docIdentify = $(this).data('doc');

                    restorePath.push({Rpath:restore_path , Cpath:current_path, deleted_time:delete_time, Identify:docIdentify});
              });

              $.ajax({
                      
                      type:"POST",
                      url:"{{ Url('/') }}/recycle/document/restore",
                      data:{
                        _token : token,
                        projects_id : projects_id,
                        restorePath  :restorePath,

                        },  
                        // multiple data sent using ajax//
                        success: function (response) { 

                            if( response = "restore"){

                                swal("restore successfully", "", "success");

                                DocumentTree(token,project_id);
                                GetDeletedDocument(token,projects_id);  
                                $('input:checkbox').prop('checked', false);

                          } 
                   }
                            
            });

     });

 
  function GetDeletedDocument (token,projects_id){
        var html="";
        var box = $('.indexing');

         $.ajax({
              
              type:"POST",
              url:"{{ Url('/') }}/recycle/document",
              data:{
                _token : token,
                projects_id : projects_id
                
              },  
              // multiple data sent using ajax//
              success: function (response) { 
                  
                   var getfolder = response.folder;
                   
                   var getfile = response.file;

                    if(getfolder == 0 && getfile == 0 )
                      {
                           html +="";

                      }else{
        
                        $.each( response.folder , function( key, value) {
                          
                           // delete folder time or date
                           var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

                           var myarr = value.split(".");
                           var getlastElementTime = myarr[0];
                           var date = new Date(getlastElementTime*1000);
                           var myDate = new Date(date);
                           var getDate = myDate.getDate();
                           var getMonth =  months[myDate.getMonth()];
                           var DeleteDate = getMonth+'/'+getDate;
                              
                           // delete folder location   
                           var myarr1  = key.split("/"); 
                           var element_length =  myarr1.length;
                           var getlastElement = myarr1.pop();
                           var getsecondLastElement = element_length-2;
                           var secondLastElement = myarr1[getsecondLastElement];
                           var restoreFolderLoc = '/'+secondLastElement+'/'; 
                           var getthirdPara = myarr1[2];
                           var getfourthPara = myarr1[3];

                           var cuurent_recycle_doc_path = "public/documents/"+getthirdPara+"/"+getfourthPara+"/RecycleBin/"+value;
                        
      
                              html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list_recycle'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' data-doc='1' class='check-box-input' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' data-time='"+getlastElementTime+"' name='recycle_documents_select' ></form></div><h4><a href='javascript:void(0)' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' data-time='"+getlastElement +"' class='projects'><i class='fa fa-folder' aria-hidden='true'></i> "+value+"</a></h4></div><div class='delete_from_dir'><span>"+restoreFolderLoc+"</span></div> <div class='delete_time_dir'><span>"+DeleteDate+"</span></div></div></div>";
     
                        });


                        var extensions =  [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
                        
                        $.each( response.file , function( key, value ) {
                          
                        // delete file time or date
                          var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                           var myarr = value.split(".");
                           var getlastElementTime = myarr[0];
                           var date = new Date(getlastElementTime*1000);
                           var myDate = new Date(date);
                           var getDate = myDate.getDate();
                           var getMonth = months[myDate.getMonth()];
                           var DeleteDate = getMonth+'/'+getDate;
                              
                           // delete file location   
                           var myarr1  = key.split("/"); 
                           var element_length =  myarr1.length;
                           var getlastElement = myarr1.pop();
                           var getsecondLastElement = element_length-2;
                           var secondLastElement = myarr1[getsecondLastElement];
                           var restoreFolderLoc = '/'+secondLastElement+'/'; 
                           var getthirdPara = myarr1[2];
                           var getfourthPara = myarr1[3];
                           var cuurent_recycle_doc_path = "public/documents/"+getthirdPara+"/"+getfourthPara+"/RecycleBin/"+value;
                          

                          html +="<div class='drop_box_document'><div class='document_index index-drag'><div class='doc_index_list_recycle'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' name='recycle_documents_select' data-doc='0'   value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' data-time='"+getlastElementTime+"'></form></div><h4><a href='javascript:void(0)' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' id='"+key+"' class='drap'><i class='fa fa-file' aria-hidden='true'></i> "+value+"</a></h4></div><div class='delete_from_dir'><p>"+restoreFolderLoc+"</p></div> <div class='delete_time_dir'><p>"+DeleteDate+"</p></div></div></div></div>";

                          });
                          
                      }
                       
                   // Display indexing of deleted documents. 
                    box.html(html);

              }

          });
  }

// Notes working 
$(document).on('click','.create_note_aside',function(){
    
    $('.notes_aside_1').html('');
    $('.notes_aside_text1').val('');

     var html = "<textarea class='notes_aside_text1' data-value='1' placeholder='Enter text here...' rows='6' cols='28'></textarea><button class='submit_note1_doc'>Add</button><button class='note1_doc_delete hidden'><i class='fa fa-trash-o'></i></button>";
     $('.notes_aside_1').append(html);

     $('.notes_aside_1').removeClass('hidden');

     $(this).addClass('hidden');
     $('.close_note_aside').removeClass('hidden');

});

$(document).on('click','.close_note_aside',function(){
      
       $('.notes_aside_1').html('');
       $('.close_note_aside').addClass('hidden');
       $('.create_note_aside').removeClass('hidden');

 });



// Delete the recycle bin documents 

$(document).on ('click','.btn_delete_doc_recycle',function(){
     
          var token = $('#csrf-token').val();
          var directory_url  =  $('.directory_location #current_directory ').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var project_directory =  $('#project_directory').val();
          
          var deletePath = [];
          var docIdentify = '';

          $.each($("input[name='recycle_documents_select']:checked"), function(e)
          {        
               
                // var current_path = $(this).val();

                // deletePath.push(current_path);

                var restore_path = $(this).data('value');
                var current_path = $(this).val();
                var docIdentify = $(this).data('doc');

                deletePath.push({Rpath:restore_path , Cpath:current_path ,Identify:docIdentify });

          });


              $.ajax({
                      
                      type:"POST",
                      url:"{{ Url('/') }}/recycle/select_document/delete",
                      data:{
                        _token : token,
                        projects_id : projects_id,
                        deletePath  :deletePath

                        },  
                        // multiple data sent using ajax//
                        success: function (response) { 

                            if( response = "Delete"){

                                swal("delete successfully", "", "success");
                                GetDeletedDocument(token,projects_id); 
                                $('input:checkbox').prop('checked', false); 

                        } 
                }
                            
     });


});

//end 


//Fav document

$(document).on('click','.fav_docs',function(e){

            
          e.preventDefault();
          var that =  $(this);

          var token = $('#csrf-token').val(); 
          var directory_url  =  $('.directory_location #current_directory ').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var project_directory =  $('#project_directory').val();
          var document_val =  $(this).data('value'); 
          
       $.ajax({
                      
                      type:"POST",
                      url:"{{ Url('/') }}/fav/document",
                      data:{
                        _token : token,
                        projects_id : projects_id,
                        document_val  :document_val,
                        directory_url : directory_url

                        },  
                        // multiple data sent using ajax//
                        success: function (response) { 
                         
                          if(response == "makeFav")
                          {
                                
                                that.removeClass('hidden_icon');
                                that.css("color","red");
                                that.css("visibility","visible");

                          }else{
                                                                
                               that.css("color","#212529");
                               that.addClass('hidden_icon');
                               that.removeAttr("style");

                          }

                       }

            });
  });


//create a note to the doucment 

$(document).on('click','.submit_note1_doc', function(){

        
        var token = $('#csrf-token').val();  
        var NotesContent  = $('.notes_aside_text1').val();

        if(NotesContent !== '')
        {
           

         var getCheckValue = $("input[name='documents_select']:checked").data('value');
  

         $('[data-value = "'+getCheckValue+'"]').parent().parent().find('.icons-doc').find('.notes_docs').css('visibility','visible');

        var notesPriority = $('.notes_aside_text1').data('value');
        var projects_id   = $('.directory_location #project_id_doc').val();
        var documentPath  = $('#single_select_doc').val();
         

        var CreateAndUpdateNote  = $('.notes_aside_text1').data('value');
          
        if(CreateAndUpdateNote !== 1)
          {

            var time = $('.note1_doc_delete').data('value');

                 $.ajax({
                          
                          type:"POST",
                          url:"{{ Url('/') }}/note/edit",
                          data:{
                            _token : token,
                            projects_id   : projects_id,
                            documentPath  : documentPath,
                            NotesContent  : NotesContent,
                            time          : time,
                            notesPriority : notesPriority
                            
                            },  
                            // multiple data sent using ajax//
                            success: function (response) { 
                                
                              if(response == 'update'){
         
                                     $('.notes_aside_1').html('');
                                     getNotesDetailsForDocument (documentPath);
                                     // $('.note1_doc_delete').removeClass('hidden');
                                     // $('.submit_note1_doc').addClass('hidden');

                                  }
                           }

                });

          }else{

                   $.ajax({
                            
                            type:"POST",
                            url:"{{ Url('/') }}/note/create",
                            data:{
                              _token : token,
                              projects_id   : projects_id,
                              documentPath  : documentPath,
                              NotesContent  : NotesContent,
                              notesPriority : notesPriority

                              },  
                              // multiple data sent using ajax//
                              success: function (response) { 
                                if(response !== ''){
       
                                   $('.notes_aside_1').html('');
                                   getNotesDetailsForDocument (documentPath);
                                   // $('.note1_doc_delete').removeClass('hidden');
                                   // $('.submit_note1_doc').addClass('hidden');

                                }
                             }

                    });
          }

      }
        
});

// delete Notes 
$(document).on('click','.note1_doc_delete', function(){
       
     var token = $('#csrf-token').val();    
     var timeNote = $(this).data('value');
     var data_value = $(this).val();

     var projects_id   = $('.directory_location #project_id_doc').val();
     
      $.ajax({
                              
                  type:"POST",
                  url:"{{ Url('/') }}/note/delete",
                  data:{
                      _token : token,
                      projects_id   :  projects_id,
                      timeNote      :  timeNote

                    },  
                    // multiple data sent using ajax//
                    success: function (response) { 
                         
                          if(response == "deleteNote")    
                          {
                             $.each($("input[name='documents_select']:checked"),function(){

                                  var data = $(this).data('value');

                                  $('#document_index_content [data-value = "'+data+'"]').parent().parent().find('.notes_docs').removeAttr("style");

                                  $(this).prop('checked', false);

                             });

                             getNotesDetailsForDocument(data_value);
                          }                    
                      }
            });
});

  function getNotesDetailsForDocument (data_value){

      var token = $('#csrf-token').val();  
      var documentPath = data_value;
      var projects_id  = $('.directory_location #project_id_doc').val();


        $.ajax({
                              
                  type:"POST",
                    url:"{{ Url('/') }}/note/get",
                  data:{
                    _token : token,
                    projects_id   :  projects_id,
                    documentPath  :documentPath

                    },  
                    // multiple data sent using ajax//
                    success: function (response) { 
                     
                       if(response !== ''){

                           $('.notes_aside_1').html(''); 
                      
                           var content = response.note[0];
                           var timestamp = response.note[1];
                           var html2 = '';
    
                           $.each(response.share_view, function(key, value) {

                                //console.log(value);
                            var datetime= value.time;
                            var datetime = datetime.split(" ");
                            console.log(datetime[0],datetime[1]);


                           html2+='<div class="readall read-more'+key+'" style= display:none><div><b>Date</b>:'+datetime[0]+'</div>'+'<div><b>Time</b>:'+datetime[1]+'</div>'+'<div><b>IP Address</b>:'+value.ip_address+'</div>'+'<div><b>Browser Details</b>:'+value.browser+'</div>'+'<div><b>Device</b>:'+value.device+ '</div> </div> <br>';

                         });
                          html2+='<button onclick="myFunction()" id="myBtn" class="btn  document-btn">Read more</button>';

                           var html = "<textarea class='notes_aside_text1' data-value='0' placeholder='Enter text here...' rows='6' cols='28'></textarea><button class='submit_note1_doc'>Add</button><button value='"+documentPath+"' data-value='"+timestamp+"' class='note1_doc_delete hidden'><i class='fa fa-trash-o'></i></button>";
     
                            $('.notes_aside_1').html(html);     
                            $('.notes_aside_text1').val(content);   
                            $('.close_note_aside').removeClass('hidden');
                            $('.create_note_aside').addClass('hidden');
                            $('.notes_aside_1').removeClass('hidden');     
                            $('.note1_doc_delete').removeClass('hidden');    
                            $('.submit_note1_doc').addClass('hidden');
                            $('.close_note_aside').addClass('hidden'); 
                            $('.shareview').html(html2);
                            $('.note1_doc_delete').removeClass('hidden');    
                            $('.submit_note1_doc').addClass('hidden');
                            $('.read-more0').css("display", "block");
                            $("#myBtn").click(function(){
                            $(".readall").show();
                              
                            });

                            $(".check-box-input").click(function(){
                            $(".shareview").toggle();
                          });
                              response_status = 1;                          
                          }else{
                              

                               response_status = 0;
                             
                             // $('.notes_aside_1').html('');
                               check();
                           
                             $('.close_note_aside').addClass('hidden');
                          } 
                         
                    }   
            });
      }



      $(document).on('keypress','.notes_aside_text1',function(){
                
              $('.submit_note1_doc').removeClass('hidden');  
              $('.note1_doc_delete').addClass('hidden'); 

             
      });



  function check() {
  
    if (check_status == 0) {
      if (response_status == 0) {
        $('.notes_aside_1').html('<textarea class="notes_aside_text1" data-value="1" placeholder="Enter text here..."" rows="6" cols="28"></textarea><button class="submit_note1_doc">Add</button><button  class="note1_doc_delete hidden"><i class="fa fa-trash-o"></i></button>');

        $('.notes_aside_1').removeClass('hidden');
        check_status = 1;
        $('.create_note_aside').addClass('hidden');
         
      }
      else{

         $('.notes_aside_1').html('');
          check_status = 1; 
              }
      }else{

          $('.notes_aside_1').html('');
         
          check_status = 1;
         
      }

    
    
  }

   $(document).on('click','.notes_docs',function(){

       $('input:checkbox').prop('checked', false);
       var data_value = $(this).data('value');
       check_status = 0;
      $(this).parent().prev().find('.check-box-input').trigger( "click" );

  });


   function DocumentTree(token,project_id){

              $.ajax({
                              
                  type:"GET",
                    url:"{{ Url('/') }}/project/"+project_id+"/documents/action",

                   data:{
                    _token : token,
                    },  
                    // multiple data sent using ajax//
                    success: function (response) { 

                      var folderTree = response.folderTree;
                      var folder_file_tree = response.folder_file_tree;
                   
                     $('.folder_struture').html(folderTree);

                      $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

                     $('.folder_file_structure').html(folder_file_tree);

                     $('#tree3').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                         
                    }

         });
    
   }


   //permission module

   $(document).on('click','#document_permission_modal input[type="checkbox"]', function() {

      var id = $(this).data('id');

      if(id == '')
      {
        $('input:checkbox').not(this).prop('checked', false);

        var getPerClass = $(this).attr('class');
        var class_get = '.'+getPerClass;

        $('.new_user_pannel '+class_get).prop('checked', true);

      }else{

        var getGroupClass = '#group'+id;
        $(getGroupClass+'  input:checkbox').not(this).prop('checked', false);
        $('.all_groups input:checkbox').prop('checked', false);

      }

   });

  

   $(document).on('click','#permission_store',function(){

          var numberOfChecked1 = $('#document_permission_modal input:checkbox:checked').length;
      
          if(numberOfChecked1 == '0')
          { 
             alert('please select any permission of the document.');
          }

          var permission_array = [];

          $.each($("input[name='set_permission']:checked"),function(){ 

             permission_array.push($(this).data('value')); 

          });


         var Document = $('#current_permission_document').val();

         var project_id  = $('.directory_location #project_id_doc').val(); 

         var token = $('#csrf-token').val();  

          $.ajax({
                                
                    type:"POST",
                    url:"{{ Url('/') }}/set_permission",
                    data:{
                      _token : token,
                      permission_array   :  permission_array,
                      Document  :  Document,
                      project_id : project_id,

                      },  
                      // multiple data sent using ajax//
                      success: function (response) { 

                       if(response == 'success'){
                             
                            swal("permission set successfully", "", "success");

                            DocumentTree(token,project_id);
                            $('#CheckUserChangePermission').val('');
                        }
 
                      }

                });
                       
   });

    $(document).on('click','.checkmark',function(){
           
           $('#CheckUserChangePermission').val('1');

    });


   $(document).on('click','.permission_cancle',function(){

        var group_id =  $(this).attr('group');

        $('#group'+group_id+' input:checkbox' ).prop('checked', false);
        $('.all_groups input:checkbox' ).prop('checked', false);

   });

    $(document).on('click','.permission_cancle_main',function(){

     $('#document_permission_modal input:checkbox').prop('checked', false);

   });

    // set the permission

    $(document).on('click','.permission_docs',function(){
          
          var permission_doc = $(this).data('value');

          $('#document_permission_modal').modal('show');
          
          var triggerEvent  = $('.document_permission [data-value = "'+permission_doc+'"]').click();

    });

   $(document).on('click','.doc_view_file',function(){   

       var file_id = $(this).data('doc_id');

       viewDocByDocPath(file_id);

   });

   $(document).on('click','.new_data_room',function(){
       $('#dismiss').click();
   });


   //create question answer

   $(document).on('click','.ques_ans_docs',function(){


       $('input:checkbox').prop('checked', false);
       $(this).parent().prev().find('.check-box-input').trigger( "click" );
       var data_value = $(this).data('value');
       var data_user = $(this).data('user');
       var getName  = data_value.split('/');
       var Name = getName[getName.length-1];

       var data_ques = $(this).data('ques');
       var project_id  = $('.directory_location #project_id_doc').val();

       if(data_ques == 1)
       {
           window.open("{{ Url('/') }}/project/"+project_id+"/questions",'_blank');

       }else{

         $('#genrate_question').modal();
         $('#genrate_question .related_question').html(Name);
         $('.question_subject').val('');
         $('.question_content').val('');

       }

       
       $('#doc_path_directory').data('value',data_value);

   }); 

  // Doc preview 

   function viewDocByDocPath(file_id){

       var project_id  = $('.directory_location #project_id_doc').val();

       window.open(
          "{{ Url('/') }}/file_view/"+project_id+"/Open_viewer/" +file_id ,
          '_blank' 
        );
   }

   $('.multipleSelect').fastselect();



  $(document).on('click','.send_question',function(){
     
     var directory_url  =  $('.directory_location #current_directory').val(); 

     var doc_path =  $('#doc_path_directory').data('value');
     
     var project_id  = $('.directory_location #project_id_doc').val();

     var token = $('#csrf-token').val();  
     var users = $('.multipleSelect').val();

     var subject = $('.question_subject').val();
     var ques_content  = $('.question_content').val();
     var project_name  = $('.project_name').val();
     
     $.ajax({

        type : "POST",
        url : "{{url('/')}}/send_question",
        //message: swal("send successfully"," ","success"),
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

              $('#genrate_question').modal('hide');
              message: swal("send successfully"," ","success"),
              data_display(token,directory_url);

            }
        }

       }); 

  });

 $(document).on('click','.ques_ans_docs_left',function(){

  $(this).parent().prev().find('.check-box-input').trigger( "click" );

 });

 $(document).ajaxSend(function(event, request, settings) {
      $('.overlay_body').removeClass('hidden');
    });

 $(document).ajaxComplete(function(event, request, settings) {
      $('.overlay_body').addClass('hidden');
    }); 


 function getUserForSelectQues(){

     var project_id  = $('.directory_location #project_id_doc').val();
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

           $('.multipleSelect').html(html);
       
        }

       });
 }


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

 
 $('.choose_around_file').click(function(){

  $('#file').click();

 })


 $('.upload_doc_upload').click(function(){

  $('.choose_around_file').removeClass('hidden');
  $('.upload_modal_check').addClass('hidden');

 });
 

 $(document).on('click','.fstQueryInput.fstQueryInputExpanded',function(){

    $('#alert_users').hide();
 });

 $(document).on('click','#go_search_doc',function(){

   var token = $('#csrf-token').val();  
   var serachContent = $('#search_doc_content').val();
   var directory_url = $('#current_directory').val();

   if(serachContent == '')
   {
        data_display(token,directory_url);

   }else{
         
         $('.move_last_folder').addClass('hidden');
         $('.ui-droppable').addClass('hidden');

         var project_id = $('.projects_id').val();
         var document_index = $('.document_indexing_count').val();

             $.ajax({
              type : "POST",
              url : "{{url('/')}}/doc/search_doc_content",
              data : {     
                _token      : token,
                serachContent : serachContent,
                project_id   : project_id,

              },
              success:function(response){


                $('.filteredTextContent .text_filter').html(serachContent);
                $('.filteredTextContent').removeClass('hidden');
                GetDocumentInfoByResponse(response,document_index,directory_url);

              }

            });

       }

 });

$(document).on('click','.fav_filter',function(){

   var token = $('#csrf-token').val();  
   var project_id = $('.projects_id').val();
   var document_index = $('.document_indexing_count').val();
   var directory_url = $('#current_directory').val();

   $.ajax({
              type : "POST",
              url : "{{url('/')}}/fav/search_doc_content",
              data : {     
                _token      : token,
                project_id   : project_id,

              },
              success:function(response){

                    $('.filteredTextContent').removeClass('hidden');
                    $('.move_last_folder').addClass('hidden');
                    $('.ui-droppable').addClass('hidden');
                    $('.text_filter').html('Favorite');
                    
                    GetDocumentInfoByResponse(response,document_index,directory_url);


              }

          });
   


});


$(document).on('click','.icon_close_filter',function(){

  var token = $('#csrf-token').val();  
  $('#search_doc_content').val('');
  var directory_url = $('#current_directory').val();

  $('.filteredTextContent').addClass('hidden');
  $('.move_last_folder').removeClass('hidden');
  $('.ui-droppable').removeClass('hidden');

  data_display(token,directory_url);

});



$(document).on('click','.question_create_doc',function(){


       var data_value = $('.checkToActionPopValue').val(); 
       var getName  = data_value.split('/');
       var Name = getName[getName.length-1];

       var project_id  = $('.directory_location #project_id_doc').val();

       $('#genrate_question').modal();
       $('#genrate_question .related_question').html(Name);
       $('.question_subject').val('');
       $('.question_content').val('');

       $('#doc_path_directory').data('value',data_value);


});


$(document).on('click','.fence_view_doc_permis',function(){

    var project_id = $('.projects_id').val();

    $('#document_permission_modal input:checkbox').prop('checked', false);

    $(this).parent().prev().find('.check-box-input').trigger( "click" );

    var getFileId = $(this).parent().prev().find('.check-box-input').data('doc_id');

     window.open("{{ Url('/') }}/file_view/"+project_id+"/Open_viewer/" +getFileId, '_blank');

});


$(document).on('click','.copy_url_document',function(){

var pageURL = $(location).attr("href");
$('#CurrentUrltildf').val(pageURL);
var dhsd = $('#CurrentUrltildf').val();
alert('Copied to clipboard');


});

$(document).on('click','.doc_permission_modal',function(){

  var current_user = $(this).attr('data_user');

  if(current_user == 0)
  {
        $('#AddUserToInvite').modal('show');
  }else{
       
        $('#document_permission_modal').modal('show');
  }

 

});

// share doc with users


  // $(".shareDocUsers").select2({
  //     tags: true
  // });


  $(document).on('click','#shareDocForUsers',function(){

    var userEmails = $(".shareDocUsers").val();
    var EmailsTitle = $(".shareDocEmailTitle").val();                           
     if(userEmails == '' ){

         $('.error_email').removeClass('hidden');
        
            
     }else{

         $('.error_email').addClass('hidden');
         $('#shareDocForUsers').prop('disabled', false);
     
    var DurationGet  = $("input[name='view_duration_e']:checked").val();

    if(DurationGet == 5)
    {
      var durationTime = $('#duration_time_val').val();

    }else{

       var durationTime = DurationGet;
    }

    var registerValid = $("input[name='Registration']:checked"). val();
    var printable = $("input[name='Printable']:checked"). val();
    var downloadable = $("input[name='Downloadable']:checked"). val();
    var DocumentId = [];

    $.each($("input[name='documents_select']:checked"), function(e)
    {        
        
          DocumentId.push($(this).data('doc_id')); 

    });
   
   var token = $('#csrf-token').val();  
   var project_id = $('.projects_id').val();


        $.ajax({

              type : "POST",
              url : "{{url('/')}}/share/documents",
              data : {     
                _token      : token,
                project_id   : project_id,
                userEmails   : userEmails,
                durationTime  : durationTime,
                registerValid : registerValid,
                printable   : printable,
                downloadable   : downloadable,
                DocumentId   : DocumentId,
                EmailsTitle :EmailsTitle,

              },
              success:function(response){

                $('#ShareDoc').modal('hide');
                swal("share successfully", "", "success");

              }

          });

       }
  });


  //email validation

   function IsEmail(email) {
             var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
             if(!regex.test(email)) {
                return false;
             }else{
                return true;
             }
           }

//date picker

$(function () {

  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());

});


 $(document).on('change','.view_duration input:radio',function(){

    if ($(this).val() == "5") {
       
       $('.custom_date').removeClass('hidden');

    }else{
       
       $('.custom_date').addClass('hidden');
    }

 });

</script>

</html>
  
