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
    Route::post('getCategories', [App\Http\Controllers\api\AppMasterController::class, 'getCategories'])->name("get.categories");
    Route::post('getCuisines', [App\Http\Controllers\api\AppMasterController::class, 'getCuisines'])->name("get.cuisines");
    Route::post('getProductDetail', [App\Http\Controllers\api\AppController::class, 'getProductDetail']);
    //
    Route::post('pending-order-rating', [App\Http\Controllers\api\AppController::class, 'pendingOrderRatings']);
    Route::post('reject-order-rating', [App\Http\Controllers\api\AppController::class, 'rejectOrderRatings']);
    Route::post('detail-order-rating', [App\Http\Controllers\api\AppController::class, 'detailOrderRating']);
    Route::post('save-order-rating', [App\Http\Controllers\api\AppController::class, 'saveOrderRating']);
    Route::post('get-driver-rating-data', [App\Http\Controllers\api\AppController::class, 'getDriverRatingData']);

    // restaurant home page api

    Route::post('home', [App\Http\Controllers\api\AppController::class, 'restaurantHomePage'])->name("restaurant.home");
    Route::post('home2', [App\Http\Controllers\api\AppController::class, 'restaurantHomePage2'])->name("restaurant.home2");
    Route::post('getRestaurantByCategory', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCategory'])->name("get.restaurant.by.category");
    Route::post('getRestaurantByCuisines', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCuisines']);
    Route::post('getRestaurantDetailPage', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage']);
    Route::post('search-RestaurantDetail-Page', [App\Http\Controllers\api\AppController::class, 'searchRestaurantDetailPage']);
    Route::post('get-restaurant-detail', [App\Http\Controllers\api\AppController::class, 'getVendorById']);

    //    Route::post('getRestaurantDetailPage_old', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage_old']);


    Route::post('getRestaurantDetailByFoodtype', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailByFoodtype']);
    Route::post('browse-menu', [App\Http\Controllers\api\AppController::class, 'getRestaurantBrowsemenu']);
    Route::post('custmizable-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantCustmizeProductData']);
    Route::post('search-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantSearchData']);

    // chef home page api
    Route::post('chef-home', [App\Http\Controllers\api\AppController::class, 'chefHomePage']);
    Route::post('getChefByCategory', [App\Http\Controllers\api\AppController::class, 'getChefByCategory']);
    Route::post('getChefByCuisines', [App\Http\Controllers\api\AppController::class, 'getChefByCuisines']);
    Route::post('getChefDetailPage', [App\Http\Controllers\api\AppController::class, 'getChefDetailPage']);
    Route::post('getChefProfile', [App\Http\Controllers\api\AppController::class, 'getChefProfile']);
    //


    //add-to-cart
    Route::post('add-to-cart', [App\Http\Controllers\api\CartApiController::class, 'add_to_cart']);
    Route::post('empty-cart', [App\Http\Controllers\api\CartApiController::class, 'empty_cart']);
    Route::post('view-cart', [App\Http\Controllers\api\CartApiController::class, 'view_cart']);
    Route::post('view-cart-vendor', [App\Http\Controllers\api\CartApiController::class, 'view_cart_vendor']);
    Route::post('update-cart', [App\Http\Controllers\api\CartApiController::class, 'update_cart']);
    Route::post('get-cart', [App\Http\Controllers\api\CartApiController::class, 'get_cart']);
    Route::post('delete-product-from-cart', [App\Http\Controllers\api\CartApiController::class, 'delete_product_from_cart']);

    // like dislike
    Route::post('like-vendor', [App\Http\Controllers\api\AppController::class, 'add_to_like_vendor']);
    Route::post('like-product', [App\Http\Controllers\api\AppController::class, 'add_to_like_product']);
    Route::post('dislike-product', [App\Http\Controllers\api\AppController::class, 'deleteLikeProduct']);
    Route::post('dislike-vendor', [App\Http\Controllers\api\AppController::class, 'deleteLikeVendor']);
    // Chef like dislike
    Route::post('like-chef', [App\Http\Controllers\api\AppController::class, 'add_to_like_product_chef']);
    Route::post('dislike-product-chef', [App\Http\Controllers\api\AppController::class, 'deleteLikeProductChef']);
    Route::post('dislike-vendor-chef', [App\Http\Controllers\api\AppController::class, 'deleteLikeChef']);
    // coupon
    Route::post('vendor-coupon', [App\Http\Controllers\api\CouponController::class, 'getCoupon']);
    Route::post('vendor-coupon-details', [App\Http\Controllers\api\CouponController::class, 'couponDetailPage']);
    Route::post('procode-coupon-details', [App\Http\Controllers\api\CouponController::class, 'getPromoCode']);
    Route::post('procode-coupon-apply', [App\Http\Controllers\api\CouponController::class, 'couponApply']);


    // order
    Route::post('create-order', [App\Http\Controllers\api\AppController::class, 'create_order']);
    Route::post('get-order', [App\Http\Controllers\api\AppController::class, 'get_order']);
    Route::post('check-vendor-available', [App\Http\Controllers\api\AppController::class, 'checkVendorAvailable']);
    Route::post('re-order', [App\Http\Controllers\api\AppController::class, 'reOrder']);
    Route::post('get-order-time-diff', [App\Http\Controllers\api\AppController::class, 'orderTimeDiff']);
    Route::post('get-order-details', [App\Http\Controllers\api\AppController::class, 'orderDetails']);

    //profile
    Route::post('get-user-info', [App\Http\Controllers\api\AppController::class, 'getUserInfo']);
    Route::post('update-user-info', [App\Http\Controllers\api\AppController::class, 'updateUserInfo']);
    Route::post('get-user-fav-vendors', [App\Http\Controllers\api\AppController::class, 'getUserFavVendors']);
    //
    // Banner Api
    Route::post('getHomeBanner', [App\Http\Controllers\api\BannerController::class, 'getHomepageBanner']);
    Route::post('getPromotionBanner', [App\Http\Controllers\api\BannerController::class, 'getPromotionBanner']);
    // Review Rating
    Route::post('save-vendor-rating-review', [App\Http\Controllers\api\VendorReviewController::class, 'saveReviewData']);
    Route::post('get-vendor-rating-review', [App\Http\Controllers\api\VendorReviewController::class, 'getReviewData']);
    Route::post('save-product-rating-review', [App\Http\Controllers\api\ProductReviewController::class, 'saveReviewData']);
    Route::post('get-vendor-all-review', [App\Http\Controllers\api\VendorReviewController::class, 'getVendorReviews']);
    Route::post('save-rider-rating-review', [App\Http\Controllers\api\AppController::class, 'saveRiderRatingReviews']);

    //    Route::get('getProductReview', [App\Http\Controllers\api\ProductReviewController::class, 'getReviewData']);
    // Delivery Address
    Route::post('delivery-address-user', [App\Http\Controllers\api\DeliveryAddressController::class, 'deliverAddress']);
    Route::post('get-delivery-address', [App\Http\Controllers\api\DeliveryAddressController::class, 'getDeliverAddress']);
    Route::post('delivery-address-update', [App\Http\Controllers\api\DeliveryAddressController::class, 'updateAdress']);
    Route::post('delivery-address-delete', [App\Http\Controllers\api\DeliveryAddressController::class, 'deleteAddres']);
    // FAQ
    Route::post('getUerFaq', [App\Http\Controllers\api\AppController::class, 'getUerFaq']);
    // Privacy Polic TAD User
    Route::get('terms-and-condition-userapp', [App\Http\Controllers\api\AppController::class, 'getTACusers']);
    Route::get('privacy-and-policy', [App\Http\Controllers\api\AppController::class, 'getUserPrivacyPolicy']);
    Route::get('cancellation-policy', [App\Http\Controllers\api\AppController::class, 'getUserCancellationPolicy']);
    Route::get('aboutus', [App\Http\Controllers\api\AppController::class, 'getAboutUs']);
    Route::get('socialmedia', [App\Http\Controllers\api\AppController::class, 'getSocialmedia']);

    //Dine out
    Route::post('get-dine-out-slot', [App\Http\Controllers\api\DineoutApiController::class, 'get_dine_out_slot']);
    Route::post('dine-out-booking', [App\Http\Controllers\api\DineoutApiController::class, 'dine_out_booking']);
    Route::post('dine-out-get-restaurant', [App\Http\Controllers\api\DineoutApiController::class, 'get_dineout_restaurant']);
    Route::post('get-booked-dine-out-details', [App\Http\Controllers\api\DineoutApiController::class, 'get_booked_dineout_detail']);

    Route::get('chelfleb-products', [\App\Http\Controllers\api\AppController::class, 'chelfleb_produst']);
    // User Rechar
    Route::post('get-user-wallet', [App\Http\Controllers\api\Userwallet::class, 'getUserwallet']);
    Route::post('recharge-wallet', [App\Http\Controllers\api\Userwallet::class, 'Recharge']);
    Route::post('user-all-transaction', [App\Http\Controllers\api\Userwallet::class, 'allTransactions']);
    // Try once
    Route::post('get-user-tryonce', [App\Http\Controllers\api\AppController::class, 'getTryonce']);
    //  filter by restourant
    Route::post('get-filter-restourant', [App\Http\Controllers\api\AppController::class, 'filterByRestaurant']);
    Route::post('get-filter-chef', [App\Http\Controllers\api\AppController::class, 'filterByChef']);
    //firbase
    Route::post('user-fcm-token', [App\Http\Controllers\api\AppController::class, 'updateTokenUser'])->name('fcmToken_user');
    Route::get('/user-send-notification', [\App\Http\Controllers\API\FirebaseApiController::class, 'notification'])->name('notification_user');
    Route::post('save-contact-us', [\App\Http\Controllers\api\AppController::class, 'save_contact_us']);
    Route::post('get-all-liked-products', [\App\Http\Controllers\api\AppController::class, 'getAllLikeProducts']);
    Route::post('get-all-liked-restaurant', [\App\Http\Controllers\api\AppController::class, 'getAllLikerestaurants']);

    Route::post('get-restaurant-by', [\App\Http\Controllers\api\AppController::class, 'getRestuarantBy']);
    Route::post('cancel-order', [\App\Http\Controllers\api\AppController::class, 'cancel_order']);
    //blog promotion
    Route::post('get-blog-promotion', [\App\Http\Controllers\api\BlogPromotionController::class, 'getBlogPromotion']);
    // refer ammount
    Route::post('refer-amount', [\App\Http\Controllers\api\AppController::class, 'getReferAmmount']);
    // user driver location
    Route::post('get-driver-live', [\App\Http\Controllers\api\AppController::class, 'getDriveLocation']);

    //
    Route::post('delete-user', [\App\Http\Controllers\api\LoginApiController::class, 'deleteUser']);



    //

});
Route::get('login', function () {
    return response()->json([
        'status' => false,
        'error'  => "Need To Use Token for this route"
    ], 500);
})->name('login');
Route::post('register-send-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_send_otp'])->name("register.otp.send");
Route::post('register-verify-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_verify_otp'])->name("register.otp.verify");
Route::post('register-verified-user', [App\Http\Controllers\api\LoginApiController::class, 'register_user'])->name("register.user.verify");
Route::post('login-otp-send', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp'])->name("login.otp.send");
Route::post('login-otp-verify', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp'])->name("login.verify.otp");
//  login version 2 api
Route::post('login-otp-send-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp_v2'])->name("login.otp.send.v2");
Route::post('login-otp-verify-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp_v2'])->name("login.verify.otp.v2");
// 
Route::post('guest-login', [App\Http\Controllers\api\LoginApiController::class, 'guestLogin'])->name("login.guest");

Route::get('user-faq', [\App\Http\Controllers\api\UserFaqApiController::class, 'get_user_faq'])->name("user.faq");

Route::post('get-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkVersion'])->name("update.version");
Route::post('get-ios-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkIosVersion'])->name("update.version");


Route::post('send-notification', [App\Http\Controllers\api\AppController::class, 'sendNotification']);

//

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




//

Route::post('rider-order-history', [App\Http\Controllers\api\rider\OrderApiController::class, 'orderhistory'])->name("rider.order.history");
Route::get('getDistance', [App\Http\Controllers\api\rider\LoginApiController::class, 'getDistance']);
Route::get('getDistance2', [App\Http\Controllers\api\rider\LoginApiController::class, 'getDistance2']);



// vi call
Route::group(['middleware' => 'auth:sanctum','prefix' => 'system-api'], function () {
    // master
    Route::post('getCategories', [App\Http\Controllers\api\AppMasterController::class, 'getCategories']);
    Route::post('getCuisines', [App\Http\Controllers\api\AppMasterController::class, 'getCuisines']);
    Route::post('getProductDetail', [App\Http\Controllers\api\AppController::class, 'getProductDetail']);
    //
    Route::post('pending-order-rating', [App\Http\Controllers\api\AppController::class, 'pendingOrderRatings']);
    Route::post('reject-order-rating', [App\Http\Controllers\api\AppController::class, 'rejectOrderRatings']);
    Route::post('detail-order-rating', [App\Http\Controllers\api\AppController::class, 'detailOrderRating']);
    Route::post('save-order-rating', [App\Http\Controllers\api\AppController::class, 'saveOrderRating']);
    Route::post('get-driver-rating-data', [App\Http\Controllers\api\AppController::class, 'getDriverRatingData']);

    // restaurant home page api

    Route::post('home', [App\Http\Controllers\api\AppController::class, 'restaurantHomePage']);
    Route::post('home2', [App\Http\Controllers\api\AppController::class, 'restaurantHomePage2']);
    Route::post('getRestaurantByCategory', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCategory']);
    Route::post('getRestaurantByCuisines', [App\Http\Controllers\api\AppController::class, 'getRestaurantByCuisines']);
    Route::post('getRestaurantDetailPage', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage']);
    Route::post('search-RestaurantDetail-Page', [App\Http\Controllers\api\AppController::class, 'searchRestaurantDetailPage']);
    Route::post('get-restaurant-detail', [App\Http\Controllers\api\AppController::class, 'getVendorById']);

    //    Route::post('getRestaurantDetailPage_old', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailPage_old']);


    Route::post('getRestaurantDetailByFoodtype', [App\Http\Controllers\api\AppController::class, 'getRestaurantDetailByFoodtype']);
    Route::post('browse-menu', [App\Http\Controllers\api\AppController::class, 'getRestaurantBrowsemenu']);
    Route::post('custmizable-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantCustmizeProductData']);
    Route::post('search-data', [App\Http\Controllers\api\AppController::class, 'getRestaurantSearchData']);

    // chef home page api
    Route::post('chef-home', [App\Http\Controllers\api\AppController::class, 'chefHomePage']);
    Route::post('getChefByCategory', [App\Http\Controllers\api\AppController::class, 'getChefByCategory']);
    Route::post('getChefByCuisines', [App\Http\Controllers\api\AppController::class, 'getChefByCuisines']);
    Route::post('getChefDetailPage', [App\Http\Controllers\api\AppController::class, 'getChefDetailPage']);
    Route::post('getChefProfile', [App\Http\Controllers\api\AppController::class, 'getChefProfile']);
    //


    //add-to-cart
    Route::post('add-to-cart', [App\Http\Controllers\api\CartApiController::class, 'add_to_cart']);
    Route::post('empty-cart', [App\Http\Controllers\api\CartApiController::class, 'empty_cart']);
    Route::post('view-cart', [App\Http\Controllers\api\CartApiController::class, 'view_cart']);
    Route::post('view-cart-vendor', [App\Http\Controllers\api\CartApiController::class, 'view_cart_vendor']);
    Route::post('update-cart', [App\Http\Controllers\api\CartApiController::class, 'update_cart']);
    Route::post('get-cart', [App\Http\Controllers\api\CartApiController::class, 'get_cart']);
    Route::post('delete-product-from-cart', [App\Http\Controllers\api\CartApiController::class, 'delete_product_from_cart']);

    // like dislike
    Route::post('like-vendor', [App\Http\Controllers\api\AppController::class, 'add_to_like_vendor']);
    Route::post('like-product', [App\Http\Controllers\api\AppController::class, 'add_to_like_product']);
    Route::post('dislike-product', [App\Http\Controllers\api\AppController::class, 'deleteLikeProduct']);
    Route::post('dislike-vendor', [App\Http\Controllers\api\AppController::class, 'deleteLikeVendor']);
    // Chef like dislike
    Route::post('like-chef', [App\Http\Controllers\api\AppController::class, 'add_to_like_product_chef']);
    Route::post('dislike-product-chef', [App\Http\Controllers\api\AppController::class, 'deleteLikeProductChef']);
    Route::post('dislike-vendor-chef', [App\Http\Controllers\api\AppController::class, 'deleteLikeChef']);
    // coupon
    Route::post('vendor-coupon', [App\Http\Controllers\api\CouponController::class, 'getCoupon']);
    Route::post('vendor-coupon-details', [App\Http\Controllers\api\CouponController::class, 'couponDetailPage']);
    Route::post('procode-coupon-details', [App\Http\Controllers\api\CouponController::class, 'getPromoCode']);
    Route::post('procode-coupon-apply', [App\Http\Controllers\api\CouponController::class, 'couponApply']);


    // order
    Route::post('create-order', [App\Http\Controllers\api\AppController::class, 'create_order']);
    Route::post('get-order', [App\Http\Controllers\api\AppController::class, 'get_order']);
    Route::post('check-vendor-available', [App\Http\Controllers\api\AppController::class, 'checkVendorAvailable']);
    Route::post('re-order', [App\Http\Controllers\api\AppController::class, 'reOrder']);
    Route::post('get-order-time-diff', [App\Http\Controllers\api\AppController::class, 'orderTimeDiff']);
    Route::post('get-order-details', [App\Http\Controllers\api\AppController::class, 'orderDetails']);
    Route::post('make-order-refund', [App\Http\Controllers\api\AppController::class, 'orderRefundToUser']);


    //profile
    Route::post('get-user-info', [App\Http\Controllers\api\AppController::class, 'getUserInfo']);
    Route::post('update-user-info', [App\Http\Controllers\api\AppController::class, 'updateUserInfo']);
    Route::post('get-user-fav-vendors', [App\Http\Controllers\api\AppController::class, 'getUserFavVendors']);
    //
    // Banner Api
    Route::post('getHomeBanner', [App\Http\Controllers\api\BannerController::class, 'getHomepageBanner']);
    Route::post('getPromotionBanner', [App\Http\Controllers\api\BannerController::class, 'getPromotionBanner']);
    // Review Rating
    Route::post('save-vendor-rating-review', [App\Http\Controllers\api\VendorReviewController::class, 'saveReviewData']);
    Route::post('get-vendor-rating-review', [App\Http\Controllers\api\VendorReviewController::class, 'getReviewData']);
    Route::post('save-product-rating-review', [App\Http\Controllers\api\ProductReviewController::class, 'saveReviewData']);
    Route::post('get-vendor-all-review', [App\Http\Controllers\api\VendorReviewController::class, 'getVendorReviews']);
    Route::post('save-rider-rating-review', [App\Http\Controllers\api\AppController::class, 'saveRiderRatingReviews']);

    //    Route::get('getProductReview', [App\Http\Controllers\api\ProductReviewController::class, 'getReviewData']);
    // Delivery Address
    Route::post('delivery-address-user', [App\Http\Controllers\api\DeliveryAddressController::class, 'deliverAddress']);
    Route::post('get-delivery-address', [App\Http\Controllers\api\DeliveryAddressController::class, 'getDeliverAddress']);
    Route::post('delivery-address-update', [App\Http\Controllers\api\DeliveryAddressController::class, 'updateAdress']);
    Route::post('delivery-address-delete', [App\Http\Controllers\api\DeliveryAddressController::class, 'deleteAddres']);
    // FAQ
    Route::post('getUerFaq', [App\Http\Controllers\api\AppController::class, 'getUerFaq']);
    // Privacy Polic TAD User
    Route::get('terms-and-condition-userapp', [App\Http\Controllers\api\AppController::class, 'getTACusers']);
    Route::get('privacy-and-policy', [App\Http\Controllers\api\AppController::class, 'getUserPrivacyPolicy']);
    Route::get('cancellation-policy', [App\Http\Controllers\api\AppController::class, 'getUserCancellationPolicy']);
    Route::get('aboutus', [App\Http\Controllers\api\AppController::class, 'getAboutUs']);
    Route::get('socialmedia', [App\Http\Controllers\api\AppController::class, 'getSocialmedia']);

    //Dine out
    Route::post('get-dine-out-slot', [App\Http\Controllers\api\DineoutApiController::class, 'get_dine_out_slot']);
    Route::post('dine-out-booking', [App\Http\Controllers\api\DineoutApiController::class, 'dine_out_booking']);
    Route::post('dine-out-get-restaurant', [App\Http\Controllers\api\DineoutApiController::class, 'get_dineout_restaurant']);
    Route::post('get-booked-dine-out-details', [App\Http\Controllers\api\DineoutApiController::class, 'get_booked_dineout_detail']);

    Route::get('chelfleb-products', [\App\Http\Controllers\api\AppController::class, 'chelfleb_produst']);
    // User Rechar
    Route::post('get-user-wallet', [App\Http\Controllers\api\Userwallet::class, 'getUserwallet']);
    Route::post('recharge-wallet', [App\Http\Controllers\api\Userwallet::class, 'Recharge']);
    Route::post('user-all-transaction', [App\Http\Controllers\api\Userwallet::class, 'allTransactions']);
    // Try once
    Route::post('get-user-tryonce', [App\Http\Controllers\api\AppController::class, 'getTryonce']);
    //  filter by restourant
    Route::post('get-filter-restourant', [App\Http\Controllers\api\AppController::class, 'filterByRestaurant']);
    Route::post('get-filter-chef', [App\Http\Controllers\api\AppController::class, 'filterByChef']);
    //firbase
    Route::post('user-fcm-token', [App\Http\Controllers\api\AppController::class, 'updateTokenUser']);
    Route::get('/user-send-notification', [\App\Http\Controllers\API\FirebaseApiController::class, 'notification']);
    Route::post('save-contact-us', [\App\Http\Controllers\api\AppController::class, 'save_contact_us']);
    Route::post('get-all-liked-products', [\App\Http\Controllers\api\AppController::class, 'getAllLikeProducts']);
    Route::post('get-all-liked-restaurant', [\App\Http\Controllers\api\AppController::class, 'getAllLikerestaurants']);

    Route::post('get-restaurant-by', [\App\Http\Controllers\api\AppController::class, 'getRestuarantBy']);
    Route::post('cancel-order', [\App\Http\Controllers\api\AppController::class, 'cancel_order']);
    //blog promotion
    Route::post('get-blog-promotion', [\App\Http\Controllers\api\BlogPromotionController::class, 'getBlogPromotion']);
    // refer ammount
    Route::post('refer-amount', [\App\Http\Controllers\api\AppController::class, 'getReferAmmount']);
    // user driver location
    Route::post('get-driver-live', [\App\Http\Controllers\api\AppController::class, 'getDriveLocation']);

    //
    Route::post('delete-user', [\App\Http\Controllers\api\LoginApiController::class, 'deleteUser']);



    //

});

//
Route::get('system-api/login', function () {
    return response()->json([
        'status' => false,
        'error'  => "Need To Use Token for this route"
    ], 500);
})->name('login');
Route::post('system-api/register-send-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_send_otp']);
Route::post('system-api/register-verify-otp', [App\Http\Controllers\api\LoginApiController::class, 'register_verify_otp']);
Route::post('system-api/register-verified-user', [App\Http\Controllers\api\LoginApiController::class, 'register_user']);
Route::post('system-api/login-otp-send', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp']);
Route::post('system-api/login-otp-verify', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp']);
//  login version 2 api
Route::post('system-api/login-otp-send-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_send_otp_v2'])->name("login.otp.send.v2");
Route::post('system-api/login-otp-verify-v2', [App\Http\Controllers\api\LoginApiController::class, 'login_verify_otp_v2'])->name("login.verify.otp.v2");
Route::post('system-api/guest-login', [App\Http\Controllers\api\LoginApiController::class, 'guestLogin']);

Route::get('system-api/user-faq', [\App\Http\Controllers\api\UserFaqApiController::class, 'get_user_faq']);

Route::post('system-api/get-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkVersion']);
Route::post('system-api/get-ios-update-version', [\App\Http\Controllers\api\LoginApiController::class, 'checkIosVersion']);


Route::post('system-api/send-notification', [App\Http\Controllers\api\AppController::class, 'sendNotification']);

//