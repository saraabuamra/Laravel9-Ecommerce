<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //Admin Login Route
    Route::match(['get', 'post'],'login','AdminController@login')->name('login');
    Route::group(['middleware' => ['admin']],function(){

        //Admin Dashboard Route
        Route::get('dashboard','AdminController@dashboard')->name('dashboard');

        //Update Admin Password
        Route::match(['get','post'],'update-admin-password',
        'AdminController@updateAdminPassword')->name('update-admin-password');

        //Check Admin Password
        Route::post('check-admin-password',
        'AdminController@checkAdminPassword')->name('check-admin-password');

        //Update Admin Details
        Route::match(['get','post'],'update-admin-details',
        'AdminController@updateAdminDetails')->name('update-admin-details');

        //Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}',
        'AdminController@updateVendorDetails');
        
        //View Admins /Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        //View Vendor Details
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

        //Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');

        //Admin Logout
        Route::get('logout','AdminController@logout')->name('logout');

        //Sections
        Route::get('sections','SectionController@sections');

         //Update Section Status
         Route::post('update-section-status','SectionController@updateSectionStatus');

         //delete section
         Route::get('delete-section/{id}','SectionController@deleteSection');

         //add edit section
         Route::match(['get', 'post'],'add-edit-section/{id?}','SectionController@addEditSection');

          //Categories
        Route::get('categories','CategoryController@categories');

        //Update Category Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');

        //delete category
        Route::get('delete-category/{id}','CategoryController@deleteCategory');

        //add edit category
        Route::match(['get', 'post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

    });

});

