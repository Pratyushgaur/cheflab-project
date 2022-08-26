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
Route::view('admin','admin/login')->name('admin.login')->middleware('isadminloginAuth');
Route::post('check-login-for-admin',[App\Http\Controllers\admin\Cn_login::class,'admin_login']);

Route::group(['middleware'=>['isAdmin'],'prefix' =>'admin'], function(){
    // City Module 
    Route::get('dashbord-admin', [App\Http\Controllers\admin\Dashboard::class,'index'])->name('admin.dashboard');
    Route::get('city', [App\Http\Controllers\admin\City::class,'index'])->name('city');
    Route::post('city-action', [App\Http\Controllers\admin\City::class,'cityAction'])->name('city.action');
    Route::get('city-datatable', [App\Http\Controllers\admin\City::class, 'get_data_table_of_city'])->name('city.getDataTable');
    Route::post('check-duplicate-city', [App\Http\Controllers\admin\City::class,'check_duplicate_city']);
    Route::get('edit-city/{id}', [App\Http\Controllers\admin\City::class, 'fun_edit_city']);
    //
    Route::get('vendors', [App\Http\Controllers\admin\UserControllers::class,'index'])->name('admin.vendors.list');
    Route::get('vendors-datatable', [App\Http\Controllers\admin\UserControllers::class,'get_data_table_of_vendord'])->name('admin.vendors.datatable');
    Route::get('vendors-restourant-create', [App\Http\Controllers\admin\UserControllers::class,'create_restourant'])->name('admin.restourant.create');

});

//Route::get('city', [App\Http\Controllers\admin\Cn_master_city::class,'index'])->name('city');