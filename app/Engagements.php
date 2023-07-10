<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
 
class Engagements extends Model
{
 
    /**
     * Consider how achievements will handle migrations in changes overtime So we don’t end up with unexpected Stale things
     * And how we might test and then how the migration will work after the test to remove the test from the customer account but preserve the results at the higher level.
     * If we split every notification variation we can have data on each separately but also roll up info, and we can test on each variation.
     *
     * At this level we should support a unqiue id, start and stop dates and a status on whether active
     * consider using live admin to provide the code that is then pulled from live api and packed in programmatically on engagementpack command
     */
    protected $type = 'engagement';

    public static function get_type()
    {
      return $type;
    }

    public static function get_meta()
    {
      return [ 
          'id' => 1,
          'start' => '2021-12-20',
          'end' => '',
          'type' => $this->$type,
          'status' => 'active',
        ];
    }

    public static function  whoiam() 
    {

        $outdata= <<<'EOD'
{
    "data":{
         "UserDetail":
            {
              "Avatarurl": "aaaaa",
              "Nickname": "JB",
              "level": 5,
              "LevelProgress": 950,
              "LevelCap": 1000
            }
         ,
          "Activity_summary":
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
            ,
          "MainAchievements":
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
                  },
                  {
                     "Icon": "Question",
                              "Name": "8 Post",
                              "Detail": "Marketing Maven"
                  }
                  ],
                  "PostsThisMonth" : 5

    }
,
"Achievements": [
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
    }
}
EOD;
        return $outdata;


    }
 
 



}
