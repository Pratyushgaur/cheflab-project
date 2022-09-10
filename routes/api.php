<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:sanctum'], function(){
    // master 
    Route::get('getCategories',[App\Http\Controllers\api\AppMasterController::class,'getCategories']);
    Route::get('getCuisines',[App\Http\Controllers\api\AppMasterController::class,'getCuisines']);
    //
    // restaurant home page api

    Route::get('home',[App\Http\Controllers\api\AppController::class,'restaurantHomePage']);
    Route::post('getRestaurantByCategory',[App\Http\Controllers\api\AppController::class,'getRestaurantByCategory']);
    Route::post('getRestaurantDetailPage',[App\Http\Controllers\api\AppController::class,'getRestaurantDetailPage']);
    Route::post('browse-menu',[App\Http\Controllers\api\AppController::class,'getRestaurantBrowsemenu']);
    Route::post('custmizable-data',[App\Http\Controllers\api\AppController::class,'getRestaurantCustmizeProductData']);
    Route::post('search-data',[App\Http\Controllers\api\AppController::class,'getRestaurantSearchData']);

    // chef home page api
    Route::get('chef-home',[App\Http\Controllers\api\AppController::class,'chefHomePage']);
    Route::post('getChefByCategory',[App\Http\Controllers\api\AppController::class,'getChefByCategory']);
    Route::post('getChefDetailPage',[App\Http\Controllers\api\AppController::class,'getChefDetailPage']);
    Route::post('getChefProfile',[App\Http\Controllers\api\AppController::class,'getChefProfile']);
   

});

Route::post('register-send-otp',[App\Http\Controllers\api\LoginApiController::class,'register_send_otp']);
Route::post('register-verify-otp',[App\Http\Controllers\api\LoginApiController::class,'register_verify_otp']);
Route::post('register-verified-user',[App\Http\Controllers\api\LoginApiController::class,'register_user']);
Route::post('login-otp-send',[App\Http\Controllers\api\LoginApiController::class,'login_send_otp']);
Route::post('login-otp-verify',[App\Http\Controllers\api\LoginApiController::class,'login_verify_otp']);
// chef 

