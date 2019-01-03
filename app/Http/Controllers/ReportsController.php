<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Project;

class ReportsController extends Controller
{
  
  public function Report($project_id){

  	$project_id = $project_id;
  	$project = Project::where('id', $project_id)->first();
    $project_name = $project->project_slug;
  
   return view('Reports.index',compact('project_id','project_name'));


  }  
      

}
