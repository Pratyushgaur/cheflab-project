<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:sanctum'], function () {
    // master
    Route::get('getCategories', [App\Http\Controllers\api\AppMasterController::class, 'getCategories']);
    Route::get('getCuisines', [App\Http\Controllers\api\AppMasterController::class, 'getCuisines']);
    Route::post('getProductDetail', [App\Http\Controllers\api\AppController::class, 'getProductDetail']);
    //
    // restaurant home page api

    Route::post('home', [App\Http\Controllers\api\AppController::class, 'restaurantHomePage']);
    Route::post('getRestaurantByCategory', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCategory']);
    Route::post('getRestaurantByCuisines', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCuisines']);
    Route::post('getRestaurantDetailPage', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage']);

//    Route::post('getRestaurantDetailPage_old', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage_old']);


    Route::post('getRestaurantDetailByFoodtype', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailByFoodtype']);
    Route::post('browse-menu', [App\Http\Controllers\api\AppController::class, 'getRestaurantBrowsemenu']);
    Route::post('custmizable-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantCustmizeProductData']);
    Route::post('search-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantSearchData']);

    // chef home page api
    Route::post('chef-home', [App\Http\Controllers\api\AppController::class, 'chefHomePage']);
    Route::post('getChefByCategory', [App\Http\Controllers\api\AppController::class, 'getChefByCategory']);
    Route::post('getChefDetailPage', [App\Http\Controllers\api\AppController::class, 'getChefDetailPage']);
    Route::post('getChefProfile', [App\Http\Controllers\api\AppController::class, 'getChefProfile']);
    //


    //add-to-cart
    Route::post('add-to-cart', [App\Http\Controllers\api\CartApiController::class, 'add_to_cart']);
    Route::post('empty-cart', [App\Http\Controllers\api\CartApiController::class, 'empty_cart']);
    Route::post('view-cart', [App\Http\Controllers\api\CartApiController::class, 'view_cart']);
    Route::post('view-cart-vendor', [App\Http\Controllers\api\CartApiController::class, 'view_cart_vendor']);
    Route::post('update-cart', [App\Http\Controllers\api\CartApiController::class, 'update_cart']);

    // like dislike
    Route::post('like-vendor', [App\Http\Controllers\api\AppController::class, 'add_to_like_vendor']);
    Route::post('like-product', [App\Http\Controllers\api\AppController::class, 'add_to_like_product']);
    Route::post('dislike-product', [App\Http\Controllers\api\AppController::class, 'deleteLikeProduct']);
    Route::post('dislike-vendor', [App\Http\Controllers\api\AppController::class, 'deleteLikeVendor']);

    // coupon
    Route::post('vendor-coupon',[App\Http\Controllers\api\CouponController::class,'getCoupon']);
    Route::post('vendor-coupon-details',[App\Http\Controllers\api\CouponController::class,'couponDetailPage']);
    Route::post('procode-coupon-details',[App\Http\Controllers\api\CouponController::class,'getPromoCode']);
    Route::post('procode-coupon-apply',[App\Http\Controllers\api\CouponController::class,'couponApply']);


    // order
    Route::post('create-order', [App\Http\Controllers\api\AppController::class, 'create_order']);
    Route::post('get-order', [App\Http\Controllers\api\AppController::class, 'get_order']);

    //profile
    Route::post('get-user-info', [App\Http\Controllers\api\AppController::class, 'getUserInfo']);
    Route::post('update-user-info', [App\Http\Controllers\api\AppController::class, 'updateUserInfo']);
    Route::post('get-user-fav-vendors', [App\Http\Controllers\api\AppController::class, 'getUserFavVendors']);
    //
    // Banner Api
    Route::get('getHomeBanner', [App\Http\Controllers\api\BannerController::class, 'getHomepageBanner']);
    Route::post('getPromotionBanner', [App\Http\Controllers\api\BannerController::class, 'getPromotionBanner']);
    // Review Rating
    Route::get('getReviewRating', [App\Http\Controllers\api\VendorReviewController::class, 'getReviewData']);
    Route::get('getProductReview', [App\Http\Controllers\api\ProductReviewController::class, 'getReviewData']);
    // Delivery Address
    Route::post('delivery-address-user',[App\Http\Controllers\api\DeliveryAddressController::class,'deliverAddress']);
    Route::post('get-delivery-address',[App\Http\Controllers\api\DeliveryAddressController::class,'getDeliverAddress']);
    // FAQ
    Route::post('getUerFaq', [App\Http\Controllers\api\AppController::class, 'getUerFaq']);
    // Privacy Polic TAD
    Route::post('terms-and-condition-userapp', [App\Http\Controllers\api\AppController::class, 'getTACusers']);
    Route::post('privacy-and-policy', [App\Http\Controllers\api\AppController::class, 'getPrivacyPolicy']);
    Route::post('cancellation-policy', [App\Http\Controllers\api\AppController::class, 'getCancellationPolicy']);
    Route::post('aboutus', [App\Http\Controllers\api\AppController::class, 'getAboutUs']);
    //Dine out
    Route::post('get-dine-out-slot', [App\Http\Controllers\api\DineoutApiController::class, 'get_dine_out_slot']);
    Route::post('dine-out-booking', [App\Http\Controllers\api\DineoutApiController::class, 'dine_out_booking']);
    Route::post('dine-out-get-restaurant', [App\Http\Controllers\api\DineoutApiController::class, 'get_dineout_restaurant']);

    Route::get('chelfleb-products', [\App\Http\Controllers\api\AppController::class, 'chelfleb_produst']);
    // User Rechar 
    Route::post('get-user-wallet', [App\Http\Controllers\api\Userwallet::class, 'getUserwallet']);
    Route::post('recharge-wallet', [App\Http\Controllers\api\Userwallet::class, 'Recharge']);
    Route::post('user-all-transaction', [App\Http\Controllers\api\Userwallet::class, 'allTransactions']);

});

Route::post('register-send-otp',[App\Http\Controllers\api\LoginApiController::class,'register_send_otp']);
Route::post('register-verify-otp',[App\Http\Controllers\api\LoginApiController::class,'register_verify_otp']);
Route::post('register-verified-user',[App\Http\Controllers\api\LoginApiController::class,'register_user']);
Route::post('login-otp-send',[App\Http\Controllers\api\LoginApiController::class,'login_send_otp']);
Route::post('login-otp-verify',[App\Http\Controllers\api\LoginApiController::class,'login_verify_otp']);

Route::get('user-faq', [\App\Http\Controllers\api\UserFaqApiController::class, 'get_user_faq']);


