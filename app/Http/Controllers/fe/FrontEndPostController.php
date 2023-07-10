<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontEndPostController extends Controller
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

    public function website_posts_create($id) 
    {
        $data=Helper::load_home_data();

        $results=Helper::GetDefaultApi("/api/websites/".$id ."/posts/draft");
        $basedir = 'photos/' . $data['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        return view('fe.websites.posts.create', (array)$results['data'])->with(['folder' => $folder, 'sig' =>$sig]);
    }

    public function website_posts_create_quick($id) 
    {
        $data=Helper::load_home_data();

        $results=Helper::GetDefaultApi("/api/websites/".$id ."/posts/draft");
        $basedir = 'photos/' . $data['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        return view('fe.websites.posts.create_quick', (array)$results['data'])->with(['folder' => $folder, 'sig' =>$sig]);
    }

    
    public function website_posts_store($id, Request $request) 
    {

        $results=Helper::ActDefaultApi("/api/websites/".$id ."/posts/create", "POST", $request->all());

        if ($results["response"]["message"] == "ok") {
        
        }
        return response()->json($results['data']);
        // return redirect()->route('websites.posts.index', $id);
    }
    
    public function show_posts($id, $post) 
    {
        $results=Helper::GetDefaultApi("/api/websites/".$id ."/posts/". $post ."/get");

        return view('fe.websites.posts.show', (array)$results['data']);
    }
    
    public function edit_posts($id, $post) 
    {
        $results=Helper::GetDefaultApi("/api/websites/".$id ."/posts/". $post ."/get");
        
        $categories=Helper::GetDefaultApi("/api/websites/posts/categories");
        $results['data']->categories = $categories['data'];

        $data=Helper::load_home_data();

        $basedir = 'photos/' . $data['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";

        return view('fe.websites.posts.edit', (array)$results['data'])->with(['folder' => $folder, 'sig' =>$sig]);;
    }


}
