<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
use App\Engagements;

class TODOs extends Widgets
{
    protected $type = 'todo';

    public static function todos()
    {

        $results=Helper::load_home_data();
        $next_steps=$results['data']->data->next_steps;

        $outdata= <<<'EOD'
{
    "data":{
        "todo": [
            {
              "Title": "Confirm your Email Address",
              "Description": "Your email hasn't been confirmed, Please click on the confirm link in the email we sent you when you signed up. Or click here to resend the confirmation email.",
              "Status": "",
              "Link_title": "Resend Confirmation Email",
              "Url": "email",
              "Route": "auth.activate.resend",
              "Type": "email"
            },
            {
              "Title": "Complete Website Interview",
              "Description": "By completing the Website Interview, we can automatically setup your website, and other resources for your account.",
              "Status": "",
              "Link_title": "Click here to Complete Interview",
              "Url": "interview/restart",
              "Route": "interview.restart",
              "Type": "interview"
            },
            {
              "Title": "Register Your Domain",
              "Description": "You haven't Registered your Free Domain. Every Basic account includes one Free Domain registration with free renewals.",
              "Link_title": "Click here to Complete Domain",
              "Status": "",
              "Route": "domains.index",
              "Url": "domains",
              "Type": "domain"
            }
        ]
    }
}
EOD;
        $rv=[];
        $rv['data']=json_decode($outdata,true);
        $rv['data']=$rv['data']['data'];
        $rv['data']['todo'][0]['Status']=($next_steps->email ?? false) ? 'DONE' : 'TODO';
        $rv['data']['todo'][1]['Status']=($next_steps->interview ?? false) ? 'DONE' : 'TODO';
        $rv['data']['todo'][2]['Status']=($next_steps->domains ?? false) ? 'DONE' : 'TODO';
        $rv['data']['todo_cnt']=0;
        foreach ($rv['data']['todo'] as $thisone) {
            $rv['data']['todo_cnt'] += $thisone['Status'] == "TODO" ? 1 : 0;
        }
        return $rv['data'];
    }

}