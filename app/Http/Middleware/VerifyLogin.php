<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\Helper;
use Illuminate\Http\Request;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request = request();

        if (!$this->quick_screen_access() and !Helper::VerifyAccessDefaultApi()) {
            return redirect(route('login'));
        }
        else {
            session([
                'last_verified_load_time' => microtime(true),
                'last_verified_access_status' => true,
                ]);
            if (session()->has('home_data')) {
                $results=session('home_data');
            } else {
                $results=Helper::GetDefaultApi("/api/home_data");
                session(['home_data' => $results]);
            }    
        }

        return $next($request);
    }

    public function quick_screen_access() {
        if (session('last_verified_access_status') and 
            microtime(true) - session('last_verified_load_time') < env('SESSIONTIMEOUT',600 )) {
                return true;
        }
    }
}
