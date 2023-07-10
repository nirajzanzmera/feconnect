<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;
use App\Charts\LineChart;
use App\Widgets;

use App\TODOs;
use App\QuickLinks;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vedmant\FeedReader\Facades\FeedReader;


class FrontEndHomeController extends Controller
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

    public function home_alt(Request $request) 
    {
        $results=Helper::load_home_data();

        $rv=$results['data']->data;
        $rv->posts=$rv->recent_posts;

        // Start Chart Data Configuration
        $chart_data = $rv->user_chart;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            $user_chart_data[$chart_data->labels[$i]] = $chart_data->datasets[0]->values[$i];
        }
        $userChart = new LineChart($chart_data->datasets[0]->name, $user_chart_data);

        $rv->settings = $rv->team->settings ?? '';
        $rv->user_chart = $userChart;
        $rv->user_chart->display_name = $chart_data->display_name;
        // End Chart Data Configuration

        $postsvar=TODOs::todos();
        $rv->widgets=Widgets::home_dashboard_widgets();
        $rv->quicklinks=QuickLinks::QuickLinks();
        $rv->datalist=$postsvar;
        $rv->interview=$request->input('interview');


        return view('fe.homealt', (array)$rv);
    }
    
    public function home_wapi(Request $request) 
    {
        $results=Helper::load_home_data();

        $rv=$results['data']->data;
        $rv->posts=$rv->recent_posts;

        // Start Chart Data Configuration
        $chart_data = $rv->user_chart;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            $user_chart_data[$chart_data->labels[$i]] = $chart_data->datasets[0]->values[$i];
        }
        $userChart = new LineChart($chart_data->datasets[0]->name, $user_chart_data);

        $rv->settings = $rv->team->settings ?? '';
        $rv->user_chart = $userChart;
        $rv->user_chart->display_name = $chart_data->display_name;
        // End Chart Data Configuration

        $postsvar=TODOs::todos();
        $rv->widgets=Widgets::home_dashboard_widgets();
        $rv->quicklinks=QuickLinks::QuickLinks();
        $rv->datalist=$postsvar;
        $rv->interview=$request->input('interview');

//        $results1=Helper::GetDefaultApi("/api/blog/data");
//        $rv->blog =$results1['data'];

        //return $rv;
        return view('fe.home', (array)$rv);
    }


    public function iframe(Request $request) 
    {
        $results=Helper::load_home_data();

        return view('fe.iframe', (array)$results['data']->data);

    }

    public function legal() 
    {
        return view('fe.legal');//, (array)$results['data']->data);
    }

 
    public function post_test(Request $request) 
    {
        
        $content=[ 
            "title" => null,
            "image" => null,
            "publish_date" => null,
            "publish_time" => null,
            "category" => null,
            "status" => null,
            "content" => null,
            "editor" => null,
        ];
        dd ( Helper::ActDefaultApi("/api/websites/152/posts/create","POST",$content) );

        $content=[ 
            "title" => 't',
            "image" => null,
            "publish_date" => null,
            "publish_time" => null,
            "category" => null,
            "status" => null,
            "content" => null,
            "editor" => null,
        ];
            dd ( Helper::ActDefaultApi("/api/websites/152/posts/45833/update","POST",$content) );

        
        $content=[
            "url" => "https://www.dataczar.com/",
            "status" => "Active",
        ];
        dd ( Helper::ActDefaultApi("/api/websites/152/posts/45833/get","GET",$content) );

        dd ( Helper::ActDefaultApi("/api/feeds/1760/update","POST",$content) );
    }

    public function get_feeds()  // ajax function for homepage
    {
        $feeds=Helper::GetDefaultApi("/api/feeds");
        return $feed =  $feeds['data'];
    }

    public function get_blogs()  // ajax function for homepage
    {
        $feeds=Helper::GetDefaultApi("/api/blog/data");
        return $feed =  $feeds['data'];
    }

    public function show_blog($id=null,$title=null)  // fe.blog view page
    {
        if(!empty($id)){
            $results=Helper::GetDefaultApi("/api/blog/".$id);
            return view('fe.blog', (array)$results['data']);
        }
        return view('fe.blog');

    }

    public function get_recent_post($website_id)  // ajax function for homepage
    {
        $tmpvar=Helper::GetDefaultApi("/api/websites/$website_id/posts");
        return $posts = $tmpvar['data']->posts;
    }

    public function content_feeds_show($id){
        // return $id;
        $content=[
            "url" => "https://www.dataczar.com/",
            "status" => "Active",
        ];
        dd ( Helper::ActDefaultApi("/api/feeds/".$id."/json?count=2","GET",$content) );
    }

    public function feed_rss(Request $request){
        $f = FeedReader::read('https://dataczar.com/feed.rss');

        $feed = array();
        foreach($f->get_items() as $k => $v){
            $feed[$k]['title'] =  $v->get_title();
            $feed[$k]['link'] =  $v->get_link();
            $feed[$k]['description'] = substr(strip_tags($v->get_content(),'<img><P>'),0,1000);//substr(strip_tags($post['content']),0,100)
            $feed[$k]['date'] = $v->get_date();
        }
        return $feed;
    }


}