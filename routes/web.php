<?php

use App\Http\Middleware\isVendorLoginAuth;
use App\Models\vendors;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



//use PubNub\PubNub;
//use PubNub\Enums\PNStatusCategory;
//use PubNub\Callbacks\SubscribeCallback;
//use PubNub\PNConfiguration;

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
    $vendor_id=1;
    \DB::enableQueryLog();

//    dd(\DB::getQueryLog ());
});


Route::get('/', function () {
    return view('welcome');
});
Route::get('admin-logout', function () {

    Auth::guard('admin')->logout();
    //Session::flush();
    return redirect('admin');
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
    Route::get('edit-category/{id}', [App\Http\Controllers\admin\Category::class, 'fun_edit_category'])->name('admin.category.edit');;
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
    
    // Banner Promotion
    Route::get('banner-promotion', [App\Http\Controllers\admin\BannerController::class, 'index'])->name('admin.banner.createbanner');
    Route::get('banner-list', [App\Http\Controllers\admin\BannerController::class, 'get_data_table_of_slote'])->name('admin.slot.data');
    Route::get('banner-slot-edit/{id}', [App\Http\Controllers\admin\BannerController::class, 'fun_edit_slot'])->name('admin.slot.edit');
    Route::post('banner-slot-update', [App\Http\Controllers\admin\BannerController::class, 'updateSlot'])->name('admin.slot.update');
    Route::get('banner-slot-check/{id}', [App\Http\Controllers\admin\BannerController::class, 'slotCheck'])->name('admin.slot.check');
    Route::post('banner-store', [App\Http\Controllers\admin\BannerController::class, 'store_banner'])->name('admin.banner.store');
    Route::get('banner-chek', [App\Http\Controllers\admin\BannerController::class, 'check_duplicate_slotename'])->name('admin.banner.slotcheck');
    Route::get('banner-chektime', [App\Http\Controllers\admin\BannerController::class, 'checktime'])->name('admin.banner.slotchecktime');
    Route::get('banner-slot-list', [App\Http\Controllers\admin\BannerController::class, 'slot_book_list'])->name('admin.slotebook.list');
    Route::get('banner-slot-data', [App\Http\Controllers\admin\BannerController::class, 'get_list_slotbook'])->name('admin.slotebook.data');
    Route::get('banner-slot-view/{id}', [App\Http\Controllers\admin\BannerController::class, 'slotView'])->name('admin.slot.view');
    Route::get('banner-slot-lists/{id}', [App\Http\Controllers\admin\BannerController::class, 'getVendorBanner'])->name('admin.slot.list');
    Route::get('banner-slot-active/{slot_id}', [App\Http\Controllers\admin\BannerController::class, 'active'])->name('admin.slot.active');
    Route::get('banner-slot-reject/{slot_id}', [App\Http\Controllers\admin\BannerController::class, 'reject'])->name('admin.slot.reject');
    Route::get('banner-slot-comment/{slot_id}', [App\Http\Controllers\admin\BannerController::class, 'comment'])->name('admin.slot.comment');
    Route::post('banner-commentstore', [App\Http\Controllers\admin\BannerController::class,'commentstore'])->name('admin.banner.commentstore');
    Route::post('banner-slot-reject', [App\Http\Controllers\admin\BannerController::class, 'rejectProduct'])->name('admin.slot.reject');
   // Root Banner
   Route::get('banner-root-banner', [App\Http\Controllers\admin\AdminRootBannerController::class, 'index'])->name('admin.root.banner');
   Route::get('root-image', [App\Http\Controllers\admin\AdminRootBannerController::class, 'get_data_table_of_slote'])->name('admin.root.data');
   Route::get('root-image-edit/{id}', [App\Http\Controllers\admin\AdminRootBannerController::class, 'fun_edit_image'])->name('admin.rootimage.edit'); 
   Route::post('root-image-update', [App\Http\Controllers\admin\AdminRootBannerController::class, 'updateBanner'])->name('admin.root.update');
   // Vendor Store Promotion
    Route::get('vendor-promotion', [App\Http\Controllers\admin\VendorPromotion::class, 'index'])->name('admin.vendor.store');
    Route::post('vendor-promotion/create', [App\Http\Controllers\admin\VendorPromotion::class, 'store'])->name('admin.vendorstore.store');
    Route::get('vendor-promotion-list', [App\Http\Controllers\admin\VendorPromotion::class,'get_data_table_of_slote'])->name('admin.vendorstore.data');
    // Vender Pendig Product List
    Route::get('vendor-products-list', [App\Http\Controllers\admin\ProductController::class, 'vendorProductList'])->name('admin.vendor.pendigProduct');
    Route::get('vendor-products-pedingdata', [App\Http\Controllers\admin\ProductController::class, 'getPendingList'])->name('admin.product.pendingdata');
    Route::get('vendors-product-list/{id}', [App\Http\Controllers\admin\ProductController::class, 'view_product'])->name('admin.vendor.product');
    Route::get('vendors-product-data/{id}', [App\Http\Controllers\admin\ProductController::class, 'venderProduct'])->name('admin.vendor.productList');
    Route::post('vendors-product-dataid', [App\Http\Controllers\admin\ProductController::class, 'venderId'])->name('admin.vendor.getId');
    Route::post('vendor-products-active', [App\Http\Controllers\admin\ProductController::class, 'activeProduct'])->name('admin.vendor.productactive');
    Route::post('vendor-products-reject', [App\Http\Controllers\admin\ProductController::class, 'rejectProduct'])->name('admin.product.reject');
    
});
//////////////////////////////////////vendor route ///////////////////////////////////////////////////////////////////////////////////////////////////

Route::view('vendor/login', 'vendor/login')->name('vendor.login')->middleware(isVendorLoginAuth::class);
Route::post('check-login-on-vendor', [App\Http\Controllers\vendor\LoginController::class, 'login'])->name('action.vendor.login');
Route::get('vendor-logout', function () {
    Auth::guard('vendor')->logout();
    return redirect()->route('vendor.login');
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
            Route::post('product/inactive', [App\Http\Controllers\vendor\restaurant\ProductController::class,'inActive'])->name('restaurant.product.inactive');
            Route::post('product/active', [App\Http\Controllers\vendor\restaurant\ProductController::class,'Active'])->name('restaurant.product.active');
            Route::get('product/edit/{id}', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'fun_edit_product'])->name('vendor.product.edit');
            Route::post('product/update', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'update'])->name('restaurant.product.update');
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
            Route::post('coupon/inactive', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class,'inActive'])->name('restaurant.coupon.inactive');
            Route::post('coupon/active', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class,'Active'])->name('restaurant.coupon.active');
            Route::get('coupon-datecheck/{id}', [App\Http\Controllers\vendor\restaurant\VendorCoupon::class, 'checkCouponDate'])->name('restaurant.coupon.datechke');
            // vendor globle setting
            Route::get('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'order_time'])->name('restaurant.globleseting.ordertime');
            Route::post('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'store'])->name('restaurant.ordertime.store');
            Route::post('offline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_offline'])->name('restaurant.set_offline');
            Route::post('online', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_online'])->name('restaurant.set_online');
            Route::get('isonline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'restaurent_get_status'])->name('restaurant.restaurent_get_status');

            //vendor location
            Route::get('globle/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'vendor_location'])->name('restaurant.globleseting.vendor_location');
            Route::post('globle/location', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_vendor_location'])->name('restaurant.globleseting.save_vendor_location');
            //promotion management
            Route::get('on-screen-notification', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'index'])->name('restaurant.promotion.list');
            Route::get('on-screen-create', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'create_promotion'])->name('restaurant.promotion.create');
            Route::post('on-screen-store', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'store_slot'])->name('restaurant.slot.store');
            Route::get('on-screen-DATA', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'selctvalue'])->name('restaurant.slot.data');
            Route::get('on-screen-data', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'get_list_slotbook'])->name('restaurant.slot.list');
            Route::post('on-screen-checkdate', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'checkdate'])->name('restaurant.slot.checkdate');
            Route::post('on-screen-getprice', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'getPrice'])->name('restaurant.slot.getPrice');
            Route::get('on-screen-slot', [App\Http\Controllers\vendor\restaurant\VendorPromotion::class,'getslot'])->name('restaurant.slot.checkslot');
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

Route::get('chef-logout', function () {
    Auth::logout();
    return redirect()->route('vendor.login');
})->name('chef.logout');

Route::group(['middleware' => ['isChef'], 'prefix' => 'chef'], function () {
    // chef route
   // Route::group(['middleware' => 'isChefRestaurant'], function () {
       // Route::group(['middleware' => 'IsVendorDoneSettingsMiddleware'], function () {
            Route::get('dashbord', [App\Http\Controllers\chef\DashboardController::class, 'index'])->name('chef.dashboard');
            //chef order linst
            Route::get('order', [App\Http\Controllers\chef\OrderController::class, 'index'])->name('order.list');
            Route::get('order/datatable/list', [App\Http\Controllers\chef\OrderController::class, 'getData'])->name('order.datatable');
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
            //vendor product
            Route::get('product-list', [App\Http\Controllers\chef\ChefProductController::class, 'index'])->name('chef.product.list');
            Route::get('product/datatable/list', [App\Http\Controllers\chef\ChefProductController::class, 'getData'])->name('chef.product.datatable');
            Route::post('product/inactive', [App\Http\Controllers\chef\ChefProductController::class,'inActive'])->name('chef.product.inactive');
            //promotion management
            Route::get('chef-promotion', [App\Http\Controllers\chef\VendorPromotion::class,'index'])->name('chef.promotion.list');
            Route::get('on-screen-create', [App\Http\Controllers\chef\VendorPromotion::class,'create_promotion'])->name('chef.promotion.create');
            Route::post('on-screen-store', [App\Http\Controllers\chef\VendorPromotion::class,'store_slot'])->name('chef.slot.store');
            Route::get('on-screen-DATA', [App\Http\Controllers\chef\VendorPromotion::class,'selctvalue'])->name('chef.slot.data');
            Route::get('on-screen-data', [App\Http\Controllers\chef\VendorPromotion::class,'get_list_slotbook'])->name('chef.slot.list');
            Route::post('on-screen-checkdate', [App\Http\Controllers\chef\VendorPromotion::class,'checkdate'])->name('chef.slot.checkdate');
            Route::post('on-screen-getprice', [App\Http\Controllers\chef\VendorPromotion::class,'getPrice'])->name('chef.slot.getPrice');
            Route::get('on-screen-slot', [App\Http\Controllers\chef\VendorPromotion::class,'getslot'])->name('chef.slot.checkslot');
        
        
        //});


        Route::get('globle', [App\Http\Controllers\chef\GlobleSetting::class, 'index'])->name('chef.globleseting');
        Route::get('globle/ordertime', [App\Http\Controllers\chef\GlobleSetting::class, 'order_time'])->name('chef.globleseting.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\chef\GlobleSetting::class, 'store'])->name('chef.ordertime.store');
        //
        Route::get('globle/require/ordertime', [App\Http\Controllers\chef\GlobleSetting::class, 'requireOrderTime'])->name('chef.require.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\vendor\chef\GlobleSetting::class, 'store'])->name('chef.ordertime.first_store');
    

    //});
});
