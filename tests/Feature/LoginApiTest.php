<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GuzzleHttp\Cookie\CookieJar;

use Tests\TestCase;

class LoginApiTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->base_uri = 'https://connect.dataczar.com/';
        $this->domain = 'connect.dataczar.com';
        $this->http = new \GuzzleHttp\Client(['base_uri' => $this->base_uri, 'cookies'=>true]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
    public function test_login_api()
    {
        
        $payload = ['email' => 'jotweb.testing@gmail.com', 'password' => 'jotweb2021'];
        $response = $this->http->request('POST', 'api/login', ['form_params'=>$payload]);

        $this->assertEquals(200, $response->getStatusCode());
        echo "\n Login Test completed";
            
    }
    
    public function test_login_status_api()
    {
        $payload = ['email' => 'jotweb.testing@gmail.com', 'password' => 'jotweb2021'];
        $login = $this->http->request('POST', 'api/login', ['form_params'=>$payload]);

        $this->assertEquals(200, $login->getStatusCode());
        $cookies = $this->http->getConfig('cookies')->toArray();

        foreach ($cookies as $cookie) {
            if ($cookie['Name'] == 'XSRF-TOKEN') {
                $token=$cookie['Value'];
            }
            if ($cookie['Name'] == 'laravel_session') {
                $session=$cookie['Value'];
            }
        }

        $cookieJar = CookieJar::fromArray([
            'XSRF-TOKEN'=>$token,
            'laravel_session'=>$session
        ],$this->domain);

        $client = new \GuzzleHttp\Client([
            'cookies'=>$cookieJar
        ]);
        $url = $this->base_uri.'api/login_status';
        $response = $client->request("GET", $url);
        $response = $client->get($url);

        $message = json_decode($response->getBody())->{"response"}->{"message"};
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Logged In", $message);
        
        echo "\n Login Status Test completed";
    }
       
}
