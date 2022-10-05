<?php

use App\Http\Middleware\isVendorLoginAuth;
use App\Models\Product_master;
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

    $cart_id=6;

    $pro = Product_master::select('cart_products.product_qty','products.product_name','products.product_image','products.category','products.menu_id',
        'products.dis','products.type','products.product_price','products.customizable', 'products.product_for' ,'products.product_rating','products.cuisines',
        'products.addons','variants.id as variant_id','variants.*','cuisines.*','cuisines.id as cuisine_id','addons',
        'cart_product_variants.*',
        'products.id as product_id')
        ->where('products.status', 1)
        ->join('cart_products','products.id','cart_products.product_id')
        ->where('cart_products.cart_id', $cart_id)
        ->leftJoin('variants','products.id','variants.product_id')
        ->leftJoin('cart_product_variants','variants.id','cart_product_variants.variant_id')
        ->leftJoin('cuisines','products.cuisines','cuisines.id')
        ->get()->toArray();
    $responce=[];

    foreach ($pro as $k=>$product){
        if($product['product_id']!=''){

            $responce[$product['product_id']]['product_id']=$product['product_id'];
            $responce[$product['product_id']]['product_name']=$product['product_name'];
            $responce[$product['product_id']]['product_name']=$product['product_name'];
            $responce[$product['product_id']]['product_image']=$product['product_image'];
            $responce[$product['product_id']]['category']=$product['category'];
            $responce[$product['product_id']]['menu_id']=$product['menu_id'];
            $responce[$product['product_id']]['dis']=$product['dis'];
            $responce[$product['product_id']]['type']=$product['type'];
            $responce[$product['product_id']]['product_price']=$product['product_price'];
            $responce[$product['product_id']]['customizable']=$product['customizable'];
            $responce[$product['product_id']]['product_for']=$product['product_for'];
            $responce[$product['product_id']]['product_rating']=$product['product_rating'];
            $responce[$product['product_id']]['addons']=$product['addons'];

            if($product['variant_id']!=''){
                $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_name']=$product['variant_name'];
                $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_price']=$product['variant_price'];
                $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_qty']=$product['variant_qty'];
            }

            if($product['cuisine_id']!=''){
                $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['name']=$product['name'];
                $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['cuisinesImage']=$product['cuisinesImage'];
            }
        }
    }
    foreach ($responce as $i=>$p){

        if(isset($p['variants']))
            $r[$i]['variants']=array_values($p['variants']);

        if(isset($p['cuisines']))
            $r[$i]['cuisines']=array_values($p['cuisines']);

        if($p['addons']!=''){
            $addons=explode(',',$p['addons']);
            $r[$i]['addons']=\App\Models\Addons::select('id','addon','price')->whereIn('id',$addons)->get()->toArray();
        }
        unset($p['variants']);
        unset($p['cuisines']);
        unset($p['addons']);
        $r[$i]=array_merge($r[$i],$p);
    }
$r=array_values($r);

    dd($r);
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
Route::post('check-login-for-admin', [App\Http\Controllers\admin\Cn_login::class, 'admin_login']);

@require_once 'admin_routes.php';


//////////////////////////////////////vendor route ///////////////////////////////////////////////////////////////////////////////////////////////////

Route::view('vendor/login', 'vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::post('check-login-on-vendor', [App\Http\Controllers\vendor\LoginController::class, 'login'])->name('action.vendor.login');
Route::get('vendor-logout', function () {
    Auth::guard('vendor')->logout();
    return redirect()->route('vendor.login');
})->name('vendor.logout');

@require_once 'restaurant_routes.php';

// chef route

Route::get('chef-logout', function () {
    Auth::logout();
    return  redirect()->route('vendor.login');
})->name('chef.logout');

@require_once 'chef_routes.php';


//comon routes for chef and restaurant

//notification
Route::get('notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification.view')->where('id', '[0-9]+');
