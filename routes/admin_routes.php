<?php

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
    Route::get('admin.chef.editchef/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_editchef'])->name('admin.chef.editchef');
    Route::post('vendors/delete', [App\Http\Controllers\admin\UserControllers::class, 'soft_delete'])->name('admin.vendors.ajax.delete');
    Route::post('vendors/product/delete', [App\Http\Controllers\admin\ProductController::class, 'soft_delete'])->name('admin.product.ajax.delete');
    Route::post('vendors/inactive/{id}', [App\Http\Controllers\admin\UserControllers::class,'vendor_inactive'])->name('admin.vendors.inactive');
    Route::post('vendors/active/{id}', [App\Http\Controllers\admin\UserControllers::class,'vendor_active'])->name('admin.vendors.active');
    //
    Route::get('vendors-view/{id}', [App\Http\Controllers\admin\UserControllers::class, 'view_vendor'])->name('admin.vendor.view');
    Route::get('vendors-chef-product/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_product'])->name('admin.cherf.product');
    Route::get('vendors-chef-videolink/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videolink'])->name('admin.cherf.videolink');
    Route::get('vendors-chef-video-list/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videolist'])->name('admin.cherf.video.link');
    Route::get('vendors-chef-video-edit/{id}', [App\Http\Controllers\admin\UserControllers::class, 'chef_videoedit'])->name('admin.chef.videoedit');
    Route::post('vendors-chef-video-update', [App\Http\Controllers\admin\UserControllers::class, 'updateVideo'])->name('admin.chef.video.update');
    Route::post('vendors-chef-video-delete', [App\Http\Controllers\admin\UserControllers::class, 'soft_delete_video'])->name('admin.chef.video.ajax.delete');
    // Refer Earn
    Route::get('refer-earn', [App\Http\Controllers\admin\UserControllers::class, 'refer'])->name('admin.refe.earn');
    Route::get('refer-amount-update', [App\Http\Controllers\admin\UserControllers::class, 'referamount'])->name('admin.refer.referamount');
    Route::post('refer-amount-store', [App\Http\Controllers\admin\UserControllers::class, 'referamountUpdate'])->name('admin.refer.amountUpdate');
    //chef route
    Route::get('vendors-chef-create', [App\Http\Controllers\admin\UserControllers::class, 'create_chef'])->name('admin.chef.create');
    Route::post('vendors-chef-store', [App\Http\Controllers\admin\UserControllers::class, 'store_chef'])->name('admin.chef.store');
    Route::post('vendors-update', [App\Http\Controllers\admin\UserControllers::class, 'vendors_update'])->name('admin.vendors.update');
    Route::post('chef-update', [App\Http\Controllers\admin\UserControllers::class, 'chef_update'])->name('admin.chef.update');
    Route::get('vendors-chef-duplicatemail', [App\Http\Controllers\admin\UserControllers::class, 'checkEmailExistUpdate'])->name('admin.restourant.Email');
    Route::post('vendors-chef-video', [App\Http\Controllers\admin\UserControllers::class, 'addVideo'])->name('admin.chef.video.add');
    Route::get('vendors-chef-productlist/{userId}', [App\Http\Controllers\admin\UserControllers::class, 'chef_product_list'])->name('admin.chef.productlist');
    Route::get('vendors-chef-productlists/{id}', [App\Http\Controllers\admin\UserControllers::class, 'product_list'])->name('admin.chef.productlists');
    Route::get('vendors-order-list/{id}', [App\Http\Controllers\admin\UserControllers::class, 'order_list'])->name('admin.user.orderlist');
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
    Route::post('category-inactive/{id}', [App\Http\Controllers\admin\Category::class, 'inactive'])->name('admin.category.inactive');
    Route::post('category-active/{id}', [App\Http\Controllers\admin\Category::class, 'active'])->name('admin.category.active');
    // cuisiness
    Route::get('cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'index'])->name('admin.cuisines.create');
    Route::post('cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'store_cuisines'])->name('admin.cuisines.store');
    Route::get('cuisines-datatable', [App\Http\Controllers\admin\CuisinesController::class, 'get_data_table_of_cuisines'])->name('admin.cuisines.datatable');
    Route::get('edit-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'fun_edit_cuisines'])->name('admin.cuisines.edit');
    Route::post('cuisines-update', [App\Http\Controllers\admin\CuisinesController::class, 'update'])->name('admin.cuisines.update');
    Route::post('cuisines/delete', [App\Http\Controllers\admin\CuisinesController::class, 'soft_delete'])->name('admin.cuisines.ajax.delete');
    Route::get('check-duplicate-cuisines', [App\Http\Controllers\admin\CuisinesController::class, 'check_duplicate_cuisines'])->name('check-duplicate-cuisines');
    Route::get('check-edit_duplicate-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'check_edit_duplicate_cuisines'])->name('check-edit_duplicate-cuisines');
    Route::post('cuisines-inactive/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'inactive'])->name('admin.cuisines.inactive');
    Route::post('cuisines-active/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'active'])->name('admin.cuisines.active');
    // product routes
    Route::get('products', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.product.create');
    Route::get('vendor/products/create/{id}', [App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.vendor.product.create');
    Route::get('vendors-chef-product-list/{id}', [App\Http\Controllers\admin\UserControllers::class, 'view_chefproduct'])->name('admin.chefproduct.view');
    Route::post('products-active/{id}', [App\Http\Controllers\admin\ProductController::class, 'active'])->name('admin.product.active');
    Route::post('products-reject/{id}', [App\Http\Controllers\admin\ProductController::class, 'reject'])->name('aadmin.product.reject');
    //chef lAB PRODUCT
    Route::get('cheflab-products', [App\Http\Controllers\admin\ProductController::class, 'cheflabProduct'])->name('admin.product.cheflabProduct');
    Route::get('cheflab-products-create', [App\Http\Controllers\admin\ProductController::class, 'createChefLabProduct'])->name('admin.product.cheflabProduct.create');
    Route::post('cheflab-products-store', [App\Http\Controllers\admin\ProductController::class, 'storeChefLabProduct'])->name('admin.product.cheflabProduct.store');
    Route::get('cheflab-products-list', [App\Http\Controllers\admin\ProductController::class, 'cheflab_product_list'])->name('admin.product.cheflabProduct.list');
    // Delivery Boy
    Route::get('delivery-boy', [App\Http\Controllers\admin\Deliveryboy::class, 'index'])->name('admin.deliverboy.list');
    Route::get('delivery-boy-create', [App\Http\Controllers\admin\Deliveryboy::class, 'create_deliverboy'])->name('admin.deliverboy.create');
    Route::get('delivery-boy-review', [App\Http\Controllers\admin\Deliveryboy::class, 'deliverboy_reviews'])->name('admin.deliverboy.review');
    Route::post('delivery-boy-store', [App\Http\Controllers\admin\Deliveryboy::class, 'store_deliverboy'])->name('admin.diliverboy.store');
    Route::get('deliverboy-datatable', [App\Http\Controllers\admin\Deliveryboy::class, 'get_data_table_of_deliverboy'])->name('admin.deliverboy.datatable');
    Route::get('edit-deliverboy/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'fun_edit_deliverboy'])->name('admin.deliverboy.view');
    Route::get('delivery-boy-emailcheck', [App\Http\Controllers\admin\Deliveryboy::class, 'checkEmailExist'])->name('admin.deliverboy.emailcheck');
    Route::get('delivery-boy-mobilecheck', [App\Http\Controllers\admin\Deliveryboy::class, 'checkMobileExist'])->name('admin.deliverboy.mobilecheck');
    Route::get('delivery-boy-emailcheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'checkEmailExistUpdate'])->name('admin.deliverboy.emailcheck_update');
    Route::get('delivery-boy-mobilecheck-update/{id}', [App\Http\Controllers\admin\Deliveryboy::class, 'checkMobileExistUpdate'])->name('admin.deliverboy.mobilecheck.update');
    Route::post('delivery-boy-update', [App\Http\Controllers\admin\Deliveryboy::class, 'update'])->name('admin.deliverboy.update');
    Route::post('delivery-boy/delete', [App\Http\Controllers\admin\Deliveryboy::class, 'soft_delete'])->name('admin.deliverboy.ajax.delete');
    Route::get('delivery-boy-setting', [App\Http\Controllers\admin\Deliveryboy::class, 'setting'])->name('admin.deliverboy.setting');
    Route::post('delivery-boy/chargse', [App\Http\Controllers\admin\Deliveryboy::class, 'storeDelivercharge'])->name('admin.deliveryboy.storeDelivercharge');
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
    // application blog promotion
    Route::get('user-app-blog', [App\Http\Controllers\admin\VendorPromotion::class, 'index'])->name('admin.application.blog');
    Route::post('user-app-blog-create', [App\Http\Controllers\admin\VendorPromotion::class, 'store'])->name('admin.application.blog.store');
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
    // Order Management
    Route::get('orders', [App\Http\Controllers\admin\OrderController::class, 'index'])->name('admin.order.list');
    Route::get('order-list', [App\Http\Controllers\admin\OrderController::class, 'get_data_table_of_order'])->name('admin.order.data');
    Route::post('get-vendor-byrole', [App\Http\Controllers\admin\OrderController::class, 'getVendorByRole'])->name('admin.vendor.byRole');
    Route::get('orders-view/{id}', [App\Http\Controllers\admin\OrderController::class, 'vieworder'])->name('admin.order.view');
    Route::get('orders-invoice/{id}', [App\Http\Controllers\admin\OrderController::class, 'invoice'])->name('admin.order.invoice');
    Route::get('orders-product/{id}', [App\Http\Controllers\admin\OrderController::class, 'get_data_table_of_product'])->name('admin.order.product');
    // Globle Setting
    Route::get('globle-setting', [App\Http\Controllers\admin\GlobleSetting::class,'index'])->name('admin.globle.setting');
    Route::get('globle-privacy-general', [App\Http\Controllers\admin\GlobleSetting::class,'general'])->name('admin.globle.general');
    Route::post('globle-general-store', [App\Http\Controllers\admin\GlobleSetting::class,'storeGernel'])->name('admin.globle.storeGernel');
    Route::get('globle-static-page', [App\Http\Controllers\admin\GlobleSetting::class,'staticpage'])->name('admin.globle.staticpage');
   
    Route::get('globle-delivery-charge', [App\Http\Controllers\admin\GlobleSetting::class,'delivery_charge'])->name('admin.globle.delivery_charge');
    Route::post('globle-store-deliverycharge', [App\Http\Controllers\admin\GlobleSetting::class,'storeDelivery'])->name('admin.globle.storeDelivercharge');
    Route::get('globle-payment-setting', [App\Http\Controllers\admin\GlobleSetting::class,'payment'])->name('admin.globle.payment.setting');
    Route::post('globle-payment-store', [App\Http\Controllers\admin\GlobleSetting::class,'storePaytm'])->name('admin.globle.storePaytm');
    Route::get('app-user-feedbacklist', [App\Http\Controllers\admin\GlobleSetting::class,'feedbacklist'])->name('admin.app.feedbacklist');
    Route::get('app-vendor-feedbacklist', [App\Http\Controllers\admin\GlobleSetting::class,'vendorfeedbacklist'])->name('admin.app.vendorfeedbacklist');
    Route::get('app-deliverboy-feedbacklist', [App\Http\Controllers\admin\GlobleSetting::class,'DeliveryBoyfeedbacklist'])->name('admin.app.deliveryfeedbacklist');
    Route::get('globle-user-feedbackdata', [App\Http\Controllers\admin\GlobleSetting::class,'getFeedback'])->name('admin.globle.feedbackdata');
    Route::get('globle-vendor-feedbackdata', [App\Http\Controllers\admin\GlobleSetting::class,'getVendorFeedback'])->name('admin.vendor.feedbackdata');
    Route::get('globle-deliveryboy-feedbackdata', [App\Http\Controllers\admin\GlobleSetting::class,'getDeliveryboyFeedback'])->name('admin.deliveryboy.feedbackdata');
    Route::get('globle-user-feedbackedit', [App\Http\Controllers\admin\GlobleSetting::class,'getFeedbackEdit'])->name('admin.user.feedbackedit');
    Route::get('globle-defualtime', [App\Http\Controllers\admin\GlobleSetting::class,'defaulttimeset'])->name('admin.globle.defaulttime');
    Route::post('globle-setting-storeDefaultTime', [App\Http\Controllers\admin\GlobleSetting::class,'storeDefaultTime'])->name('admin.globle.storeDefaultTime'); 
    
    
    Route::get('globle-social-media', [App\Http\Controllers\admin\GlobleSetting::class,'social_media'])->name('admin.globle.socialmedia');
    Route::post('globle-social-media-add', [App\Http\Controllers\admin\GlobleSetting::class,'social_media_add'])->name('admin.globle.socialmedia_add');
    Route::get('globle-social-media-data', [App\Http\Controllers\admin\GlobleSetting::class,'getSocialMedia'])->name('admin.globle.socilamediadata');
    Route::get('globle-social-media-edit/{id}', [App\Http\Controllers\admin\GlobleSetting::class, 'fun_edit_socialmedia'])->name('admin.social.mediaedit');
    Route::post('globle-social-media-update', [App\Http\Controllers\admin\GlobleSetting::class,'social_media_update'])->name('admin.globle.socialmedia_update');
    Route::get('globle-product-active', [App\Http\Controllers\admin\GlobleSetting::class,'product_active'])->name('admin.globle.productactive');
    //Route::get('vendor-products-active/{id}', [App\Http\Controllers\admin\ProductController::class, 'activeProduct'])->name('admin.appblock.list');
    // Contant Managemnt 
    Route::get('content-menegement-user', [App\Http\Controllers\admin\Contantmanagement::class,'index'])->name('admin.user.contentmanagement');
    Route::post('content-static-user-storePrivacy', [App\Http\Controllers\admin\Contantmanagement::class,'storePrivacy'])->name('admin.user.storePrivacy');
    Route::post('content-static-storeVendorTC', [App\Http\Controllers\admin\Contantmanagement::class,'storeVendorTC'])->name('admin.user.storeVendorTC');
  //  Route::post('content-static-storeCheflabTC', [App\Http\Controllers\admin\Contantmanagement::class,'storeCheflabTC'])->name('admin.globle.storeCheflabTC');
    //Route::post('content-static-storeDeliveryTC', [App\Http\Controllers\admin\Contantmanagement::class,'storeDeliveryTC'])->name('admin.globle.storeDeliveryTC');
    Route::post('content-static-storeRefund', [App\Http\Controllers\admin\Contantmanagement::class,'storeRefund'])->name('admin.user.storeRefund');
    Route::get('content-static-faquser', [App\Http\Controllers\admin\Contantmanagement::class,'user_faq'])->name('admin.user.faq');
    Route::get('content-static-data', [App\Http\Controllers\admin\Contantmanagement::class,'getFaq'])->name('admin.user.faqdata');
    Route::get('content-static-faqedit/{id}', [App\Http\Controllers\admin\Contantmanagement::class,'fun_edit_faq'])->name('admin.user.faqedit');
    Route::post('content-static-faqupdate', [App\Http\Controllers\admin\Contantmanagement::class,'update_faq'])->name('admin.globle.update_faq');   
    Route::post('content-static-faq', [App\Http\Controllers\admin\Contantmanagement::class,'store_faq'])->name('admin.user.store_faq');

    Route::get('content-menegement-vendor', [App\Http\Controllers\admin\Contantmanagement::class,'vendor'])->name('admin.vendor.contentmanagement');
    Route::post('content-static-vendore-storePrivacy', [App\Http\Controllers\admin\Contantmanagement::class,'vendorPrivacy'])->name('admin.vendor.storePrivacy');
    Route::post('content-static-VendorTC', [App\Http\Controllers\admin\Contantmanagement::class,'VendorTC'])->name('admin.vendore.storeVendorTC');
    Route::post('content-static-vendorRefund', [App\Http\Controllers\admin\Contantmanagement::class,'vendorRefund'])->name('admin.vendore.storeRefund');
    Route::get('content-static-faqvendor', [App\Http\Controllers\admin\Contantmanagement::class,'vendor_faq'])->name('admin.vendor.faq');
    Route::get('content-static-vendor-data', [App\Http\Controllers\admin\Contantmanagement::class,'getVendorFaq'])->name('admin.vendor.faqdata');
    Route::post('content-static-faq-vendor', [App\Http\Controllers\admin\Contantmanagement::class,'vendorstore_faq'])->name('admin.vendor.store_faq');
    Route::get('content-static-faqedit-vendor/{id}', [App\Http\Controllers\admin\Contantmanagement::class,'fun_edit_faq_vendor'])->name('admin.vendor.faqedit');
    Route::post('content-static-vendor-faqupdate', [App\Http\Controllers\admin\Contantmanagement::class,'update_vendorfaq'])->name('admin.vendor.update_faq');  
    
    Route::get('content-menegement-dliveryboy', [App\Http\Controllers\admin\Contantmanagement::class,'dliveryboy'])->name('admin.dliveryboy.contentmanagement');
    Route::post('content-static-deliveryboy-storePrivacy', [App\Http\Controllers\admin\Contantmanagement::class,'deliveryboyPrivacy'])->name('admin.deliveryboy.storePrivacy');
    Route::post('content-static-dliveryboy-storePrivacy', [App\Http\Controllers\admin\Contantmanagement::class,'dliveryboyPrivacy'])->name('admin.deliveryboy.storeVendorTC');
    Route::post('content-static-dliveryboyRefund', [App\Http\Controllers\admin\Contantmanagement::class,'deliveryboyRefund'])->name('admin.deliveryboy.storeRefund');
    Route::get('content-static-faqdliveryboy', [App\Http\Controllers\admin\Contantmanagement::class,'deliveryboy_faq'])->name('admin.deliveryboy.faq');
    Route::get('content-static-deliveryboy-data', [App\Http\Controllers\admin\Contantmanagement::class,'getDeliverboyFaq'])->name('admin.deliveryboy.faqdata');
    Route::post('content-static-faq-deliveryboy', [App\Http\Controllers\admin\Contantmanagement::class,'deliveryboystore_faq'])->name('admin.deliveryboy.store_faq');
    Route::get('content-static-faqedit-deliveryboy/{id}', [App\Http\Controllers\admin\Contantmanagement::class,'fun_edit_faq_deliveryboy'])->name('admin.deliveryboy.faqedit');
    Route::post('content-static-vendor-faqdeliveryboy', [App\Http\Controllers\admin\Contantmanagement::class,'update_deliveryboyfaq'])->name('admin.deliveryboy.update_faq');  
    //notification
    Route::get('notification', [App\Http\Controllers\NotificationController::class, 'admin_index'])->name('admin.notification.view')->where('id', '[0-9]+');


    //users
    Route::get('users', [App\Http\Controllers\admin\UserControllers::class,'user_list'])->name('admin.user.list');
    Route::post('users/inactive/{id}', [App\Http\Controllers\admin\UserControllers::class,'user_inactive'])->name('admin.user.inactive');
    Route::post('users/active/{id}', [App\Http\Controllers\admin\UserControllers::class,'user_active'])->name('admin.user.active');
    Route::post('user/delete/{id}', [App\Http\Controllers\admin\UserControllers::class,'user_delete'])->name('admin.user.delete');
    Route::get('users/view/{id}', [App\Http\Controllers\admin\UserControllers::class,'user_view'])->name('admin.user.view');
    //Refund
    Route::get('refund-list',[\App\Http\Controllers\admin\UserControllers::class,'refundlist'])->name('admin.refund.list');
});
