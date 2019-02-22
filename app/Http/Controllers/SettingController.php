<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Setting;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class SettingController extends Controller
{
   public function WatermarkSetting($project_id){

        $project_id = $project_id;

        $project = Project::where('id', $project_id)->first();

        $project_name = $project->project_name;

        $getSetting = Setting::where('project_id',$project_id)->first();

        $watermark_view = $getSetting['watermark_view']; 
        $watermark_text = $getSetting['watermark_text'];

        $watermark_color = $getSetting['watermark_color'];
        $downloadable = $getSetting['downloadable'];
        $printable = $getSetting['printable'];
        $discussable = $getSetting['discussable'];

        return view('Setting.watermark',compact('project_name','project_id','watermark_view','watermark_text','watermark_color','downloadable','printable','discussable'));

   }


   public function SaveWatermarkSetting(Request $request)
   {
    
      $project_id = $request->project_id;
      $waterMark_text = $request->waterMark_text;
      $watermark_view   = $request->get1;
      $downloadable   = $request->get3;
      $printable   = $request->get2;
      

      //$getDocInFolder = Setting::where('project_id',$project_id)->update(['watermark_view' => $watermark_view,'watermark_text'=>$waterMark_text ,'downloadable'=>$downloadable,'printable'=>$printable]);
		$getDocInFolder = Setting::updateOrCreate([
							'project_id'   =>$project_id,
						  ],
						  [	
							'watermark_view' => $watermark_view,
							'watermark_text'=>$waterMark_text ,
							'downloadable'=>$downloadable,
							'printable'=>$printable,
							'discussable'=>'1',
							'watermark_color'=>'1'
						 ]);
		return "sucess";


   }
}
