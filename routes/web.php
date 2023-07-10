<?php

use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/api/home_data',function () {return Helper::GetDefaultApi("/api/home_data");});
Route::get('/api/logout',function () {return Helper::GetDefaultApi("/api/logout");});

Route::get('post_test','App\Http\Controllers\fe\FrontEndHomeController@post_test');
Route::get('demo_notify','App\Http\Controllers\fe\MailableDemoController@demo_notify');

Route::get('/notifications/data', function () {return Helper::GetDefaultApi("/notifications/data");})->name('notifications.data'); // list notifications
//Route::get('/notification/{id}',function ($id) {return Helper::GetDefaultApi("/notification/$id");}); // mark read
Route::get('/notification/archive/{id}',function ($id) {return Helper::GetDefaultApi("/notification/archive/$id");}); // archive
Route::get('notifications/mark-all',function () {return Helper::GetDefaultApi("/notification/mark-all");})->name('notifications.markAll'); // mark all read
Route::get('/api/notifications/all',function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/notifications/all',"GET");})->name('api.notifications.all');
Route::get('/notifications/inbox','App\Http\Controllers\fe\FrontEndWebsitesController@inbox')->name('notifications.inbox');
Route::get('/api/login_status',function () {return Helper::GetDefaultApi('/api/login_status/');})->name('api.login_status');
Route::get('/accounts/api/get_list',function () {return Helper::GetDefaultApi('/accounts/api/get_list/');});
Route::get('/api/websites/{id}/posts',function ($id) {return Helper::GetDefaultApi("/api/websites/$id/posts");});
Route::get('/accounts/api/switch/{id}',function ($id) {return Helper::GetDefaultApi("/accounts/api/switch/$id");});
Route::get('/api/templates/{type}/{status}',function ($type,$status) {return Helper::GetDefaultApi("/api/templates/$type/$status");});
Route::get('/accounts', 'App\Http\Controllers\fe\FrontEndUserController@account')->name('teams.index');
Route::get('/feed_rss', 'App\Http\Controllers\fe\FrontEndHomeController@feed_rss')->name('feed.rss');
Route::get('/api/blog/data',function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/blog/data',"GET");});
Route::get('/api/blogs','App\Http\Controllers\fe\FrontEndHomeController@get_blogs')->name('blog.data');
Route::get('/blog/{id?}/{title?}','App\Http\Controllers\fe\FrontEndHomeController@show_blog')->name('blog.show');
Route::get('/websites/{website}/edit','App\Http\Controllers\fe\FrontEndWebsitesController@website_edit')->name('websites.edit');
// Feeds
Route::get('/get_feeds', 'App\Http\Controllers\fe\FrontEndHomeController@get_feeds')->name('get_feeds'); // ajax call
Route::get('/get_recent_post/{wid}', 'App\Http\Controllers\fe\FrontEndHomeController@get_recent_post')->name('get_recent_post'); // ajax call
Route::get('/content/feeds', 'App\Http\Controllers\fe\FrontEndContentController@content_feeds')->name('content.feeds.index');
Route::post('/content/feeds', 'App\Http\Controllers\fe\FrontEndContentController@content_feeds_create')->name('content.feeds.create');

Route::get('/automation/feeds/{id}', 'App\Http\Controllers\fe\FrontEndHomeController@content_feeds_show')->name('content.feeds.show');
Route::get('/automation/feeds/{id}/edit', 'App\Http\Controllers\fe\FrontEndHomeController@content_feeds_show')->name('content.feeds.edit');

/*
Pending helper function and use specification:
POST  /api/feeds/create
POST  /api/feeds/{feed}/update
POST /api/websites/{website}/posts/create
POST /api/websites/{website}/posts/{post}/update

*/
Route::get('/api/feeds',function () {return Helper::GetDefaultApi("/api/feeds");}); // list feeds
Route::get('/api/feeds/{id}/json',function ($id) {return Helper::GetDefaultApi("/api/feeds/$id/json");}); // show a feed
Route::get('/api/websites/{id}/posts/{post}/get',function ($id,$post) {return Helper::GetDefaultApi("/api/websites/$id/posts/$post/get");})->name('api.website.post');
Route::get('/api/websites/{id}/pages/{page}/get',function ($id,$page) {return Helper::GetDefaultApi("/api/websites/$id/pages/$page/get");})->name('api.website.page');

//Route::get('/content/list', function() {return Helper::GetDefaultApi('/content/list',true);})->name('content.images.list');
Route::get('/content/list', function(Request $request) {return Helper::RepeatDefaultApi($request,'/content/list',"GET");})->name('content.images.list');
//Route::get('/content/listfiles', function(Request $request) {return Helper::RepeatDefaultApi($request,'/content/list',"GET");});
Route::post('/api/contact', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/contact',"POST");})->name('api.contact');
Route::get('/api/contact', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/contact',"POST");})->name('api.contact');

/**
 * GET /api/content/{key}
 *          education.index
 *          education.getting_started
 *          education.videos
 *          education.content_tools
 *          education.coaching
 *          education.ebooks
 */
Route::get('/api/content/{id}',function ($id) {return Helper::GetDefaultApi("/api/content/$id");});


Route::get('accounts/switch/{id}', 'App\Http\Controllers\fe\FrontEndUserController@switch_accounts')->name('teams.switch'); // switch account

Route::get('/rr',           'App\Http\Controllers\fe\RemoteRedirectController@redirect');
Route::get('/logout_wapi',  'App\Http\Controllers\fe\FrontEndLoginController@logout_wapi')->name('logout_wapi');
Route::get('/logout', 'App\Http\Controllers\fe\FrontEndLoginController@logout_wapi')->name('logout');
Route::post('/logout', 'App\Http\Controllers\fe\FrontEndLoginController@logout_wapi')->name('logout');

Route::get('/sso_out','App\Http\Controllers\fe\FrontEndLoginController@sso_out');
Route::get('/sso_custom','App\Http\Controllers\fe\FrontEndLoginController@sso_custom');
Route::get('/login_waypoint','App\Http\Controllers\fe\FrontEndLoginController@waypoint')->name('login_waypoint');
Route::get('/login_wapi', 'App\Http\Controllers\fe\FrontEndLoginController@show_login_wapi')->name('login_wapi');
Route::post('/login_wapi', 'App\Http\Controllers\fe\FrontEndLoginController@login_wapi')->name('login_wapi');
Route::get('/home_wapi', 'App\Http\Controllers\fe\FrontEndHomeController@home_wapi')->name('home_wapi');
Route::get('/', 'App\Http\Controllers\fe\FrontEndHomeController@home_wapi')->name('home');
Route::get('/alt', 'App\Http\Controllers\fe\FrontEndHomeController@home_alt');
Route::get('/user', 'App\Http\Controllers\fe\FrontEndUserController@user_dashboard')->name('user.dashboard');
Route::get('/user/profile', 'App\Http\Controllers\fe\FrontEndUserController@user_profile')->name('user.profile');
Route::get('/user/journal', 'App\Http\Controllers\fe\FrontEndUserController@user_journal')->name('user.journal');
Route::get('/user/badge/{id}', 'App\Http\Controllers\fe\FrontEndUserController@user_badge')->name('user.badge');
Route::get('/statistics', 'App\Http\Controllers\fe\FrontEndUserController@statistics')->name('user.statistics.static');
Route::get('/user/statistics', function(Request $request) {return Helper::RepeatDefaultApi($request,'/user/statistics',"GET");})->name('user.statistics');

Route::get('education','App\Http\Controllers\fe\FrontEndEducationController@help')->name('education.index');
Route::get('education/getting-started','App\Http\Controllers\fe\FrontEndEducationController@getting_started')->name('education.getting_started');
Route::get('education/videos','App\Http\Controllers\fe\FrontEndEducationController@videos')->name('education.videos');
Route::get('education/coaching','App\Http\Controllers\fe\FrontEndEducationController@coaching')->name('education.coaching');
Route::get('education/ebooks','App\Http\Controllers\fe\FrontEndEducationController@ebooks')->name('education.ebooks');
Route::get('education/ask','App\Http\Controllers\fe\FrontEndEducationController@ask')->name('education.ask');
Route::get('education/ask/raw','App\Http\Controllers\fe\FrontEndEducationController@ask_raw')->name('education.ask.raw');
Route::get('content/content_tools', 'App\Http\Controllers\fe\FrontEndContentController@content_tools')->name('content.tools');

Route::get('register/{referral?}', function($r = "") {return redirect(env('APIROOTENDPOINT').'register/'.$r);})->name('register');
Route::get('/login', 'App\Http\Controllers\fe\FrontEndLoginController@show_login_wapi')->name('login');
Route::post('/login', 'App\Http\Controllers\fe\FrontEndLoginController@login_wapi')->name('login');
// TODO: Placeholder Route Stubs:
Route::delete('image/{filename?}', function() { return response()->json(['status' => 'error'] );})->name('content.images.delete'); // TODO
//Route::post('/pexels/search', function() { return response()->json(['status' => 'error'] );})->name('content.images.search'); // TODO
//Route::post('/images/down_up', function() { return response()->json(['status' => 'error'] );})->name('content.downUp');
//Route::get('upload/signed', function() { return response()->json(['status' => 'error'] );}); 
Route::post('/images/down_up', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/images/down_up',"POST");})->name('content.downUp'); 
Route::get('upload/signed', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/upload/signed',"GET");}); 
Route::get('images/event', function(Request $request) {return Helper::RepeatDefaultApi($request,'/images/event',"GET");})->name('images.event');
#Route::post('/pexels/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/pexels/search',"POST");})->name('content.images.search'); // TODO
Route::post('/flaticon/search', 'App\Http\Controllers\fe\FrontEndImageController@searchFlaticon')->name('content.flaticon.search');
Route::get('/flaticon/search', 'App\Http\Controllers\fe\FrontEndImageController@searchFlaticon')->name('content.flaticon.search');
Route::post('/api/flaticon/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/flaticon/search',"POST");})->name('api.flaticon.search'); // TODO
Route::get('/api/flaticon/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/flaticon/search',"POST");})->name('api.flaticon.search'); // TODO
Route::get('/api/pixabay/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/pixabay/search',"POST");})->name('api.pixabay.search'); // TODO
Route::post('/api/pixabay/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/pixabay/search',"POST");})->name('api.pixabay.search'); // TODO
Route::get('/pexels/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPexels');
Route::post('/pexels/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPexels')->name('content.pexels.search');
Route::get('/pixabay/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPixabay');
Route::post('/pixabay/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPixabay')->name('content.pixabay.search');

//Route::get('/images/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/pixabay/search',"POST");})->name('content.images.search'); 
//Route::post('/images/search', function(Request $request) {return Helper::RepeatDefaultApi($request,'/api/pixabay/search',"POST");})->name('content.images.search'); 
Route::get('/images/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPixabay')->name('content.images.search'); 
Route::post('/images/search', 'App\Http\Controllers\fe\FrontEndImageController@searchPixabay')->name('content.images.search'); 


Route::get('/_home', function(){
    if (Cookie::get('nobclink') == 'true') {
        return redirect()->back();
    }
    else {
        return redirect(route('home'));
    }   
})->name('homebc');

/*
Route::get('/profile/preference/{value}', function ($value) {
    switch ($value) {
        case 'light':
            $account = auth()->user()->currentTeam;
            $settings = $account->settings;
            $settings->preference = 'light';
            $account->settings = $settings;
            $account->save();
            break;
        case 'dark':
            $account = auth()->user()->currentTeam;
            $settings = $account->settings;
            $settings->preference = 'dark';
            $account->settings = $settings;
            $account->save();
            break;
        default:
            # code...
            break;
    }

    return back();
})->name('profile.preference');
*/

Route::get('/profile/preference/{value}', 'App\Http\Controllers\fe\FrontEndUserController@profilePreference')->name('profile.preference');


Route::get('legal', 'App\Http\Controllers\fe\FrontEndHomeController@legal')->name('legal');

//Route::get('/', function() {return redirect(env('APIROOTENDPOINT').'/');})->name('home');
//Route::get('legal', function() {return redirect(env('APIROOTENDPOINT').'legal');})->name('legal');
Route::get('password/reset', function() {return redirect(env('APIROOTENDPOINT').'password/reset');})->name('password.request');
Route::get('share/confirm', function() {return redirect(env('APIROOTENDPOINT').'share/confirm');})->name('campaigns.invite.confirm');

// Route::get('/websites/{id}/pages',function($id) {return redirect(env('APIROOTENDPOINT')."websites/$id/pages");})->name('websites.pages.index');
// Route::get('/websites/{id}/posts',function($id) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts");})->name('websites.posts.index');
// Route::get('/websites/{id}/posts/{post}/edit',function($id,$post) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts/$post/edit");})->name('websites.posts.edit');

//Route::get('profile', function() {return redirect(env('APIROOTENDPOINT').'profile');})->name('profile');
Route::get('/profile/{filter?}', 'App\Http\Controllers\fe\FrontEndUserController@profile')->name('profile');
Route::put('/profile/password', 'App\Http\Controllers\fe\FrontEndUserController@updatePassword')->name('user.pass.update');
Route::post('/profile/notifications','App\Http\Controllers\fe\FrontEndUserController@profileNotifications')->name('user.notifications');

Route::get('phone/confirmation/check', function() {return redirect(env('APIROOTENDPOINT').'phone/confirmation/check');})->name('auth.phone_confirmation.check');
Route::get('cc/confirmation/check', function() {return redirect(env('APIROOTENDPOINT').'cc/confirmation/check');})->name('auth.cc_confirmation');
Route::get('email/confirmation', function() {return redirect(env('APIROOTENDPOINT').'email/confirmation');})->name('auth.email_confirmation');
Route::get('phone/confirmation', function() {return redirect(env('APIROOTENDPOINT').'phone/confirmation');})->name('auth.phone_confirmation');
Route::get('plan/confirm', function() {return redirect(env('APIROOTENDPOINT').'plan/confirm');})->name('auth.plan_confirm');
Route::get('auth/activate', function() {return redirect(env('APIROOTENDPOINT').'auth/activate');})->name('auth.activate');
Route::get('auth/activate/resend', function() {return redirect(env('APIROOTENDPOINT').'auth/activate/resend');})->name('auth.activate.resend');
Route::get('accounts/members', function() {return redirect(env('APIROOTENDPOINT').'accounts/members');})->name('teams.members.index');
//Route::get('notifications/data', function() {return redirect(env('APIROOTENDPOINT').'notifications/data');})->name('notifications.data');
//Route::get('content/feeds', function() {return redirect(env('APIROOTENDPOINT').'content/feeds');})->name('content.feeds.index');
Route::get('/admin/accounts/{id}', function($id) {return redirect(env('APIROOTENDPOINT')."/admin/accounts/$id");})->name('admin.account.manage');
Route::get('/accept/{token}', function($token) {return redirect(env('APIROOTENDPOINT')."/accept/$token");})->name('teams.accept_invite');


Route::get('accounts/key','App\Http\Controllers\fe\FrontEndKeyController@index')->name('key.list');
Route::post('accounts/key','App\Http\Controllers\fe\FrontEndKeyController@store')->name('key.store');
Route::get('accounts/key/delete/{id}','App\Http\Controllers\fe\FrontEndKeyController@destroy')->name('key.delete');
Route::get('accounts/key/edit/{id}','App\Http\Controllers\fe\FrontEndKeyController@edit')->name('key.edit');
Route::post('accounts/key/update/{id}','App\Http\Controllers\fe\FrontEndKeyController@update')->name('key.update');

//Route::get('notifications', function() {return redirect(env('APIROOTENDPOINT').'notifications');})->name('notifications.index');
//Route::get('notifications/mark-all', function() {return redirect(env('APIROOTENDPOINT').'notifications/mark-all');})->name('notifications.markAll');
//Route::get('education/coaching', function() {return redirect(env('APIROOTENDPOINT').'education/coaching');})->name('education.coaching');
//Route::get('education/content-tools', function() {return redirect(env('APIROOTENDPOINT').'education/content-tools');})->name('content.tools');
//
//Route::get('education/ebooks', function() {return redirect(env('APIROOTENDPOINT').'education/ebooks');})->name('education.ebooks');
//Route::get('education/getting-started', function() {return redirect(env('APIROOTENDPOINT').'education/getting-started');})->name('education.getting_started');
//Route::get('education', function() {return redirect(env('APIROOTENDPOINT').'education');})->name('education.index');
Route::get('content/logo_request', function() {return redirect(env('APIROOTENDPOINT').'content/logo_request');})->name('content.logo_request');

//Route::get('content', function() {return redirect(env('APIROOTENDPOINT').'content');})->name('content.index');
//Route::get('content/feeds', function() {return redirect(env('APIROOTENDPOINT').'content/feeds');})->name('content.feeds.index');

Route::get('accounts/referrals', function() {return redirect(env('APIROOTENDPOINT').'accounts/referrals');})->name('accounts.referrals');

//Route::get('education/videos', function() {return redirect(env('APIROOTENDPOINT').'education/videos');})->name('education.videos');
Route::get('templates/website', function() {return redirect(env('APIROOTENDPOINT').'templates/website');})->name('templates.website');

// Route::get('content/images', function() {return redirect(env('APIROOTENDPOINT').'content/images');})->name('content.images');
Route::get('content/images', 'App\Http\Controllers\fe\FrontEndContentController@content_images')->name('content.images');
Route::get('content/files', 'App\Http\Controllers\fe\FrontEndContentController@content_files')->name('content.files');
Route::get('content/search', 'App\Http\Controllers\fe\FrontEndContentController@content_search')->name('content.search');
Route::get('content/icons', 'App\Http\Controllers\fe\FrontEndContentController@content_icons')->name('content.icons');
Route::get('content', 'App\Http\Controllers\fe\FrontEndContentController@content_upload')->name('content.index');

Route::post('save/user/avatar', 'App\Http\Controllers\fe\FrontEndHomeController@save_user_avatar')->name('save.user_image');

Route::get('notifications', 'App\Http\Controllers\fe\FrontEndWebsitesController@notifications')->name('notifications.index');
Route::get('/notification/{id}','App\Http\Controllers\fe\FrontEndWebsitesController@notifications_get')->name('notification.get'); // mark read
// Route::get('websites/dashboard', 'App\Http\Controllers\fe\FrontEndWebsitesController@index')->name('websites.dashboard');
Route::get('websites', 'App\Http\Controllers\fe\FrontEndWebsitesController@index')->name('websites.dashboard');
Route::get('websites/{website}/edit', 'App\Http\Controllers\fe\FrontEndWebsitesController@edit_websites')->name('websites.edit');
Route::put('/websites/{website}/update', 'App\Http\Controllers\fe\FrontEndWebsitesController@website_update')->name('websites.update');
Route::get('/websites/{website}/theme', 'App\Http\Controllers\fe\FrontEndWebsitesController@website_theme')->name('websites.theme');
Route::post('/websites/{website}/theme', 'App\Http\Controllers\fe\FrontEndWebsitesController@website_theme')->name('websites.theme');
Route::get('/websites/{website}/templates', 'App\Http\Controllers\fe\FrontEndWebsitesController@website_templates')->name('websites.templates.index');
Route::post('/websites/{website}/menu/detach', function (Request $request,$id) {return Helper::RepeatDefaultApi($request,"/api/websites/$id/menu/detach","POST");})->name('websites.menus.detach');
Route::get('/websites/{website}/data',function (Request $request, $website) {return Helper::RepeatDefaultApi($request,"/websites/$website/data","GET");})->name('websites.data');
Route::get('/api/websites/{website}/data',function (Request $request, $website) {return Helper::RepeatDefaultApi($request,"/websites/$website/data","GET");})->name('api.websites.data');

Route::post('/websites/{id}/preview', function (Request $request,$id) {return Helper::RepeatDefaultApi($request,"/api/websites/$id/preview","POST");})->name('website.preview');
Route::get('/templates/{id}', function ($id) {return Helper::GetDefaultApi("/templates/$id");})->name('templates.show');
Route::get('lists/count', function (Request $request) {return Helper::RepeatDefaultApi($request,"/lists/count","GET");})->name('list.get_count');
Route::get('/lists/{list}/generate_signup', function (Request $request,$list) {return Helper::RepeatDefaultApi($request,"/lists/$list/generate_signup","GET");})->name('lists.generate_signup');
Route::get('/datatable/list_id/{list}/subscribers', function (Request $request,$list) {return Helper::RepeatDefaultApi($request,"/datatable/list_id/$list/subscribers","GET");});
Route::get('/api/lists/subscriber/{subscriber}/get', function (Request $request,$subscriber) {return Helper::RepeatDefaultApi($request,"/api/lists/subscriber/$subscriber/get","GET");});


// the below routes are not found - there are set below to avoid error 
//Route::get('/templates/{id}', function ($id) {return Helper::GetDefaultApi("/templates/$id");})->name('templates.show');
//Route::get('/websites/data', 'App\Http\Controllers\fe\FrontEndHomeController@websites')->name('websites.data');
//Route::get('/websites/{website}/preview', 'App\Http\Controllers\fe\FrontEndHomeController@websites')->name('website.preview');
//Route::get('/websites/{website}/menu/detach', 'App\Http\Controllers\fe\FrontEndHomeController@websites')->name('websites.menus.detach');
// END UNDEFINED ROUTES


// POST ROUTES
Route::get('/websites/{website}/post/{post}', 'App\Http\Controllers\fe\FrontEndPostController@show_posts')->name('websites.posts.show');
Route::get('/websites/{website}/posts', 'App\Http\Controllers\fe\FrontEndWebsitesController@website_posts')->name('websites.posts.index');
Route::get('/websites/{website}/posts/create', 'App\Http\Controllers\fe\FrontEndPostController@website_posts_create')->name('websites.posts.create');
Route::post('/websites/{website}/posts/store', 'App\Http\Controllers\fe\FrontEndPostController@website_posts_store')->name('websites.posts.store');
Route::get('/websites/{website}/posts/{post}/edit', 'App\Http\Controllers\fe\FrontEndPostController@edit_posts')->name('websites.posts.edit');
// Route::post('/websites/{website}/posts/{post}/update', 'App\Http\Controllers\fe\FrontEndPostController@website_posts_update')->name('websites.posts.update');
Route::get('/websites/{website}/posts/quick','App\Http\Controllers\fe\FrontEndPostController@website_posts_create_quick')->name('post.quick_create');
Route::get('/websites/{website}/post_quick_create','App\Http\Controllers\fe\FrontEndPostController@website_posts_create_quick');
//Route::get('/websites/{website}/posts/quick',function($id) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts/quick");})->name('post.quick_create');
//Route::get('/websites/{website}/post_quick_create',function($id) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts/quick");});

Route::post('/api/websites/{website}/posts/{post}/update', function(Request $request,$website,$post) {return Helper::RepeatDefaultApi($request,"/api/websites/".$website ."/posts/".$post."/update","POST");})->name('websites.posts.update');
Route::delete('/api/websites/{website}/posts/{post}/delete', function(Request $request,$website,$post) {return Helper::RepeatDefaultApi($request,"/api/websites/".$website ."/posts/".$post."/delete","DELETE");})->name('websites.posts.delete');
Route::get('/websites/{id}/posts/{post}/preview', function($id,$post) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts/$post/preview");})->name('websites.posts.preview');
Route::get('/websites/{id}/posts/{post}/replicate',function($id,$post) {return redirect(env('APIROOTENDPOINT')."websites/$id/posts/$post/replicate");})->name('websites.posts.replicate');

// PAGE ROUTES
// Route::get('/websites/{website}/pages/create', 'App\Http\Controllers\fe\FrontEndPageController@website_pages_show_create')->name('websites.pages.create');
Route::get('/websites/pages/{website}/create', 'App\Http\Controllers\fe\FrontEndPageController@website_pages_show_create')->name('websites.pages.create');
Route::get('/websites/{website}/pages', 'App\Http\Controllers\fe\FrontEndPageController@website_pages')->name('websites.pages.index');
Route::get('/websites/{id}/pages/title_check', function(Request $request,$id) {return Helper::RepeatDefaultApi($request,"websites/$id/pages/title_check","GET");})->name('websites.pages.title_check');
Route::get('/websites/{website}/pages/{page}', 'App\Http\Controllers\fe\FrontEndPageController@show_pages')->name('websites.pages.show');
Route::post('/websites/{website}/pages/store', 'App\Http\Controllers\fe\FrontEndPageController@website_pages_store')->name('websites.pages.store');
Route::get('/websites/{website}/pages/{page}/edit', 'App\Http\Controllers\fe\FrontEndPageController@edit_pages')->name('websites.pages.edit');
Route::get('/websites/{website}/pages/{page}/code', 'App\Http\Controllers\fe\FrontEndPageController@code_pages')->name('websites.pages.code');
Route::put('/websites/{website}/pages/{page}/update', 'App\Http\Controllers\fe\FrontEndPageController@website_pages_update')->name('websites.pages.update');
Route::get('website/{id}/post/{post}/preview', function ($id,$post) {return Helper::GetDefaultApi("website/$id/post/$post/preview");})->name('websites.posts.preview');
Route::get('website/{id}/post/{post}/previewjson', function ($id,$post) {return Helper::GetDefaultApi("website/$id/post/$post/previewjson");})->name('websites.posts.previewjson');
Route::get('website/{id}/page/{page}/preview', function ($id,$page) {return Helper::GetDefaultApi("website/$id/page/$page/preview");})->name('websites.pages.preview');    
Route::get('website/{id}/page/{page}/previewjson', function ($id,$page) {return Helper::GetDefaultApi("website/$id/page/$page/previewjson");})->name('websites.pages.previewjson');    
Route::delete('website/{website}/page/{page}/delete', function ($id,$page) {return Helper::GetDefaultApi("website/$id/page/$page/delete");})->name('websites.page.delete');
//Route::post('website/{website}/page/{page}/archive', function ($id,$page) {return Helper::GetDefaultApi("website/$id/page/$page/archive");})->name('websites.page.archive');
//Route::post('website/{website}/page/{page}/unarchive', function ($id,$page) {return Helper::GetDefaultApi("website/$id/page/$page/unarchive");})->name('websites.page.unarchive');

Route::post('website/{website}/page/{page}/archive', 'App\Http\Controllers\fe\FrontEndPageController@archive')->name('websites.page.archive');
Route::post('website/{website}/page/{page}/unarchive', 'App\Http\Controllers\fe\FrontEndPageController@unarchive')->name('websites.page.unarchive');

Route::get('/websites/{id}/pages/{page}/replicate',function($id,$post) {return redirect(env('APIROOTENDPOINT')."websites/$id/page/$post/replicate");})->name('websites.pages.replicate');




// Route::get('websites/{id}/templates', function($id) {return redirect(env('APIROOTENDPOINT').'websites/'.$id.'/templates');})->name('websites.templates.index');
// Route::get('websites/{id}/theme', function($id) {return redirect(env('APIROOTENDPOINT').'websites/'.$id.'/theme');})->name('websites.theme');
// Route::get('websites/{id}/edit', function($id) {return redirect(env('APIROOTENDPOINT').'websites/'.$id.'/edit');})->name('websites.edit');

Route::get('websites/create', function() {return redirect(env('APIROOTENDPOINT').'websites/create');})->name('websites.create');
Route::get('websites/create/preview', function() {return redirect(env('APIROOTENDPOINT').'websites/create/preview');})->name('websites.create.preview');
Route::get('websites/create_sc', function() {return redirect(env('APIROOTENDPOINT').'websites/create_sc');})->name('websites.create_sc');

Route::get('websites/device_chart', function() {return redirect(env('APIROOTENDPOINT').'websites/device_chart');})->name('websites.device_chart');
// Route::get('websites/dashboard', function() {return redirect(env('APIROOTENDPOINT').'websites/dashboard');})->name('websites.dashboard');
// Route::get('websites', function() {return redirect(env('APIROOTENDPOINT').'websites');})->name('websites.dashboard');
Route::get('websites/referer_chart', function() {return redirect(env('APIROOTENDPOINT').'websites/referer_chart');})->name('websites.referer_chart');
Route::get('websites/session_chart', function() {return redirect(env('APIROOTENDPOINT').'websites/session_chart');})->name('websites.session_chart');
Route::get('websites/user_chart', function() {return redirect(env('APIROOTENDPOINT').'websites/user_chart');})->name('websites.user_chart');
//Route::get('content/files', function() {return redirect(env('APIROOTENDPOINT').'content/files');})->name('content.files');
//Route::get('content/search', function() {return redirect(env('APIROOTENDPOINT').'content/search');})->name('content.search');
Route::get('images/create', function() {return redirect(env('APIROOTENDPOINT').'images/create');})->name('images.create');
//Route::get('images/event', function() {return redirect(env('APIROOTENDPOINT').'images/event');})->name('images.event');
Route::get('images', function() {return redirect(env('APIROOTENDPOINT').'images');})->name('images.index');
Route::get('images/list', function() {return redirect(env('APIROOTENDPOINT').'images/list');})->name('images.list');
//Route::get('automation/feeds/create', function() {return redirect(env('APIROOTENDPOINT').'automation/feeds/create');})->name('feeds.create');
//Route::get('automation/feeds', function() {return redirect(env('APIROOTENDPOINT').'automation/feeds');})->name('feeds.index');

//Route::get('emails/campaigns/create', function() {return redirect(env('APIROOTENDPOINT').'emails/campaigns/create');})->name('campaigns.create');

Route::get('emails/campaigns/create','App\Http\Controllers\fe\FrontEndEmailsController@create')->name('campaigns.create');
Route::post('emails/campaigns','App\Http\Controllers\fe\FrontEndEmailsController@store')->name('campaigns.store');
Route::post('emails/campaigns/{campaign}','App\Http\Controllers\fe\FrontEndEmailsController@update')->name('campaigns.update');

Route::post('emails/templates/store','App\Http\Controllers\fe\FrontEndEmailsController@index')->name('templates.store');
Route::get('emails/{campaigns}/send_test','App\Http\Controllers\fe\FrontEndEmailsController@sendTest')->name('campaigns.send_test');
Route::get('emails/{campaigns}/send_test_limit','App\Http\Controllers\fe\FrontEndEmailsController@sendTest')->name('campaigns.send_test_limit');
Route::get('emails/campaigns/spamscore/ajax','App\Http\Controllers\fe\FrontEndEmailsController@index')->name('campaign.spamscore.ajax');

// NEW EMAILS ROUTES
Route::get('emails', 'App\Http\Controllers\fe\FrontEndEmailsController@emailCampaigns')->name('campaigns.index');

Route::get('emails/{campaign}/preview', 'App\Http\Controllers\fe\FrontEndEmailsController@show')->name('campaigns.preview');
Route::get('emails/{campaign}/publish_preview', 'App\Http\Controllers\fe\FrontEndEmailsController@publish_preview')->name('campaigns.publish_preview');
Route::put('emails/{campaign}/update_schedule', 'App\Http\Controllers\fe\FrontEndEmailsController@update_schedule')->name('campaigns.update_schedule');
Route::get('emails/{campaign}/publish', 'App\Http\Controllers\fe\FrontEndEmailsController@campaigns_publish')->name('campaigns.publish');
Route::get('emails/{campaign}/edit', 'App\Http\Controllers\fe\FrontEndEmailsController@edit')->name('campaigns.edit');
Route::get('emails/{campaign}/cancel', 'App\Http\Controllers\fe\FrontEndEmailsController@cancelEmailCampaigns')->name('campaigns.cancel');
Route::get('emails/{campaign}/saveas', 'App\Http\Controllers\fe\FrontEndEmailsController@campaigns_saveas')->name('campaigns.saveAs');
Route::delete('emails/{campaign}/destroy', 'App\Http\Controllers\fe\FrontEndEmailsController@destroy')->name('campaigns.destroy');
// Route::get('emails', function() {return redirect(env('APIROOTENDPOINT').'emails');})->name('campaigns.index');

Route::get('templates', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('templates.index');
Route::get('emails/templates', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('emails.templates.index');
Route::get('emails/templates/{id}/preview', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('templates.preview');
Route::get('emails/templates/{id}/edit', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('templates.edit');
Route::delete('emails/templates/{id}', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('templates.delete');

Route::get('emails/templates/{template}/sys_preview', 'App\Http\Controllers\fe\FrontEndEmailsController@emailTemplates')->name('templates.sys_preview');

Route::get('lists', 'App\Http\Controllers\fe\FrontEndListsController@lists')->name('lists.index');
Route::get('lists/{id}/subscribers', 'App\Http\Controllers\fe\FrontEndListsController@lists_subscribers')->name('lists.subscribers');
Route::get('/lists/subscriber/{subscriber}/manage', 'App\Http\Controllers\fe\FrontEndListsController@list_manage_subscribers')->name('lists.subscribers.manage');
Route::get('/lists/contact/{subscriber}', 'App\Http\Controllers\fe\FrontEndListsController@list_subscribers_contact')->name('lists.subscribers.contact');
Route::get('lists/{id}/upload', 'App\Http\Controllers\fe\FrontEndListsController@lists_uploads')->name('lists.upload');
Route::get('lists/{id}/settings', 'App\Http\Controllers\fe\FrontEndListsController@lists_settings')->name('lists.settings');
Route::get('lists/{id}/analytics', 'App\Http\Controllers\fe\FrontEndListsController@lists_analytics')->name('lists.analytics');

Route::get('lists/default', 'App\Http\Controllers\fe\FrontEndListsController@lists_default')->name('lists.default');
Route::get('/datatable/{parent}/{parent_id}/subscribers',function(Request $request, $parent,$parent_id) {return Helper::RepeatDefaultApi($request,"/datatable/$parent/$parent_id/subscribers","GET");})->name('subscribers.index');

Route::post('lists/store', 'App\Http\Controllers\fe\FrontEndListsController@lists_store')->name('lists.store');
Route::put('lists/{id}/update', 'App\Http\Controllers\fe\FrontEndListsController@lists_update')->name('lists.update');
Route::delete('lists/{id}/destroy', 'App\Http\Controllers\fe\FrontEndListsController@lists_delete')->name('lists.destroy');

Route::post('lists/{id}/subscriber/quick_add', 'App\Http\Controllers\fe\FrontEndListsController@lists_subscribers_quickadd')->name('lists.subscribers.quick_add');
Route::post('lists/subscriber/{id}/update', 'App\Http\Controllers\fe\FrontEndListsController@lists_subscribers_update')->name('lists.subscribers.update');
Route::post('lists/subscriber/{id}/update_data', 'App\Http\Controllers\fe\FrontEndListsController@lists_subscribers_update_data')->name('lists.subscribers.update_data');

#Route::get('/emails/{id}/iframe',function($id) {return redirect(env('APIROOTENDPOINT').'emails/'.$id.'/iframe');})->name('campaigns.iframe');
Route::get('/emails/{id}/iframe',function($id) {return Helper::GetDefaultApi("/emails/$id/iframe");})->name('campaigns.iframe');

// Lists Route not found but needed
Route::get('lists/import', 'App\Http\Controllers\fe\FrontEndListsController@lists')->name('lists.import');
Route::get('lists/{file}/import/cancel', 'App\Http\Controllers\fe\FrontEndListsController@lists')->name('lists.import.cancel');
//End List rount not found

Route::get('emails/newsletters/create', function() {return redirect(env('APIROOTENDPOINT').'emails/newsletters/create');})->name('newsletters.create');
Route::get('automation', function() {return redirect(env('APIROOTENDPOINT').'automation');})->name('newsletters.index');
//Route::get('emails/newsletters', function() {return redirect(env('APIROOTENDPOINT').'emails/newsletters');})->name('newsletters.index');
//Route::get('emails/dashboard', function() {return redirect(env('APIROOTENDPOINT').'emails/dashboard');})->name('reports.dashboard');
Route::get('emails/dashboard', 'App\Http\Controllers\fe\FrontEndEmailsController@email_dashboard')->name('reports.dashboard');
Route::get('/api/emails','App\Http\Controllers\fe\FrontEndEmailsController@get_emails')->name('email.data');
/* NEWSLETTER NEW ROUTE */
Route::get('emails/newsletters', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletters')->name('newsletters.index');
Route::get('emails/newsletters/create', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletters_create')->name('newsletters.create');
Route::get('emails/newsletters/create/preview/{template_id}/website/{website}', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletters_create_preview_website')->name('newsletters.create.website.preview');
Route::get('emails/newsletters/create/preview/{template_id}/feed/{feed}', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletters_create_preview_feed')->name('newsletters.create.feed.preview');
Route::get('emails/newsletters/ads/{news}/create', 'App\Http\Controllers\fe\FrontEndEmailsController@campaign_newsletters_create')->name('campaigns.newsletter.ads');
Route::get('emails/newsletters/{news}/create', 'App\Http\Controllers\fe\FrontEndEmailsController@campaign_newsletters')->name('campaigns.newsletter');
Route::get('emails/newsletters/preview/{news}', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletter_preview')->name('newsletters.preview');
Route::get('emails/newsletters/{news}/edit', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletter_edit')->name('newsletters.edit');
Route::get('emails/newsletters/{news}/saveas', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletter_saveas')->name('newsletters.saveAs');
Route::delete('emails/newsletters/{news}/destroy', 'App\Http\Controllers\fe\FrontEndEmailsController@newsletter_destroy')->name('newsletters.destroy');
Route::get('emails/newsletters/{id}/iframe',function($id) {return redirect(env('APIROOTENDPOINT').'emails/newsletters/'.$id.'/iframe');})->name('newsletter.iframe');
Route::post('emails/newsletters/feeds','App\Http\Controllers\fe\FrontEndEmailsController@newsletter_feed_store')->name('feeds.store');
Route::POST('emails/newsletters/store','App\Http\Controllers\fe\FrontEndEmailsController@newsletter_store')->name('newsletters.store');
Route::put('emails/newsletters/{news}','App\Http\Controllers\fe\FrontEndEmailsController@newsletter_update')->name('newsletters.update');



Route::get('emails/analytics', 'App\Http\Controllers\fe\FrontEndEmailsController@analytics')->name('reports.overview');
Route::get('emails/email/{marketing_campaign}', 'App\Http\Controllers\fe\FrontEndEmailsController@email_resource')->name('email.resource');

Route::get('domains', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.index');
Route::get('/domains/{id}/edit', 'App\Http\Controllers\fe\FrontEndDomainsController@domains_edit')->name('domains.edit');
Route::get('/domains/{id}/update', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.update');

Route::get('/domains/{id}/email', 'App\Http\Controllers\fe\FrontEndDomainsController@domain_emails')->name('domains.email_boxes.index');
Route::get('/domains/{id}/hosting', 'App\Http\Controllers\fe\FrontEndDomainsController@domains_hosting')->name('domains.hosting.index');
Route::get('/domains/{id}/advanced', 'App\Http\Controllers\fe\FrontEndDomainsController@domains_advanced')->name('domains.advanced.index');
Route::get('/domains/{id}/advanced/lock', 'App\Http\Controllers\fe\FrontEndDomainsController@domains_advanced_lock')->name('domains.advanced.lock');
Route::get('/domains/{id}/hosting/data', 'App\Http\Controllers\fe\FrontEndDomainsController@hosting_data')->name('domains.hosting.data');
Route::get('/domains/{id}/emails/data', 'App\Http\Controllers\fe\FrontEndDomainsController@emails_data')->name('domains.emails.data');
// Route not found
Route::get('/domains/{domain}/email/{email}/change_password', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.change_password');
Route::get('/domains/{domain}/email/{email}', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.delete');
Route::get('/domains/{id}/nameservers', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.nameservers.index');
Route::get('/domains/{id}/advanced/info', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.advanced.info');
Route::get('/domains/{id}/advanced/confirm_delete', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.advanced.confirm_delete');

Route::get('/domains/{id}/forwards/list', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.forwards.list');
Route::post('/domains/{id}/forwards/list', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.forwards.store');
Route::delete('/domains/{id}/forwards/delete', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.forwards.delete');
Route::put('/domains/{id}/forwards/update', 'App\Http\Controllers\fe\FrontEndDomainsController@domains')->name('domains.forwards.update');

Route::get('settings/senders/confirm', function() {return redirect(env('APIROOTENDPOINT').'settings/senders/confirm');})->name('senders.confirm');
//Route::get('emails/senders', function() {return redirect(env('APIROOTENDPOINT').'emails/senders');})->name('senders.index');
Route::get('emails/senders', 'App\Http\Controllers\fe\FrontEndEmailsController@index')->name('senders.index');
Route::post('emails/senders/store', 'App\Http\Controllers\fe\FrontEndEmailsController@sender_store')->name('senders.store');
Route::patch('emails/senders/{id?}', 'App\Http\Controllers\fe\FrontEndEmailsController@sender_update')->name('senders.update');
Route::delete('emails/senders/destroy/{id?}', 'App\Http\Controllers\fe\FrontEndEmailsController@sender_delete')->name('senders.destroy');
Route::get('emails/senders/json', 'App\Http\Controllers\fe\FrontEndEmailsController@index')->name('senders.json');
Route::get('emails/sendConf/{id}', 'App\Http\Controllers\fe\FrontEndEmailsController@sendConf')->name('sendConf');
// Route::get('emails/senders/list', function() {return redirect(env('APIROOTENDPOINT').'emails/senders/list');})->name('senders.list');
Route::get('emails/senders/list', 'App\Http\Controllers\fe\FrontEndEmailsController@senders_list')->name('senders.list');
Route::get('emails/templates/create', function() {return redirect(env('APIROOTENDPOINT').'emails/templates/create');})->name('emails.templates.create');
Route::get('automation/templates/create', function() {return redirect(env('APIROOTENDPOINT').'automation/templates/create');})->name('emails.templates.create');
// Route::get('emails/templates', function() {return redirect(env('APIROOTENDPOINT').'emails/templates');})->name('emails.templates.index');
//Route::get('templates', function() {return redirect(env('APIROOTENDPOINT').'templates');})->name('emails.templates.index');
Route::get('templates/native', function() {return redirect(env('APIROOTENDPOINT').'templates/native');})->name('templates.native');
Route::get('templates/newsletter', function() {return redirect(env('APIROOTENDPOINT').'templates/newsletter');})->name('templates.newsletter');
Route::get('automation/templates', function() {return redirect(env('APIROOTENDPOINT').'automation/templates');})->name('templates.newsletter');
Route::get('lists/create', function() {return redirect(env('APIROOTENDPOINT').'lists/create');})->name('lists.create');
//Route::get('lists/count', function() {return redirect(env('APIROOTENDPOINT').'lists/count');})->name('list.get_count');
// Route::get('lists', function() {return redirect(env('APIROOTENDPOINT').'lists');})->name('lists.index');
// Route::get('/lists/subscriber/{subscriber}/manage', function($id) {return redirect(env('APIROOTENDPOINT')."/lists/subscriber/$id/manage");})->name('lists.subscribers.manage');
Route::get('domains/create', function() {return redirect(env('APIROOTENDPOINT').'domains/create');})->name('domains.create');
// Route::get('domains', function() {return redirect(env('APIROOTENDPOINT').'domains');})->name('domains.index');
Route::get('domains/find', function() {return redirect(env('APIROOTENDPOINT').'domains/find');})->name('domains.search.index');
Route::get('domains/{id}/emails', function($id) {return redirect(env('APIROOTENDPOINT').'domains/emails/'.$id);})->name('domains.emails.index');
Route::get('billing/funds', function() {return redirect(env('APIROOTENDPOINT').'billing/funds');})->name('billing.funds');
Route::get('billing/retry', function() {return redirect(env('APIROOTENDPOINT').'billing/retry');})->name('billing.retry');
Route::get('plans/alt', function() {return redirect(env('APIROOTENDPOINT').'plans/alt');})->name('plans.index');
Route::get('plans/table', function() {return redirect(env('APIROOTENDPOINT').'plans/table');})->name('plans.table');
Route::get('upgrade', function() {return redirect(env('APIROOTENDPOINT').'upgrade');})->name('plans.upgrade');
Route::get('upgrade2', function() {return redirect(env('APIROOTENDPOINT').'upgrade2');})->name('plans.upgrade2');
Route::get('username', function() {return redirect(env('APIROOTENDPOINT').'username');})->name('plans.username');
Route::get('plans/cancel', function() {return redirect(env('APIROOTENDPOINT').'plans/cancel');})->name('plans.cancel');
Route::get('plans/card', function() {return redirect(env('APIROOTENDPOINT').'plans/card');})->name('plans.card');
Route::get('plans/resume', function() {return redirect(env('APIROOTENDPOINT').'plans/resume');})->name('plans.resume');
Route::get('accounts/payments', function() {return redirect(env('APIROOTENDPOINT').'accounts/payments');});
Route::get('accounts/create', function() {return redirect(env('APIROOTENDPOINT').'accounts/create');})->name('teams.create');
Route::get('accounts/edit/{id}', function($id) {return redirect(env('APIROOTENDPOINT')."accounts/create/$id");})->name('teams.edit');

//Route::get('accounts', function() {return redirect(env('APIROOTENDPOINT').'accounts');})->name('teams.index');
Route::get('accounts/interview', function() {return redirect(env('APIROOTENDPOINT').'accounts/interview');})->name('teams.interview');
Route::get('land', function() {return redirect(env('APIROOTENDPOINT').'land');})->name('landing.testing');

Route::get('/interview/restart', function () {
    session(['interview' => 'pending']);
    return redirect(route('home'));
})->name('interview.restart');

Route::get('checkout', function() {return redirect(env('APIROOTENDPOINT').'checkout');})->name('auth.checkout');
Route::get('checkout/1', function() {return redirect(env('APIROOTENDPOINT').'checkout/1');})->name('checkout.lead');

Route::get('datatable/accounts/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/accounts/create');})->name('datatable.accounts.create');

Route::get('datatable/accounts', function() {return redirect(env('APIROOTENDPOINT').'datatable/accounts');})->name('datatable.accounts.index');

Route::get('datatable/domains/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/domains/create');})->name('datatable.domains.create');

Route::get('datatable/domains', function() {return redirect(env('APIROOTENDPOINT').'datatable/domains');})->name('datatable.domains.index');

Route::get('datatable/feeds/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/feeds/create');})->name('datatable.feeds.create');

Route::get('datatable/feeds', function() {return redirect(env('APIROOTENDPOINT').'datatable/feeds');})->name('datatable.feeds.index');

Route::get('datatable/list_uploads/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/list_uploads/create');})->name('datatable.list_uploads.create');

Route::get('datatable/list_uploads', function() {return redirect(env('APIROOTENDPOINT').'datatable/list_uploads');})->name('datatable.list_uploads.index');

Route::get('datatable/logins/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/logins/create');})->name('datatable.logins.create');

Route::get('datatable/logins', function() {return redirect(env('APIROOTENDPOINT').'datatable/logins');})->name('datatable.logins.index');

Route::get('datatable/pages/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/pages/create');})->name('datatable.pages.create');

Route::get('datatable/pages', function() {return redirect(env('APIROOTENDPOINT').'datatable/pages');})->name('datatable.pages.index');

Route::get('datatable/posts/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/posts/create');})->name('datatable.posts.create');

Route::get('datatable/posts', function() {return redirect(env('APIROOTENDPOINT').'datatable/posts');})->name('datatable.posts.index');

Route::get('datatable/templates/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/templates/create');})->name('datatable.templates.create');

Route::get('datatable/templates', function() {return redirect(env('APIROOTENDPOINT').'datatable/templates');})->name('datatable.templates.index');

Route::get('datatable/transactions/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/transactions/create');})->name('datatable.transactions.create');

Route::get('datatable/transactions', function() {return redirect(env('APIROOTENDPOINT').'datatable/transactions');})->name('datatable.transactions.index');

Route::get('datatable/users/create', function() {return redirect(env('APIROOTENDPOINT').'datatable/users/create');})->name('datatable.users.create');

Route::get('datatable/users', function() {return redirect(env('APIROOTENDPOINT').'datatable/users');})->name('datatable.users.index');
Route::get('facebook/event', function() {return redirect(env('APIROOTENDPOINT').'facebook/event');})->name('facebook.event');
Route::get('api/reports/templates', function() {return redirect(env('APIROOTENDPOINT').'api/reports/templates');})->name('api.reports.templates');
Route::get('api/reports/up', function() {return redirect(env('APIROOTENDPOINT').'api/reports/up');})->name('api.reports.up');
// Route::get('websites', function() {return redirect(env('APIROOTENDPOINT').'websites');})->name('websites.index');

Route::get('websites/analytics/{website?}', function($w="") {return redirect(env('APIROOTENDPOINT').'websites/analytics/'.$w);})->name('websites.analytics');
Route::get('page/{page}/analytics', function($p="") {return redirect(env('APIROOTENDPOINT').'page/'.$p.'/analytics');})->name('page.analytics');
Route::get('post/{post}/analytics', function($p="") {return redirect(env('APIROOTENDPOINT').'post/'.$p.'/analytics');})->name('post.analytics');

//Route::get('post/{post}/analytics', function($p="") {return redirect(env('APIROOTENDPOINT').'post/'.$p.'/analytics');})->name('websites.post.analytics');
Route::get('/websites/{website}/posts/{post}/analytics', function ($website, $post) {
    return redirect(env('APIROOTENDPOINT') . "websites/$website/posts/$post/analytics");
})->name('websites.posts.analytics');


Route::get('/websites/{website}/posts/{post}/analytics',function($website,$post) {return redirect(env('APIROOTENDPOINT')."websites/$website/posts/$post/analytics");})->name('websites.posts.analytics');


Route::get('/sidebar/{state}', function ($state) {
    session(['sidebar' => $state]);
})->name('sidebar');


Route::get('/content/images/view', 'App\Http\Controllers\fe\FrontEndContentController@viewImage')->name('images.view');
Route::get('/content/images/edit', 'App\Http\Controllers\fe\FrontEndContentController@editImage')->name('images.edit');
Route::post('/content/images/upload', 'App\Http\Controllers\fe\FrontEndContentController@uploadCroppedImage')->name('images.upload');
Route::get('/content/files/view', 'App\Http\Controllers\fe\FrontEndContentController@viewFile')->name('file.view');

Route::get('/billing/plans/card', 'App\Http\Controllers\fe\FrontEndBillingController@card')->name('billing.card');
Route::get('/billing/funds', 'App\Http\Controllers\fe\FrontEndBillingController@funds')->name('billing.funds');
Route::get('/billing/referrals', 'App\Http\Controllers\fe\FrontEndBillingController@referrals')->name('billing.referrals');
Route::get('/billing/plans', 'App\Http\Controllers\fe\FrontEndBillingController@plans')->name('billing.plans');
Route::get('/billing/plans/table', 'App\Http\Controllers\fe\FrontEndBillingController@plans_table')->name('billing.plans.table');
Route::get('/billing/payments', 'App\Http\Controllers\fe\FrontEndBillingController@payment')->name('billing.payment');


