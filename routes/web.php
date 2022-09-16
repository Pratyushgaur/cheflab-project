<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isVendorLoginAuth;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\isChefLoginAuth;
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
Route::get('admin-logout', function () {

    Auth::guard('admin')->logout();
    //Session::flush();
    return  redirect('admin');
})->name('admin.logout');
Route::view('admin', 'admin/login-2')->name('admin.login')->middleware('isadminloginAuth');
Route::post('check-login-for-admin', [App\Http\Controllers\admin\Cn_login::class, 'admin_login']);

Route::group(['middleware' => ['isAdmin'], 'prefix' => 'admin'], function () {
    // City Module
    Route::get('dashbord-admin', [App\Http\Controllers\admin\Dashboard::class, 'index'])->name('admin.dashboard');
    Route::get('city', [App\Http\Controllers\admin\City::class, 'index'])->name('city');
    Route::post('city-action', [App\Http\Controllers\admin\City::class, 'cityAction'])->name('city.action');
    Route::post('city-update', [App\Http\Controllers\admin\City::class, 'update'])->name('city.update');
    Route::get('city-datatable', [App\Http\Controllers\admin\City::class, 'get_data_table_of_city'])->name('city.getDataTable');
    Route::get('check-duplicate-city', [App\Http\Controllers\admin\City::class, 'check_duplicate_city'])->name('check-duplicate-city');
    Route::get('check-edit-duplicate-city/{id}', [App\Http\Controllers\admin\City::class, 'check_edit_duplicate_city'])->name('check-edit-duplicate-city');
    Route::get('edit-city/{id}', [App\Http\Controllers\admin\City::class, 'fun_edit_city'])->name('fun_edit_city');
    Route::post('city/delete', [App\Http\Controllers\admin\City::class, 'soft_delete'])->name('admin.city.ajax.delete');
    // vendor's
    Route::get('vendors', [App\Http\Controllers\admin\UserControllers::class, 'index'])->name('admin.vendors.list');
    Route::get('vendors-datatable', [App\Http\Controllers\admin\UserControllers::class, 'get_data_table_of_vendor'])->name('admin.vendors.datatable');
    Route::get('vendors-restourant-create', [App\Http\Controllers\admin\UserControllers::class, 'create_restourant'])->name('admin.restourant.create');
    Route::get('vendors-vendors-emailcheck', [App\Http\Controllers\admin\UserControllers::class, 'checkEmailExist'])->name('admin.vendor.emailcheck');
    Route::get('vendors-vendors-emailcheck-update/{id}', [App\Http\Controllers\admin\UserControllers::class, 'checkEmailExistUpdate'])->name('admin.vendor.emailcheckUpdate');
    Route::get('vendors-vendors-mobilecheck', [App\Http\Controllers\admin\UserControllers::class, 'checkMobileExist'])->name('admin.vendor.mobilecheck');
    Route::get('vendors-vendors-mobilecheck-update/{id}', [App\Http\Controllers\admin\UserControllers::class, 'checkMobileExistUpdate'])->name('admin.vendor.mobilecheckUpdate');
    Route::post('vendors-restourant-store', [App\Http\Controllers\admin\UserControllers::class, 'store_restourant'])->name('admin.restourant.store');
    Route::post('vendors-chef-store-product', [App\Http\Controllers\admin\UserControllers::class, 'store_chef_product'])->name('admin.chef.store_product');
    Route::get('admin.chef.edit/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_edit'])->name('admin.chef.edit');
    Route::post('vendors/delete', [App\Http\Controllers\admin\UserControllers::class, 'soft_delete'])->name('admin.vendors.ajax.delete');
    Route::post('vendors/product/delete', [App\Http\Controllers\admin\ProductController::class, 'soft_delete'])->name('admin.product.ajax.delete');
    //
    Route::get('vendors-view/{id}', [App\Http\Controllers\admin\UserControllers::class, 'view_vendor'])->name('admin.vendor.view');
    Route::get('vendors-chef-product/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_product'])->name('admin.cherf.product');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videolink'])->name('admin.cherf.videolink');
    Route::get('vendors-chef-video-list/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videolist'])->name('admin.cherf.video.link');
    Route::get('vendors-chef-video-edit/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videoedit'])->name('admin.chef.videoedit');
    Route::post('vendors-chef-video-update', [App\Http\Controllers\admin\UserControllers::class, 'updateVideo'])->name('admin.chef.video.update');
    Route::post('vendors-chef-video-delete', [App\Http\Controllers\admin\UserControllers::class, 'soft_delete_video'])->name('admin.chef.video.ajax.delete');
    //
    //chef route
    Route::get('vendors-chef-create', [App\Http\Controllers\admin\UserControllers::class, 'create_chef'])->name('admin.chef.create');
    Route::post('vendors-chef-store', [App\Http\Controllers\admin\UserControllers::class, 'store_chef'])->name('admin.chef.store');
    Route::post('vendors-update', [App\Http\Controllers\admin\UserControllers::class, 'vendors_update'])->name('admin.vendors.update');
    Route::post('vendors-chef-video', [App\Http\Controllers\admin\UserControllers::class, 'addVideo'])->name('admin.chef.video.add');
    Route::get('vendors-chef-productlist/{userId}', [App\Http\Controllers\admin\UserControllers::class, 'chef_product_list'])->name('admin.chef.productlist');
    Route::get('vendors-chef-productlists/{id}', [App\Http\Controllers\admin\UserControllers::class, 'product_list'])->name('admin.chef.productlists');
    Route::get('vendors-chef-productedit/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_product_edit'])->name('admin.chef.productedit');
    // categoryies
    Route::get('category', [App\Http\Controllers\admin\Category::class, 'index'])->name('admin.category.create');
    Route::post('category', [App\Http\Controllers\admin\Category::class, 'store_catogory'])->name('admin.category.store');
    Route::get('category-datatable', [App\Http\Controllers\admin\Category::class, 'get_data_table_of_category'])->name('admin.category.datatable');
    Route::get('edit-category/{id}', [App\Http\Controllers\admin\Category::class, 'fun_edit_category']);
    Route::post('category/delete', [App\Http\Controllers\admin\Category::class, 'soft_delete'])->name('admin.category.ajax.delete');
    Route::post('category-update', [App\Http\Controllers\admin\Category::class, 'update'])->name('admin.category.update');
    Route::get('check-duplicate-category', [App\Http\Controllers\admin\Category::class, 'check_duplicate_category'])->name('check-duplicate-category');
    Route::get('check-edit_duplicate-category/{id}', [App\Http\Controllers\admin\Category::class, 'check_edit_duplicate_category'])->name('check-edit_duplicate-category');
    // cuisiness
    Route::get('cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'index'])->name('admin.cuisines.create');
    Route::post('cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'store_cuisines'])->name('admin.cuisines.store');
    Route::get('cuisines-datatable', [App\Http\Controllers\admin\CuisinesController::class, 'get_data_table_of_cuisines'])->name('admin.cuisines.datatable');
    Route::get('edit-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'fun_edit_cuisines'])->name('admin.cuisines.edit');
    Route::post('cuisines-update', [App\Http\Controllers\admin\CuisinesController::class, 'update'])->name('admin.cuisines.update');
    Route::post('cuisines/delete', [App\Http\Controllers\admin\CuisinesController::class, 'soft_delete'])->name('admin.cuisines.ajax.delete');
    Route::get('check-duplicate-cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'check_duplicate_cuisines'])->name('check-duplicate-cuisines');
    Route::get('check-edit_duplicate-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'check_edit_duplicate_cuisines'])->name('check-edit_duplicate-cuisines');

    // product routes
    Route::get('products', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.product.create');
    Route::get('vendor/products/create/{id}', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.vendor.product.create');
    Route::get('vendors-chef-product-list/{id}', [App\Http\Controllers\admin\UserControllers::class, 'view_chefproduct'])->name('admin.chefproduct.view');
    //chef lAB PRODUCT
    Route::get('cheflab-products', [App\Http\Controllers\admin\ProductController::class, 'cheflabProduct'])->name('admin.product.cheflabProduct');
    Route::get('cheflab-products-create', [App\Http\Controllers\admin\ProductController::class, 'createChefLabProduct'])->name('admin.product.cheflabProduct.create');
    Route::post('cheflab-products-store', [App\Http\Controllers\admin\ProductController::class, 'storeChefLabProduct'])->name('admin.product.cheflabProduct.store');
    Route::get('cheflab-products-list', [App\Http\Controllers\admin\ProductController::class, 'cheflab_product_list'])->name('admin.product.cheflabProduct.list');
    // Delivery Boy
    Route::get('delivery-boy', [App\Http\Controllers\admin\Deliveryboy::class, 'index'])->name('admin.deliverboy.list');
    Route::get('delivery-boy-create', [App\Http\Controllers\admin\Deliveryboy::class, 'create_deliverboy'])->name('admin.deliverboy.create');
    Route::post('delivery-boy-store', [App\Http\Controllers\admin\Deliveryboy::class, 'store_deliverboy'])->name('admin.diliverboy.store');
    Route::get('deliverboy-datatable', [App\Http\Controllers\admin\Deliveryboy::class, 'get_data_table_of_deliverboy'])->name('admin.deliverboy.datatable');
    Route::get('edit-deliverboy/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'fun_edit_deliverboy'])->name('admin.deliverboy.view');
    Route::get('delivery-boy-emailcheck', [App\Http\Controllers\admin\Deliveryboy::class, 'checkEmailExist'])->name('admin.deliverboy.emailcheck');
    Route::get('delivery-boy-mobilecheck', [App\Http\Controllers\admin\Deliveryboy::class, 'checkMobileExist'])->name('admin.deliverboy.mobilecheck');
    Route::get('delivery-boy-emailcheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'checkEmailExistUpdate'])->name('admin.deliverboy.emailcheck_update');
    Route::get('delivery-boy-mobilecheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'checkMobileExistUpdate'])->name('admin.deliverboy.mobilecheck.update');
    Route::post('delivery-boy-update', [App\Http\Controllers\admin\Deliveryboy::class, 'update'])->name('admin.deliverboy.update');
    Route::post('delivery-boy/delete', [App\Http\Controllers\admin\Deliveryboy::class, 'soft_delete'])->name('admin.deliverboy.ajax.delete');
    //Coupons
    Route::get('coupon', [App\Http\Controllers\admin\CouponController::class, 'index'])->name('admin.coupon.list');
    Route::get('coupon-list', [App\Http\Controllers\admin\CouponController::class, 'get_data_table_of_coupon'])->name('admin.coupon.data');
    Route::get('coupon-create', [App\Http\Controllers\admin\CouponController::class, 'create_coupon'])->name('admin.coupon.create');
    Route::post('coupon-store', [App\Http\Controllers\admin\CouponController::class, 'store_coupon'])->name('admin.coupon.store');
    Route::get('coupon-couponcheck', [App\Http\Controllers\admin\CouponController::class, 'checkCoupon'])->name('admin.coupon.couponcheck');
    Route::get('coupon-upercase', [App\Http\Controllers\admin\CouponController::class, 'upercase'])->name('admin.coupon.upercase');
    Route::get('coupon-couponcheckUpdate/{id}', [App\Http\Controllers\admin\CouponController::class, 'checkCouponUpdate'])->name('admin.coupon.couponcheckedit');
    Route::get('coupon-edit/{id}', [App\Http\Controllers\admin\CouponController::class, 'fun_edit_coupon'])->name('admin.coupon.edit');
    Route::post('coupon-update', [App\Http\Controllers\admin\CouponController::class, 'update'])->name('admin.coupon.update');
    Route::post('coupon-delete', [App\Http\Controllers\admin\CouponController::class, 'soft_delete'])->name('admin.coupon.delete');
});
//////////////////////////////////////vendor route ///////////////////////////////////////////////////////////////////////////////////////////////////

Route::view('vendor/login', 'vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::post('check-login-on-vendor', [App\Http\Controllers\vendor\LoginController::class, 'login'])->name('action.vendor.login');
Route::get('vendor-logout', function () {
    Auth::guard('vendor')->logout();
    return  redirect()->route('vendor.login');
})->name('vendor.logout');
// vendor auth route
Route::group(['middleware' => ['isVendor'], 'prefix' => 'vendor'], function () {
    // restaurant route
    Route::group(['prefix' => 'restaurant', 'middleware' => ['isRestaurant']], function () {
        Route::group(['middleware' => 'IsVendorDoneSettingsMiddleware'], function () {
            Route::get('dashbord', [App\Http\Controllers\vendor\restaurant\DashboardController::class, 'index'])->name('restaurant.dashboard');

            Route::get('menus', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'index'])->name('restaurant.menu.list');
            Route::get('menus/create', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'create'])->name('restaurant.menu.create');
            Route::post('menus/create', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'store'])->name('restaurant.menu.store');
            Route::get('menus/datatable/list', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'getData'])->name('restaurant.menu.datatable');
            Route::get('menus/edit/{id}', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'menu_edit'])->name('restaurant.menu.edit');
            Route::post('menus/update', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'update'])->name('restaurant.menu.update');
            Route::get('menus/duplicate_menu', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'check_duplicate_menu'])->name('restaurant.menu.check_duplicate');
            Route::get('menus/edit/duplicate_menu/{id}', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'check_edit_duplicate_menu'])->name('restaurant.menu.check_duplicate.edit');
            //vendor product
            Route::get('product', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'index'])->name('restaurant.product.list');
            Route::get('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'create'])->name('restaurant.product.create');
            Route::post('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'store'])->name('restaurant.product.store');
            Route::get('product/datatable/list', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'getData'])->name('restaurant.product.datatable');
            Route::get('product/addon/list', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'addons'])->name('restaurant.product.addon');
            Route::get('product/addon/datatable', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'getAddonData'])->name('restaurant.product.addon.datatable');
            Route::get('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'createAddon'])->name('restaurant.product.addon.create');
            Route::post('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'storeAddon'])->name('restaurant.product.addon.store');
            //vendor order linst
            Route::get('order', [App\Http\Controllers\vendor\restaurant\OrderController::class, 'index'])->name('restaurant.order.list');
            Route::get('order/datatable/list', [App\Http\Controllers\vendor\restaurant\OrderController::class, 'getData'])->name('order.datatable');

            //coupon
            Route::get('coupon', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'index'])->name('restaurant.coupon.list');
            Route::get('coupon-list', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'get_data_table_of_coupon'])->name('restaurant.coupon.data');
            Route::get('coupon-create', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'create_coupon'])->name('restaurant.coupon.create');
            Route::post('coupon-store', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'store_coupon'])->name('restaurant.coupon.store');
            Route::get('coupon-couponcheck', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'checkCoupon'])->name('restaurant.coupon.couponcheck');
            Route::get('coupon-couponcheckUpdate/{id}', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'checkCouponUpdate'])->name('restaurant.coupon.couponcheckedit');
            Route::get('coupon-edit/{id}', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'fun_edit_coupon'])->name('restaurant.coupon.edit');
            Route::post('coupon-update', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'update'])->name('restaurant.coupon.update');
            Route::post('coupon-delete', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'soft_delete'])->name('restaurant.coupon.delete');
            Route::post('restaurent_status', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'restaurent_status'])->name('restaurant.restaurent_status');

            // vendor globle setting
            Route::get('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'order_time'])->name('restaurant.globleseting.ordertime');
            Route::post('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'store'])->name('restaurant.ordertime.store');
            Route::post('offline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_offline'])->name('restaurant.set_offline');
            Route::post('online', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_online'])->name('restaurant.set_online');
            Route::get('isonline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'restaurent_get_status'])->name('restaurant.restaurent_get_status');

            //vendor location
            Route::get('globle/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'vendor_location'])->name('restaurant.globleseting.vendor_location');
            Route::post('globle/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_vendor_location'])->name('restaurant.globleseting.save_vendor_location');
        });
        Route::get('globle', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'index'])->name('restaurant.globleseting');


        //first time setting
        Route::get('globle/require/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'requireOrderTime'])->name('restaurant.require.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'store'])->name('restaurant.ordertime.first_store');


        //first time vendor location save
        Route::get('globle/require/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'first_vendor_location'])->name('restaurant.globleseting.frist_vendor_location');
        Route::post('globle/require/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_vendor_location'])->name('restaurant.globleseting.frist_save_vendor_location');
        
        // first time Banner or logo setup
        Route::get('globle/require/logo', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'first_vendor_Logo'])->name('restaurant.globleseting.first_vendor_logo');
        Route::post('globle/require/logo', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_vendor_Logo'])->name('restaurant.globleseting.save_vendor_logo');

    });
});
// chef route
//Route::view('vendor/login', 'vendor/login')->name('chef.login')->middleware(isVendorLoginAuth::class);
Route::get('chef-logout', function () {
    Auth::logout();
    return  redirect()->route('vendor.login');
})->name('chef.logout');

Route::group(['middleware' => ['isChef'], 'prefix' => 'chef'], function () {
    // restaurant route
    Route::group(['prefix' => 'chef', 'middleware' => 'isChefRestaurant'], function () {
        Route::get('dashbord', [App\Http\Controllers\chef\DashboardController::class, 'index'])->name('chef.dashboard');
        //chef order linst
        Route::get('order', [App\Http\Controllers\chef\OrderController::class, 'index'])->name('order.list');
        Route::get('order/datatable/list', [App\Http\Controllers\chef\OrderController::class, 'getData'])->name('order.datatable');
        // vendor globle setting
        Route::get('globle', [App\Http\Controllers\chef\GlobleSetting::class, 'index'])->name('chef.globleseting');
        Route::get('globle/ordertime', [App\Http\Controllers\chef\GlobleSetting::class, 'order_time'])->name('chef.globleseting.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\chef\GlobleSetting::class, 'store'])->name('chef.ordertime.store');
        //coupon
        Route::get('coupon', [App\Http\Controllers\chef\VendorCoupon::class, 'index'])->name('chef.coupon.list');
        Route::get('coupon-list', [App\Http\Controllers\chef\VendorCoupon::class, 'get_data_table_of_coupon'])->name('chef.coupon.data');
        Route::get('coupon-create', [App\Http\Controllers\chef\VendorCoupon::class, 'create_coupon'])->name('chef.coupon.create');
        Route::post('coupon-store', [App\Http\Controllers\chef\VendorCoupon::class, 'store_coupon'])->name('chef.coupon.store');
        Route::get('coupon-couponcheck', [App\Http\Controllers\chef\VendorCoupon::class, 'checkCoupon'])->name('chef.coupon.couponcheck');
        Route::get('coupon-couponcheckUpdate/{id}', [App\Http\Controllers\chef\VendorCoupon::class, 'checkCouponUpdate'])->name('chef.coupon.couponcheckedit');
        Route::get('coupon-edit/{id}', [App\Http\Controllers\chef\VendorCoupon::class, 'fun_edit_coupon'])->name('chef.coupon.edit');
        Route::post('coupon-update', [App\Http\Controllers\chef\VendorCoupon::class, 'update'])->name('chef.coupon.update');
        Route::post('coupon-delete', [App\Http\Controllers\chef\VendorCoupon::class, 'soft_delete'])->name('chef.coupon.delete');
    });
});
