<?php

Route::group(['middleware'=>['isChef'],'prefix' =>'chef'], function(){



        Route::get('dashbord', [App\Http\Controllers\chef\DashboardController::class,'index'])->name('chef.dashboard');
        //chef order linst
        Route::get('order', [App\Http\Controllers\chef\OrderController::class,'index'])->name('order.list');
        Route::get('order/datatable/list', [App\Http\Controllers\chef\OrderController::class,'getData'])->name('order.datatable');
        //coupon
        Route::get('coupon', [App\Http\Controllers\chef\VendorCoupon::class,'index'])->name('chef.coupon.list');
        Route::get('coupon-list', [App\Http\Controllers\chef\VendorCoupon::class,'get_data_table_of_coupon'])->name('chef.coupon.data');
        Route::get('coupon-create', [App\Http\Controllers\chef\VendorCoupon::class,'create_coupon'])->name('chef.coupon.create');
        Route::post('coupon-store', [App\Http\Controllers\chef\VendorCoupon::class,'store_coupon'])->name('chef.coupon.store');
        Route::get('coupon-couponcheck', [App\Http\Controllers\chef\VendorCoupon::class,'checkCoupon'])->name('chef.coupon.couponcheck');
        Route::get('coupon-couponcheckUpdate/{id}', [App\Http\Controllers\chef\VendorCoupon::class,'checkCouponUpdate'])->name('chef.coupon.couponcheckedit');
        Route::get('coupon-edit/{id}', [App\Http\Controllers\chef\VendorCoupon::class,'fun_edit_coupon'])->name('chef.coupon.edit');
        Route::post('coupon-update', [App\Http\Controllers\chef\VendorCoupon::class,'update'])->name('chef.coupon.update');
        Route::post('coupon-delete', [App\Http\Controllers\chef\VendorCoupon::class,'soft_delete'])->name('chef.coupon.delete');
        //vendor product
        Route::get('product-list', [App\Http\Controllers\chef\ChefProductController::class, 'index'])->name('chef.product.list');
        Route::get('product/datatable/list', [App\Http\Controllers\chef\ChefProductController::class, 'getData'])->name('chef.product.datatable');
        Route::post('product/inactive', [App\Http\Controllers\chef\ChefProductController::class,'inActive'])->name('chef.product.inactive');
        //promotion management
        //promotion management
        Route::get('promotion/banner', [App\Http\Controllers\chef\VendorPromotionController::class,'index'])->name('chef.promotion.list');
        Route::get('promotion/on-screen-create', [App\Http\Controllers\chef\VendorPromotionController::class,'create_promotion'])->name('chef.promotion.create');
        Route::post('promotion/on-screen-store', [App\Http\Controllers\chef\VendorPromotionController::class,'store_slot'])->name('chef.slot.store');
        Route::get('promotion/on-screen-DATA', [App\Http\Controllers\chef\VendorPromotionController::class,'selctvalue'])->name('chef.slot.data');
        Route::get('promotion/on-screen-data', [App\Http\Controllers\chef\VendorPromotionController::class,'get_list_slotbook'])->name('chef.slot.list');
        Route::post('promotion/on-screen-checkdate', [App\Http\Controllers\chef\VendorPromotionController::class,'checkdate'])->name('chef.slot.checkdate');
        Route::post('promotion/on-screen-getprice', [App\Http\Controllers\chef\VendorPromotionController::class,'getPrice'])->name('chef.slot.getPrice');
        Route::get('promotion/on-screen-slot', [App\Http\Controllers\chef\VendorPromotionController::class,'getslot'])->name('chef.slot.checkslot');
//            Route::get('promotion/shop-promotion', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'shop_promotion'])->name('restaurant.shop.promotion');
//            Route::get('promotion/shop-promotion/create', [App\Http\Controllers\vendor\restaurant\VendorPromotionController::class,'crate_shop_promotion'])->name('restaurant.shop.promotion.create');
        Route::get('promotion/shop-promotion', [App\Http\Controllers\chef\BlogPromotionController::class,'shop_promotion'])->name('chef.shop.promotion');
        Route::get('promotion/shop-promotion/create', [App\Http\Controllers\chef\BlogPromotionController::class,'create_shop_promotion'])->name('chef.shop.promotion.create');
        Route::post('promotion/shop-promotion/position', [App\Http\Controllers\chef\BlogPromotionController::class,'get_positions'])->name('chef.shop.promotion.positions');
        Route::post('promotion/shop-promotion/create', [App\Http\Controllers\chef\BlogPromotionController::class,'save_shop_promotion'])->name('chef.shop.promotion.save');

        Route::get('promotion/product-promotion', [App\Http\Controllers\chef\BlogPromotionController::class,'product_promotion'])->name('chef.product.promotion');
        Route::get('promotion/product-promotion/create', [App\Http\Controllers\chef\BlogPromotionController::class,'create_product_promotion'])->name('chef.product.promotion.create');
        Route::post('promotion/product-promotion/position', [App\Http\Controllers\chef\BlogPromotionController::class,'product_get_positions'])->name('chef.product.promotion.positions');
        Route::post('promotion/product-promotion/create', [App\Http\Controllers\chef\BlogPromotionController::class,'save_product_promotion'])->name('chef.product.promotion.save');
        //vendor order linst
        Route::get('orders', [App\Http\Controllers\chef\OrderController::class, 'index'])->name('chef.order.list');
        Route::post('order/accept/{id}', [App\Http\Controllers\chef\OrderController::class,'order_accept'])->name('chef.order.accept')->where('id', '[0-9]+');
        Route::post('order/vendor_reject/{id}', [App\Http\Controllers\chef\OrderController::class,'order_vendor_reject'])->name('chef.order.vendor_reject')->where('id', '[0-9]+');
        Route::post('order/preparing/{id}', [App\Http\Controllers\chef\OrderController::class,'order_preparing'])->name('chef.order.preparing')->where('id', '[0-9]+');
        Route::post('order/ready_to_dispatch/{id}', [App\Http\Controllers\chef\OrderController::class,'order_ready_to_dispatch'])->name('chef.order.ready_to_dispatch')->where('id', '[0-9]+');
        Route::post('order/dispatched/{id}', [App\Http\Controllers\chef\OrderController::class,'order_dispatched'])->name('chef.order.dispatched')->where('id', '[0-9]+');
        Route::get('order/view/{id}', [App\Http\Controllers\chef\OrderController::class,'view'])->name('chef.order.view')->where('id', '[0-9]+');
        Route::post('order/preparation_time', [App\Http\Controllers\chef\OrderController::class,'get_preparation_time'])->name('chef.order.get_preparation_time')->where('id', '[0-9]+');







        Route::get('globle', [App\Http\Controllers\chef\GlobleSetting::class,'index'])->name('chef.globleseting');
        Route::get('globle/ordertime', [App\Http\Controllers\chef\GlobleSetting::class,'order_time'])->name('chef.globleseting.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\chef\GlobleSetting::class,'store'])->name('chef.ordertime.store');
        //
        Route::get('globle/require/ordertime', [App\Http\Controllers\chef\GlobleSetting::class, 'requireOrderTime'])->name('chef.require.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\vendor\chef\GlobleSetting::class, 'store'])->name('chef.ordertime.first_store');





        Route::get('globle', [App\Http\Controllers\chef\GlobleSetting::class,'index'])->name('chef.globleseting');
        Route::get('globle/ordertime', [App\Http\Controllers\chef\GlobleSetting::class,'order_time'])->name('chef.globleseting.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\chef\GlobleSetting::class,'store'])->name('chef.ordertime.store');
        //
        Route::get('globle/require/ordertime', [App\Http\Controllers\chef\GlobleSetting::class, 'requireOrderTime'])->name('chef.require.ordertime');
        Route::post('globle/createtime', [App\Http\Controllers\vendor\chef\GlobleSetting::class, 'store'])->name('chef.ordertime.first_store');


//});
});
