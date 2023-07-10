<?php

namespace App\Http\Controllers\fe;

use App\Charts\LineChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\TODOs;
use App\Widgets;
use App\QuickLinks;
use App\Traits\PaginationTrait;

class FrontEndEmailsController extends Controller
{

    use PaginationTrait;
    
    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results=Helper::GetDefaultApi("/emails/senders/list");
        $results;

        return view('fe.campaigns.sender',(array)$results);
    }
    
    public function senders_list()
    {
        $results=Helper::GetDefaultApi("/emails/senders/list");
        return $results['data'];
    }

    public function sender_store(Request $request)
    {
        $input = $request->all();
        $results=Helper::ActDefaultApi("/api/emails/senders/create","POST",$input);

        return $results['data'];
    }
    
    public function sender_update(Request $request, $id)
    {
        $input = $request->all();
        $results=Helper::ActDefaultApi("/api/emails/senders/$id","PATCH",$input);

        return $results['data'];
    }
    
    public function sender_delete($id)
    {
        $results=Helper::ActDefaultApi("/api/emails/senders/$id","DELETE");
        return $results['data'];
    }

    public function create()
    {
        $results=Helper::GetDefaultApi("api/emails/draft");
        $lists=Helper::GetDefaultApi("/api/lists");
        
        $results['data']->default_list_id = $lists['data']->default_list_id;
        $results['data']->lists = $lists['data']->lists;

        return view('fe.campaigns.create',(array)$results['data']);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Helper::ActDefaultApi("/api/emails/create","POST",$input);
        return redirect(route('campaigns.index'));
    }

    public function show($id)
    {
        $results=Helper::GetDefaultApi("api/emails/".$id."/get");
        $results['data']->id = $id;
        return view('fe.campaigns.preview',(array)$results['data']);
    }
    
    public function edit($id)
    {
        $results=Helper::GetDefaultApi("api/emails/".$id."/get");
        $lists=Helper::GetDefaultApi("/api/lists");
        
        $results['data']->id = $id;
        $results['data']->default_list_id = $lists['data']->default_list_id;
        $results['data']->lists = $lists['data']->lists;
        
        return view('fe.campaigns.edit',(array)$results['data']);
    }
    
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $results = Helper::ActDefaultApi("/api/emails/".$id."/update","POST",$input);

        return redirect(route('campaigns.index'));
    }
    
    public function publish_preview($id)
    {
        $results=Helper::GetDefaultApi("api/emails/".$id."/get");
        $results['data']->id = $id;
        return view('fe.campaigns.publish',(array)$results['data']);
    }
    
    public function campaigns_publish($id)
    {
        $results = Helper::GetDefaultApi("api/emails/".$id."/publish");

        $results['data']->id = $id;

        return redirect()->route('campaigns.index');
    }
    
    public function update_schedule(Request $request, $id)
    {
        $input = $request->all();
        $results = Helper::ActDefaultApi("/api/emails/".$id."/update_schedule","PUT",$input);
        return $results;
    }
    
    public function campaigns_saveas($id)
    {
        $results = Helper::GetDefaultApi("/api/emails/".$id."/saveas");
        
        return redirect(route('campaigns.edit', $id));
    }
    
    public function destroy($id)
    {
        $results = Helper::ActDefaultApi("/api/emails/".$id."/destroy","POST");

        return $results;
        // return redirect(route('campaigns.index'));
    }

    public function analytics(Request $request){
        $results=Helper::GetDefaultApi("/api/emails/analytics");
        // return $results['data'];

        // Start Chart Data Configuration
        $chart_data = $results['data']->results_tied;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            $user_chart_data[$chart_data->labels[$i]] = $chart_data->datasets[0]->values[$i];
        }
        $userChart = new LineChart($chart_data->datasets[0]->name, $user_chart_data);


        $results['data']->user_chart = $userChart;
        $results['data']->user_chart->display_name = "Time-series sends, clicks, opens Tied back to Send Date";

        // Start Chart Data 2 Configuration
        $chart_data2 = $results['data']->results;
        for ($i=0; $i < count($chart_data2->labels); $i++) {
            $user_chart_data2[$chart_data2->labels[$i]] = $chart_data2->datasets[0]->values[$i];
        }
        $userChart2 = new LineChart($chart_data2->datasets[0]->name, $user_chart_data2);


        $results['data']->user_chart2 = $userChart2;
        $results['data']->user_chart2->display_name = "Time-series sends, clicks, opens as of time";
        // End Chart Data Configuration

        //return $results['data'];
        return view('fe.campaigns.analytics',(array)$results['data']);
    }

    public function email_resource($id){
        $results=Helper::GetDefaultApi("api/emails/email/".$id);

        // Start Chart Data Configuration
        $chart_data = $results['data']->results_tied;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            $user_chart_data[$chart_data->labels[$i]] = $chart_data->datasets[0]->values[$i];
        }
        $userChart = new LineChart($chart_data->datasets[0]->name, $user_chart_data);


        $results['data']->user_chart = $userChart;
        //return $results['data'];
        return view('fe.campaigns.email',(array)$results['data']);
    }


    public function emailCampaigns() 
    {
        $results=Helper::GetDefaultApi("api/emails");

        $results['data']->campaigns = $this->paginate($results['data']->campaigns);
        $results['data']->campaigns->withPath('');
        return view('fe.campaigns.index', (array)$results['data']);
    }

    public function cancelEmailCampaigns($id) 
    {
        $results=Helper::GetDefaultApi("api/emails/".$id."/cancel");
        return view('fe.campaigns.index',(array)$results['data']);
    }
    
    public function sendTest(Request $request, $id) 
    {
        $email = $request->input('email');

        $results=Helper::GetDefaultApi("/api/emails/".$id."/testsend");
        return view('fe.campaigns.index',(array)$results['data']);
    }

    public function emailTemplates() 
    {
        $results=Helper::GetDefaultApi("api/emails/templates");
        return view('fe.campaigns.templates.index',(array)$results['data']);
    }

    public function sendConf($id){
        $results=Helper::GetDefaultApi("emails/senders/sendConf/".$id);
        return $results['data'];
    }

    /* ------------- NEWSLETTER METHODS ---------------- */

    public function newsletters(){
        $results=Helper::GetDefaultApi("api/newsletters");
        return view('fe.newsletter.index',(array)$results['data']);
    }

    public function newsletters_create(){
        $results=Helper::GetDefaultApi("api/newsletters/draft");
        return view('fe.newsletter.create',(array)$results['data']);
    }

    public function newsletters_create_preview_website(Request $request, $tid,$wid){
        $results=Helper::GetDefaultApi("/api/newsletters/preview/$tid/website/$wid");
        $results['data']->tid = $tid;
        // dd($results['data']);
        return view('fe.newsletter.create_preview',(array)$results['data']);
    }

    public function newsletters_create_preview_feed(Request $request, $tid,$wid){
        $results=Helper::GetDefaultApi("/api/newsletters/preview/".$tid."/".$wid);
        $results['data']->tid = $tid;
        return view('fe.newsletter.create_preview',(array)$results['data']);
    }

    public function campaign_newsletters_create(Request $request,$id){

    }

    public function campaign_newsletters(Request $request, $id){

    }

    public function newsletter_preview(Request $request, $news){
        $results=Helper::GetDefaultApi("api/newsletters/".$news."/preview");
        $results['data']->id = $news;

        //return $results['data'];
        return view('fe.newsletter.preview',(array)$results['data']);
    }

    public function newsletter_edit(Request $request, $id){
        $results=Helper::GetDefaultApi("api/newsletters/".$id."/get");
        $results['data']->id = $id;

        $results1=Helper::GetDefaultApi("api/newsletters");
        $results['data']->feed = $results1['data']->feeds;

        return view('fe.newsletter.edit',(array)$results['data']);
    }

    public function newsletter_saveas(Request $request, $id){
        $results=Helper::GetDefaultApi("/api/newsletters/".$id."/duplicate");
        $new_id  = $results['data']->id;
        return redirect(route('newsletters.edit',['news'=>$new_id]));
    }

    public function newsletter_destroy(Request $request, $id){
        $results=Helper::ActDefaultApi("/api/newsletters/".$id."/delete", "POST");
        return $results['data'];
    }

    public function newsletter_feed_store(Request $request){

    }

    public function newsletter_store(Request $request){
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        Helper::ActDefaultApi("/api/newsletters/create","POST",$input);

        return redirect(route('newsletters.index'));
    }

    public function newsletter_update(Request $request,$id){

        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        Helper::ActDefaultApi("/api/newsletters/$id/update","POST",$input);

        return redirect(route('newsletters.edit',['news'=>$id]));
    }

    /* Email Dashboard */
    public function email_dashboard(Request $request){

        $results=Helper::GetDefaultApi("/api/emails/analytics");

        // Start Chart Data Configuration
        $chart_data = $results['data']->results_tied;
        for ($i=0; $i < count($chart_data->labels); $i++) {
            $user_chart_data[$chart_data->labels[$i]] = $chart_data->datasets[0]->values[$i];
        }
        $userChart = new LineChart($chart_data->datasets[0]->name, $user_chart_data);


        $results['data']->user_chart = $userChart;
        $results['data']->user_chart->display_name = "Time-series sends, clicks, opens Tied back to Send Date";

        // Start Chart Data 2 Configuration
        $chart_data2 = $results['data']->results;
        for ($i=0; $i < count($chart_data2->labels); $i++) {
            $user_chart_data2[$chart_data2->labels[$i]] = $chart_data2->datasets[0]->values[$i];
        }
        $userChart2 = new LineChart($chart_data2->datasets[0]->name, $user_chart_data2);


        $results['data']->user_chart2 = $userChart2;
        $results['data']->user_chart2->display_name = "Time-series sends, clicks, opens as of time";
        // End Chart Data Configuration

        //$results1=Helper::GetDefaultApi("api/emails");

        //$results['data']->emails = $results1['data']->campaigns;

        //return $results['data'];
        return view('fe.campaigns.dashboard',(array)$results['data']);

    }

    public function get_emails()  // ajax function for homepage
    {
        $emails=Helper::GetDefaultApi("/api/emails");
        return $email =  $emails['data']->campaigns;
    }
}
