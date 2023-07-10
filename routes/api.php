<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*
//Route::get('/api/home_data','App\Http\Controllers\fe\FrontEndAPIController@home_data');
Route::get('/api/home_data',function () {return Helper::GetDefaultApi("/api/home_data");});

Route::get('/notifications/data', function () {return Helper::GetDefaultApi("/notification/data");})->name('notifications.data');
Route::get('/notification/{id}',function ($id) {return Helper::GetDefaultApi("/notification/$id");});
Route::get('/notification/archive/{id}',function ($id) {return Helper::GetDefaultApi("/notification/archive/$id");});
Route::get('notifications/mark-all',function () {return Helper::GetDefaultApi("/notification/mark-all");})->name('notifications.markAll');
Route::get('/api/login_status',function () {return Helper::GetDefaultApi('/api/login_status/');})->name('api.login_status');
Route::get('/accounts/api/get_list',function () {return Helper::GetDefaultApi('/accounts/api/get_list/');});
Route::get('/websites/{id}/data',function ($id) {return Helper::GetDefaultApi("/websites/$id/data");});
Route::get('/api/websites/{id}/posts',function ($id) {return Helper::GetDefaultApi("/api/websites/$id/posts");});
Route::get('/accounts/api/switch/{id}',function ($id) {return Helper::GetDefaultApi("/accounts/api/switch/$id");});
Route::get('/api/templates/{type}/{status}',function ($type,$status) {return Helper::GetDefaultApi("/api/templates/$type/$status");});
*/

/*

/api/feeds
/api/feeds/{feed}/json
POST  /api/feeds/{feed}/create
POST  /api/feeds/{feed}/update
GET /api/websites/{website}/posts
GET /api/websites/{website}/posts/{post}/get
POST /api/websites/{website}/posts/{post}/create
POST /api/websites/{website}/posts/{post}/update
GET /api/content/{key}
            education.index
            education.getting_started
            education.videos
            education.content_tools
            education.coaching
            education.ebooks


*/
