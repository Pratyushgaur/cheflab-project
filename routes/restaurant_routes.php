<?php // vendor auth route
Route::group(['middleware' => ['isVendor'], 'prefix' => 'vendor'], function () {
    // restaurant route
    Route::group([
        'prefix' => 'restaurant',
                  'middleware' => ['isRestaurant']], function () {
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
            Route::get('orders', [App\Http\Controllers\vendor\restaurant\OrderController::class, 'index'])->name('restaurant.order.list');
            Route::post('order/accept/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_accept'])->name('restaurant.order.accept')->where('id', '[0-9]+');
            Route::post('order/vendor_reject/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_vendor_reject'])->name('restaurant.order.vendor_reject')->where('id', '[0-9]+');
            Route::post('order/preparing/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_preparing'])->name('restaurant.order.preparing')->where('id', '[0-9]+');
            Route::post('order/ready_to_dispatch/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_ready_to_dispatch'])->name('restaurant.order.ready_to_dispatch')->where('id', '[0-9]+');
            Route::post('order/dispatched/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_dispatched'])->name('restaurant.order.dispatched')->where('id', '[0-9]+');
            Route::get('order/view/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'view'])->name('restaurant.order.view')->where('id', '[0-9]+');
            Route::post('order/preparation_time', [App\Http\Controllers\vendor\restaurant\OrderController::class,'get_preparation_time'])->name('restaurant.order.get_preparation_time')->where('id', '[0-9]+');


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
            Route::get('promotion/banner', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'index'])->name('restaurant.promotion.list');
            Route::get('promotion/on-screen-create', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'create_promotion'])->name('restaurant.promotion.create');
            Route::post('promotion/on-screen-store', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'store_slot'])->name('restaurant.slot.store');
            Route::get('promotion/on-screen-DATA', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'selctvalue'])->name('restaurant.slot.data');
            Route::get('promotion/on-screen-data', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'get_list_slotbook'])->name('restaurant.slot.list');
            Route::post('promotion/on-screen-checkdate', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'checkdate'])->name('restaurant.slot.checkdate');
            Route::post('promotion/on-screen-getprice', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'getPrice'])->name('restaurant.slot.getPrice');
            Route::get('promotion/on-screen-slot', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'getslot'])->name('restaurant.slot.checkslot');
//            Route::get('promotion/shop-promotion', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'shop_promotion'])->name('restaurant.shop.promotion');
//            Route::get('promotion/shop-promotion/create', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'crate_shop_promotion'])->name('restaurant.shop.promotion.create');
            Route::get('promotion/shop-promotion', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'shop_promotion'])->name('restaurant.shop.promotion');
            Route::get('promotion/shop-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'crate_shop_promotion'])->name('restaurant.shop.promotion.create');


            //dine out
            Route::get('dine-out-setting', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'dine_out_globle_setting'])->name('restaurant.dineout.setting');
            Route::post('dine-out-setting/edit', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'update'])->name('restaurant.dineout.update');
            Route::post('dine-out-setting/vendor-table-setting', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'vendor_table_setting'])->name('restaurant.dineout.vendor_table_setting');
            Route::post('dine-out-setting/active', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'dine_out_setting'])->name('restaurant.dineout.dine_out_setting');
            Route::get('dine-out/booking_requests', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'index'])->name('restaurant.dineout.index');
            Route::post('dine-out/accept/{id}', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'dine_out_accept'])->name('restaurant.dineout.accept')->where('id', '[0-9]+');
            Route::post('dine-out/reject/{id}', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'dine_out_reject'])->name('restaurant.dineout.reject')->where('id', '[0-9]+');

            //payment transection
            Route::post('payment', [App\Http\Controllers\vendor\restaurant\TransectionController::class,'payment_request'])->name('transection.request');

            Route::get('globle/bank', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'bank_details'])->name('restaurant.globleseting.bank_details');
            Route::post('globle/bank', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_bank_details'])->name('restaurant.globleseting.save_bank_details');

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

        Route::get('globle/require/bank', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'first_bank_details'])->name('restaurant.globleseting.first_bank_details');
        Route::post('globle/require/bank', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_bank_details'])->name('restaurant.globleseting.first_save_bank_details');

    });
});
