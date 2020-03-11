<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use Session;
use App\Page;
use App\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;


class PagesController extends Controller
{
    public function Pages()
    {
        $pages = Page::All();
        return view('Admin.pages')->with('pages',$pages);
    }

    public function addPages(Request $request)
    {
        if ($request->isMethod('post')) {
            $pagename = $request->name;
            $page = Page::insert(['name'=> $pagename]);
            return Redirect::back()->with('success','Added Successfully');
        }else{
            return view('Admin.addpage');
        }
    }

    public function homePage(Request $request)
    {
        if ($request->isMethod('post')) {
            $pagename = $request->name;
            $section = $request->section;
            if(!empty($section)){
                foreach ($section as $key => $value) {
                    $page = Content::insert(['name'=> $pagename,'section'=>$key,'content'=>$value]);
                }
            }
            return Redirect::back()->with('success','Update Successfully');
          
        }else{
            return view('Admin.homepage');
        }
    }
    public function editHomePage(Request $request)
    {
        if ($request->isMethod('post')) {
            $pagename = $request->name;
            $section = $request->section;
            if(!empty($section)){
                foreach ($section as $key => $value) {
                    $page = Content::where('name', '=' , $pagename)
                    ->where('section', '=' , $key)
                    ->update(['content'=>$value]);
                }
            }
            return Redirect::back()->with('success','Update Successfully');
        }else{
            $page = Content::where('name', 'home')->get();
            $sections = array();
            foreach ($page as $value) {
                $section = $value['section'];
                $sections[$section] = $value['content'];
            }
            return view('Admin.edithomepage')->with('sections',$sections);
        }
    }
    
    public function contactPage(Request $request)
    {
    	if ($request->isMethod('post')) {
            $pagename = $request->name;
            $section = $request->section;
            if(!empty($section)){
                foreach ($section as $key => $value) {
                    $page = Content::insert(['name'=> $pagename,'section'=>$key,'content'=>$value]);
                }
            }
            return Redirect::back()->with('success','Update Successfully');
          
        }else{
            return view('Admin.contactpage');
        }
    }

    public function editContactPage(Request $request)
    {
        if ($request->isMethod('post')) {
            $pagename = $request->name;
            $section = $request->section;
            if(!empty($section)){
                foreach ($section as $key => $value) {
                    $page = Content::where('name', '=' , $pagename)
                    ->where('section', '=' , $key)
                    ->update(['content'=>$value]);
                }
            }
            return Redirect::back()->with('success','Update Successfully');
        }else{
            $page = Content::where('name', 'contact')->get();
            $sections = array();
            foreach ($page as $value) {
                $section = $value['section'];
                $sections[$section] = $value['content'];
            }
            return view('Admin.editcontactpage')->with('sections',$sections);
        }
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
