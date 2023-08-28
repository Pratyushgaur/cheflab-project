<?php
// vendor auth route
Route::group(['middleware' => ['isVendor'], 'prefix' => 'vendor'], function () {
    // restaurant route
    Route::group([
        'prefix' => 'restaurant',
                  'middleware' => ['isRestaurant']], function () {

                    Route::post('/time-model', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_model'])->name('restaurant.time.model');
                    Route::post('restaurent/time-model/save', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_save'])->name('restaurant.time.save');
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
            Route::get('menu-delete', [App\Http\Controllers\vendor\restaurant\MenuController::class, 'soft_delete'])->name('restaurant.menu.delete');
            Route::post('menu-inactive', [App\Http\Controllers\vendor\restaurant\MenuController::class,'menuStatus'])->name('restaurant.product.status');


            //vendor product
            Route::get('product', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'index'])->name('restaurant.product.list');
            Route::get('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'create'])->name('restaurant.product.create');
            Route::post('product/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'store'])->name('restaurant.product.store');
            Route::get('product/datatable/list', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'getData'])->name('restaurant.product.datatable');
            Route::get('product/addon/list', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'addons'])->name('restaurant.product.addon');
            Route::get('product/addon/datatable', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'getAddonData'])->name('restaurant.product.addon.datatable');
            Route::get('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'createAddon'])->name('restaurant.product.addon.create');
            Route::post('product/addon/create', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'storeAddon'])->name('restaurant.product.addon.store');
            Route::get('product/addon/edit/{id}', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'editAddon'])->name('restaurant.product.addon.edit');
            Route::post('product/addon/update', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'updateAddon'])->name('restaurant.product.addon.update');
            Route::get('product/addon/delete/{id}', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'delete_addon'])->name('restaurant.product.addon.delete');


            Route::post('product/inactive', [App\Http\Controllers\vendor\restaurant\ProductController::class,'inActive'])->name('restaurant.product.inactive');
            Route::post('product/active', [App\Http\Controllers\vendor\restaurant\ProductController::class,'Active'])->name('restaurant.product.active');
            Route::get('product/edit/{id}', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'fun_edit_product'])->name('vendor.product.edit');
            Route::post('product/update', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'update'])->name('restaurant.product.update');
            Route::get('product/delete', [App\Http\Controllers\vendor\restaurant\ProductController::class, 'delete'])->name('restaurant.product.delete');
            //vendor order linst
            Route::get('orders/{order_status?}', [App\Http\Controllers\vendor\restaurant\OrderController::class, 'index'])->name('restaurant.order.list');
//                ->whereIn('order_status', ['all','pending','confirmed','preparing','ready_to_dispatch','dispatched','cancelled_by_vendor','completed']);
            Route::post('order/accept/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_accept'])->name('restaurant.order.accept')->where('id', '[0-9]+');
            Route::post('order/vendor_reject/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_vendor_reject'])->name('restaurant.order.vendor_reject')->where('id', '[0-9]+');
            Route::post('order/preparing/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_preparing'])->name('restaurant.order.preparing')->where('id', '[0-9]+');
            Route::post('order/extend-preparation-time/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_need_more_time'])->name('restaurant.order.order_need_more_time')->where('id', '[0-9]+');
            Route::post('order/ready_to_dispatch/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_ready_to_dispatch'])->name('restaurant.order.ready_to_dispatch')->where('id', '[0-9]+');
            Route::post('order/dispatched/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'order_dispatched'])->name('restaurant.order.dispatched')->where('id', '[0-9]+');
            Route::get('order/view/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'view'])->name('restaurant.order.view')->where('id', '[0-9]+');
            Route::post('order/preparation_time', [App\Http\Controllers\vendor\restaurant\OrderController::class,'get_preparation_time'])->name('restaurant.order.get_preparation_time')->where('id', '[0-9]+');
            Route::post('order/set_preparation_time', [App\Http\Controllers\vendor\restaurant\OrderController::class,'get_set_preparation_time'])->name('restaurant.order.get_set_preparation_time')->where('id', '[0-9]+');
            Route::get('order/invoice/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'invoice'])->name('restaurant.order.invoice')->where('id', '[0-9]+');
            Route::get('order/qot/{id}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'qot'])->name('restaurant.order.qot')->where('id', '[0-9]+');
            Route::get('order/refresh_list/{staus_filter}', [App\Http\Controllers\vendor\restaurant\OrderController::class,'refresh_list'])->name('restaurant.order.refresh_list');

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
            
            // offers
            Route::get('offer', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'index'])->name('restaurant.offers.list');
            Route::get('offer-list', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'get_data_table_of_offer'])->name('restaurant.offer.data');
            Route::get('offer-create', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'create_offer'])->name('restaurant.offer.create');
            Route::post('offer-store', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'store_offer'])->name('restaurant.offer.store');
            Route::get('offer-edit/{id}', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'editOffer'])->name('restaurant.offer.edit');
            Route::post('offer-update/{id}', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'updateOffer'])->name('restaurant.offer.update');
            Route::get('offer-delete/{id}', [App\Http\Controllers\vendor\restaurant\OfferController::class, 'delete'])->name('restaurant.offer.delete');
            

            // vendor globle setting
            Route::get('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'order_time'])->name('restaurant.globleseting.ordertime');
            Route::post('globle/ordertime', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'store'])->name('restaurant.ordertime.store');
            Route::get('globle/auto_accept', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'order_auto_accept'])->name('restaurant.order.auto_accept');
            Route::post('globle/auto_accept', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'save_order_auto_accept'])->name('restaurant.order.save_order_auto_accept');

             
 
             Route::post('/time-edit', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_edit'])->name('restaurant.time.edit');
 
             Route::post('restaurent/time-model/update', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_update'])->name('restaurant.time.update');
 
             Route::get('time/delete', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_delete'])->name('restaurant.time.delete');

            Route::post('offline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_offline'])->name('restaurant.set_offline');
            Route::post('online', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'set_online'])->name('restaurant.set_online');
            Route::get('isonline', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'restaurent_get_status'])->name('restaurant.restaurent_get_status');
            Route::get('time/delete', [App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'time_delete'])->name('restaurant.time.delete');

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
            Route::get('promotion/shop-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'create_shop_promotion'])->name('restaurant.shop.promotion.create');
            Route::post('promotion/shop-promotion/position', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'get_positions'])->name('restaurant.shop.promotion.positions');
            Route::post('promotion/shop-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'save_shop_promotion'])->name('restaurant.shop.promotion.save');

            Route::get('promotion/product-promotion', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'product_promotion'])->name('restaurant.product.promotion');
            Route::get('promotion/product-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'create_product_promotion'])->name('restaurant.product.promotion.create');
            Route::post('promotion/product-promotion/position', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'product_get_positions'])->name('restaurant.product.promotion.positions');
            Route::post('promotion/product-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'save_product_promotion'])->name('restaurant.product.promotion.save');


            Route::get('promotion/banner-promotion/create', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'create_shop_promotion'])->name('restaurant.shop.promotion.create');
            Route::post('promotion/banner-promotion/position', [App\Http\Controllers\vendor\restaurant\BlogPromotionController::class,'get_positions'])->name('restaurant.shop.promotion.positions');


            //dine out
            Route::get('dine-out-order-setting', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'dine_out_order_time'])->name('restaurant.dineout.dine_out_order_time');
            Route::post('dine-out-order-setting/edit', [App\Http\Controllers\vendor\restaurant\DineoutController::class,'update_dine_out_order_time'])->name('restaurant.dineout.update_dine_out_order_time');
            Route::get('dineout/time/delete', [App\Http\Controllers\vendor\restaurant\DineoutController::class, 'time_delete'])->name('restaurant.dineout.time.delete');


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
            
            Route::get('globle/products/display-setting',[App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'product_display_setting'])->name('restaurant.globleseting.products.display_setting');
            Route::post('globle/products/display-setting',[App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'store_product_display_setting'])->name('restaurant.globleseting.products.display_setting.store');
            Route::get('globle/products/display-setting/delete/{id}',[App\Http\Controllers\vendor\restaurant\GlobleSetting::class, 'delete_product_display_setting'])->name('restaurant.globleseting.products.display_setting.delete.entry');

            Route::get('razorpay', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'razorpay'])->name('razorpay');
            Route::post('razorpaypayment', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'payment'])->name('payment');
            Route::post('banner_razorpaypayment', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'banner_payment'])->name('banner_payment');
//            Route::get('banner_razorpay', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'razorpay'])->name('banner_razorpay');

            Route::get('reviews/vendors', [App\Http\Controllers\vendor\restaurant\ReviewController::class,'index'])->name('restaurant.vendor.reviews');
            Route::get('reviews/products', [App\Http\Controllers\vendor\restaurant\ReviewController::class,'product_index'])->name('restaurant.product.reviews');

//            Route::get('product', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'index']);
//            Route::get('paysuccess', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'razorPaySuccess']);
//            Route::get('razor-thank-you', [App\Http\Controllers\vendor\restaurant\RazorpayRestaurantController::class, 'RazorThankYou']);

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

        Route::get('user/profile', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'profile'])->name('restaurant.profile');

        Route::post('user/profile/update', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'update'])->name('restaurant.update');
        Route::get('user/password', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'change_password'])->name('restaurant.vendor.change_password');
        Route::post('user/password', [App\Http\Controllers\vendor\restaurant\VendorController::class, 'update_password'])->name('restaurant.vendor.update_password');

        Route::post('user/profile/category/update',[App\Http\Controllers\vendor\restaurant\VendorController::class, 'update_profile_categories'])->name('restaurant.profile.update.category');
        Route::post('user/profile/cuisines/update',[App\Http\Controllers\vendor\restaurant\VendorController::class, 'update_profile_cuisines'])->name('restaurant.profile.update.cuisines');
        // mis
        Route::get('mis/renvenue', [App\Http\Controllers\vendor\restaurant\MisController::class, 'index'])->name('restaurant.mis.renvenue');
        Route::post('mis/order-list', [App\Http\Controllers\vendor\restaurant\MisController::class, 'order_list'])->name('restaurant.mis.order.list');
        Route::post('mis/renvenue-ajax', [App\Http\Controllers\vendor\restaurant\MisController::class, 'renvenue_ajax'])->name('restaurant.mis.renvenue.ajax');
        Route::get('mis/order/view/{id}', [App\Http\Controllers\vendor\restaurant\MisController::class, 'order_detail'])->name('restaurant.mis.order.view');
        Route::get('mis/order/export', [App\Http\Controllers\vendor\restaurant\MisController::class, 'oredr_export'])->name('restaurant.mis.order.export');
        Route::get('mis/renvenue/recipt/download/{id}', [App\Http\Controllers\vendor\restaurant\MisController::class, 'download_recipt'])->name('restaurant.mis.payout.download_recipt');

        Route::get('mis/order-data', [App\Http\Controllers\vendor\restaurant\MisController::class, 'order_data'])->name('restaurant.mis.order.data');
        Route::get('mis/renvenue/addition-view', [App\Http\Controllers\vendor\restaurant\MisController::class, 'addition_view'])->name('restaurant.mis.renvenue.addition');
        Route::get('mis/renvenue/deductions-view', [App\Http\Controllers\vendor\restaurant\MisController::class, 'deductions_view'])->name('restaurant.mis.renvenue.deductions');
        Route::get('mis/renvenue/settlements-view', [App\Http\Controllers\vendor\restaurant\MisController::class, 'settlements_view'])->name('restaurant.mis.renvenue.settlements');

        Route::get('mis/renvenue/settlements-list', [App\Http\Controllers\vendor\restaurant\MisController::class, 'settlements_list'])->name('restaurant.mis.renvenue.settlements.list');

        Route::get('mis/order-invoice-pdf', [App\Http\Controllers\vendor\restaurant\MisController::class, 'order_invoice'])->name('restaurant.mis.order.invoice.pdf');

        Route::get('mis/order-monthly-invoice-list', [App\Http\Controllers\vendor\restaurant\MisController::class, 'monthly_invoice_list'])->name('restaurant.mis.monthly_invoice_list');

        Route::get('mis/order-monthly-invoice-list-data', [App\Http\Controllers\vendor\restaurant\MisController::class, 'monthly_invoice_list_data'])->name('restaurant.mis.monthly_invoice_list_data');

        Route::get('mis/monthly-invoice/print/{id}', [App\Http\Controllers\vendor\restaurant\MisController::class, 'print_invoice'])->name('restaurant.mis.print.invoice');
    });
});
