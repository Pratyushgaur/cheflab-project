<?php

use App\Http\Middleware\isVendorLoginAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/check-queue-work', function() {
    return exec('ps -aux | grep queue:work');
});
Route::get('/queue-work', function() {
    return exec('nohup php artisan queue:work --daemon &');
});
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
Route::get('check-login-for-admin', function(){
    return view('admin/login-2');
});

@require_once 'admin_routes.php';


//////////////////////////////////////vendor route ///////////////////////////////////////////////////////////////////////////////////////////////////

Route::view('vendor/login', 'vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::get('check-login-on-vendor', function(){
    return view('vendor/login');
});

Route::post('check-login-on-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'login' ])->name('action.vendor.login');
Route::get('vendor-logout', function () {
    Auth::guard('vendor')->logout();
    return redirect()->route('vendor.login');
})->name('vendor.logout');
Route::post('check-email-for-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'checkEmailVendor' ])->name('action.vendor.changepass');
Route::post('verify-otp-for-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'verify_otp' ])->name('action.vendor.verify_pass');
Route::post('change-new-password-vendor', [ App\Http\Controllers\vendor\LoginController::class, 'change_new_pass' ])->name('action.vendor.change_new_pass');
Route::post('vendor-login', [ App\Http\Controllers\vendor\LoginController::class, 'vendorLogin' ])->name('admin.vendor.login');


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


// vendor app route
Route::group([ 'prefix' => 'app'], function () {
   
    Route::get('vendor/login', [\App\Http\Controllers\app\LoginController::class,'index']);
    Route::post('check-login-on-vendor', [ App\Http\Controllers\app\LoginController::class, 'login' ])->name('app.action.vendor.login');
    @require_once 'app_restaurant_routes.php';
});

Route::post('vendor/app/test/login',[App\Http\Controllers\app\LoginController::class, 'login_test' ]);
