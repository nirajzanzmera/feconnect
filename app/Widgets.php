<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
use App\Engagements;

class Widgets extends Engagements
{
    protected $type = "widget";

    protected $child_order;

    /**
     * Examples: time-based behavior engagements
     */
    public static function home_dashboard_widgets()
    {

        $outdata= <<<"EOD"
{
    "id":"baseline",
    "child_order":[
        {"route":"fe._todo"},
        {"route":"fe._quicklink"},

        {"route":"fe._pkgcds"},
        {"route":"fe._recent_posts"},
        {"route":"fe._chart"},
        {"route":"fe._top_pages"},
        {"route":"fe._getting_started"}
    ]
}
EOD;
        return json_decode($outdata);
    }
}

