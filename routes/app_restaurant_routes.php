<?php
// vendor auth route
Route::group(['middleware' => ['isAppVendor'], 'prefix' => 'vendor'], function () {
    // restaurant route
Route::group(['prefix' => 'restaurant','middleware' => ['isAppRestaurant','IsAppVendorDoneSettingsMiddleware']], function () {
        Route::get('dashbord/{id}', [App\Http\Controllers\app\DashboardController::class, 'index'])->name('app.restaurant.dashboard');
    });
});
