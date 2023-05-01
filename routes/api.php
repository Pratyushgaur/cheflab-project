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
Route::post('razorpay-success',[App\Http\Controllers\api\AppController::class, 'razorpaySuccessRes']);
Route::post('razorpay-cancel',[App\Http\Controllers\api\AppController::class, 'razorpayCancelRes']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    @require_once 'api_route.php';
});
Route::get('login', function () {
    return response()->json([
        'status' => false,
        'error'  => "Need To Use Token for this route"
    ], 500);
})->name('login');
Route::post('register-send-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_send_otp'])->name("register.otp.send");
Route::post('register-verify-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_verify_otp'])->name("register.otp.verify");
Route::post('register-verified-user', [App\Http\Controllers\api\LoginApiController::class, 'register_user'])->name("register.user.verify");
Route::post('login-otp-send', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp'])->name("login.otp.send");
Route::post('login-otp-verify', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp'])->name("login.verify.otp");
//  login version 2 api
Route::post('login-otp-send-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp_v2'])->name("login.otp.send.v2");
Route::post('login-otp-verify-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp_v2'])->name("login.verify.otp.v2");
// 
Route::post('guest-login', [App\Http\Controllers\api\LoginApiController::class, 'guestLogin'])->name("login.guest");

Route::get('user-faq', [\App\Http\Controllers\api\UserFaqApiController::class, 'get_user_faq'])->name("user.faq");

Route::post('get-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkVersion'])->name("update.version");
Route::post('get-ios-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkIosVersion'])->name("update.version");


Route::post('send-notification', [App\Http\Controllers\api\AppController::class, 'sendNotification']);

@require_once 'rider_routes.php';

// vi call
Route::group(['middleware' => 'auth:sanctum','prefix' => 'system-api'], function () {
    @require_once 'system_api.php';
});

//
Route::get('system-api/login', function () {
    return response()->json([
        'status' => false,
        'error'  => "Need To Use Token for this route"
    ], 500);
})->name('login');
Route::post('system-api/register-send-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_send_otp']);
Route::post('system-api/register-verify-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_verify_otp']);
Route::post('system-api/register-verified-user', [App\Http\Controllers\api\LoginApiController::class, 'register_user']);
Route::post('system-api/login-otp-send', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp']);
Route::post('system-api/login-otp-verify', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp']);
//  login version 2 api
Route::post('system-api/login-otp-send-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp_v2'])->name("login.otp.send.v2");
Route::post('system-api/login-otp-verify-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp_v2'])->name("login.verify.otp.v2");
Route::post('system-api/guest-login', [App\Http\Controllers\api\LoginApiController::class, 'guestLogin']);

Route::get('system-api/user-faq', [\App\Http\Controllers\api\UserFaqApiController::class, 'get_user_faq']);

Route::post('system-api/get-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkVersion']);
Route::post('system-api/get-ios-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkIosVersion']);


Route::post('system-api/send-notification', [App\Http\Controllers\api\AppController::class, 'sendNotification']);

//