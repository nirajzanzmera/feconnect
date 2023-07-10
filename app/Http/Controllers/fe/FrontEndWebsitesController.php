<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;

use App\Charts\LineChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FrontEndWebsitesController extends Controller
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

    public function index() 
    {
        $results=Helper::GetDefaultApi("api/websites");
        // Start Chart Data Configuration
        $chart_data = $results['data']->user_chart;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            if(empty($chart_data->datasets)) $datasets = 0;
            else $datasets = $chart_data->datasets[0]->values[$i];
            $user_chart_data[$chart_data->labels[$i]] = $datasets;
        }
        $userChart = new LineChart('', $user_chart_data);

        $results['data']->user_chart = $userChart;
        $results['data']->user_chart->display_name = $chart_data->display_name;
        // End Chart Data Configuration


        $results1=Helper::load_home_data();

        $rv=$results1['data']->data;
        $results['data']->posts=$rv->recent_posts;
        
        return view('fe.websites.index',(array)$results['data']);
    }

    public function edit_websites($id) 
    {

        $results=Helper::load_home_data();

        $results['data']->data->menu = "Feeds";

        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";

        $results=Helper::GetDefaultApi("/websites/".$id."/data");
        $results['data']->id = $id;
        $results['data']->name = $results['data']->site_name;

        return view('fe.websites.edit2', (array)$results['data'])->with(['data' => $results['data'], 'folder' => $folder, 'sig' =>$sig]);
    }
    
    public function website_update($website, Request $request) 
    {
        $results=Helper::ActDefaultApi("api/websites/". $website ."/update", "POST", $request->except('_method'));

        if ($results["response"]["message"] == "ok") {
            //success message
        }
        return redirect()->route('websites.edit', $website);
    }
    
    public function website_posts($id) 
    {

        $results=Helper::GetDefaultApi("/api/websites/".$id."/posts");


        return view('fe.websites.posts.index', (array)$results['data']);
    }
    
    public function website_templates($website) 
    {
        $results=Helper::GetDefaultApi("/api/templates/page/active");
        $results['data']->templates = $results['data']->data;

        return view('fe.websites.templates.index', (array)$results['data'])->with(['wid' => $website]);
    }

    public function website_theme($id) 
    {
        $results=Helper::GetDefaultApi("/api/templates/website/active");
        $results['data']->templates = $results['data']->data;

        $basedir = 'SysTemplate/';
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";

        return view('fe.websites.theme', (array)$results['data'])->with(['folder' => $folder, 'sig' =>$sig]);
    }

    public function website_edit(Request $request, $id)
    {
        $results=Helper::GetDefaultApi("websites/".$id."/data");
        return view('fe.websites.edit',(array)$results['data']);
    }

    public function notifications(Request $request){
        $results=Helper::GetDefaultApi("api/notifications/all");
        return view('fe.notifications.index',(array)$results['data']);
    }

    public function inbox(Request $request){
        $results=Helper::GetDefaultApi("api/notifications/all");
        return view('fe.notifications.inbox',(array)$results['data']);
    }

    public function notifications_get(Request $request, $id){
        $results=Helper::GetDefaultApi("api/notifications/all");
        $results['data']->noti_id = $id;

        $result1=Helper::GetDefaultApi("notification/".$id);

        return view('fe.notifications.view',(array)$results['data']);
    }


}