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

  <!--  icon cdn date 18 oct 2018 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- end -->

  
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
      
      var MinusSign = 'glyphicon-minus-sign';
      var PlusSign = 'glyphicon-plus-sign';
      
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
       
        tree.find('li:not(:has(>.customspan))').prepend("<span class='inactive customspan'></i><i class='shuffle glyphicon " + PlusSign + "'></i><i class='indicator glyphicon " + closedClass + "'></span>");
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

<!-- get document script -->

<script>

$(document).ready(function(){
        check_status = 1;
        response_status = '';
        // Document details
         var GetFolderName = $('.project_name').val();
         var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetFolderName+"";
         $('.checked_doc_details').html(showDocWithDoc); 


        $(this).bind('click', function(){
               hideRightClickPopup();
               $('.rightClickPopUpWithOutValue').css("display", "none");
    });
                     
    project_name =  "<?php echo $project_name ?>";
         $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

        var clickEvent = $('.projects').find('span').first();
        var triggerEvent  = clickEvent.find('.shuffle').first();
        setTimeout(function(){ triggerEvent.trigger('click') }, 0);

     
    var token =$('#csrf-token').val();
    var directory_url= $('.projects').first().data("value");
    data_display(token,directory_url);
     

   //click open folders
    $(document).on('click','.projects',function(event){
 
          $('.projects#projects').addClass('verifyCheck');
          $('.projects').children("span").removeClass("active");
          $(this).children("span").addClass("active");

        event.preventDefault();
        event.stopPropagation(); 

        // if (this == event.target ) {
        var directory_url= $(this).data("value");
 
        getLastUrl(directory_url);
        
        var current_directory = $('#directory_current .current_dir').val(directory_url);
        //set value in current direcory for upload document by first way
        $('.directory_location #current_directory ').val(directory_url); 
       //set value in current direcory for upload document by second way
        $('.current_dir_down').val(directory_url);

        var token =$('#csrf-token').val(); 
        data_display(token,directory_url);
      // }
  
      });

     
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
                     
                     window.location.href = '{{url("/")}}/project/'+response+'/documents'; 
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
         
           var genrate_folder = get_genrate_folder.replace(' ', '_');

           var getPath = path+"/"+genrate_folder; 
           var box = $('.indexing');
           var folder =$('#tree2');
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
                     getPath     : getPath
                  },  
              success: function (response) {              
                if(response == 'success')
                  { 
                    
          
                    if (!$('[data-value = "'+path+'"]').find('ul').length) {
                         
                        $('[data-value = "'+path+'"]').append('<ul> </ul>');
                    }

                    html1 +="<li id='projects' data-value='"+getPath+"'class='projects'><span class='doucment_name'>"+genrate_folder+"</span></li>";
                 
                      $('[data-value = "'+path+'"]').find('ul').eq(0).append(html1);
                       $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
                      var directory_url= path;
                      data_display(token,directory_url);
                  }
          }   
       });   
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
                var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.

                // SHOW THE EXTRACTED DETAILS OF THE FILE.
                document.getElementById('fileDetails').innerHTML =
                    document.getElementById('fileDetails').innerHTML + '<div class="row"><div class="col-md-12 "><div class="upload_details_index"><div class="col-md-6"><p>' +fname + '</p></div><div class="col-md-4"><p>' + fsize + 'bytes</p></div><div class="col-md-2"><p>X</p></div></div></div></div>';
            }
        }

    }

    $(document).on('change','input:file',function(){
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

          $('.choose_file_upload.overlay').hide();
          event.preventDefault();
          var token = $("input[name=_token]").val(); 
          var path = $('.current_dir').val();
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

                 swal("file uploaded successfully", "", "success");
                 $('.table_section.document_scroll').addClass('document_scroll_done');            
                    $.ajax({
                  type:"POST",
                  url:"{{ Url('/') }}/show_documents",
                  data:{
                    _token : token,
                    directory_url: path
                  },  
                  // multiple data sent using ajax//
                  success: function (response) {
                     
                    $.each( response.folder , function( key, value ) {

                      var myarr = value.split("/");
                      var element = myarr.pop();
                      
                       if (element =='RecycleBin' || element =='thumbnail_img' )
                          {
                            html +="";

                          }else{
                      
                        html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' value="+element+" data-value="+value+" name='documents_select' ></form></div><h4><a href='javascript:void(0)' data-value='"+value+"'  class='projects'><i class='fa fa-folder-o'></i> "+element+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon'  data-value="+value+"><span><i class='fa fa-star' aria-hidden='true'></i></span></div><div class='notes_docs hidden_icon'  data-value="+value+"><span><i class='fas fa-thumbtack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans'  data-value="+value+"><span><i class='fa fa-comment'></i></span></div><div class='permission_docs hidden_icon'  data-value="+value+"><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";

                          }
                      
                      });


                      var extensions =  [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
                   
           
                    $.each( response.files , function( key, value ) {
                      // alert(response); 
                   
                      var myarr = value.split("/");
                      var element1 = myarr.pop();
                      // gte extension
                      var getExt = element1.split(".");
                      var Ext = getExt.pop();

                      var element= element1.substr(0, 50);

                       $.inArray(element , extensions);

                      
                      if(Ext == 'jpg' || Ext == 'png' || Ext =='jpeg')
                          {
                            html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+element+"' data-value='"+value+"'></form></div><h4><a href='javascript:void(0)' value='"+value+"' data-value='"+value+"' id='"+value+"' class='drap'><i class='fa fa-photo'></i>"+element+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+value+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";


                         
                          }else if(Ext == 'zip'){

                               html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+element+"' data-value='"+value+"'></form></div><h4><a href='javascript:void(0)' value='"+value+"' data-value='"+value+"' id='"+value+"' class='drap'><i class='far fa-file-archive'></i> "+element+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+value+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";
                          }else{

                                html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+element+"' data-value='"+value+"'></form></div><h4><a href='javascript:void(0)' value='"+value+"' data-value='"+value+"' id='"+value+"' class='drap'><i class='far fa-file'></i> "+element+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+value+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+value+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";


                          }
                    
                      });
                    
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
                               //alert(moveFile);
                               $.ajax({
                                   type:"POST",
                                   url:"{{ Url('/') }}/move_documents",
                                   data:{
                                    _token : token,
                                    movedInFolder: movedInFolder,
                                    moveFile     : moveFile,

                                    }, 

                                    success:function(response){
                                       
                                      if(response == 'moved')
                                      {
                                         swal("file moved successfully", "", "success");
                                      }
                                      
                                    } 

                                });
                         }
                   });
                  }
                }); 
                   
                   
                 }
              }

            });
       }); 

  // Delete folder and file 
   $(document).on('click','.delete_item',function(event){
          var paths = [];

          var token = $('#csrf-token').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var directory_url  =  $('.directory_location #current_directory ').val(); 

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
                                   // alert(response);
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
           var folder_name=folder.pop();
           //alert(folder_name);
           html2+= folder_name;


           $('.back-arrow').html(html2);
     
    }

  // go to back folder 
      function upone_folder() {
        
        var path =  $('.directory_location #current_directory ').val();  
        var root_path =  "<?php echo 'public/documents/'.Auth::user()->id ?>/"+project_name;
        var n = path.lastIndexOf("/");
        var token =$('#csrf-token').val();
        var directory_url = path.substring(0, n);
        if (path != root_path) {
            data_display(token,directory_url);
         $(' #current_directory ').val(directory_url);  
         getLastUrl(directory_url);
        }
     }  
 

   // display data function
   function data_display(token,directory_url){

    $('.fav_filter').removeClass('hidden');
    $('.new_filter').removeClass('hidden');
    var projects_id = $('.directory_location #project_id_doc').val();
    
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

                var getfolder = response.folder;
                var getfiles = response.files;
                var getFav    = response.doc_index;


                $.each(response.doc_index, function(key ,value) {
                    
                     
                    var document_name = value.document_name;
                    var path          = value.path;
                       
                    var myarr = document_name.split(".");
                    var length1 = myarr.length;

                    if(length1 == 1)
                    {

                        html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' value="+document_name+" data-value="+path+" name='documents_select' ></form></div><h4><a href='javascript:void(0)' data-value='"+path+"'  class='projects'><i class='fa fa-folder-o'></i> "+document_name+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon'  data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs  hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans'  data-value='"+path+"' ><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon'  data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";

                    }else{
                         

                          var myarr = document_name.split("/");
                          var getElement = myarr.pop();
                          //get file is jpg an png 
                          var getExt = getElement.split(".");
                          var Ext = getExt.pop();

                          var element= getElement.substr(0, 50);

                          var n =  element.lastIndexOf(".");
                          var length  = element.length;
                          var ext = element.substring(n, length);


                         if(Ext == 'jpg' || Ext == 'png' || Ext =='jpeg')
                          {

                            html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+document_name+"' data-value='"+path+"'></form></div><h4><a href='javascript:void(0)' value='"+path+"' data-value='"+path+"' id='"+path+"' class='drap'><i class='fa fa-photo'></i>"+element+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+path+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";


                          }else if(Ext == 'zip'){

                               html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+document_name+"' data-value='"+path+"'></form></div><h4><a href='javascript:void(0)' value='"+path+"' data-value='"+path+"' id='"+path+"' class='drap'><i class='far fa-file-archive'></i> "+document_name+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+path+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";

                          }else{


                                html +="<div class='drop_box_document'><div class='document_index  index-drag'><div class='doc_index_list'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='documents_select' value='"+document_name+"' data-value='"+path+"'></form></div><h4><a href='javascript:void(0)' value='"+path+"' data-value='"+path+"' id='"+path+"' class='drap'><i class='far fa-file'></i> "+document_name+"</a></h4></div><div class='icons-doc'><div class='fav_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-star-o'></i></span></div><div class='notes_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-thumb-tack'></i></span></div><div class='ques_ans_docs hidden_icon black_ques_ans' data-value='"+path+"'><span><i class='fa fa-comment-o'></i></span></div><div class='permission_docs hidden_icon' data-value='"+path+"'><span><i class='fa fa-lock' aria-hidden='true'></i></span></div></div></div></div>";

                          }

                    }
                                   
                });

                box.html(html);
                $('#folder_create')[0].reset();
                $('#genrate_folder').modal('hide'); 
                $('.choose_upload_document').removeClass("beat");
                $(".table_section").find(".index-drag").addClass("draggable");
                $(".draggable").draggable({ helper : "clone"});

                    $(".table_section").find(".index-drop").addClass("droppable");
                    $(".droppable").droppable({
                          
                        drop: function( event, ui ) {
                              
                               var movedInFolder= $( this ).find('a').data('value');
                               $(ui.draggable).css('display','none');
                               var moveFile = $(ui.draggable).find('a').data('value');
                               //alert(moveFile);
                               $.ajax({
                                   type:"POST",
                                   url:"{{ Url('/') }}/move_documents",
                                   data:{
                                    _token : token,
                                    movedInFolder: movedInFolder,
                                    moveFile     : moveFile,

                                    }, 

                                    success:function(response){
                                      
                                      if(response == 'moved')
                                      {
                                         swal("file moved successfully", "", "success");
                                      }
                                    } 

                            });
                         }
                   });

              }//success
        });//ajax
   }


   // right click on document// 
    $(document).on('contextmenu','.document_index' ,function(e) {
          
          $('input:checkbox').prop('checked', false);
          e.preventDefault();

          $('.rightClickPopUpWithOutValue').css("display","none");

          var rightClickPositionLeft = e.pageX;

          var rightClickPositionTop  = e.pageY-63;

          var value = $(this).find('a').data('value');  

          $(this).find('input:checkbox').trigger( "click" );

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


          $('.right_click.drop-holder').css("top" ,rightClickPositionTop);
          $('.right_click.drop-holder').css("left",rightClickPositionLeft);

         $('.right_click.drop-holder').css("display", "block");
         
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

          $.ajax({
              
              type:"POST",
              url:"{{ Url('/') }}/extractDocument",
              data:{
                _token : token,
                extractDocumentPath: extractDocumentPath
              },  
              // multiple data sent using ajax//
              success: function (response) { 

                 var directory_url = $('#current_directory').val();
                 var token =$('#csrf-token').val(); 
                 data_display(token,directory_url);
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
     var token =$('#csrf-token').val();

     $.ajax({
              type:"POST",
              url:"{{ Url('/') }}/copy_documents",
              data:{

                _token : token,
                pasted_directory : pasted_directory,
                copied_directory : copied_directory,

              },   
              success: function (response) { 
                    //alert(response);
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
       
       var editableDocumentName = $('#renameDocumentContent').val();
       var editableDocumentUrl  = $('#renameDocumentUrl').val();
       var renameDocumentFullPath =$('#renameDocumentFullPath').val();

       var token =$('#csrf-token').val();  
         $.ajax({
                  type:"POST",
                  url:"{{ Url('/') }}/rename_documents",
                  data:{

                    _token : token,
                    editableDocumentName   : editableDocumentName,
                    editableDocumentUrl    : editableDocumentUrl,
                    renameDocumentFullPath : renameDocumentFullPath,

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

         })

          
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

})

 
  //Show selected doc details 

  $(document).on('click','input[type="checkbox"]', function() {

    var showDocWithDoc = '';

    var numberOfChecked = $('input:checkbox:checked').length;

      if(numberOfChecked == 1)
      {
          
          // var ffd  = $('.notes_aside_text1').val();
          // alert(ffd);
          var noteDocPath = $(this).data('value');
          $('.close_note_aside').addClass('hidden');
          $('.create_note_aside').removeClass('hidden');
          $('#single_select_doc').val(noteDocPath);
          $('.delete_items').removeClass('hideDeleteBtn'); 
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


                  if(getDocLength == "1"){

                     if(getDocumentTitle == "jpg" || getDocumentTitle == "png" || getDocumentTitle == "jpeg")
                     {

                          var html11  = '<img src="{{url('/')}}/display/image/?image='+thumbnailPath+'"> </img>';
                          $('.file_view_aside').removeClass('hidden');  

                          var showDocWithDoc ="<i class='fa fa-photo'></i>" +value_document+"";
                          
                     }
                     else if(getDocumentTitle == 'zip')
                     {
                          
                          var showDocWithDoc ="<i class='far fa-file-archive'></i> "+value_document+"";
                          $('.file_view_aside').addClass('hidden');  

                          
                     }else{

                          var showDocWithDoc ="<i class='fa fa-file' aria-hidden='true'></i> " +value_document+""; 
                          $('.file_view_aside').addClass('hidden');  

                     }

                  }else{
                          
                         var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +value_document+"";
                  }

                  
                  $('.create_notes_get').removeClass('hidden');
                  $('.checked_doc_details').html(showDocWithDoc);
                  $('.file_view_aside').html(html11);

          });
              
      }else if(numberOfChecked == 0)
        {
             // $('.delete_items').addClass('hideDeleteBtn'); 
             // $('.btn_delete_doc_recycle').addClass('hideDeleteBtn'); 
             // var GetDocumentName = $('.project_name').val();
             // var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetDocumentName+"";
             // $('.checked_doc_details').html(showDocWithDoc);
             // $('.create_notes_get').addClass('hidden');
             // $('.notes_aside_text1').addClass('hidden');
             // $('.note1_doc_delete').addClass('hidden');
             // $('.file_view_aside').addClass('hidden');
             // $('.submit_note1_doc').addClass('hidden');

             $('.delete_items').addClass('hideDeleteBtn'); 
             $('.btn_delete_doc_recycle').addClass('hideDeleteBtn'); 
             var GetDocumentName = $('.project_name').val();
             var showDocWithDoc ="<i class='fa fa-folder-o'></i> " +GetDocumentName+"";
             $('.checked_doc_details').html(showDocWithDoc);
             $('.create_notes_get').addClass('hidden');
             $('.notes_aside_text1').addClass('hidden');
             $('.note1_doc_delete').addClass('hidden');
             $('.file_view_aside').html('');
             $('.notes_aside_1').html('');
             $('.submit_note1_doc').addClass('hidden');


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

     $('input:checkbox').prop('checked', this.checked); 

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
          var project_directory =  $('#project_directory').val();
          
          var restorePath = [];

          $.each($("input[name='recycle_documents_select']:checked"), function(e)
          {        

                var restore_path = $(this).data('value');
                var current_path = $(this).val();
                
                restorePath.push({Rpath:restore_path , Cpath:current_path});
          });

              $.ajax({
                      
                      type:"POST",
                      url:"{{ Url('/') }}/recycle/document/restore",
                      data:{
                        _token : token,
                        projects_id : projects_id,
                        restorePath  :restorePath

                        },  
                        // multiple data sent using ajax//
                        success: function (response) { 
                            if( response = "restore"){

                                swal("restore successfully", "", "success");
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
                           var getlastElement = myarr[0];
                           var date = new Date(getlastElement*1000);
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
                        
      
                              html +="<div class='drop_box_document'><div class='document_index index-drop'><div class='doc_index_list_recycle'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' name='recycle_documents_select' ></form></div><h4><a href='javascript:void(0)' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"'  class='projects'><i class='fa fa-folder' aria-hidden='true'></i> "+value+"</a></h4></div><div class='delete_from_dir'><span>"+restoreFolderLoc+"</span></div> <div class='delete_time_dir'><span>"+DeleteDate+"</span></div></div></div>";
     
                        });


                        var extensions =  [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
                        
                        $.each( response.file , function( key, value ) {
                          
                        // delete file time or date
                          var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                           var myarr = value.split(".");
                           var getlastElement = myarr[0];
                           var date = new Date(getlastElement*1000);
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
                          

                          html +="<div class='drop_box_document'><div class='document_index index-drag'><div class='doc_index_list_recycle'><div class='check-box select_check'><form  action='#' method='post'><input type='checkbox' class='check-box-input'name='recycle_documents_select'  value='"+cuurent_recycle_doc_path+"' data-value='"+key+"'></form></div><h4><a href='javascript:void(0)' value='"+cuurent_recycle_doc_path+"' data-value='"+key+"' id='"+key+"' class='drap'><i class='fa fa-file' aria-hidden='true'></i> "+value+"</a></h4></div><div class='delete_from_dir'><p>"+restoreFolderLoc+"</p></div> <div class='delete_time_dir'><p>"+DeleteDate+"</p></div></div></div></div>";

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



// $(document).on('click','.create_note_aside.second',function(){
     
//      $('.notes_aside_2').removeClass('hidden');
//      $(this).addClass('hidden');
//      $('.close_note_aside').removeClass('hidden');

// });

// $(document).on('click','.close_note_aside.second',function(){
       
//        alert('fsf');
       
//        $('.notes_aside_2').addClass('hidden');
//        $('.close_note_aside').addClass('hidden');
//  });

//


// Delete the recycle bin documents 

$(document).on ('click','.btn_delete_doc_recycle',function(){
     
          var token = $('#csrf-token').val();
          var directory_url  =  $('.directory_location #current_directory ').val();
          var projects_id = $('.directory_location #project_id_doc').val();
          var project_directory =  $('#project_directory').val();
          
          var deletePath = [];

          $.each($("input[name='recycle_documents_select']:checked"), function(e)
          {        
               
                // var current_path = $(this).val();

                // deletePath.push(current_path);

                var restore_path = $(this).data('value');
                var current_path = $(this).val();
                deletePath.push({Rpath:restore_path , Cpath:current_path});

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
                                that.css("display","block"); 
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
                           
                           var content = response[0];
                           var timestamp = response[1];

    
                           var html = "<textarea class='notes_aside_text1' data-value='0' placeholder='Enter text here...' rows='6' cols='28'></textarea><button class='submit_note1_doc'>Add</button><button value='"+documentPath+"' data-value='"+timestamp+"' class='note1_doc_delete hidden'><i class='fa fa-trash-o'></i></button>";

                            $('.notes_aside_1').html(html);     
                            $('.notes_aside_text1').val(content);   
                            $('.close_note_aside').removeClass('hidden');
                            $('.create_note_aside').addClass('hidden');
                            $('.notes_aside_1').removeClass('hidden');     
                            $('.note1_doc_delete').removeClass('hidden');    
                            $('.submit_note1_doc').addClass('hidden');
                            $('.close_note_aside').addClass('hidden');   
                              response_status = 1;
                           

                          }else{
                              

                               response_status = 0;
                             
                             // $('.notes_aside_1').html('');
                               check();
                             $('.close_note_aside').addClass('hidden');
                             $('.create_note_aside').removeClass('hidden');

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

 



          // var noteTextarea = $('.notes_aside_1').html();

          //  if(noteTextarea == '')
          //  {
          //     $('.notes_aside_text1').removeClass('hidden'); 
          //  }
       

  

</script>

</html>
  
  