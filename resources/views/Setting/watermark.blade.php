@extends('layouts.app_blank')
@section('content')
<div class="padding_top_users"></div>
<div class="content-wrapper">

	<div class="row">
		<div class="reports_record col-md-12">
		    <input type="hidden" class='current_dir_qa'>
			<input type="hidden" class='project_id_Wsetting' value="{{$project_id}}">
			<input type='hidden' class='project_name_Wsetting' value='{{$project_name}}'>
      <input type="hidden" id ="project_path">

      <input type="hidden" id="watermark_view" data-value= '{{$watermark_view}}'>
      <input type="hidden" id="watermark_text" data-value= '{{$watermark_text}}'>
      <input type="hidden" id="watermark_color" data-value= '{{$watermark_color}}'>
      <input type="hidden" id="downloadable" data-value= '{{$downloadable}}'>
      <input type="hidden" id="printable"  data-value= '{{$printable}}'>
      <input type="hidden" id="discussable"  data-value= '{{$discussable}}'>

			<input type="hidden" class='auth_name' value='{{ Auth::user()->name }}'>

			<div class="col-md-2">
					<div class="left_section">
						<ul>
							<!-- <li id='Report1'><span><i class="fa fa-cogs"></i></span><a href="#overview">General Setting</a></li> -->
							<li><span><i class="fa fa-cogs"></i></span><a href="javascript:;">WaterMark</a></li>
						</ul>
					</div>	
		    </div>
			<div class="document_index_contentable col-md-10">
        <div class="water_mark_setting_sec">
          <div class='water_mark_setting_up'>
             <div class='mark_setting_text'>
              
             </div>
             <!-- <button>Edit</button> -->
          </div>
          <div class="water_mark_setting_container">
                    <div class="panel-body form-horizontal">
                      <div class="media ng-scope" ng-if="vm.isGeneralEditing" style="">
                        <div class="media-left">
                          <div class="watermark-preview watermark-preview--body">
                            <div class="watermark-preview__holder" ng-style="{'color': vm.generalSettings.Color }" style="color: rgb(72, 112, 175);">
                            </div>
                          </div>
                        </div>
                        <div class="media-body"><div class="form-group"><div class="col-xs-5">  <label class="control-label ng-binding">Watermark pages on:</label>
                        </div>
                        <div class="col-xs-7">
                          <div class="viewed_doc_checkbox">
                            <label>
                              <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
                              <input type="checkbox" id='viewed_doc'> 
                              <span class="theme-checkbox"></span> <span class="ng-binding">View</span></label>
                            </div><div class="print_doc_checkbox"><label>
                              <input type="checkbox" id='print_doc'> 
                              <span class="theme-checkbox"></span> <span class="ng-binding">Print</span></label></div>
                              <div class="download_doc_checkbox"><label>
                              <input type="checkbox" id='download_doc'>
                             <span class="theme-checkbox"></span>
                             <span ng-bind="vm.downloadWatermarkSettings" class="ng-binding">Download PDF / encrypted file</span>
                            </label>
                            </div></div></div>
                            <div class="form-group ng-scope" ng-if="!vm.isCustomWatermarksDisabled"><div class="col-xs-5">
                              <label class="control-label ng-binding">Watermark pattern:</label>
                            </div><div class="col-xs-7">
                              <textarea rows="1" maxlength="90" minlength="40" onkeyup="countChar(this)" id='waterMark_text_ch_doc' class="form-control"  style="overflow: hidden; overflow-wrap: break-word; height: 55px;"></textarea>

                              <div class='error_text hidden' style="color:red; border: 1px solid red;margin-top: 10px;"></div>
                            </div>
                          </div>
                          <div class="form-group ng-scope" ng-if="!vm.isCustomWatermarksDisabled"><div class="col-xs-5"><label class="control-label ng-binding">Watermark color:</label></div><div class="col-xs-7"><div class="form-control-static"><div class='colorWatermark'></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class='water_mark_setting_down'>
            <!-- <button id='sdfsdfdfdfsdf'>Edit</button> -->
            <button id='watermark_setting_save' class='btn btn-primary'>Apply</button>
          </div>
        </div>
	   </div>

     <script type="text/javascript">

$(document).ready(function(){


        var watermark_view = $('#watermark_view').data('value');  
        var watermark_text = $('#watermark_text').data('value');
        var watermark_color = $('#watermark_color').data('value');
        var downloadable = $('#downloadable').data('value');
        var printable = $('#printable').data('value');
        var discussable = $('#discussable').data('value');


        $('#waterMark_text_ch_doc').val(watermark_text);

        if(watermark_view == 1)
        {
          
          $('.viewed_doc_checkbox input:checkbox').prop('checked', true); 

        }

        if(printable == 1)
        {
          
          $('.print_doc_checkbox input:checkbox').prop('checked', true); 

        }

        if(downloadable == 1)
        {
          
          $('.download_doc_checkbox input:checkbox').prop('checked', true); 

        }


        $('#watermark_setting_save').click(function(){

         var waterMark_text = $('#waterMark_text_ch_doc').val();
          if(waterMark_text == '')
          {
            var waterMark_text = 'WaterMark';
          }

         var project_id     = $('.project_id_Wsetting').val();

         if($('.viewed_doc_checkbox input[type="checkbox"]'). prop("checked") == true){

           var get1 = '1';

          }else{

            var get1 = '0';
          }

          if($('.print_doc_checkbox input[type="checkbox"]'). prop("checked") == true){

           var get2 = '1';

          }else{

            var get2 = '0';

          }

          if($('.download_doc_checkbox input[type="checkbox"]'). prop("checked") == true){

           var get3 = '1';

          }else{

            var get3 = '0';

          }

         var token = $('#csrf-token').val();  

                    $.ajax({

                        type : "POST",
                        url : "{{url('/')}}/save_WaterMark/setting",
                        data : {     
                          _token       : token,
                          project_id   : project_id,
                          waterMark_text   : waterMark_text,
                          get1 : get1,
                          get2 : get2,
                          get3 : get3,

                        },
                        success:function(response){
                            if(response =='sucess'){

                              swal("successfull", "", "success"); 
                            }
                          }

                    });

        });
    
    });

    function countChar(val){

       var len = val.value.length;

       if (len <= 90 && len >=40 ) {

            $('#watermark_setting_save').prop('disabled', false);
            $('.error_text').addClass('hidden');
            $('.error_text').html('');

       }else{
            
            $('#watermark_setting_save').prop('disabled', true);

            $('.error_text').removeClass('hidden');
            $('.error_text').html('Please enter minimum 40 letter.');

       }

    };

   </script>

@endsection

