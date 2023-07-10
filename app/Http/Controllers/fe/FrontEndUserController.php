<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Badges;
use App\UserProfile;
use Illuminate\Support\Facades\Auth;


class FrontEndUserController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }

    public function statistics(Request $request){

        return '
{

    "accounts": 2,
    "active_days": 63,
    "activity": {
    "start": 1645574400,
        "end": 1646179200,
        "data": [
            {
                "dl": "https://connect.dataczar.com/",
                "views": "5",
                "elapsed": "14039771"
            },
            {
                "dl": "https://connect.dataczar.com/emails/senders",
                "views": "1",
                "elapsed": "2450"
            },
            {
                "dl": "https://connect.dataczar.com/accounts/members",
                "views": "12",
                "elapsed": "4129827"
            },
            {
                "dl": "https://connect.dataczar.com/websites/12171/pages",
                "views": "2",
                "elapsed": "211513"
            },
            {
                "dl": "https://connect.dataczar.com/accounts/create",
                "views": "1",
                "elapsed": "4343"
            },
            {
                "dl": "https://connect.dataczar.com/websites/12171/pages/57220/edit",
                "views": "1",
                "elapsed": "7690"
            },
            {
                "dl": "https://connect.dataczar.com/emails",
                "views": "1",
                "elapsed": "2309"
            },
            {
                "dl": "https://connect.dataczar.com/websites",
                "views": "3",
                "elapsed": "7885"
            },
            {
                "dl": "https://connect.dataczar.com/accounts",
                "views": "4",
                "elapsed": "73418"
            },
            {
                "dl": "https://connect.dataczar.com/profile",
                "views": "1",
                "elapsed": "3716"
            },
            {
                "dl": "https://connect.dataczar.com/emails/templates",
                "views": "1",
                "elapsed": "1482"
            },
            {
                "dl": "https://connect.dataczar.com/emails/newsletters",
                "views": "1",
                "elapsed": "4510"
            }
        ]
    },
    "created_at": {
    "date": "2021-03-04 16:49:41.000000",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "domains": 0,
    "last_login": {
    "user_id": 7784,
        "user-agent": "GuzzleHttp/6.5.5 curl/7.76.1 PHP/8.0.11",
        "referrer": "",
        "ip": "123.201.70.17",
        "hostname": "17-70-201-123.static.youbroadband.in",
        "city": "Ahmedabad",
        "region": "Gujarat",
        "country": "IN",
        "loc": "23.0258,72.5873",
        "org": "AS18207 YOU Broadband & Cable India Ltd.",
        "postal": "380001",
        "created_at": "2022-03-02 08:52:11",
        "updated_at": "2022-03-02 08:52:11"
    },
    "login_count": 4560,
    "marketing_campaigns_complete": 0,
    "posts": 5,
    "streak_login_current": 0,
    "streak_login_max": 7,
    "subscribers": 2

}';

        //return $statistics=Helper::GetDefaultApi("/user/statistics");
    }
    public function user_dashboard(Request $request)
    {

        $results=Helper::load_home_data();
        //$statistics=Helper::GetDefaultApi("/user/statistics");

        $postsvar['Activity_summary']=UserProfile::activity_summary();
        $postsvar['Achievements']=Badges::badges();

        $count = 1;
        foreach($postsvar['Achievements'] as $k => $v){
            $postsvar['Achievements'][$k]['id'] = $count;
            $count++;
        }

        $postsvar['MainAchievements']=Badges::post_achievements();
        $postsvar['UserDetail']=UserProfile::user_detail();

        $results['data']->data->datalist=$postsvar;
        //$wid=$results['data']->data->website->id;

        $results['data']->data->interview=$request->input('interview');
        //$results['data']->data->statistics=$statistics['data'];

        $avatarResult = UserProfile::get_user_avatar();
        $avatar = $avatarResult['data']->data->value;
        $basedir = 'photos/' . $results['data']->data->user->current_team_id;
        $folder = $basedir;
        $sig = "a2d09c7d76fced01f8be4b1f4cce8bec";
        $defaultSearch = 'Avatar';
        $type = 'icons';

        //return $results['data']->data;

        return view('fe.user_dashboard', (array)$results['data']->data)->with(['folder'=>$folder, 'sig'=>$sig, 'avatar'=>$avatar, 'defaultSearch'=>$defaultSearch, 'type'=>$type ]);
    }

    public function user_badge($id){
        $results=Helper::load_home_data();
        $postsvar['Achievements']=Badges::badges();

        $count = 1;
        foreach($postsvar['Achievements'] as $k => $v){
            $postsvar['Achievements'][$k]['id'] = $count;
            $count++;
        }

        return view('fe.user_badge', (array)$results['data']->data)->with(['id'=>$id]);
    }

    public function save_user_avatar(Request $request) {
        $value = $request->image;
        $result = UserProfile::set_user_avatar($value);

        return redirect()->back();
    } 

    public function user_profile(Request $request){


        $results=Helper::load_home_data();
        $postsvar['Activity_summary']=(UserProfile::activity_summary());
        $postsvar['Achievements']=(Badges::badges());
        $postsvar['MainAchievements']=(Badges::post_achievements());
        $postsvar['UserDetail']=(UserProfile::user_detail());
        $results['data']->data->datalist=$postsvar;

//        $statistics=Helper::GetDefaultApi("/user/statistics");
//        $statistics=[];
        //$wid=$results['data']->data->website->id;
       // return $results['data']->data;
        return view('fe.user_profile', (array)$results['data']->data);
    }


    public function user_journal() 
    {
        $results['data']['journals'] = UserProfile::journal();
        
        return view('fe.user_journal',(array)$results['data']);
    }


    public function account(Request $request)
    {

        $results=Helper::load_home_data();
        return view('fe.account',(array)$results['data']->data);

    }

    public function switch_accounts($id) {

      session()->forget('home_data');

      $results=Helper::GetDefaultApi("/accounts/api/switch/$id");

      return redirect(route('home'));

    }

    public function profile(Request $request,$filter='',$apiflag=false){

        $filter = $request->input('filter') ?? $filter;
        $results=Helper::GetDefaultApi("/api/profile");
        //return $results['data']->user;

        $user = (array)$results['data']->user;
        return view('fe.user_settings', compact('user','filter'));
    }

    public function updatePassword(Request $request,$apiflag=false){

        $valid_data = $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);

        $results=Helper::ActDefaultApi("api/update_password", "PUT", $input);

        if ($results["response"]["message"] == "ok") {
            //success message
        }

        return redirect(route('profile'))->withSuccess('Password Changed.');
    }

    public function profileNotifications(Request $request){

        $valid_data = $request->validate([
            'mail_list_id' => 'integer | required',
            'property' => 'string | required',
            'value' => 'string | required',
        ]);
        $request['mail_list_id'] = $valid_data['mail_list_id'];
        $request['property'] = $valid_data['property'];
        $request['value'] = ($valid_data['value'] == 'true') ? true : false;

        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);

        $results=Helper::ActDefaultApi("profile/notifications/", "POST", $input);
        return response()->json(['status' => 'successful','response' => $results]);

    }

    public function profilePreference(Request $request, $value){

        $results=Helper::GetDefaultApi("api/profile/preference/$value");

        if ($results["response"]["message"] == "ok") {
        }

        $results1=Helper::GetDefaultApi("/api/home_data");
        session([
            'home_data' => $results1,
            'last_home_data_load' => microtime(true),
        ]);

        return redirect()->back();
    }
    
}