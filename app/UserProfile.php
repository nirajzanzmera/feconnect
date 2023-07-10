<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;

class UserProfile
{

    public static function user_detail()
    {
        $outdata='
        {
            "Avatarurl": "aaaaa",
            "Nickname": "JB",
            "level": 5,
            "LevelProgress": 950,
            "LevelCap": 1000
          }
        ';
          return json_decode($outdata,true);
    }

    public static function activity_summary()
    {
        $outdata= '
    {
      "line_items": [
        {
          "Display": "Posts",
          "Value": 50
        },
        {
          "Display": "Logins",
          "Value": 50
        }
      ],
      "Days of activity": 210,
      "Last activity": "Today",
      "Current streak": 100,
      "Longest streak": 100,
      "Accounts": 30,
      "Website domains": 1,
      "Page Updates": 500,
      "Website Visits": "10k",
      "User invitations": 9,
      "Email subscribers": 20,
      "Email sent": 20,
      "Last Login" : "1/1/2021",
      "Last Login IP" : "1.0.0.2.1",
      "Login location" : "Carlsbad, CA",
      "Total logins" : 200,
      "Total time" : "15 hrs",
      "Websites" : "8hr",
      "Posts" : "3 hr",
      "Pages" : "2 hr",
      "Others" : "1 hr",
      "Emails" : "30 mins",
      "Domains" : "30 mins",
      "User Profile" : "1 hr"
    }
';
    return json_decode($outdata,true);
    }

    public static function journal()
    {
        $outdata= '
            [
                {
                    "title":"Publish post “This post” in Yogurt Concoction account",
                    "icon":"fa-wifi",
                    "icon-color":"text-dark",
                    "date":"10/2/2021 9:03am",
                    "addition": {
                        "icon-color":"text-success",
                        "icon":"fa-check-circle",
                        "items":[
                            "Gained Pro Poster Status!",
                            "1 Posts"
                        ]
                    }
                },
                {
                    "title":"Switch to Yogurt Concoction Account",
                    "icon":"fa-shield",
                    "icon-color":"text-primary",
                    "date":"10/2/2021 9:00am"
                },
                {
                    "title":"Logged in from Carlsbad, CA",
                    "icon":"fa-arrow-right",
                    "icon-color":"text-secondary",
                    "date":"10/2/2021 8:55am",
                    "addition": {
                        "icon":"fa-fire",
                        "icon-color":"text-danger",
                        "items":[
                            "Streak updated to 100!",
                            "Longest streak updated to 100!",
                            "Days of activity updated to 210!"
                        ]
                    }
                },
                {
                    "title":"Updated Page Contact Us (on Yogurt Concoction website) in Yogurt Concoction Account [link]",
                    "icon":"fa-repeat",
                    "icon-color":"text-success",
                    "date":"10/1/2021 8:55am"
                },
                {
                    "title":"Gained 10 subscribers in past 24 hours!",
                    "icon":"fa-money",
                    "icon-color":"text-dark",
                    "date":"10/1/2021 7:00am"
                },
                {
                    "title":"100 People Visited Yogurt Concoction in past 24 hours!",
                    "icon":"fa-user",
                    "icon-color":"text-dark",
                    "date":"10/1/2021 7:00am"
                },
                {
                    "title":"Invited another user Bill to your account Yogurt Concoction",
                    "icon":"fa-user-plus",
                    "icon-color":"text-primary",
                    "date":"10/1/2021 7:00am",
                    "addition": {
                        "icon":"fa-compress",
                        "items":[
                            "1 Collaboration!"
                        ]
                    }
                },
                {
                    "title":"You sent an bulk email to 50 people from your Yogurt Concoction account",
                    "icon":"fa-paper-plane",
                    "icon-color":"text-info",
                    "date":"10/1/2021 6:00am"
                },
                {
                    "title":"You registered the domain yogurtconcoction.net",
                    "icon":"fa-server",
                    "icon-color":"text-dark",
                    "date":"10/1/2021 6:00am",
                    "addition": {
                        "icon":"fa-rocket",
                        "items":[
                            "1 Brand Launcher!"
                        ]
                    }
                }
            ]
       ';

        return json_decode($outdata,true);
    }

    public static function get_user_avatar()
    {
        return Helper::GetDefaultApi("/api/meta/user/get?type=avatar&key=default");
    }
    public static function set_user_avatar($value)
    {
        return Helper::GetDefaultApi("/api/meta/user/set?type=avatar&key=default&value=".$value);
    }
}

