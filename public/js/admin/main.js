(function () {
	"use strict";
	var treeviewMenu = $('.app-menu');
	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});
	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});
	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();
})();

//CK Editor
CKEDITOR.replace("section[bannercontent]");
CKEDITOR.replace("section[trustedby]");
CKEDITOR.replace("section[focus]");
CKEDITOR.replace("section[SandR]");
CKEDITOR.replace("section[idealplatform]");
CKEDITOR.replace("section[customerreviews]");
CKEDITOR.replace("section[contactus]");
CKEDITOR.replace("section[contactaddress]");
//images upload 
$(".imgAdd").click(function(){
	var maxlength = $(this).parent().find(".img").first().data('max');
	console.log(maxlength);
	var length    = $(this).parent().find(".img").length;
	if(length < maxlength){
		$(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" name=uploadFile[] value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
	}else{
		swal("You can maximum "+maxlength+" file upload")
	}
});
$(document).on("click", "i.del" , function() {
	$(this).parent().remove();
});
$(function() {
    $(document).on("change",".uploadFile", function() {
    	var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if (/^image/.test( files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
				uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});