<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;



class PagesController extends Controller
{
    public function home()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.home');
    }
    
    public function contact()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.contact');
    }
    public function platform()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.platform');
    }
    public function solutions()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.solutions');
    }
    public function support()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.support');
    }
    public function clients()
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.clients');
    }
    public function pricing()    
    {
    	//$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('frontend.pricing');
    }

    public function profile()    
    {
        //$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('users.profile');
    }

      public function security()    
    {
        //$page = Page::where('page_name', 'about_us')->first();
        //$page_name = 'Home';
        return view('users.updateSecurity');
    }
    
    public function users($project_id)    
    {
        $project_id = $project_id;

        $project = Project::where('id', $project_id)->first();

        $project_name = $project->project_name;

        return view('groups.index',compact('project_name','project_id'));

    }


    public function Shared_By($project_id){

        if (Auth::user()){

            $project_id = $project_id;

            $project = Project::where('id', $project_id)->first();

            $project_name = $project->project_slug;

            return view('Share.shareByMe',compact('project_name','project_id'));
        }
        else{
            return redirect('/login');
        }

    }

}
