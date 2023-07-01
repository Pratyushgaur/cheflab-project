<?php
// vendor auth route
Route::group(['middleware' => ['isAppVendor'], 'prefix' => 'vendor'], function () {
    // restaurant route
    Route::group(['prefix' => 'restaurant','middleware' => ['isAppRestaurant','IsAppVendorDoneSettingsMiddleware']], function () {
        Route::get('dashbord/{id}', [App\Http\Controllers\app\DashboardController::class, 'index'])->name('app.restaurant.dashboard');
        Route::post('accept/order', [App\Http\Controllers\app\DashboardController::class, 'order_preparing'])->name('app.restaurant.acceptOrder');
        Route::post('ready/order', [App\Http\Controllers\app\DashboardController::class, 'order_ready_to_dispatch'])->name('app.restaurant.ready_to_dispatch');
        Route::get('app/dashbord/refresh', [App\Http\Controllers\app\DashboardController::class, 'refresh_list'])->name('app.restaurant.order.refresh_list');
        Route::post('reject/order', [App\Http\Controllers\app\DashboardController::class, 'order_vendor_reject'])->name('app.restaurant.order.reject');
    
    });
});
