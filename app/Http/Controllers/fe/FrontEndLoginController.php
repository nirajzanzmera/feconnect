<?php

namespace App\Http\Controllers\fe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

use App\Helper\Helper;


class FrontEndLoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('guest')->except('logout');

    }
    public function logout_wapi(Request $request) {
        session()->forget('home_data');
        session()->forget('last_verified_load_time');
        session()->forget('last_verified_access_status');

        return redirect(route('login'))
            ->withCookie(cookie('api_xsrf_token',null,0))
            ->withCookie(cookie('api_laravel_session',null,0))
            ->withCookie(cookie('api_remname',null,0))
            ->withCookie(cookie('api_remval',null,0))
            ->withMessage('Logout complete.')
            ;
    }
    public function show_login_wapi(Request $request) 
    {
        if(!session()->has('url.intended') || url()->previous() != route('login'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('fe.auth.login_wapi');
    }
    public function waypoint(Request $request) {
        return view('fe.auth.login_waypoint',[
            'rediruser' => $request->input('email'),
            'redirpass' => $request->input('password')
        ]);
    }
    public function login_wapi(Request $request) 
    {
        //dd($request->request);
        $email=$request->input('email');
        $password=$request->input('password');
        try {
            $results=Helper::PostLoginApi(env('APIROOTENDPOINT',"https://connect.dataczar.com/")."api/login",['email'=>$email,'password'=>$password,'remember'=>true]);
            // THIS WORKS:
            $token="";
            $session="";
            foreach ($results['cookies'] as $thiscookie) {
                if ($thiscookie['Name'] == 'XSRF-TOKEN') {
                    $token=$thiscookie['Value'];
                }
                if ($thiscookie['Name'] == 'laravel_session') {
                    $session=$thiscookie['Value'];
                    $sesmaxage=$thiscookie['Max-Age'];
                }
                if (strpos($thiscookie['Name'],"remember_web_")===0) {
                    $remname=$thiscookie['Name'];
                    $remval=$thiscookie['Value'];
                    $remmaxage=$thiscookie['Max-Age'];
                }
            }

            return redirect()->intended('/')
            ->with('email',$email)
            ->with('password',$password)
            ->withCookie(
                'api_laravel_session',
                $session,
                $sesmaxage, //864000, // 10 days
                null,
                null,
                false,
                false // HttpOnly
            )
            ->withCookie(
                'api_remname',
                $remname,
                $remmaxage, 
                null,
                null,
                false,
                false // HttpOnly
            )
            ->withCookie(
                'api_remval',
                $remval,
                $remmaxage, //2592000, // 30 days
                null,
                null,
                false,
                false // HttpOnly
            )
            ->withCookie(
                'api_xsrf_token',
                $token,
                $sesmaxage, //864000, // 10 days
                null,
                null,
                false,
                false // HttpOnly
            );
        }
        catch (\Exception $e) {
            return redirect(route('login'))->withMessage("Login failed.");//$e->getMessage());
        }
    }

    public function sso_custom(Request $request)
    {
        $request->merge(['sso'=>'http://localhost:91/ssor']);
        return $this->sso_out($request);
    }

    public function sso_out (Request $request) 
    {
       //dd($request);
        $incookies=Cookie::get();
        $session='';
        $remname='';
        $remval='';
        $token='';
        $redir=$request->input('r') ?? $request->input('redir') ?? '';
        $sso=$request->input('sso') ?? '';
        foreach ($incookies as $cookiekey=>$cookieval) {
            // if not api-driven:
            //    'XSRF-TOKEN' => $token
            //laravel_session => $session
            //remember_web_ => $remname => $remval
            if ($cookiekey == 'api_laravel_session') {
                $session=$cookieval;
            }
            if ($cookiekey == 'api_remname') {
                $remname=$cookieval;
            }
            if ($cookiekey == 'api_remval') {
                $remval = $cookieval;
            }
            if ($cookiekey == 'api_xsrf_token') {
                $token=$cookieval;
            }
        }
        return redirect(
            url($sso) . '?' . http_build_query([
                'api_laravel_session' => $session,
                'api_remname' => $remname,
                'api_remval' => $remval,
                'api_xsrf_token' => $token,
                'r' => $redir
            ])
        );

    }

}