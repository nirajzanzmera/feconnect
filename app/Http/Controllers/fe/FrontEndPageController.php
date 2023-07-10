<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontEndPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }


    public function website_pages($website) 
    {
        $results=Helper::GetDefaultApi("/api/websites/".$website."/pages");


        return view('fe.websites.pages.index', (array)$results['data']);
    }

    public function website_pages_show_create($website) 
    {
        $data=Helper::load_home_data();
        
        $basedir = 'photos/' . $data['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        
        $results=Helper::GetDefaultApi("/api/websites/".$website ."/pages/draft");
        return view('fe.websites.pages.create', (array)$results['data'])->with(['folder' => $folder, 'sig' =>$sig]);
    }
    
    public function website_pages_store($website, Request $request) 
    {

        $results=Helper::ActDefaultApi("/api/websites/".$website ."/pages/create", "POST", $request->all());

        if ($results["response"]["message"] == "ok") {
            //success message
        }
        return response()->json($results);

        // return redirect()->route('websites.pages.index');
    }
    
    public function website_pages_update($website, $page, Request $request) 
    {

        $results=Helper::ActDefaultApi("/api/websites/".$website ."/pages/". $page ."/update", "POST", $request->all());

        if ($results["response"]["message"] == "ok") {
            //success message
        }
        return response()->json($results);

        // return redirect()->route('websites.pages.index');
    }
    
    public function show_pages($website, $page) 
    {
         $results=Helper::GetDefaultApi("/api/websites/".$website ."/pages/". $page ."/get");
        
         return view('fe.websites.pages.show', (array)$results['data']);
    }
    
    public function edit_pages($website, $page) 
    {
        $results=Helper::GetDefaultApi("/api/websites/".$website ."/pages/". $page ."/get");
        $results['data']->type='page';
        $basedir = 'photos/' . $results['data']->website->token;
        $results['data']->folder = $basedir;
        $results['data']->sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $results['data']->crud_type = "edit";

        return view('fe.websites.pages.edit_new', (array)$results['data']);
    }


    public function code_pages($website, $page)
    {
        $results=Helper::GetDefaultApi("/api/websites/".$website ."/pages/". $page ."/get");
        $results['data']->type='page';
        $basedir = 'photos/' . $results['data']->website->token;
        $results['data']->folder = $basedir;
        $results['data']->sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $results['data']->crud_type = "edit";

        return view('fe.websites.pages.code', (array)$results['data']);
    }

    public function replicate($id,$post){
        $results=Helper::ActDefaultApi("websites/$id/page/$post/replicate", "POST", $request->all());

        if ($results["response"]["message"] == "ok") {
            //success message
        }
        return response()->json($results);
    }

    public function archive($website,$page,Request $request){

        $results=Helper::GetDefaultApi("/api/websites/$website/pages/$page/archive");

        if ($results["response"]["message"] == "ok") {
        }
        return $results;
    }


    public function unarchive($website,$page,Request $request){

        $results=Helper::GetDefaultApi("/api/websites/$website/pages/$page/unarchive");

        if ($results["response"]["message"] == "ok") {
        }
        return $results;
    }
}
