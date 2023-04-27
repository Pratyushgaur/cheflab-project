<?php 
Route::post('rider-otp-send', [App\Http\Controllers\api\rider\LoginApiController::class, 'login_send_otp'])->name("rider.otp.send");
Route::post('rider-otp-verify', [App\Http\Controllers\api\rider\LoginApiController::class, 'login_verify_otp'])->name("rider.otp.verify");
// home

Route::post('rider-home', [App\Http\Controllers\api\rider\AppController::class, 'home'])->name("rider.home");
Route::post('rider-profile', [App\Http\Controllers\api\rider\AppController::class, 'profile'])->name("rider.profile");
Route::post('rider-register-token', [App\Http\Controllers\api\rider\AppController::class, 'register_token'])->name("rider.register.token");
Route::post('rider-chage-status', [App\Http\Controllers\api\rider\AppController::class, 'change_status']);


Route::post('rider-order-status', [App\Http\Controllers\api\rider\AppController::class, 'orderStatus'])->name("rider.order.status");
Route::post('rider-pick-up-otp', [App\Http\Controllers\api\rider\AppController::class, 'pickupOtpCheck'])->name("rider.pick.up.otp");
Route::post('rider-analytics', [App\Http\Controllers\api\rider\AppController::class, 'analytics'])->name("rider.analytics");
Route::post('rider-order-earnings', [App\Http\Controllers\api\rider\AppController::class, 'orderEarnings'])->name("rider.order.earning");
Route::post('rider-incentive-history', [App\Http\Controllers\api\rider\AppController::class, 'incentiveHistory'])->name("rider.incentive.history");
Route::post('rider-latLng-update', [App\Http\Controllers\api\rider\AppController::class, 'updateLatLng'])->name("rider.latlng.update");
Route::post('rider-deliver-otp', [App\Http\Controllers\api\rider\AppController::class, 'deliverOtpCheck'])->name("rider.delivery.otp");
Route::post('rider-login-history', [App\Http\Controllers\api\rider\AppController::class, 'logInHistory'])->name("rider.login.history");
Route::post('rider-update-version', [\App\Http\Controllers\api\rider\LoginApiController::class, 'checkVersion'])->name("rider.update.version");
Route::post('rider-active-status', [\App\Http\Controllers\api\rider\AppController::class, 'checkRiderActive'])->name("rider.active.status");


Route::post('rider-order-history', [App\Http\Controllers\api\rider\OrderApiController::class, 'orderhistory'])->name("rider.order.history");
Route::get('getDistance', [App\Http\Controllers\api\rider\LoginApiController::class, 'getDistance']);
Route::get('getDistance2', [App\Http\Controllers\api\rider\LoginApiController::class, 'getDistance2']);

