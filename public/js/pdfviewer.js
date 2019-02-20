		function showPdf(url) {			
			var pdfjsLib = window['pdfjs-dist/build/pdf'];            
			// The workerSrc property shall be specified.
			pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
			var loadingTask = pdfjsLib.getDocument(url);
			loadingTask.promise.then(function(pdf) {
				var __TOTAL_PAGES = pdf.numPages; 
				// Fetch the first page
				var pageNumber = 1;			  
				for( let i=1; i<=__TOTAL_PAGES; i+=1){
					var id ='the-canvas'+i;
					$('#canvas_div').append("<div style='background-color:gray;text-align: center;padding:20px;' ><canvas calss='the-canvas' id='"+id+"'></canvas></div>");				
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
		}		
		function renderPage(canvas, pdf, pageNumber, callback) {
			pdf.getPage(pageNumber).then(function(page) {
				var scale = 1.5;
				var viewport = page.getViewport({scale: scale});

				var pageDisplayWidth = viewport.width;
				var pageDisplayHeight = viewport.height;
				//var pageDivHolder = document.createElement();
				// Prepare canvas using PDF page dimensions
				//var canvas = document.createElement(id);
				var context = canvas.getContext('2d');
				canvas.width = pageDisplayWidth;
				canvas.height = pageDisplayHeight;
				// pageDivHolder.appendChild(canvas);

				// Render PDF page into canvas context
				var renderContext = {
				  canvasContext: context,
				  viewport: viewport
				};
				page.render(renderContext).promise.then(callback);
		  });
		} 