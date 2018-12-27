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

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('dist/img/') }}" />
      
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script> 
    <!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

     <!--  sheetjs -->
     <script type="text/javascript" src="http://cdn.grapecity.com/spreadjs/hosted/scripts/gc.spread.sheets.all.10.1.0.min.js"></script>

    <script type="text/javascript" src="http://cdn.grapecity.com/spreadjs/hosted/scripts/interop/gc.spread.excelio.10.1.0.min.js"></script>


    <script lang="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.8/xlsx.full.min.js"></script>

    <script src="https://fastcdn.org/FileSaver.js/1.1.20151003/FileSaver.min.js"></script>

    <script src="js/pdf.js"></script>

    <script src="js/pdf.worker.js"></script>


</head>
	<body>
       <div class="row">
		<div class="top_head col-md-12">
		<div class="left_whole col-md-6">
			<div class="left_text">
			<i class="fa fa-image"></i> <a href="#">{{$doc_name}}</a>
			</div>
		</div>
		<div class="zoom_icons">
		<span id="minus"><i class='fas fa-search-minus'></i></span>
		<span id="plus"><i class='fas fa-search-plus'></i></span>
		</div>

		<div class="repeat_icons">
		<i class="fa fa-repeat"></i>
		<i class="fa fa-repeat"></i>
		<span class="fence_view"><i class="fa fa-low-vision"></i></span>
		</div>


		<div class="icon_center col-md-6 ">
		<span class="ng-scope view_download">
                <a href="javascript:void(0)"><span class="dld"><i class="fas fa-download"></i></span><span class="download_file">
                    <form action="{{ Url('/') }}/project/documents/download" method="post">
                      {{ csrf_field() }}

                      <input type="hidden" name="download" id="document-download-viewer" value="{{$filePath}}">
                      <input type="submit" name="submit">
                  </form>
                  </span>
              </a>
         </span>
		<i class="fa fa-print"></i>
		<i class="fa fa-comments"></i>
		<i class="fa fa-search"></i>
		</div>

		<div class="arrows_right">
		<i class="fa fa-angle-left"></i>
		<i class="fa fa-angle-right"></i>
		</div>
		</div>

        
		<div class="Doc_viewer">
			<input type="hidden" id='doc_source' value='{{$document_Data}}'>
			<input type="hidden" id='doc_type' value='{{$Ext}}'>
			<input type="hidden" id="docx_file_data" value="{{$docx_data}}">
			<div class="viewer_header">
			</div>

		    <div class="viewer_display">

				 <div class="kato">
				 	<div class="overlay_new"></div>
	                <canvas id="canvas" width="1500" height="700"></canvas> 
	                <div class="blurPic" style='display: none'></div>
	                <div class="button_next_pre hidden">
			           <button id="pdf-prev">Previous</button>
                       <button id="pdf-next">Next</button>
                    </div> 
                 </div>
                 <div id="excel_viewer"></div>
                 <div id='docx_viewer'></div>
               
			</div>
		</div>
  
	</body>
	 <div class="overlay_body">

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

	<script type="text/javascript">

      $(document).ready(function(){

      	var window_width = $(window).width();
		var window_height = $(window).height();

		var excel_path  = $('#excel_file').val();

 
         $('.viewer_display').css('height',window_height);

       
		   // $(document).ready(function () {  
			  //   $.support.cors = true;  
			  //   workbook = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));  
			  //   //...  
     //        }); 
            
		    var __PDF_DOC,
		      __TOTAL_PAGES,
		    __CURRENT_PAGE = 1,
		    __PAGE_RENDERING_IN_PROGRESS = 0,
		    __CANVAS = $('#canvas').get(0),
		    __CANVAS_CTX = __CANVAS.getContext('2d');

		    var docPath = $('#doc_source').val();
		    var docType = $('#doc_type').val();
		    
		    if(docType == 'jpeg' || docType == 'jpg'|| docType == 'png')
		    {
		    				var canvas = document.getElementById("canvas");
					        var ctx = canvas.getContext("2d");

					        var img = new Image();
					        $('.overlay_body').addClass('hidden');
					        img.onload = function () {
					            // canvas.width=img.width;
					            // canvas.height=img.height;
					            ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0,1500, 1000);
					        }
					        img.src ='data:image/jpeg;base64,'+docPath;
		    }
              
             // pdf view

		    if(docType == 'pdf')
		    {
                $('.button_next_pre').removeClass('hidden');   
                pdfViewer(docPath,__CURRENT_PAGE);
		    }

		    function pdfViewer (docPath,__CURRENT_PAGE){

		    	var pdfData = atob(docPath);

					// Loaded via <script> tag, create shortcut to access PDF.js exports.
					var pdfjsLib = window['pdfjs-dist/build/pdf'];

					// The workerSrc property shall be specified.
					pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

					// Using DocumentInitParameters object to load binary data.
					var loadingTask = pdfjsLib.getDocument({data: pdfData});
					loadingTask.promise.then(function(pdf) {

					 var __TOTAL_PAGES = pdf.numPages;

					  // Fetch the first page
					  var pageNumber = __CURRENT_PAGE;
					  pdf.getPage(pageNumber).then(function(page) {

					    var scale = 1.5;
					    var viewport = page.getViewport(scale);

					    $('.overlay_body').addClass('hidden');

					    // Prepare canvas using PDF page dimensions
					    var canvas = document.getElementById('canvas');
					    var context = canvas.getContext('2d');
					    canvas.height = 700;
					    canvas.width = 1500;

					    // Render PDF page into canvas context
					    var renderContext = {
					      canvasContext: context,
					      viewport: viewport
					    };
					    var renderTask = page.render(renderContext);
					    renderTask.then(function () {
					      console.log('Page rendered');
					    });
					  });
					}, function (reason) {
					  // PDF loading error
					  console.error(reason);
				}); 

		    }


			// Previous page of the PDF
			$("#pdf-prev").on('click', function() {
			    if(__CURRENT_PAGE != 1)

			        pdfViewer(docPath,--__CURRENT_PAGE);
			});

			// Next page of the PDF
			$("#pdf-next").on('click', function() {
			    if(__CURRENT_PAGE != __TOTAL_PAGES)

			        pdfViewer(docPath,++__CURRENT_PAGE);
			});


        $('.blurPic').css('width',window_width);
       	$('.blurPic').css('height',window_height);
       
       $(document).on('click','.fence_view',function(){

       	            $('.blurPic').toggle();

					/**Give equal width and height as <img> to .blurPic**/
					var hgt = $('.blurPic').width($('#container img').width());
					$('.blurPic').height($('#container img').height());
					/*****************************************************/

					/*******Get shadow values*****/
					var result = $('.blurPic').css('backgroud').match(/(-?\d+px)|(rgb\(.+\))/g)
					var color = result[0],
					    y = result[1],
					    x = result[2],
					    blur = result[3];

					/******************************/

					/**Change box-shadow on mousemove over image**/
					var blurStartW = hgt.width()/2;
					var blurStartH = hgt.height()/2;
					$('.blurPic').mousemove(function(event){
					    event.preventDefault();
					    var scrollLeftPos = $(window).scrollLeft(),
					    scrollTopPos = $(window).scrollTop(),
					    offsetLft = hgt.offset().left,
					    offsetTp = hgt.offset().top;
					    var upX = event.clientX;
					    var upY = event.clientY;
					    $(this).css({boxShadow : ''+(-offsetLft+upX-blurStartW+scrollLeftPos)+'px '+(-offsetTp+upY-blurStartH+scrollTopPos)+'100px 0px 20px black inset'});
					});
					/*********************************************/

					/***reset box-shadow on mouseout***/
					$('.blurPic').mouseout(function(){
					    $(this).css({backgroud : '0px 0px 0px 160px black inset'});
					}); 


       })


         
				   //   var excelIO = new GC.Spread.Excel.IO(); 

				   //        function ImportFile() {  
						 //    var excelUrl = "./test.xlsx";  

						 //    var oReq = new XMLHttpRequest();  
						 //    oReq.open('get', excelUrl, true);  
						 //    oReq.responseType = 'blob';  
						 //    oReq.onload = function () {  
						 //        var blob = oReq.response;  
						 //        excelIO.open(blob, LoadSpread, function (message) {  
						 //            console.log(message);  
						 //        });  
						 //    };  
						 //    oReq.send(null);  
						 // }  

							// function LoadSpread(json) {  
							//     jsonData = json;  
							//     workbook.fromJSON(json);  

							//     workbook.setActiveSheet("Revenues (Sales)");  
							// }  


							 /* set up XMLHttpRequest */

                    if(docType == 'xlsx' || docType == 'xls'){

                    	 $('#excel_viewer').css('height',window_height-50);
                    	 var pdfData = atob(docPath);             

		                        var data = pdfData;
		                        var wb = XLSX.read(data,{type:'binary'});
                                
		                        var htmlstr = XLSX.write(wb,{type:'binary',bookType:'html'});
		                        
		                        $('.overlay_body').addClass('hidden');

		                $('#excel_viewer')[0].innerHTML += htmlstr;
                    }      

                if(docType == 'docx')
			        {
                      
			           	var data = $('#docx_file_data').val();
                     	$('#docx_viewer').html(data);

                    } 

                 if( docType == 'ppt')
                 {
                 	 var data = $('#docx_file_data').val();
                 	 pdfViewer(docPath,__CURRENT_PAGE);
                 }

       });

	</script>

</html>

