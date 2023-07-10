<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Mail\Test;

class MailableDemoController extends Controller
{

    public function demo_notify(Request $request)
    {
/*
        $result = "";
        try {
            $this->$data=$data;
            $result = $this->markdown('emails.subscription.canceled');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
*/

        //'emails.subscription.canceled'
        $data=array();
        $data=json_decode($request->input('data'),true) ?? [];
        //$data['route']= ''; // enter route, optional  
        //$data['msg'] = 'test';
         //'route' => 'emails.html.placeholder']);//$data,'emails.subscription.canceled');
        
        $td = array();
        try {
            return new Test($this->get_test_data($request->input('test')));
        }
        catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function get_test_data($input) 
    {
        switch ($input) {
            case 'auth.activation':
                $user=new \StdClass;
                $user->activation_token='test';
                $user->email='test';
                $rv= array(
                    'user'=> $user,
                    'user2'=> $user,
                    "route" => 'emails.auth.activation',
                );
                return $rv;
            case 'auth.tmp_pass':
                    $user = new \StdClass;
                    $user->activation_token = 'test token';
                    $user->email = 'test email';
                    return [
                        'tmp_pass' => 'testpass',
                        'user' => $user,
                        'user2' => $user,
                        'route' => 'emails.auth.tmp_pass',
                    ];
            case 'share.invite':
                $invite = new \StdClass;
                $invite->campaign = new \StdClass;
                $invite->inviter = new \StdClass;
                $invite->inviter->name="Billy Test";
                $invite->campaign->thumburl='https://dataczar-public.s3.us-west-2.amazonaws.com/675/ScheduledItem/9866_Nushn69ZCxEid8HS.png?id=1637515497';
                $invite->token='test';
                return [
                    'invite'=> $invite,
                    "route" => 'emails.share.invite',
                ];
            case 'sender.confirmation':
                $sender = new \StdClass;
                $sender->token = 'test';
                $sender->email = 'testemail';
        
                return [
                    'sender' => $sender,
                    'route' => 'emails.sender.confirmation',
                ];
            case 'subscription.canceled':
                return [
                    'data' => ['msg' => 'test message'],
                    "route" => 'emails.subscription.canceled',
                ];
            case 'subscription.domain_delete':
                return [
                    'route' => 'emails.subscription.domain_delete',
                    'data' => ['msg' => 'test message'],
                ];
            case 'team.card_required':
                $team = new \StdClass;
                $team->name = 'test account';
                $team->id = 1;
                return [
                    'route' => 'emails.team.card_required',
                    'team' => $team,
                ];
            case 'team.freeze':
                $team = new \StdClass;
                $team->name = 'test account';
                $team->id = 1;
                return [
                    'route' => 'emails.team.freeze',
                    'team' => $team,
                ];
            case 'teamwork.invite':
                $invite = new \StdClass;
                $invite->team = new \StdClass;
                $invite->accept_token = 'test token';
                $invite->team->name = 'test name';
                return [
                    'route' => 'emails.teamwork.invite',
                    'invite' => $invite,
                ];
            case 'twilio.zendesk':
                return [];
            case 'website.contact':
                $data = new \StdClass;
                $data->name='test name';
                $data->email='test email';
                $data->phone='test phone';
                $data->subject='test subject';
                $data->message='test message';
                $data->display='test display';
                $data->date='test date';
                return [
                    'route' => 'emails.website.contact',
                    'data' => $data,
                ];
            case 'website.domain_registered':
                $domain = new \StdClass;
                $domain->created_at=\Carbon\Carbon::parse('2021-01-01');
                $domain->domain = 'test domain';
                $user = new \StdClass;
                $user->name='test name';
                $sub = new \StdClass;
                $sub->plan = new \StdClass;
                $sub->plan->name = 'test plan';
                $sub->plan->price = '9.95';
                $account = new \StdClass;
                $account->owner = new \StdClass;
                $account->owner->email = 'test email';
                return [
                    'route' => 'emails.website.domain_registered',
                    'domain' => $domain,
                    'user' => $user,
                    'sub' => $sub,
                    'first_charge_date' => \Carbon\Carbon::parse('2021-01-01'),
                    'domain_price' => '9.95',
                    'account' => $account,
                    'trial' => 1,
                ];
            case 'website.live':
                $domain = new \StdClass;
                $domain->domain = 'test.com';
                return [
                    'route' => 'emails.website.live',
                    'domain' => $domain,
                ];
            case 'website.new_sub':
                $user = new \StdClass;
                $user->name='test';
                $list = new \StdClass;
                $list->name='test';
                $account = new \StdClass;
                $account->owner = new \StdClass;
                $account->owner->email='test email';
                $subscriber = new \StdClass;
                $subscriber->id = 1;
                return [
                    'route' => 'emails.website.new_sub',
                    'subscriber_id' => $subscriber,
                    'list' => $list,
                    'user' => $user,
                    'account' => $account,
                ];
            case 'website.summary':
                $next = new \StdClass;
                $next->email = false;
                $next->interview = false;
                $next->domains = false;
                $account = new \StdClass;
                $account->owner = new \StdClass;
                $account->owner->email='test email';
                $account->token = 'test token';
                return [
                    'route' => 'emails.website.summary',
                    'display_name' => 'test name',
                    'pay_alert' => true,
                    'start' => \Carbon\Carbon::parse('2021-01-01'),
                    'end' => \Carbon\Carbon::parse('2021-01-07'),
                    'next' => $next,
                    'user_chart' => '',
                    'behavior' => [

                    ],
                    'item' => [
                        [
                            'page' => 'test page',
                            'views' => 't',
                        ],
                    ],
                    'account' => $account,
                    'links' => [
                        [
                            'text' => 'Getting Started',
                            'url' => route('education.getting_started'),
                            'fa' => 'fa-map-o',
                            'icon' => 'map.png',
                            'icon-right' => 'chevron-right.png',
                        ],
                    ],

                ];
            default:
                return array();
        }
    }

/*
    
http://localhost/demo_notify?data={%22msg%22:%22test%22,%22route%22:%22emails.subscription.canceled%22}
{
    "emails.subscription.canceled" : 
        {
            "data" : {
                "msg":"test",
            }
            "route":"emails.subscription.canceled"
        }
}

*/


}
