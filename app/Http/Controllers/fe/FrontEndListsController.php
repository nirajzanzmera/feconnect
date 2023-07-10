<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FrontEndListsController extends Controller
{


    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }


    public function lists() 
    {
        $results=Helper::GetDefaultApi("/api/lists");

        //dd($results);
        return view('lists.index', (array)$results['data']);
    }

    public function lists_store(Request $request) 
    {
        
        $results=Helper::ActDefaultApi("/api/lists/store", "POST", $request->all());

        if (!empty($results['data']) && $results['data']->status == 'error') {
            $errors = $results['data']->message;
            return redirect()->back()->withErrors($errors);
        } 

        // $lists=Helper::GetDefaultApi("/api/lists");

        return redirect(route('lists.index'));
    }
    
    public function lists_update(Request $request, $id) 
    {
        $this->validate($request, [
            'name' => 'string | required',
            'tracking_link_override' => 'url | nullable',
            'default_sender' => 'string | nullable',
        ]);
        $results=Helper::ActDefaultApi("/api/lists/$id/update", "POST", $request->except('_method'));

        if (!empty($results['data']) && $results['data']->status == 'error') {
            $errors = $results['data']->message;
            return redirect()->back()->withErrors($errors);
        } 

        return redirect(route('lists.settings', $id));
    }

    public function lists_delete($id) 
    {
        $results=Helper::ActDefaultApi("/api/lists/$id/delete", "DELETE");

        if ($results["response"]["message"] == "ok") {
            //success message
        }
        return response()->json($results);
    }

    public function lists_subscribers(Request $request, $id) 
    {
        
        $results=Helper::GetDefaultApi("/datatable/list_id/${id}/subscribers");
        $lists=Helper::GetDefaultApi("/api/lists/$id/get");

        // dd($results);
        $success = null;
        $message = null;

        if (session()->has('messages')) {
            $message = session('messages');
        }
        if (session()->has('successes')) {
            $success = session('successes');
        }
        
        $results['data']->data->list = $lists['data']->list;
        return view('lists.subscribers', (array)$results['data']->data)->withMessages($message)->withSuccesses($success);
    }

    public function lists_uploads($id) 
    {
        $results=Helper::GetDefaultApi("/api/lists/$id/get");
        $list_folder = '';
        $list_sig = '';

        return view('lists.upload', (array)$results['data'])->with(['list_folder'=>$list_folder, 'list_sig'=> $list_sig]);
    }
    
    public function lists_settings($id) 
    {
        $results=Helper::GetDefaultApi("/api/lists/$id/get");
        $lists=Helper::GetDefaultApi("/api/lists");
        $list_folder = '';
        $list_sig = '';
        $senders = [];

        $results['data']->default_list_id = $lists['data']->default_list_id;

        return view('lists.settings', (array)$results['data'])->with(['list_folder'=>$list_folder, 'list_sig'=> $list_sig, 'senders'=>$senders]);
    }
    
    public function lists_default() 
    {
        $results=Helper::GetDefaultApi("/api/lists");
        if (empty($results['data']->default_list_id)) {
            return redirect('list');            
        }
        $default_id = $results['data']->default_list_id;
        
        return redirect('lists/'.$default_id.'/subscribers');
    }

    public function lists_analytics($id) 
    {
        $results=Helper::GetDefaultApi("/api/lists/${id}/analytics");
        // dd($results);
        return view('lists.analytics', (array)$results['data']->data);

    }

    public function list_manage_subscribers($id) 
    {
        $results=Helper::GetDefaultApi("api/lists/subscriber/${id}/get");
        $lists=Helper::GetDefaultApi("/api/lists");
        $results['data']->list = $lists['data']->list;

        return view('lists.subscriber_edit', (array)$results['data']);

    }

    public function list_subscribers_contact($id) 
    {
        $results=Helper::GetDefaultApi("/api/lists/subscriber/${id}/get");
        $lists=Helper::GetDefaultApi("/api/lists");
        $results['data']->list = $lists['data']->list;

        return view('lists.subscriber_contact', (array)$results['data']);

    }

    public function lists_subscribers_update(Request $request, $id) 
    {
        $results=Helper::ActDefaultApi("/api/lists/subscriber/".$id ."/update", "POST", $request->all());
        if ($results["response"]["message"] == "ok") {

        }
        return redirect()->route('lists.subscribers.manage', $id);
    }
    
    public function lists_subscribers_update_data(Request $request, $id) 
    {
        $results=Helper::ActDefaultApi("/api/lists/subscriber/".$id ."/update_data", "POST", $request->except('_method'));

        if ($results["response"]["message"] == "ok") {

        }
        return redirect()->route('lists.subscribers.manage', $id);

    }
    
    public function lists_subscribers_quickadd(Request $request, $id) 
    {
        $results=Helper::ActDefaultApi("/api/lists/".$id ."/subscribers/quick_add", "POST", $request->all());

        $success = [];
        $message = [];

        if ($results["response"]["message"] == "OK") {
            $success = $results['data']->successes;
            $message = $results['data']->messages;
        }
        return redirect()->route('lists.subscribers', $id)->with(['successes' => $success, 'messages' => $message]);

    }

}