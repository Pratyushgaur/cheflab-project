<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isVendorLoginAuth;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin-logout',function(){
    Auth::logout();
    Session::flush();
    return  redirect('admin');
})->name('admin.logout');
Route::view('admin','admin/login-2')->name('admin.login')->middleware('isadminloginAuth');
Route::post('check-login-for-admin',[App\Http\Controllers\admin\Cn_login::class,'admin_login']);

Route::group(['middleware'=>['isAdmin'],'prefix' =>'admin'], function(){
    // City Module 
    Route::get('dashbord-admin', [App\Http\Controllers\admin\Dashboard::class,'index'])->name('admin.dashboard');
    Route::get('city', [App\Http\Controllers\admin\City::class,'index'])->name('city');
    Route::post('city-action', [App\Http\Controllers\admin\City::class,'cityAction'])->name('city.action');
    Route::post('city-update', [App\Http\Controllers\admin\City::class,'update'])->name('city.update');
    Route::get('city-datatable', [App\Http\Controllers\admin\City::class, 'get_data_table_of_city'])->name('city.getDataTable');
    Route::get('check-duplicate-city', [App\Http\Controllers\admin\City::class,'check_duplicate_city'])->name('check-duplicate-city');
    Route::get('check-edit-duplicate-city/{id}', [App\Http\Controllers\admin\City::class,'check_edit_duplicate_city'])->name('check-edit-duplicate-city');
    Route::get('edit-city/{id}', [App\Http\Controllers\admin\City::class, 'fun_edit_city'])->name('fun_edit_city');
    Route::post('city/delete', [App\Http\Controllers\admin\City::class, 'soft_delete'])->name('admin.city.ajax.delete');
    // vendor's
    Route::get('vendors', [App\Http\Controllers\admin\UserControllers::class,'index'])->name('admin.vendors.list');
    Route::get('vendors-datatable', [App\Http\Controllers\admin\UserControllers::class,'get_data_table_of_vendor'])->name('admin.vendors.datatable');
    Route::get('vendors-restourant-create', [App\Http\Controllers\admin\UserControllers::class,'create_restourant'])->name('admin.restourant.create');
    Route::get('vendors-vendors-emailcheck', [App\Http\Controllers\admin\UserControllers::class,'checkEmailExist'])->name('admin.vendor.emailcheck');
    Route::get('vendors-vendors-emailcheck-update/{id}', [App\Http\Controllers\admin\UserControllers::class,'checkEmailExistUpdate'])->name('admin.vendor.emailcheckUpdate');
    Route::get('vendors-vendors-mobilecheck', [App\Http\Controllers\admin\UserControllers::class,'checkMobileExist'])->name('admin.vendor.mobilecheck');
    Route::get('vendors-vendors-mobilecheck-update/{id}', [App\Http\Controllers\admin\UserControllers::class,'checkMobileExistUpdate'])->name('admin.vendor.mobilecheckUpdate');
    Route::post('vendors-restourant-store', [App\Http\Controllers\admin\UserControllers::class,'store_restourant'])->name('admin.restourant.store');
    Route::post('vendors-chef-store-product', [App\Http\Controllers\admin\UserControllers::class,'store_chef_product'])->name('admin.chef.store_product');
    Route::get('admin.chef.edit/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_edit'])->name('admin.chef.edit');
    //
    Route::get('vendors-view/{id}', [App\Http\Controllers\admin\UserControllers::class,'view_vendor'])->name('admin.vendor.view');
    Route::get('vendors-chef-product/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_product'])->name('admin.cherf.product');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_videolink'])->name('admin.cherf.videolink');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_videolink'])->name('admin.cherf.videolink');
    
    //
    Route::get('vendors-view/{id}', [App\Http\Controllers\admin\UserControllers::class,'view_vendor'])->name('admin.vendor.view');
    Route::get('vendors-chef-product/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_product'])->name('admin.cherf.product');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_videolink'])->name('admin.cherf.videolink');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class,'chef_videolink'])->name('admin.cherf.videolink');
    //
    //chef route
    Route::get('vendors-chef-create', [App\Http\Controllers\admin\UserControllers::class,'create_chef'])->name('admin.chef.create');
    Route::post('vendors-chef-store', [App\Http\Controllers\admin\UserControllers::class,'store_chef'])->name('admin.chef.store');
    // categoryies
    Route::get('category', [App\Http\Controllers\admin\Category::class,'index'])->name('admin.category.create');
    Route::post('category', [App\Http\Controllers\admin\Category::class,'store_catogory'])->name('admin.category.store');
    Route::get('category-datatable', [App\Http\Controllers\admin\Category::class,'get_data_table_of_category'])->name('admin.category.datatable');
    Route::get('edit-category/{id}', [App\Http\Controllers\admin\Category::class, 'fun_edit_category']);
    Route::post('category/delete', [App\Http\Controllers\admin\Category::class, 'soft_delete'])->name('admin.category.ajax.delete');
    Route::post('category-update', [App\Http\Controllers\admin\Category::class,'update'])->name('admin.category.update');
    Route::get('check-duplicate-category', [App\Http\Controllers\admin\Category::class,'check_duplicate_category'])->name('check-duplicate-category');
    Route::get('check-edit_duplicate-category/{id}', [App\Http\Controllers\admin\Category::class,'check_edit_duplicate_category'])->name('check-edit_duplicate-category');
    // cuisiness
    Route::get('cuisines', [App\Http\Controllers\admin\CuisinesController::class,'index'])->name('admin.cuisines.create');
    Route::post('cuisines', [App\Http\Controllers\admin\CuisinesController::class,'store_cuisines'])->name('admin.cuisines.store');
    Route::get('cuisines-datatable', [App\Http\Controllers\admin\CuisinesController::class,'get_data_table_of_cuisines'])->name('admin.cuisines.datatable');
    Route::get('edit-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'fun_edit_category']);
    Route::post('cuisines-update', [App\Http\Controllers\admin\CuisinesController::class,'update'])->name('admin.cuisines.update');
    Route::post('cuisines/delete', [App\Http\Controllers\admin\CuisinesController::class, 'soft_delete'])->name('admin.cuisines.ajax.delete');
    Route::get('edit-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'fun_edit_cuisines'])->name('admin.cuisines.edit');
    Route::get('check-duplicate-cuisines', [App\Http\Controllers\admin\CuisinesController::class,'check_duplicate_cuisines'])->name('check-duplicate-cuisines');
    Route::get('check-edit_duplicate-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class,'check_edit_duplicate_cuisines'])->name('check-edit_duplicate-cuisines');
    // product routes
    Route::get('products', [App\Http\Controllers\admin\ProductController::class,'index'])->name('admin.product.create');
    Route::get('vendor/products/create/{id}', [App\Http\Controllers\admin\ProductController::class,'index'])->name('admin.vendor.product.create');
    Route::get('vendors-chef-product-list/{id}', [App\Http\Controllers\admin\UserControllers::class,'view_chefproduct'])->name('admin.chefproduct.view');
    // Delivery Boy
    Route::get('delivery-boy', [App\Http\Controllers\admin\Deliveryboy::class,'index'])->name('admin.deliverboy.list');
    Route::get('delivery-boy-create', [App\Http\Controllers\admin\Deliveryboy::class,'create_deliverboy'])->name('admin.deliverboy.create');
    Route::post('delivery-boy-store', [App\Http\Controllers\admin\Deliveryboy::class,'store_deliverboy'])->name('admin.diliverboy.store');
    Route::get('deliverboy-datatable', [App\Http\Controllers\admin\Deliveryboy::class,'get_data_table_of_deliverboy'])->name('admin.deliverboy.datatable');
    Route::get('edit-deliverboy/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'fun_edit_deliverboy'])->name('admin.deliverboy.view');
    Route::get('delivery-boy-emailcheck', [App\Http\Controllers\admin\Deliveryboy::class,'checkEmailExist'])->name('admin.deliverboy.emailcheck');
    Route::get('delivery-boy-mobilecheck', [App\Http\Controllers\admin\Deliveryboy::class,'checkMobileExist'])->name('admin.deliverboy.mobilecheck');
    Route::get('delivery-boy-emailcheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class,'checkEmailExistUpdate'])->name('admin.deliverboy.emailcheck_update');
    Route::get('delivery-boy-mobilecheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class,'checkMobileExistUpdate'])->name('admin.deliverboy.mobilecheck.update');
    Route::post('delivery-boy-update', [App\Http\Controllers\admin\Deliveryboy::class,'update'])->name('admin.deliverboy.update');
    Route::post('delivery-boy/delete', [App\Http\Controllers\admin\Deliveryboy::class, 'soft_delete'])->name('admin.deliverboy.ajax.delete');
    
});

// vendor route
Route::view('vendor/login','vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::post('check-login-on-vendor',[App\Http\Controllers\vendor\LoginController::class,'login'])->name('action.vendor.login');
Route::get('vendor-logout',function(){
    Auth::logout();
    Session::flush();
    return  redirect()->route('vendor.login');
})->name('vendor.logout');
// vendor auth route
Route::group(['middleware'=>['isVendor'],'prefix' =>'vendor'], function(){
    // restaurant route
    Route::group(['prefix' =>'restaurant','middleware' => 'isRestaurant'], function(){
        Route::get('dashbord', [App\Http\Controllers\vendor\restaurant\DashboardController::class,'index'])->name('restaurant.dashboard');
        Route::get('menus', [App\Http\Controllers\vendor\restaurant\MenuController::class,'index'])->name('restaurant.menu.list');
        Route::get('menus/create', [App\Http\Controllers\vendor\restaurant\MenuController::class,'create'])->name('restaurant.menu.create');
        Route::post('menus/create', [App\Http\Controllers\vendor\restaurant\MenuController::class,'store'])->name('restaurant.menu.store');
        Route::get('menus/datatable/list', [App\Http\Controllers\vendor\restaurant\MenuController::class,'getData'])->name('restaurant.menu.datatable');
        //vendor product
        Route::get('product', [App\Http\Controllers\vendor\restaurant\ProductController::class,'index'])->name('restaurant.product.list');
        Route::get('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class,'create'])->name('restaurant.product.create');
        Route::post('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class,'store'])->name('restaurant.product.store');
        Route::get('product/datatable/list', [App\Http\Controllers\vendor\restaurant\ProductController::class,'getData'])->name('restaurant.product.datatable');
        Route::get('product/addon/list', [App\Http\Controllers\vendor\restaurant\ProductController::class,'addons'])->name('restaurant.product.addon');
        Route::get('product/addon/datatable', [App\Http\Controllers\vendor\restaurant\ProductController::class,'getAddonData'])->name('restaurant.product.addon.datatable');
        Route::get('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class,'createAddon'])->name('restaurant.product.addon.create');
        Route::post('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class,'storeAddon'])->name('restaurant.product.addon.store');


        
    });
    // restaurant route
    
});