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
    Route::post('getData',[App\Http\Controllers\admin\UserControllers::class,'getData']);
});

Route::post('register-send-otp',[App\Http\Controllers\api\LoginApiController::class,'register_send_otp']);
Route::post('register-verify-otp',[App\Http\Controllers\api\LoginApiController::class,'register_verify_otp']);
Route::post('register-verified-user',[App\Http\Controllers\api\LoginApiController::class,'register_user']);
