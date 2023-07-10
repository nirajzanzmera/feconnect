<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
use App\Engagements;

class Badges extends Widgets
{

    protected $type = 'badge';


    public static function post_achievements()
    {
        $outdata= <<<'EOD'

    {
        "RewardIcons":[
            {
                "Icon": "Checkmark",
                "Name": "1 Post",
                "Detail": "Active Poster"
            },{
                "Icon": "Checkmark",
                "Name": "4 Post",
                "Detail": "Pro Poster"
            },{
                "Icon": "Question",
                "Name": "8 Post",
                "Detail": "Marketing Maven"
            }],
            "PostsThisMonth" : 5
    }
  EOD;
        return json_decode($outdata,true);
    }

    public static function badges()
    {
        $outdata= <<<'EOD'

[
    {
      "Title": "Contact Confirmed",
      "IconURL": "phone_confirmed.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "Website Interview",
      "IconURL": "website_interview.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "Domain Launch!",
      "IconURL": "badge_design.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "First Post!",
      "IconURL": "first_post.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "Pro Poster!",
      "IconURL": "pro_poster.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "First Email!",
      "IconURL": "first_email.jpg",
      "State": "complete",
      "AchievedDate": "9/15/2021",
      "Progress": 1,
      "ProgressCap": 1,
      "Locked": false
    },
    {
      "Title": "Marketing Maven!",
      "IconURL": "MARKETING_MAVEN.jpg",
      "State": "inprogress",
      "AchievedDate": "9/15/2021",
      "Progress": 4,
      "ProgressCap": 8,
      "Locked": false
    },{
      "Title": "Pro Collaborator!",
      "IconURL": "pro_collobration.jpg",
      "State": "inprogress",
      "AchievedDate": "9/15/2021",
      "Progress": 4,
      "ProgressCap": 8,
      "Locked": false
    },
    {
      "Title": "Pro Emailer",
      "IconURL": "pro_emailer.jpg",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    },{
      "Title": "Brand Launcher!",
      "IconURL": "brand_launcher.jpg",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    },{
      "Title": "100 Day Streak!",
      "IconURL": "100_day_streak.jpg",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    },{
      "Title": "100 Logins!",
      "IconURL": "100_logins.jpg",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    },{
      "Title": "Campaigns Interview",
      "IconURL": "campaigns_interview.jpg",
      "link": "?interview=aboutyou",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    },{
      "Title": "Marketing Interview",
      "IconURL": "marketing_interview.jpg",
      "link": "?interview=leadvalue",
      "State": "locked",
      "AchievedDate": "9/15/2021",
      "Progress": "",
      "ProgressCap": "",
      "Locked": true
    }
  ]
EOD;
        return json_decode($outdata,true);
    }
}