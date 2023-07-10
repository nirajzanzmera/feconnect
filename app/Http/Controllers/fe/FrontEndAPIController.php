<?php

namespace App\Http\Controllers\fe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Helper;

class FrontEndAPIController extends Controller
{



    protected $token;
    protected $session;
   /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Request $request)
    {
        if (!Helper::VerifyAccessDefaultApi()) {
            return redirect(route('login'));
        }
    }

    public function home_data(Request $request) 
    {

        if (!Helper::VerifyAccessDefaultApi()) {
            return redirect(route('login'));
        }
        return Helper::GetDefaultApi("/api/home_data");
        

    }

    public function notifications_data(Request $request)
    {
        return Helper::GetDefaultApi("/notification/data");
  }

    public function notification_read($id)
    {
        return Helper::GetDefaultApi('/notification/'.$id);
    }
    
    public function notification_archive($id)
    {
        return Helper::GetDefaultApi('/notification/archive/'.$id);
    }

}
?>