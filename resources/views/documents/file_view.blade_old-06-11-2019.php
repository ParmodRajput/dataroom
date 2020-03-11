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

   <!--  <script src="https://fastcdn.org/FileSaver.js/1.1.20151003/FileSaver.min.js"></script> -->
   <script src="{{ asset('public/js/FileSaver.min.js')}}"></script>

    <script src="{{asset('js/pdf.js')}}"></script>

    <script src="{{asset('js/pdf.worker.js')}}"></script>

    <style>
		*{margin:0; padding: 0; box-sizing: border-box; font-family: arial; color: #666;}
		.header-set {
		    float: left;
		    width: 100%;
		    background: #F1F1F1;
		    border-bottom: 1px solid #e2e2e2;
		    position: relative;
		    padding: 15px;
		    border-top: 2px solid #4cfff8;
		    height: 55px;
		}

		.header-set section {
		    float: left;
		    position: relative;
		    z-index: 1;

		}

		.image-name p {
		    float: right;
		    max-width: 300px;
		    padding-right: 15px;
		    overflow: hidden!important;
		    text-overflow: ellipsis!important;
		    white-space: nowrap!important;
		    padding-left: 3px;
		}

		.image-name {
		    float: left;
		    /*max-width: 300px;*/
		    line-height: 30px;
		}

		.zoom-set {
		    float: left;
		    border-left: 1px solid silver;
		    border-right: 1px solid silver;
		    padding: 0 5px;
		}

		.zoom-set a {
		    padding: 6px;
		    float: left;
		}

		.round {
		    float: left;
		    border-right: 1px solid silver;
		    padding: 0 5px;
		}

		.round a {
		    padding: 6px;
		    float: left;
		}

		.set-center {
		    position: absolute;
		    width: 100%;
		    text-align: center;
		    top: 20px;
		    left: 0;
		}

		.view {
		    float: left;
		}

		.view a {
		    display: inline-block;
		    padding: 5px 10px;
		}

		.set-center  a {
		    padding: 5px;
		}
				.share {
		    float: right;
		}

		.share a {
		    padding: 5px;
		    display: inline-block;
		    position: relative;
		    z-index: 1;
		    text-decoration: none;
		}

		.header-set i {
            font-size: 19px;
         }

         .set-center a button {
			background: none; 
			border: none;
			outline:none;
			}
		 .set-center a {
			padding: 5px;
			display: inline-block;
		  }
		  
	@media only screen and (max-width: 1100px) {
				.set-center {
		    text-align: right;
		    padding-right: 85px;
	 }
    }
   @media only screen and (max-width: 600px) {
					
   }

   #canvas_div{
   	display:none;
   	overflow-y:scroll;
   	height:95vh
   }

   .pageing a{
   		background-color: #eee;
    	width: 36px;
    	display: inline;
    	float: left;
   }

   .pageing span{
   		background-color: #eee;
    	width: 36px;
    	display: inline;
    	float: left;
   }

	</style>


</head>

	<body *oncontextmenu="return false;">
		<!-- <body> -->
       <div>
       	<input type="hidden" id="watermark_view" data-value= '{{$watermark_view}}'>
       	<input type="hidden" id="watermark_text" data-value= '{{$watermark_text}}'>
       	<input type="hidden" id="watermark_color" data-value= '{{$watermark_color}}'>
        <input type="hidden" id="downloadable" data-value= '{{$downloadable}}'>
       	<input type="hidden" id="printable"  data-value= '{{$printable}}'>
       	<input type="hidden" id="discussable"  data-value= '{{$discussable}}'>

       	<input type="hidden" id="CurrentDocPermission" data-value= '{{$DocPermission}}'>
       	<input type='hidden' id='currentPdfScale'>
       	<input type="hidden" id='current_rotated_deg' value='0'>
       	<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}'/>
       	<input type="hidden" name="download" id="document-download-viewer" value="{{$filePath}}">
       	<input type="hidden" name="scrolled" id="scrolled" value="0">
       	<input type="hidden" name="canvasheight" id="canvasheight" value="">

		<div class="header-set">
			<section><div class="image-name">
				<i class="fa fa-image"></i>
				<p>{{$doc_name}}</p>
				</div>
		     <div class="zoom-set">
				<a id="minus" href="javascript:;"><i class="fas fa-search-minus"></i></a>
			<a id="plus" href="javascript:;"><i class="fas fa-search-plus"></i></a>
				</div>
				<div class="round">

				<a id='rotate_doc_left' href="javascript:;" onclick="rotate_doc_left();"><i class="fas fa-redo"></i></a>
				<a id='rotate_doc_right' href="javascript:;" onclick="rotate_doc_right();"><i class="fas fa-undo"></i></a>

				</div>
				<div class="view">
				<a href="javascript:;" class="fence_view"><img src="{{url('/')}}/dist/img/fance.png"></img></a>
				</div></section>
				<div class="set-center">
					<a href="javascript:;" class="view_download">
						<form action="{{ Url('/') }}/project/documents/download" method="post">
                          {{ csrf_field() }}

                           <input type="hidden" name="download" id="document-download-viewer" value="{{$filePath}}">
						   <button type="submit" name="submit"><i class="fas fa-download"></i></button>
                        </form>
                    </a>

					<a class='print_document' href=""><i class="fas fa-print"></i></a>
					<a href="{{url('/')}}/project/{{$project_id}}/questions" target="_blank"><i class="fas fa-comment"></i></a>
				</div>
				<div class="share">
				<a href="javascript:;"><i class="fas fa-share-alt"></i> Share</a>
				</div>
			</div>

        
		<div class="Doc_viewer">
			<input type="hidden" id='doc_source' value='{{$document_Data}}'>
			<input type="hidden" id='doc_type' value='{{$Ext}}'>
			<input type="hidden" id="docx_file_data" value="{{$docx_data}}">
			<input type="hidden" id="zoooom" value="100">
			<input type="hidden" id="zoooom1" value="10">
			
			<div class="viewer_header">
			</div>

		    <div class="viewer_display">

				 <div class="kato" id='pageContainer'>
		
				 		<div class="WaterMarkTextContent noselect" style='top:-500px; left:-20%;z-index:999;'>
				 			<p class="content_text_wm noselect" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:-250px;left:-20%;z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:0px;left:-20%;z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:250px;left:-20%;z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap; left:-20%'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:500px; left:-20%;z-index:999;'>
				 			<p class="content_text_wm noselect" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:750px; left:-20%;z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:1000px; left:-20%; z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>
				 		<div class="WaterMarkTextContent noselect" style='top:1250px;left:-20%; z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>

				 		<div class="WaterMarkTextContent noselect" style='top:1500px;left:-20% ;z-index:999;'>
				 			<p class="content_text_wm" style='white-space:nowrap;'></p>
				 		</div>
				 	
				 <!-- 	<div class="overlay_new"></div> -->
	                <canvas id="canvas"></canvas>
	                <div id="canvas_div"></div> 
	                <div class="button_next_pre hidden">
	                	<div class="row">
	                		<div class="col-md-2 col-md-offset-5">
	                			<div class="row">
	                				<div class="pageing">
							           <a class="input-group-addon" id="pdf-prev" href="javascript:void(0);">
							           		<i class="fas fa-chevron-up"></i>
							           	</a>
								        <input name="currentnumber" type="hidden" id="currentPage" class="" value="1"/>
										<span class="input-group-addon" id="current-page">1</span>
										<span class="input-group-addon" id="total-page">1</span>
					                    <a class="input-group-addon" id="pdf-next" href="javascript:void(0);">
					                    	<i class="fas fa-chevron-down"></i>
					                    </a>
	                				</div>		                				
	                			</div>				           	
	                		</div>
	                	</div>
	                </div> 

	                <canvas id="IMGcanvas" width="1500" height="700"></canvas> 

	                <div class="blurPic" style='display: none;'></div>
                 </div>
                 <div id="excel_viewer" class="noselect"></div>
                 <div id='docx_viewer' class="noselect"></div>
               
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
      	var watermark_view = $('#watermark_view').data('value');
      	var watermark_text = $('#watermark_text').data('value');
      	var text_length = watermark_text.length;

      	if(text_length > 64)
      	{
      		$('.WaterMarkTextContent.noselect').css('font-size','20px');
              
            if(text_length > 74)
      	       {
                     $('.WaterMarkTextContent.noselect').css('font-size','17px');

      	       }

      	}

      	if(text_length < 64)
      	{
           $('.WaterMarkTextContent.noselect').css('font-size','30px');

		       if(text_length < 40)
		      	{
                   $('.WaterMarkTextContent.noselect').css('font-size','33px');
		      	}
      	}

      	var watermark_color = $('#watermark_color').data('value');
      	var downloadable = $('#downloadable').data('value');
      	var printable = $('#printable').data('value');
      	var discussable = $('#discussable').data('value');

 // downloadable exit
      	if(downloadable !== 1)
      	{
      		$('.view_download').addClass('hidden');

      	}else{

             $('.view_download').removeClass('hidden');
      	}

 // printable exit
      	if(printable !== 1)
      	{
      		$('.print_document').addClass('hidden');

      	}else{
      		
             $('.print_document').removeClass('hidden');
      	}

 // discussable exit
       // if(discussable !== 1)
      	// {
      	// 	$('.discuss_question').addClass('hidden');

      	// }else{
      		
       //       $('.discuss_question').removeClass('hidden');
      	// }


      	if(watermark_view == 1)
      	{
      		$('.content_text_wm').html(watermark_text+' '+watermark_text+' '+watermark_text);
      		$('.content_text_wm').css('color','#'+watermark_color);
      	}

		$(window).bind('mousewheel DOMMouseScroll', function(e)
		{
		    //ctrl key is pressed
		    if(e.ctrlKey == true)
		    {
		        e.preventDefault();       
		    }
		});

		$(window).keydown(function(event)
			{
			    if((event.keyCode == 107 && event.ctrlKey == true) || (event.keyCode == 109 && event.ctrlKey == true))
			    {
			        event.preventDefault();

			}
		});

      	var window_width = $(window).width();
		var window_height = $(window).height();

		$('#IMGcanvas').css('width',window_width);
        $('#IMGcanvas').css('height',window_height);
        $('#IMGcanvas').css('padding-top','1%');
        $('#IMGcanvas').css('padding-bottom','3.2%');
        $('#IMGcanvas').css('padding-right','4%');
        $('#IMGcanvas').css('padding-left','4%');

		var excel_path  = $('#excel_file').val();

		var DocPermission = $('#CurrentDocPermission').data('value');

		if(DocPermission == '7')
		{
			$('.fence_view').click();
			var clickEvent = $('.fence_view');
            setTimeout(function(){ clickEvent.trigger('click') }, 0);
            
            $('.fence_view').addClass('hidden');

		}else{

			$('.fence_view').removeClass('hidden');

		}
 
         $('.viewer_display').css('height',window_height);

		   
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

		    	            $('#canvas').css('display','none');
		    	            $('.overlay_body').addClass('hidden');

		    				var canvas = document.getElementById("IMGcanvas");
					        var ctx = canvas.getContext("2d");
					        var cw = canvas.width;
                            var ch = canvas.height;

					        var img = new Image();
					        
					        img.crossOrigin='anonymous';
					        img.onload = function () {
					            // canvas.width=img.width;
					            // canvas.height=img.height;
					            ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0,cw, ch);

					            // var dataURL=watermarkedDataURL(canvas,"It's Mine! nyfbfgf gfhdfksdf  fus fusd f f sdfo fd f hkd fh ud ");
					        }

					        img.src ='data:image/jpeg;base64,'+docPath;


					        ////////////////////////////////////////////

							// document.addEventListener("DOMContentLoaded", function(e) {

							// 		// Canvas
							// 		var mouseDown = false;
							// 		var mousePos = [0, 0];
							// 		var canvas = document.querySelector("#myCanvas");
							// 		var context = canvas.getContext("2d");
							// 		canvas.addEventListener("mousewheel", zoom, false);
							// 		canvas.addEventListener("mousedown", setMouseDown, false);
							// 		canvas.addEventListener("mouseup", setMouseUp, false);
							// 		canvas.addEventListener("mousemove", move, false);

							// 		// Defaults
							// 		var DEFAULT_ZOOM = .5;
							// 		var MAX_ZOOM = 3;
							// 		var MIN_ZOOM = .2;
							// 		var ZOOM_STEP = .1;
							// 		// var DRAW_POS = [0, 0];
							// 		var DRAW_POS = [canvas.width/2, canvas.height/2];

							// 		// Buttons
							// 		var zoomInBtn = document.querySelector("#plus");
							// 		zoomInBtn.addEventListener("click", zoomIn, false);
							// 		var zoomOutBtn = document.querySelector("#minus");
							// 		zoomOutBtn.addEventListener("click", zoomOut, false);
							// 		var resetZoomBtn = document.querySelector("#resetZoom");
							// 		resetZoomBtn.addEventListener("click", resetZoom, false);
							// 		var resetPosBtn = document.querySelector("#resetPos");
							// 		resetPosBtn.addEventListener("click", resetPos, false);

							// 		// Image
							// 		var loaded = false;
							// 		var drawPos = DRAW_POS;
							// 		var scale = DEFAULT_ZOOM;
							// 		var image = new Image();
							// 		image.src = 'data:image/jpeg;base64,'+docPath;
							// 		image.addEventListener("load", function(e) {
							// 			loaded = true;
							// 			drawCanvas();
							// 		}, false);

							// 		// Draw the canvas
							// 		function drawCanvas() {
							// 			context.fillStyle = "#FFFFFF";
							// 			context.fillRect(0,0,canvas.width,canvas.height);
							// 			if (loaded) {
							// 				drawImage();
							// 			}
							// 		}

							// 		// Draw the image
							// 		function drawImage() {
							// 			var w = image.width * scale;
							// 			var h = image.height * scale;
							// 			// var x = drawPos[0];
							// 			// var y = drawPos[1]; 
							// 			var x = drawPos[0] - (w / 2);
							// 			var y = drawPos[1] - (h / 2);
							// 			context.drawImage(image, x, y, w, h);
							// 		}
									
							// 		// Set the zoom with the mouse wheel
							// 		function zoom(e) {
							// 			if (e.wheelDelta > 0) {
							// 				zoomIn();
							// 			}
							// 			else {
							// 				zoomOut();
							// 			}
							// 		}

							// 		// Zoom in
							// 		function zoomIn(e) {
							// 			if (scale < MAX_ZOOM) {
							// 				scale += ZOOM_STEP;
							// 				drawCanvas();
							// 			}
							// 		}

							// 		// Zoom out
							// 		function zoomOut(e) {
							// 			if (scale > MIN_ZOOM) {
							// 				scale -= ZOOM_STEP;
							// 				drawCanvas();
							// 			}
							// 		}

							// 		// Reset the zoom
							// 		function resetZoom(e) {
							// 			scale = DEFAULT_ZOOM;
							// 			drawCanvas();
							// 		}

							// 		// Reset the position
							// 		function resetPos(e) {
							// 			drawPos = DRAW_POS;
							// 			drawCanvas();
							// 		}

							// 		// Toggle mouse status
							// 		function setMouseDown(e) {
							// 			mouseDown = true;
							// 			mousePos = [e.x, e.y];
							// 		}
							// 		function setMouseUp(e) {
							// 			mouseDown = false;
							// 		}

							// 		// Move
							// 		function move(e) {
							// 			if (mouseDown) {
							// 				var dX = 0, dY = 0;
							// 				var delta = [e.x - mousePos[0], e.y - mousePos[1]];
							// 				drawPos = [drawPos[0] + delta[0], drawPos[1] + delta[1]];
							// 				mousePos = [e.x, e.y];
							// 				drawCanvas();
							// 			}
							// 		}

							// 	}, true);




					        /////////////////////////////////////////////

					    //     function watermarkedDataURL(canvas,text){
									//   var tempCanvas=document.createElement('canvas');
									//   var tempCtx=tempCanvas.getContext('2d');
									//   var cw,ch;
									//   cw=tempCanvas.width=canvas.width;
									//   ch=tempCanvas.height=canvas.height;
									//   tempCtx.drawImage(canvas,0,0);
									//   tempCtx.font="240px verdana";
									//   var textWidth=tempCtx.measureText(text).width;
									//   tempCtx.globalAlpha=.50;
									//   tempCtx.fillStyle='white'
									//   tempCtx.fillText(text,cw-textWidth-10,ch-20);
									//   tempCtx.fillStyle='black'
									//   tempCtx.fillText(text,cw-textWidth-10+2,ch-20+2);
									//   // just testing by adding tempCanvas to document
									//   document.body.appendChild(tempCanvas);
									//   return(tempCanvas.toDataURL());
									// }
		    }

             // pdf view

		    if(docType == 'pdf')
		    {
		    	$('#canvas').css('display','block');

                $('.button_next_pre').removeClass('hidden'); 
                var scale = (1.2); 

                var Canvas = "IMGcanvas";
                var Content = ''; 
               
                pdfViewer(docPath,__CURRENT_PAGE,scale);
		    }

		    function pdfViewer (docPath,__CURRENT_PAGE,scale){

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

					    $('.overlay_body').addClass('hidden');

					    // Prepare canvas using PDF page dimensions

					    //$('#canvas').css('text-align','center');
					    $('#canvas').css('display','none');
					    $('#canvas_div').css('display','block');
					    $('#total-page').text(__TOTAL_PAGES);
					    // Render PDF page into canvas context
							for( let i=1; i<=__TOTAL_PAGES; i+=1){
								var id ='the-canvas'+i;
								$('#canvas_div').append("<div style='background-color:gray;text-align:center;padding:20px;' ><canvas calss='the-canvas' id='"+id+"' data-id='"+ i +"' ></canvas></div>");				
								  var canvas = document.getElementById(id);
								  //var pageNumber = 1;
								renderPage(canvas, pdf, pageNumber++, function pageRenderingComplete() {
									if (pageNumber > pdf.numPages) {
									  return; 
									}
									// Continue rendering of the next page
									renderPage(canvas, pdf, pageNumber++, pageRenderingComplete);
								});				
							}					    
					  });
					}, function (reason) {
					  // PDF loading error
					  console.error(reason);
				}); 

		    }
		function renderPage(canvas, pdf, pageNumber, callback) {
			pdf.getPage(pageNumber).then(function(page) {
				var scale = 1.5;
				var viewport = page.getViewport({scale: scale});
				var pageDisplayWidth = viewport.width;
				var pageDisplayHeight = viewport.height;
				$('#canvasheight').val(pageDisplayHeight);
				var context = canvas.getContext('2d');
				canvas.width = pageDisplayWidth;
				canvas.height = pageDisplayHeight;
				var renderContext = {
				  canvasContext: context,
				  viewport: viewport
				};
				page.render(renderContext).promise.then(callback);
		  });
		}	 

		function scrolled(a){
			var scrolled = parseInt($('#scrolled').val());
			var pagehyt  = parseInt($('#canvasheight').val());
			if(a =='up'){
				scrolled=scrolled-pagehyt;
			}
			if(a =='down'){
				scrolled=scrolled+pagehyt;
			}
			
			return scrolled;
		}
			
		    $('#canvas_div').on('scroll',function(){
		    	var tatal_canvas = parseInt($('#total-page').text());
		    	//alert(tatal_canvas);
		        //var Wscroll = $(this).scrollTop();
		        var windowHeight = $(window).height();
		        $('canvas[id^="the-canvas"]').each(function(){
		            var ThisOffset = $(this).closest('canvas').offset();
		            //console.log(ThisOffset);
		            if(windowHeight > ThisOffset.top &&  windowHeight < ThisOffset.top  + $(this).closest('canvas').outerHeight(true)){
		                var tres = $(this).closest('canvas').attr('id');
		                //alert(tres);
		                console.log($(this).attr('id')); // will return undefined if this anchor not has an Id
		                // to get parent <p> id
		                console.log($(this).closest('canvas').attr('id')); // will return the parent <p> id
		                var parent_page = $(this).closest('canvas').attr('id');
		               // alert(parent_page);
		               	var canvas_data_id = $(this).closest('canvas').attr('data-id');
		               	var prev_page =parseInt(canvas_data_id)-1;
		               	var next_page =parseInt(canvas_data_id)+1;

		               if(prev_page >= 1 || next_page <= tatal_canvas){
		      			// var prev_page_href ="#the-canvas"+prev_page;
		      			// var next_page_href ="#the-canvas"+next_page;		               	
		         //        $("#pdf-prev").attr("href",'#the-canvas'+canvas_data_id); 
		         //         $("#pdf-next").attr("href",'#'+parent_page);
			                $('#currentPage').val($(this).closest('canvas').attr('data-id'));
			                $('#current-page').text($('#currentPage').val());
			                $('#scrolled').val($('#canvas_div').scrollTop());
		               }
		            }
		        });
		    });
			// Previous page of the PDF
			$("#pdf-prev").on('click', function(event) {
				var currentPage =  $('#currentPage').val();
				var prev_page =parseInt(currentPage) -1;
				if(prev_page >= 1){
					var scroll=scrolled('up');		
					$("#canvas_div").animate({
					    scrollTop:  scroll
					});
					$('#scrolled').val(scroll);		
				}
				
			    // // Add smooth scrolling to all links
			    // // Make sure this.hash has a value before overriding default behavior
			    // if (this.hash !== "") {
			    //   // Prevent default anchor click behavior
			    //   event.preventDefault();

			    //   // Store hash
			    //   var hash = this.hash;
			    //   // Using jQuery's animate() method to add smooth page scroll
			    //   // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			    //   $('html, body').animate({
			    //     scrollTop: $(hash).offset().top
			    //   }, 100, function(){			   
			    //     // Add hash (#) to URL when done scrolling (default click behavior)
			    //     window.location.hash = hash;
			    //   });
				   //    var currentPage =  $('#currentPage').val();

				   //    var prev_page =parseInt(currentPage) -1;
				   //    //alert(prev_page);
				   //    var next_page =parseInt(currentPage)+1;
				   //    //alert(next_page);
		     //  		if(prev_page >= 1){
		     //  			var prev_page_href ="#the-canvas"+prev_page;
		     //  			var next_page_href ="#the-canvas"+next_page;
		     //  			//alert(canvas_href);
		    	// 		$("#pdf-prev").attr("href",prev_page_href); 
		    	// 		$('#pdf-next').attr("href",next_page_href);
		    	// 		$('#currentPage').val(prev_page);
		     //  		}  
			    // } // End if
 
			});

			// Next page of the PDF
			$("#pdf-next").on('click', function() {
				var tatal_canvas = parseInt($('#total-page').text());
				var currentPage =  $('#currentPage').val();
				var next_page =parseInt(currentPage)+1;
				if(next_page <= tatal_canvas){
					var scroll=scrolled('down');		
					$("#canvas_div").animate({
					    scrollTop:  scroll
					});
					$('#scrolled').val(scroll);
				}
				
				// var currentPage =  $('#currentPage').val();
				// var tatal_canvas = parseInt($('#total-page').text());
				// var next_page =parseInt(currentPage)+1;
				// if(next_page <= tatal_canvas){
				// 	$('#currentPage').val(next_page);
				// 	var canid ="#the-canvas"+currentPage;
				// 	var nextid ="#the-canvas"+next_page;
				// 	alert(canid+' '+nextid);
				//   	$('#canvas_div').animate({
				//         scrollTop: $(canid).parent().next().find(nextid).offset().top
				//     },1000);
				// }
				// var tatal_canvas = parseInt($('#total-page').text());
				// //alert(tatal_canvas);
			 //    // Add smooth scrolling to all links
			 //    // Make sure this.hash has a value before overriding default behavior
			 //    if (this.hash !== "") {
			 //      // Prevent default anchor click behavior
			 //      event.preventDefault();

			 //      // Store hash
			 //      var hash = this.hash;
			 //      // Using jQuery's animate() method to add smooth page scroll
			 //      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			 //      $('html, body').animate({
			 //        scrollTop: $(hash).offset().top
			 //      }, 100, function(){			   
			 //        // Add hash (#) to URL when done scrolling (default click behavior)
			 //        window.location.hash = hash;
			 //      });
				//       var currentPage =  $('#currentPage').val();
				//       var prev_page =parseInt(currentPage) -1;
				//       var next_page =parseInt(currentPage)+1;
				//     // alert(currentPage);
		  //     		if(next_page <= tatal_canvas){
		  //     			var prev_page_href ="#the-canvas"+prev_page;
		  //     			var next_page_href ="#the-canvas"+next_page;
		  //     			//alert(canvas_href);
		  //   			$("#pdf-prev").attr("href",prev_page_href); 
		  //   			$('#pdf-next').attr("href",next_page_href);
		  //   			$('#currentPage').val(next_page);
		  //     		}  
			 //    } // End if
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

                    if(docType == 'xlsx' || docType == 'xls' || docType == 'xlsb' ||  docType == 'xltx' || docType == 'xlt'){
                    	 $('.round').hide();
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
                 	 pdfViewer(docPath,__CURRENT_PAGE,scale);
                 }

       });

//print  functionality 

 $(document).on('click','.print_document',function(){
    window.print();
 });

 // zoom-in and zoom-out fucntionality:-

		function draw(scale, translatePos){
		    var canvas = document.getElementById("IMGcanvas");
		    var context = canvas.getContext("2d");
		 
		    // clear canvas
		    context.clearRect(0, 0, canvas.width, canvas.height);
		 
			context.save();
			context.translate(translatePos.x, translatePos.y);
			context.scale(scale, scale);
			img = new Image();
			context.drawImage(img, 0, 0, img.width, img.height,     // source rectangle
		                   0, 0, canvas.width, canvas.height); // destination rectangle;
		  
		    
			context.restore();
		} 

		var initialize = (function(){
		    var canvas = document.getElementById("IMGcanvas");
		 
		    var translatePos = {
		        x: canvas.width/100,
		        y: canvas.height/100 
		    };
		 
		    var scale = 1.0;
		    var scaleMultiplier = 0.92;
		    var startDragOffset = {};
		    var mouseDown = false;
		    var docPath = $('#doc_source').val();
		    var docType = $('#doc_type').val();

		    if(docType == 'jpg' || docType == 'png' || docType == 'jpeg' )
		    	{

			       img = new Image();
			       img.src ='data:image/jpeg;base64,'+docPath;

			   }
		 
		    // add button event listeners
		    document.getElementById("plus").addEventListener("click", function(){
		    	if(docType == 'jpg' || docType == 'png' || docType == 'jpeg' ){		    	
		        scale /= scaleMultiplier;
		        draw(scale, translatePos);
				}
				if(docType == 'pdf'){

		    		var counter ='';
		    		counter++;
		    		var zom = parseInt(counter * 25);
		    		var plus_zoom =$('#zoooom').val();
		    		if(plus_zoom < 300){
			    		var final =(parseInt(plus_zoom) + zom);
			    		console.log(final);
			    		$('#zoooom').val(final);
	                    $('#canvas_div').css('zoom',final +'%');
		    		}
				}	

				if(docType == 'xlsx' || docType == 'xls' || docType == 'xlsb' ||  docType == 'xltx' || docType == 'xlt'){
					var counter ='';
		    		counter++;
		    		var zom = parseInt(counter * 25);
		    		var plus_zoom =$('#zoooom').val();
		    		if(plus_zoom < 300){
			    		var final =(parseInt(plus_zoom) + zom);
			    		console.log(final);
			    		$('#zoooom').val(final);
	                    $('#excel_viewer').css('zoom',final +'%');
		    		}
				}

		    }, false);
		 
		    document.getElementById("minus").addEventListener("click", function(){

		    	if(docType == 'jpg' || docType == 'png' || docType == 'jpeg' )
		    	{
                   
			        scale *= scaleMultiplier;
			        draw(scale, translatePos);
		    	}

		    	if(docType == 'pdf')
		    	{  
		    		var counter ='';
		    		counter++;
		    		var zom = counter * 20;
		    		var minus_zoom = $('#zoooom').val();
		    		if(minus_zoom > 20){
		    			var final =minus_zoom-zom;
		    			console.log(zom);
		    			$('#zoooom').val(final);
                 	 	$('#canvas_div').css('zoom',final+'%');
		    		}
		    	}
		    	if(docType == 'xlsx' || docType == 'xls' || docType == 'xlsb' ||  docType == 'xltx' || docType == 'xlt'){
		    		var counter ='';
		    		counter++;
		    		var zom = counter * 20;
		    		var minus_zoom = $('#zoooom').val();
		    		if(minus_zoom > 20){
		    			var final =minus_zoom-zom;
		    			console.log(zom);
		    			$('#zoooom').val(final);
                 	 	$('#excel_viewer').css('zoom',final+'%');
		    		}
		    	}

		    }, false);
		 
		    // add event listeners to handle screen drag
		    canvas.addEventListener("mousedown", function(evt){

		        mouseDown = true;
		        startDragOffset.x = evt.clientX - translatePos.x;
		        startDragOffset.y = evt.clientY - translatePos.y;
		    });
		 
		    canvas.addEventListener("mouseup", function(evt){
		        mouseDown = false;
		    });
		 
		    canvas.addEventListener("mouseover", function(evt){
		        mouseDown = false;
		    });
		 
		    canvas.addEventListener("mouseout", function(evt){
		        mouseDown = false;
		    });
		 
		    canvas.addEventListener("mousemove", function(evt){
		        if (mouseDown) {
		            translatePos.x = evt.clientX - startDragOffset.x;
		            translatePos.y = evt.clientY - startDragOffset.y;
		            draw(scale, translatePos);
		        }
		    });

		    draw(scale, translatePos);

		}());

		// document.addEventListener('contextmenu', event => event.preventDefault());

		document.onkeydown = function(e) {

	    if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 ||     e.keyCode === 117 || e.keycode === 17 || e.keycode === 85)) {//ctrl+u Alt+c, Alt+v will also be disabled sadly.
	          
	         }
	       return false;
	    };

	    $('body').bind('copy paste',function(e) {
            e.preventDefault(); return false; 
        });



     // rotate functionality


     // $('#rotate_doc_left').click(function(){
     	function rotate_doc_left(){
			var docType2 = $('#doc_type').val();
			if(docType2 == 'jpg' || docType2 == 'png' || docType2 == 'jpeg' ){
			   var current_Deg = $('#current_rotated_deg').val();

			   var Rotated_Deg = parseInt(current_Deg) + parseInt('90');

			   $('#IMGcanvas').css('transform','rotate('+Rotated_Deg+'deg)');

			   var current_Deg = $('#current_rotated_deg').val(Rotated_Deg);				
			}
			if(docType2 == 'pdf'){
				var Wscroll = $(this).scrollTop();
		        $('canvas[id^="the-canvas"]').each(function(){
		            var ThisOffset = $(this).closest('canvas').offset();
		            if(Wscroll > ThisOffset.top &&  Wscroll < ThisOffset.top  + $(this).closest('canvas').outerHeight(true)){ 
		                console.log($(this).closest('canvas').attr('id')); // will return the parent <p> id
		                var parent_page = $(this).closest('canvas').attr('id');
						var current_Deg = $('#current_rotated_deg').val();
						var Rotated_Deg = parseInt(current_Deg) + parseInt('90');
						$('#'+parent_page).css('transform','rotate('+Rotated_Deg+'deg)');
						var current_Deg = $('#current_rotated_deg').val(Rotated_Deg);					   
		            }
		        });
			}			
     	}
     // });

         // Right rotate functionality


	     // $('#rotate_doc_right').click(function(){
	    function rotate_doc_right(){
			var docType2 = $('#doc_type').val();
			//alert(docType2);
			if(docType2 == 'jpg' || docType2 == 'png' || docType2 == 'jpeg' ){
			   var current_Deg = $('#current_rotated_deg').val();

			   var Rotated_Deg = parseInt(current_Deg) - parseInt('90');

			   $('#IMGcanvas').css('transform','rotate('+Rotated_Deg+'deg)');

			   var current_Deg = $('#current_rotated_deg').val(Rotated_Deg);				
			}	
			if(docType2 == 'pdf'){
				var Wscroll = $(this).scrollTop();
		        $('canvas[id^="the-canvas"]').each(function(){
		            var ThisOffset = $(this).closest('canvas').offset();
		            if(Wscroll > ThisOffset.top &&  Wscroll < ThisOffset.top  + $(this).closest('canvas').outerHeight(true)){ 
		                console.log($(this).closest('canvas').attr('id')); // will return the parent <p> id
		                var parent_page = $(this).closest('canvas').attr('id');
		               // alert(parent_page);
					   var current_Deg = $('#current_rotated_deg').val();
					   var Rotated_Deg = parseInt(current_Deg) - parseInt('90');
					   $('#'+parent_page).css('transform','rotate('+Rotated_Deg+'deg)');
					   var current_Deg = $('#current_rotated_deg').val(Rotated_Deg);					   
		            }
		        });
			}		
	    }
	     // });  

	</script>

</html>

