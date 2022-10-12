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
    $vendor_ids = [ '1', '2' ];

    $current_time = mysql_time();
    $current_date = mysql_date_time();

    $slots = \App\Models\SloteBook::rightJoin('cheflab_banner_image', 'cheflab_banner_image.id', '=', 'slotbooking_table.cheflab_banner_image_id')
        ->where([ 'cheflab_banner_image.is_active' => '1' ])
        ->whereOr(function($q) use ($vendor_ids,$current_date,$current_time){
            $q->whereIn('vendor_id', $vendor_ids)
                ->where('from_date', '<=', $current_date)
                ->where('to_date', '>=', $current_date)
                ->where('from_time', '<=', $current_time)
                ->where('to_time', '>=', $current_time)
                ->where([ 'slotbooking_table.is_active' => '1' ]);

        })
      ->selectRaw('slot_id,CONCAT("' . asset('slot-vendor-image') . '/", slot_image) AS slot_image,CONCAT("' . asset('slot-vendor-image') . '/", bannerImage) AS bannerImage,'
//        .'from_date,to_date,name,slotbooking_table.id as slot_id,cheflab_banner_image.id as banner_id,slotbooking_table.price as slot_price,cheflab_banner_image.price as banner_price,'
        .'cheflab_banner_image.position as banner_position')
        ->orderBy('cheflab_banner_image.position','asc')
        ->get();
//    ->toArray();

    $response=[];
    foreach ($slots as $k=>$slot){
        if($slot->slot_id!='')
            $response[]=['image'=>$slot->slot_image,'position'=>$slot->banner_position];
        else
            $response[]=['image'=>$slot->bannerImage,'position'=>$slot->banner_position];
    }

    dd($slots);
    DB::enableQueryLog();

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
