<?php 


namespace App\Helper;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;

class Helper
{

    public static function GetApi($url)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $response = $request->getBody();
        return $response;
    }


    public static function PostApi($url,$body) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $url, ['form_params'=>$body]);
        $response = $client->send($response);
        return $response;
    }

    public static function PostLoginApi($url,$body) {
        $client = new \GuzzleHttp\Client(['cookies'=>true]);
        $response = $client->request("POST", $url, ['form_params'=>$body]);
        //$response = $client->send($response);
        $cookieJar = $client->getConfig('cookies');
        return ['cookies'=>$cookieJar->toArray(),
                'response'=>$response];
    }


    public static function GetOwnApi($url,$token,$session,$remname,$remval,$domain)
    {
        $cookieJar = CookieJar::fromArray([
            'XSRF-TOKEN'=>$token,
            'laravel_session'=>$session,
            $remname => $remval,
        ],$domain);

        $client = new \GuzzleHttp\Client([
            'cookies'=>$cookieJar
        ]);
        try {
            $request = $client->request("GET", $url);//['cookies'=>$cookieJar]);
            $request = $client->get($url);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return [ 
                    'response' => [
                        'success' => 'false',
                    ],
                ];
        }
        $response['data']=json_decode($request->getBody());
        $response['response']=[
                'success' =>($response['data'] ? 'true' : 'false'),
                'code' => $request->getStatusCode(),
                'message'=>$request->getReasonPhrase(),
        ];
        return $response;
    }

    public static function ActOwnApi($url,$token,$session,$remname,$remval,$domain,$method = "POST",$body=[])
    {
        $cookieJar = CookieJar::fromArray([
            'XSRF-TOKEN'=>$token,
            'laravel_session'=>$session,
            $remname => $remval,
        ],$domain);

        $client = new \GuzzleHttp\Client([
            'cookies'=>$cookieJar
        ]);
        if ($method == "GET") {
            $request = $client->request($method, $url, ['query'=>$body]);
        }
        else {
            $request = $client->request($method, $url, ['form_params'=>$body]);
        }
        //$request = $client->send($url);
        $response['data']=json_decode($request->getBody());
        $response['response']=[
                'success' =>($response['data'] ? 'true' : 'false'),
                'code' => $request->getStatusCode(),
                'message'=>$request->getReasonPhrase(),
        ];
        return $response;
    }

    public static function ActDefaultApi($inurl,$method="POST",$body=[],$dataonly=false)
    {
        if (!Helper::VerifyAccessDefaultApi()) {
            return response()->json([
                'response' => [
                    'success' => 'false',
                ],
            ]);
        }
        $domain=env('APIROOTDOMAIN');
        $url=env('APIROOTENDPOINT').$inurl;
        $request = request();
        $token=$request->cookie('api_xsrf_token');
        $session=$request->cookie('api_laravel_session');
        $remname=$request->cookie('api_remname');
        $remval=$request->cookie('api_remval');
        if ($dataonly) {
            $rv=Helper::ActOwnApi($url,$token,$session,$remname,$remval,$domain,$method,$body);
            return $rv['data'] ?? $rv;
        }
        return Helper::ActOwnApi($url,$token,$session,$remname,$remval,$domain,$method,$body);
    }

    public static function RepeatDefaultApi(Request $request, $inurl,$method="POST") 
    {
        $outdata=$request->all();
        return Helper::ActDefaultApi($inurl,$method,$outdata,true);
    }

    public static function GetDefaultApi($inurl,$dataonly=false)
    {
        if (!Helper::VerifyAccessDefaultApi()) {
            return response()->json([
                'response' => [
                    'success' => 'false',
                ],
            ]);
        }
        $domain=env('APIROOTDOMAIN');
        $url=env('APIROOTENDPOINT').$inurl;
        $request = request();
        $token=$request->cookie('api_xsrf_token');
        $session=$request->cookie('api_laravel_session');
        $remname=$request->cookie('api_remname');
        $remval=$request->cookie('api_remval');
        if ($dataonly) {
            $rv=Helper::GetOwnApi($url,$token,$session,$remname,$remval,$domain);
            return $rv['data'] ?? $rv;
        }
        return Helper::GetOwnApi($url,$token,$session,$remname,$remval,$domain);
    }


    public static function VerifyAccessDefaultApi() {
        $request = request();
        if (!($request->cookie('api_laravel_session') &&  $request->cookie('api_xsrf_token'))) {
            return false;
        }
        $token=$request->cookie('api_xsrf_token');
        $session=$request->cookie('api_laravel_session');
        $remname=$request->cookie('api_remname');
        $remval=$request->cookie('api_remval');

        $results=Helper::GetOwnApi(env('APIROOTENDPOINT')."/api/login_status",$token,$session,$remname,$remval,env('APIROOTDOMAIN'));
        if (!($results['data']->response->success ?? false)) {
            return false;
        }
        return true;
    }

    public static function load_home_data() {
        if (session()->has('home_data') 
            and session()->has('last_home_data_load') 
            and (session('last_home_data_load') - microtime(true) < env('CACHE_MAX_TIME',600))
        ) {
            $results=session('home_data');
        } else {
            if (Helper::VerifyAccessDefaultApi()) {
                $results=Helper::GetDefaultApi("/api/home_data");
                session([
                    'home_data' => $results,
                    'last_home_data_load' => microtime(true),
                ]);
            }
        }
        return $results ?? [];
    }

}

?>
