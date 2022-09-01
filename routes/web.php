<?php

use Illuminate\Support\Facades\Route;
//use Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin-logout',function(){
    Auth::logout();
    Session::flush();
    return  redirect('admin');
})->name('admin.logout');
Route::view('admin','admin/login-2')->name('admin.login')->middleware('isadminloginAuth');
Route::post('check-login-for-admin',[App\Http\Controllers\admin\Cn_login::class,'admin_login']);

Route::group(['middleware'=>['isAdmin'],'prefix' =>'admin'], function(){
    // City Module 
    Route::get('dashbord-admin', [App\Http\Controllers\admin\Dashboard::class,'index'])->name('admin.dashboard');
    Route::get('city', [App\Http\Controllers\admin\City::class,'index'])->name('city');
    Route::post('city-action', [App\Http\Controllers\admin\City::class,'cityAction'])->name('city.action');
    Route::post('city-update', [App\Http\Controllers\admin\City::class,'update'])->name('city.update');
    Route::get('city-datatable', [App\Http\Controllers\admin\City::class, 'get_data_table_of_city'])->name('city.getDataTable');
    Route::get('check-duplicate-city', [App\Http\Controllers\admin\City::class,'check_duplicate_city'])->name('check-duplicate-city');
    Route::get('check-edit-duplicate-city/{id}', [App\Http\Controllers\admin\City::class,'check_edit_duplicate_city'])->name('check-edit-duplicate-city');
    Route::get('edit-city/{id}', [App\Http\Controllers\admin\City::class, 'fun_edit_city'])->name('fun_edit_city');
    Route::post('city/delete', [App\Http\Controllers\admin\City::class, 'soft_delete'])->name('admin.city.ajax.delete');
    // vendor's
    Route::get('vendors', [App\Http\Controllers\admin\UserControllers::class,'index'])->name('admin.vendors.list');
    Route::get('vendors-datatable', [App\Http\Controllers\admin\UserControllers::class,'get_data_table_of_vendor'])->name('admin.vendors.datatable');
    Route::get('vendors-restourant-create', [App\Http\Controllers\admin\UserControllers::class,'create_restourant'])->name('admin.restourant.create');
    Route::get('vendors-vendors-emailcheck', [App\Http\Controllers\admin\UserControllers::class,'checkEmailExist'])->name('admin.vendor.emailcheck');
    Route::get('vendors-vendors-mobilecheck', [App\Http\Controllers\admin\UserControllers::class,'checkMobileExist'])->name('admin.vendor.mobilecheck');
    Route::post('vendors-restourant-store', [App\Http\Controllers\admin\UserControllers::class,'store_restourant'])->name('admin.restourant.store');
    //
    Route::get('vendors-view/{id}', [App\Http\Controllers\admin\UserControllers::class,'view_vendor'])->name('admin.vendor.view');
    //
    //chef route
    Route::get('vendors-chef-create', [App\Http\Controllers\admin\UserControllers::class,'create_chef'])->name('admin.chef.create');
    Route::post('vendors-chef-store', [App\Http\Controllers\admin\UserControllers::class,'store_chef'])->name('admin.chef.store');
    // categoryies
    Route::get('category', [App\Http\Controllers\admin\Category::class,'index'])->name('admin.category.create');
    Route::post('category', [App\Http\Controllers\admin\Category::class,'store_catogory'])->name('admin.category.store');
    Route::get('category-datatable', [App\Http\Controllers\admin\Category::class,'get_data_table_of_category'])->name('admin.category.datatable');
    Route::get('edit-category/{id}', [App\Http\Controllers\admin\Category::class, 'fun_edit_category']);
    Route::post('category/delete', [App\Http\Controllers\admin\Category::class, 'soft_delete'])->name('admin.category.ajax.delete');
    // cuisiness
    Route::get('cuisines', [App\Http\Controllers\admin\CuisinesController::class,'index'])->name('admin.cuisines.create');
    Route::post('cuisines', [App\Http\Controllers\admin\CuisinesController::class,'store_cuisines'])->name('admin.cuisines.store');
    Route::get('cuisines-datatable', [App\Http\Controllers\admin\CuisinesController::class,'get_data_table_of_cuisines'])->name('admin.cuisines.datatable');
    Route::get('edit-cuisines/{id}', [App\Http\Controllers\admin\CuisinesController::class, 'fun_edit_category']);
    Route::post('cuisines/delete', [App\Http\Controllers\admin\CuisinesController::class, 'soft_delete'])->name('admin.cuisines.ajax.delete');
    // product routes
    Route::get('products', [App\Http\Controllers\admin\ProductController::class,'index'])->name('admin.product.create');
    Route::get('vendor/products/create/{id}', [App\Http\Controllers\admin\ProductController::class,'index'])->name('admin.vendor.product.create');
    
});

//Route::get('city', [App\Http\Controllers\admin\Cn_master_city::class,'index'])->name('city');