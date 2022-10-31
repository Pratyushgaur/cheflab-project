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
        Route::get('chef-promotion', [App\Http\Controllers\chef\VendorPromotion::class,'index'])->name('chef.promotion.list');
        Route::get('on-screen-create', [App\Http\Controllers\chef\VendorPromotion::class,'create_promotion'])->name('chef.promotion.create');
        Route::post('on-screen-store', [App\Http\Controllers\chef\VendorPromotion::class,'store_slot'])->name('chef.slot.store');
        Route::get('on-screen-DATA', [App\Http\Controllers\chef\VendorPromotion::class,'selctvalue'])->name('chef.slot.data');
        Route::get('on-screen-data', [App\Http\Controllers\chef\VendorPromotion::class,'get_list_slotbook'])->name('chef.slot.list');
        Route::post('on-screen-checkdate', [App\Http\Controllers\chef\VendorPromotion::class,'checkdate'])->name('chef.slot.checkdate');
        Route::post('on-screen-getprice', [App\Http\Controllers\chef\VendorPromotion::class,'getPrice'])->name('chef.slot.getPrice');
        Route::get('on-screen-slot', [App\Http\Controllers\chef\VendorPromotion::class,'getslot'])->name('chef.slot.checkslot');





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
