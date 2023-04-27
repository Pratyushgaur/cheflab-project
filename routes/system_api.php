<?php 
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
 Route::post('v2-create-order', [App\Http\Controllers\api\AppController::class, 'create_order_for_gateway']);
 Route::post('v3-create-order', [App\Http\Controllers\api\AppController::class, 'create_order_for_gateway2']);
 Route::post('get-order', [App\Http\Controllers\api\AppController::class, 'get_order']);
 Route::post('get-temporary-order-detail', [App\Http\Controllers\api\AppController::class, 'get_temporary_order_detail']);
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
