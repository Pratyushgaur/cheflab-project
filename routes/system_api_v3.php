<?php 
 // restaurant detail
 Route::post('getRestaurantDetailPage', [App\Http\Controllers\api\v3\AppController::class, 'getRestaurantDetailPage']);
 Route::post('getTopRatedRestaurant', [App\Http\Controllers\api\v3\AppController::class, 'getTopRatedRestaurant']);
 Route::post('tryOnesMoreRestaurant', [App\Http\Controllers\api\v3\AppController::class, 'tryOnesMoreRestaurant']);
 Route::post('getRestauantMasterBlog', [App\Http\Controllers\api\v3\AppController::class, 'getRestauantMasterBlog']);
 Route::post('getopRatedProducts', [App\Http\Controllers\api\v3\AppController::class, 'getTopRatedProducts']);
 Route::post('geMostViewVendors', [App\Http\Controllers\api\v3\AppController::class, 'geMostViewVendors']);
 Route::post('search-data', [App\Http\Controllers\api\v3\AppController::class, 'getRestaurantSearchData']);
 Route::post('search-RestaurantDetail-Page', [App\Http\Controllers\api\v3\AppController::class, 'searchRestaurantDetailPage']);
