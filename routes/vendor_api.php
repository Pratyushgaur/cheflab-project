<?php
 Route::post('login', [App\Http\Controllers\api\vendor\LoginApiController::class, 'index']);
 Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('home', [App\Http\Controllers\api\vendor\HomeApiController::class, 'index']);
    Route::post('accept-order', [App\Http\Controllers\api\vendor\HomeApiController::class, 'order_preparing']);
    Route::post('reject-order', [App\Http\Controllers\api\vendor\HomeApiController::class, 'order_vendor_reject']);
    Route::post('ready-to-dispatch', [App\Http\Controllers\api\vendor\HomeApiController::class, 'ready_to_dispatch']);
    
});