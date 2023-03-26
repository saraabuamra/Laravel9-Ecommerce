<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
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

          //Brands
        Route::get('brands','BrandController@brands');

        //Update brand Status
        Route::post('update-brand-status','BrandController@updateBrandStatus');

        //delete brand
        Route::get('delete-brand/{id}','BrandController@deleteBrand');

        //add edit brand
        Route::match(['get', 'post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

          //Categories
        Route::get('categories','CategoryController@categories');

        //Update Category Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');

        //delete category
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');


        //add edit category
        Route::match(['get', 'post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

        Route::get('append-categories-level','CategoryController@appendCategoryLevel');


          //Products
          Route::get('products','ProductController@products');

          //Update Product Status
          Route::post('update-product-status','ProductController@updateProductStatus');
  
          //delete product
          Route::get('delete-product/{id}','ProductController@deleteProduct');

            //add edit product
        Route::match(['get', 'post'],'add-edit-product/{id?}','ProductController@addEditProduct');
          //delete product image
        Route::get('delete-product-image/{id}','ProductController@deleteProductImage');
           //delete product video
        Route::get('delete-product-video/{id}','ProductController@deleteProductVideo');

          //Attributes
          Route::match(['get', 'post'],'add-edit-attributes/{id?}','ProductController@addAttributes');
          //Update Attribute Status
          Route::post('update-attribute-status','ProductController@updateAttributeStatus');
          //delete product
          Route::get('delete-attribute/{id}','ProductController@deleteAttribute');

          Route::match(['get', 'post'],'edit-attributes/{id}','ProductController@editAttributes');

           //Filters
           Route::get('filters','FilterController@filters');
           Route::get('filters-values','FilterController@filtersValues');
           Route::post('update-filter-status','FilterController@updateFilterStatus');
           Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
           Route::match(['get', 'post'],'add-edit-filters/{id?}','FilterController@addEditFilter');
           Route::match(['get', 'post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
           Route::post('category-filters','FilterController@categoryFilters');
           Route::get('delete-filter/{id}','FilterController@deleteFilter');


          //images
           Route::match(['get', 'post'],'add-images/{id}','ProductController@addImages');
            //Update image Status
          Route::post('update-image-status','ProductController@updateImageStatus');
          //delete image
          Route::get('delete-image/{id}','ProductController@deleteImage');


          //Banners
           Route::get('banners','BannersController@banners');
             //Update banner Status
          Route::post('update-banner-status','BannersController@updateBannerStatus');
          //delete banner
          Route::get('delete-banner/{id}','BannersController@deleteBanner');
          //add-edit-banner
          Route::match(['get', 'post'],'add-edit-banner/{id?}','BannersController@addEditBanner');
         


    });

});

Route::namespace('App\Http\Controllers\Front')->group(function(){
  Route::get('/','IndexController@index');


    //listing|categories Routes
  $catUrl = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
  foreach ($catUrl as $key => $url){
   Route::match(['get','post'],'/'.$url,'ProductsController@listing');
  }

  // Vendor Products
  Route::get('/products/{vendorid}','ProductsController@vendorListing');

  // Product Details Page
  Route::get('/product/{id}','ProductsController@detail');

  // Get Product Attribute Price
  Route::post('get-product-price','ProductsController@getProductPrice');

  // Vendor Login/Register
  Route::get('vendor/login-register','VendorController@loginRegister');

  //vendor Register
  Route::post('vendor/register','VendorController@vendorRegister');

  //Confirm Vendor Account
  Route::get('vendor/confirm/{code}','VendorController@confirmVendor');

  // Add to Cart Route
  Route::post('cart/add','ProductsController@cartAdd');

  // Cart Route
  Route::get('/cart','ProductsController@cart');
});

