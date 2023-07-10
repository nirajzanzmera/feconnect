<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
use App\Engagements;

class QuickLinks extends Widgets
{
    protected $type = 'quicklink';

    public static function QuickLinks()
    {
        $rv = Helper::load_home_data();
        $cnt=0;
        foreach ($rv['data']->data->links as $thislink) {
            $cnt++;
        }
        return [
            'quicklinks'=>$rv['data']->data->links,
            'quicklink_cnt' => $cnt,
            ] ;
    }


}