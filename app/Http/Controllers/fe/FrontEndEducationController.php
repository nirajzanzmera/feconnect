<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FrontEndEducationController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }


    public function help() {

        $indata=Helper::GetDefaultApi("/api/content/education.index");
        $outdata=(object)array(
            'menu' => 'help',
            'content' => $indata['data']->data->content ?? '',
        );

        return view('fe.help', ['newcontent'=>$outdata]);// (array)$results['data']->data);//compact('newcontent'));//(array)$results['data']->data);
    }

    public function getting_started() {
        // this stuff is needed to populate side menu
        //if (!Helper::VerifyAccessDefaultApi()) {
        //    return redirect(route('login'));
        //}
        $results=Helper::load_home_data();
        $content=Helper::GetDefaultApi("/api/content/education.getting_started");
        $results['data']->data->newcontent=$content['data']->data;
        $results['data']->data->menu = "Getting-Started";
        return view('fe.help', (array)$results['data']->data);
    }

    public function videos() {
        // this stuff is needed to populate side menu
        //if (!Helper::VerifyAccessDefaultApi()) {
        //    return redirect(route('login'));
        //}
        $results=Helper::load_home_data();
        $content=Helper::GetDefaultApi("/api/content/education.videos");
        $results['data']->data->newcontent=$content['data']->data;
        $results['data']->data->menu = "Videos";
        return view('fe.help', (array)$results['data']->data);
    }

    public function coaching() {
        // this stuff is needed to populate side menu
        //if (!Helper::VerifyAccessDefaultApi()) {
        //    return redirect(route('login'));
        //}
        $results=Helper::load_home_data();
        $content=Helper::GetDefaultApi("/api/content/education.coaching");
        $results['data']->data->newcontent=$content['data']->data;
        $results['data']->data->menu = "Coaching";
        return view('fe.help', (array)$results['data']->data);
    }

    public function ebooks() {
        // this stuff is needed to populate side menu
        //if (!Helper::VerifyAccessDefaultApi()) {
        //    return redirect(route('login'));
        //}
        $results=Helper::load_home_data();
        $content=Helper::GetDefaultApi("/api/content/education.ebooks");
        $results['data']->data->newcontent=$content['data']->data;
        $results['data']->data->menu = "Ebooks";
        return view('fe.help', (array)$results['data']->data);
    }


    public function ask() {

        $results=Helper::load_home_data();
     //   $content=Helper::GetDefaultApi("/api/content/education.ebooks");
        $results['data']->data->newcontent="";
        $results['data']->data->menu = "Ask";
        return view('fe.help', (array)$results['data']->data);
    }

    public function ask_raw() {

        $results=Helper::load_home_data();
        return view('fe.raw');
    }
    

}