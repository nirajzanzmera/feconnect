<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GuzzleHttp\Cookie\CookieJar;

use Tests\TestCase;

class AccountApiTest extends TestCase
{
    private $http, $client;
    private $website_id = 152;
    private $account_id = 675;
    private $notification_id = 1;
    private $template_id = 590;
    private $post_id = 48916;
    private $page_id = 158;
    private $sender_id = 1374;
    private $email_id = 7117;
    private $domain_id = 9;
    private $newsletter_id = 683;

    public function setUp(): void
    {
        // Defined properties

        $this->base_uri = 'https://connect.dataczar.com/';
        $this->domain = 'connect.dataczar.com';
        $this->http = new \GuzzleHttp\Client(['base_uri' => $this->base_uri, 'cookies'=>true]);

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

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->base_uri,
            'cookies'=>$cookieJar
        ]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
    
    public function test_home_api()
    {

        $url = $this->base_uri.'api/home_data';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        // dd(json_decode($response->getBody()));
        $this->assertIsObject($response->getBody());

        echo "\n Home Data Test completed";

    }

    public function test_account_api()
    {
        $url = $this->base_uri.'accounts/api/get_list';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Account List Test completed";
    }

    public function test_education_api()
    {
        $url = 'api/content/education';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Education Test completed";

        $url = 'api/content/education.getting_started';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Education Getting_started Test completed";

        $url = 'api/content/education.videos';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Education Videos Test completed";

        $url = 'api/content/education.content_tools';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Education Content Tools Test completed";

        $url = 'api/content/education.coaching';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Education Coaching Test completed";
    }

    public function test_content_ebook_api()
    {
        $url = 'api/content/ebooks';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Ebook Test completed";
    }

    public function test_content_list_api()
    {
        $url = 'content/list';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Content List Test completed";

        $url = '/content/list?show_files=true';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Content List Show File Test completed";
    }

    public function test_account_switch_api()
    {
        $url = 'accounts/api/switch/'.$this->account_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Switch account Test completed";
    }

    public function test_website_data_api()
    {

        $url = 'websites/'. $this->website_id . '/data/';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Data Test completed";
    }

    public function test_website_list_api()
    {
        $url = 'api/websites';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website List Test completed";

        $url = 'websites/device_chart';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Device Chart Test completed";

        $url = 'websites/referer_chart';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Referer Chart Test completed";

        $url = 'websites/user_chart';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website User Chart Test completed";

        $url = 'websites/session_chart';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Session Chart Test completed";
    }

    public function test_website_post_api()
    {

        $url = '/api/websites/'.$this->website_id .'/posts';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Post Test completed";

        $url = '/api/websites/'.$this->website_id .'/posts/'.$this->post_id.'/get';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Post by ID Test completed";

        $url = '/api/websites/'.$this->website_id .'/posts/draft';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Post Draft Test completed";
    }

    public function test_website_pages_api()
    {
        $url = '/api/websites/'.$this->website_id .'/pages';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Page Test completed";

        $url = '/api/websites/'.$this->website_id .'/pages/draft';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Page Draft Test completed";

        $url = '/api/websites/'.$this->website_id .'/pages/'.$this->page_id.'/get';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Website Page By ID Test completed";
    }

    public function test_feed_api()
    {

        $url = '/api/feeds';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);
        // dd(json_decode($response->getBody()));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Feed Test completed";

        $feeds = json_decode($response->getBody());

        $index = 1;
        foreach ($feeds as $key => $feed) {
            if ($index > 1) break;
            $feed_id = $feed->id;
            $index++;
        }

        $feedJsonUrl = '/api/feeds/'. $feed_id .'/json';
        $feedJsonResponse = $this->client->request("GET", $feedJsonUrl);
        $feedJsonResponse = $this->client->get($url);

        $this->assertEquals(200, $feedJsonResponse->getStatusCode());
        $this->assertIsObject($feedJsonResponse->getBody());
        echo "\n Feed Json Test completed";


        $feedJsonUrl = '/api/feeds/'. $feed_id .'/get';
        $feedJsonResponse = $this->client->request("GET", $feedJsonUrl);
        $feedJsonResponse = $this->client->get($url);

        $this->assertEquals(200, $feedJsonResponse->getStatusCode());
        $this->assertIsObject($feedJsonResponse->getBody());
        echo "\n Feed get by ID Test completed";

    }

    /* NOTIFICATION LIST */

    public function test_notification_api(){
        $url = 'notifications/data';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Notification Test completed";
    }

    public function test_notification_read_api()
    {
        $url = '/notification/'.$this->notification_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Notification Read Test completed";
    }

    /* LOGIN STATUS */
    public function test_login_status_api(){
        $url = 'api/login_status';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Login status completed";
    }

    public function test_logout_api()
    {

        $url = '/api/logout';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Logout Test completed";
    }

    /* ACCOUNT LIST */

    public function test_account_list_api()
    {

        $url = '/accounts/api/get_list';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Account list api Test completed";
    }

    /* TEMPLATE LIST */
    public function test_template_list_api()
    {

        $url = '/api/templates/'.$this->template_id.'/active';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Template list api Test completed";
    }

    /* NOTIFICATION MARK ALL */

    public function test_notification_markall_api()
    {

        $url = 'notifications/mark-all';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Notification mark all api Test completed";
    }

    /* NOTIFICATIONS: Get all */
    public function test_notification_getall_api()
    {

        $url = '/api/notifications/all';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Notification get all api Test completed";
    }

    /* PROFILE*/

    public function test_profile_list_api()
    {
        $url = 'api/profile';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());

        echo "\n Profile Test completed";

    }

    /* LISTS */

    public function test_list_api()
    {
        $url = 'api/lists';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n List api Test completed";


        $url = 'lists/count';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n List Count Test completed";
    }


    public function test_email_api()
    {
        $url = 'api/emails';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email api Test completed";


        $url = 'api/emails/templates';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Template api Test completed";

        $url = 'api/emails/analytics';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Analytics api Test completed";

        $url = 'emails/senders/list';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Sender List api Test completed";

        $url = 'emails/senders/sendConf/'.$this->sender_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Sender Send Config api Test completed";

        $url = 'emails/senders/json/'.$this->sender_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Sender Json api Test completed";

        $url = 'emails/senders/json/'.$this->sender_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Sender Json api Test completed";

        $url = 'api/emails/draft';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Draft api Test completed";


        $url = 'api/emails/'.$this->email_id.'/get';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Campaign Get By ID api Test completed";

        $url = '/api/emails/email/'.$this->email_id;
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Email Marketing Campaign Get By ID api Test completed";
    }


    /* DOMAIN API */
    public function test_domain_api()
    {
        $url = 'api/domains';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Domain api Test completed";


        $url = '/domains/'.$this->domain_id.'/hosting/data';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Domain Hosting Data api Test completed";

        $url = '/domains/'.$this->domain_id.'/emails/data';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Domain Email Data api Test completed";
    }

    /* PLAN API */
    public function test_plan_api()
    {
        $url = 'api/plans/card';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Plan Card api Test completed";

    }

    /* ACCOUNT REFERRAL */
    public function test_account_referral_api()
    {
        $url = '/api/accounts/referrals';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Account Referral api Test completed";

    }

    /* USER STATISTICS */

    public function test_user_statistics_api()
    {
        $url = '/user/statistics';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n User Statistics api Test completed";

    }

    /* NEWSLETTERS */

    public function test_newsletters_api()
    {
        $url = '/api/newsletters';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Newsletter api Test completed";


        $url = '/api/newsletters/draft';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Newsletter Draft api Test completed";


        $url = '/api/newsletters/'.$this->newsletter_id.'/get';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Newsletter Get By ID api Test completed";

        $url = '/api/newsletters/'.$this->newsletter_id.'/preview';
        $response = $this->client->request("GET", $url);
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($response->getBody());
        echo "\n Newsletter Preview Get By ID api Test completed";

//        $url = '/api/newsletters/'.$this->newsletter_id.'/duplicate';
//        $response = $this->client->request("GET", $url);
//        $response = $this->client->get($url);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertIsObject($response->getBody());
//        echo "\n Newsletter Duplicate api Test completed";

    }

}
