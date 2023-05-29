<?php 
 // restaurant detail
 Route::post('getRestaurantDetailPage', [App\Http\Controllers\api\v3\AppController::class, 'getRestaurantDetailPage']);
 Route::post('getTopRatedRestaurant', [App\Http\Controllers\api\v3\AppController::class, 'getTopRatedRestaurant']);
 Route::post('tryOnesMoreRestaurant', [App\Http\Controllers\api\v3\AppController::class, 'tryOnesMoreRestaurant']);
 Route::post('getRestauantMasterBlog', [App\Http\Controllers\api\v3\AppController::class, 'getRestauantMasterBlog']);
 Route::post('getopRatedProducts', [App\Http\Controllers\api\v3\AppController::class, 'getTopRatedProducts']);
 Route::post('geMostViewVendors', [App\Http\Controllers\api\v3\AppController::class, 'geMostViewVendors']);
