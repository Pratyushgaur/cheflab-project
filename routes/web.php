<?php

use App\Http\Middleware\isVendorLoginAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $Order=\App\Models\Order::find(3);
//    dd($Order);
//    $on = \Carbon\Carbon::now()->addSecond(3);
//    dispatch(new \App\Jobs\OrderCreateJob($Order))->delay($on);


//    event(new \App\Events\OrderCreateEvent($Order,$Order->id, 1, 1));
//    dispatch(function(){
//        echo mysql_date_time();
//    })->delay(now()->addSeconds(30));

    \App\Jobs\OrderCreateJob::dispatch($Order)
        ->delay(now()->addSeconds(3));
})->name('test');

Route::get('dashbord', [App\Http\Controllers\vendor\restaurant\DashboardController::class, 'index'])->name('restaurant.dashboard');
Route::get('/clear-cache', function() {
    Artisan::call('view:clear');
    echo Artisan::output();
    Artisan::call('config:clear');
    echo Artisan::output();
    Artisan::call('route:clear');
    echo Artisan::output();
    Artisan::call('cache:clear');
    echo Artisan::output();
//    dd($r);
    return "Cache is cleared";
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/pubnub-test', function () {
    return view('welcome2');
});
Route::get('admin-logout', function () {

    Auth::guard('admin')->logout();
    //Session::flush();
    return redirect('admin');
})->name('admin.logout');
Route::view('admin', 'admin/login-2')->name('admin.login')->middleware('isadminloginAuth');
Route::post('check-login-for-admin', [ App\Http\Controllers\admin\Cn_login::class, 'admin_login' ]);

@require_once 'admin_routes.php';


//////////////////////////////////////vendor route ///////////////////////////////////////////////////////////////////////////////////////////////////

Route::view('vendor/login', 'vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::post('check-login-on-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'login' ])->name('action.vendor.login');
Route::get('vendor-logout', function () {
    Auth::guard('vendor')->logout();
    return redirect()->route('vendor.login');
})->name('vendor.logout');
Route::post('check-email-for-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'checkEmailVendor' ])->name('action.vendor.changepass');
Route::post('verify-otp-for-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'verify_otp' ])->name('action.vendor.verify_pass');
Route::post('change-new-password-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'change_new_pass' ])->name('action.vendor.change_new_pass');

@require_once 'restaurant_routes.php';

// chef route

Route::get('chef-logout', function () {
    Auth::logout();
    return redirect()->route('vendor.login');
})->name('chef.logout');

@require_once 'chef_routes.php';


//comon routes for chef and restaurant

//notification
Route::get('notification', [ App\Http\Controllers\NotificationController::class, 'index' ])->name('notification.view')->where('id', '[0-9]+');



//test
Route::get('get-firebase-data', [\App\Http\Controllers\FirebaseController::class, 'index'])->name('firebase.index');
Route::patch('/fcm-token', [\App\Http\Controllers\FirebaseController::class, 'updateTokenVendor'])->name('fcmToken_vendor');
Route::get('/send-notification',[\App\Http\Controllers\FirebaseController::class,'notification'])->name('notification');



Route::get('event-registration', [\App\Http\Controllers\vendor\restaurant\PaytmController::class,'register']);
Route::get('payment', [\App\Http\Controllers\vendor\restaurant\PaytmController::class,'order']);
Route::post('payment/status', [\App\Http\Controllers\vendor\restaurant\PaytmController::class,'paymentCallback']);


