<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FrontEndContentController extends Controller
{


    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }

    public function viewImage(Request $request) {
        // Condition added for testing purpose
        //if(empty($request->file)) $file = 'https://dataczar-public.s3.us-west-2.amazonaws.com/photos/675/D594263F-F438-4F10-A308-2DCAB9CD6943_xqwfQ.jpeg';
        //else $file = $request->file;
        $file=$request->input('file');
        if (empty($file)) {
            abort(403,"No file specified");
        }
        $results=Helper::load_home_data();
        $results['data']->data->file = $file;

        return view('fe.content.images.view', (array)$results['data']->data);
    }

    public function editImage(Request $request) {
        // Condition added for testing purpose
        //if(empty($request->file)) $file = 'https://dataczar-public.s3.us-west-2.amazonaws.com/photos/675/D594263F-F438-4F10-A308-2DCAB9CD6943_xqwfQ.jpeg';
        //else $file = $request->file;
        $file=$request->input('file');
        if (empty($file)) {
            abort(403,"No file specified");
        }
        $results=Helper::load_home_data();
        $results['data']->data->file = $file;

        return view('fe.content.images.edit', (array)$results['data']->data);
    }

    public function uploadCroppedImage(Request $request) {
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name= time().'.png';

        
        // $path = public_path('upload/'.$image_name);
        // file_put_contents($path, $image);
        return response()->json(['status'=>true]);
    }

    public function viewFile(Request $request) {
        $file=$request->input('file');
        if (empty($file)) {
            abort(403,"No file specified");
        }
        $results=Helper::load_home_data();
        $results['data']->data->file = $file;

        return view('fe.content.files.view', (array)$results['data']->data);
    }
    
    public function content_feeds()
    {
        $results=Helper::load_home_data();
        $feeds=Helper::GetDefaultApi("/api/feeds");

        $results['data']->data->feeds=$feeds['data'];
        $results['data']->data->menu = "Feeds";

        return view('fe.content.feeds', (array)$results['data']->data);
    }

    public function content_feeds_create(Request $request){

        $validated = $request->validate([
            'url' => 'required|url',
        ]);



        $input = $request->all();
        $input['status'] = "Active";
        Helper::ActDefaultApi("/api/feeds/create","POST",$input);

        return redirect(route('content.feeds.index'));
    }

    public function content_images(Request $request)
    {
        $results=Helper::load_home_data();

        // Please note line 481 below. Menu has Feeds as value  
        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $file_folder = 'files/' . $results['data']->data->user->current_team_id;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $file_sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $window = ($request->type == 'window') ? true : false;
        $context = isset($request->context) ? $request->context : 'content';
        $field_name = !empty($request->field_name) ? $request->field_name : '';
        $tab = 'images';

        return view('fe.images.main', (array)$results['data']->data)->with(['folder' => $folder, 'file_folder' => $file_folder, 'sig' => $sig, 'file_sig' => $file_sig, 'window' => $window, 'context' => $context, 'field_name' => $field_name, 'tab' => $tab ]);
    }
    public function content_files(Request $request)
    {
        $results=Helper::load_home_data();

        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $file_folder = 'files/' . $results['data']->data->user->current_team_id;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $file_sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $window = ($request->type == 'window') ? true : false;
        $context = isset($request->context) ? $request->context : 'content';
        $field_name = !empty($request->field_name) ? $request->field_name : '';
        $tab = 'files';

        return view('fe.images.main', (array)$results['data']->data)->with(['folder' => $folder, 'file_folder' => $file_folder, 'sig' => $sig, 'file_sig' => $file_sig, 'window' => $window, 'context' => $context, 'field_name' => $field_name, 'tab' => $tab ]);
    }
    public function content_upload(Request $request)
    {
        $results=Helper::load_home_data();

        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $file_folder = 'files/' . $results['data']->data->user->current_team_id;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $file_sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $window = ($request->type == 'window') ? true : false;
        $context = isset($request->context) ? $request->context : 'content';
        $field_name = !empty($request->field_name) ? $request->field_name : '';
        $tab = 'upload';

        return view('fe.images.main', (array)$results['data']->data)->with(['folder' => $folder, 'file_folder' => $file_folder, 'sig' => $sig, 'file_sig' => $file_sig, 'window' => $window, 'context' => $context, 'field_name' => $field_name, 'tab' => $tab ]);
    }
    public function content_search(Request $request)
    {
        $results=Helper::load_home_data();

        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $file_folder = 'files/' . $results['data']->data->user->current_team_id;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $file_sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $window = ($request->type == 'window') ? true : false;
        $context = isset($request->context) ? $request->context : 'content';
        $field_name = !empty($request->field_name) ? $request->field_name : '';
        $tab = 'search';

        return view('fe.images.main', (array)$results['data']->data)->with(['folder' => $folder, 'file_folder' => $file_folder, 'sig' => $sig, 'file_sig' => $file_sig, 'window' => $window, 'context' => $context, 'field_name' => $field_name, 'tab' => $tab ]);
    }

    public function content_icons(Request $request)
    {
        $results=Helper::load_home_data();

        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $file_folder = 'files/' . $results['data']->data->user->current_team_id;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $file_sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $window = ($request->type == 'window') ? true : false;
        $context = isset($request->context) ? $request->context : 'content';
        $field_name = !empty($request->field_name) ? $request->field_name : '';
        $tab = 'icon';
        $type = 'icons';
        return view('fe.images.main', (array)$results['data']->data)->with(['folder' => $folder, 'file_folder' => $file_folder, 'sig' => $sig, 'file_sig' => $file_sig, 'window' => $window, 'context' => $context, 'field_name' => $field_name, 'tab' => $tab, 'type' => $type ]);
    }


    public function content_tools() {
        // this stuff is needed to populate side menu
        //if (!Helper::VerifyAccessDefaultApi()) {
        //    return redirect(route('login'));
        //}
        $results=Helper::load_home_data();
        $content=Helper::GetDefaultApi("/api/content/education.content_tools");
        $results['data']->data->newcontent=$content['data']->data;
        $results['data']->data->menu = "Content Tools";
        return view('fe.content-tools', (array)$results['data']->data);
    }

}
