<?php

namespace App\Http\Controllers\fe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemoteRedirectController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function redirect(Request $request)
    {
        $token=$request->cookie('api_xsrf_token');
        $session=$request->cookie('api_laravel_session');

        /*
        $cookieJar = CookieJar::fromArray([
            'XSRF-TOKEN'=>$token,
            'laravel_session'=>$session
        ],env('APIROOTDOMAIN'));
*/

        $inroute=$request->input('route');
        /*$incookies=json_decode($request->input('cookies'),true);
        if (is_array($incookies)) {
            foreach ($incookies as $thiscookie) {
                if (isset($thiscookie['name']) and isset($thiscookie['value'])) {
                    \Cookie::Queue($thiscookie['name'], $thiscookie['value']);
                }
            }
        }*/

        if ($inroute!="") {
            return redirect(env('APIROOTENDPOINT').$inroute)->withCookies(
                [
                    cookie('XSRF-TOKEN',$token,100000),
                    cookie('laravel_session',$session,100000)
                ]
            );
        }
        // default to go home
        return redirect()->route('home');
    }

}
