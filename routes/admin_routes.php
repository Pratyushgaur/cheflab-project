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
    // Globle Setting
    Route::get('globle-setting', [App\Http\Controllers\admin\GlobleSetting::class,'index'])->name('admin.globle.setting');
    Route::get('globle-setting-faq', [App\Http\Controllers\admin\GlobleSetting::class,'user_faq'])->name('admin.user.faq');
    Route::get('globle-setting-data', [App\Http\Controllers\admin\GlobleSetting::class,'getFaq'])->name('admin.user.faqdata');
    Route::post('globle-setting-faq', [App\Http\Controllers\admin\GlobleSetting::class,'store_faq'])->name('admin.globle.store_faq');
    //Route::get('vendor-products-active/{id}', [App\Http\Controllers\admin\ProductController::class, 'activeProduct'])->name('admin.appblock.list');

    Route::get('notification', [App\Http\Controllers\NotificationController::class, 'admin_index'])->name('admin.notification.view')->where('id', '[0-9]+');
});
