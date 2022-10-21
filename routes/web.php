<?php

use App\Http\Middleware\isVendorLoginAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//use Auth;

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

Route::get('/test', function () {
    $data['lat'] = 24.4637223;
    $data['lng'] = 74.8866346;
    $select = "( 3959 * acos( cos( radians(".$data['lat'].") ) * cos( radians( vendors.lat ) ) * cos( radians( vendors.long ) - radians(".$data['lng'].") ) + sin( radians(".$data['lat'].") ) * sin( radians( vendors.lat ) ) ) ) ";
//    $userid = request()->user()->id;
    $vendors = \App\Models\Vendors::where(['status' => '1', 'vendor_type' => 'restaurant', 'is_all_setting_done' => '1'])
        ->select('name', \DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image'), 'vendor_ratings',
            'vendors.id', 'lat', 'long', 'deal_categories', \DB::raw('if(user_vendor_like.user_id is not null, true, false)  as is_like'));
//        ->selectRaw("-({$select},1) AS distance");
    $vendors = $vendors->leftJoin('user_vendor_like', function ($join) {
        $join->on('vendors.id', '=', 'user_vendor_like.vendor_id');
        $join->where('user_vendor_like.user_id', '=', 1);
    });
//    dd("sdfsd");
    $vendors = $vendors->orderBy('vendors.id', 'desc')->get();
dd($vendors);
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
