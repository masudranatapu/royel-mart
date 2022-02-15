<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// admin controller 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\SubUnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\HappyClientController;
use App\Http\Controllers\Admin\BannerController;

// customer controller 
use App\Http\Controllers\Customer\InformationController;

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

Route::get('/', [HomeController::class, 'welcome'])->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('pass-updated/{id}', [DashboardController::class, 'updatePass'])->name('password.update');
    // website seeting
    Route::resource('website', WebsiteController::class);
    Route::post('get-add-row-', [WebsiteController::class, 'addRemoveRow'])->name('row.addremove');
    // category
    Route::resource('category', CategoryController::class);
    Route::get('category-active/{id}', [CategoryController::class, 'categoryActive'])->name('category.active');
    Route::get('category-inactive/{id}', [CategoryController::class, 'categoryInactive'])->name('category.inactive');
    // sub category
    Route::resource('parent-category', SubCategoryController::class);
    Route::get('subcategory-active/{id}', [SubCategoryController::class, 'subCategoryActive'])->name('subcategory.active');
    Route::get('subcategory-inactive/{id}', [SubCategoryController::class, 'subCategoryInactive'])->name('subcategory.inactive');
    // sub sub category
    Route::resource('child-category', SubSubCategoryController::class);
    Route::get('subsubcategory-active/{id}', [SubSubCategoryController::class, 'subSubCategoryActive'])->name('subsubcategory.active');
    Route::get('subsubcategory-inactive/{id}', [SubSubCategoryController::class, 'subSubCategoryInactive'])->name('subsubcategory.inactive');
    Route::post('category-ajax', [SubSubCategoryController::class, 'getCategoryId'])->name('category.ajax');
    // brand
    Route::resource('brand', BrandController::class);
    Route::get('brand-active/{id}', [BrandController::class, 'brandActive'])->name('brand.active');
    Route::get('brand-inactive/{id}', [BrandController::class, 'brandInactive'])->name('brand.inactive');
    
    // Unit
    Route::resource('unit', UnitController::class);
    Route::get('unit-active/{id}', [UnitController::class, 'unitActive'])->name('unit.active');
    Route::get('unit-inactive/{id}', [UnitController::class, 'unitInactive'])->name('unit.inactive');
    // sub unit
    Route::resource('sub-unit', SubUnitController::class);
    Route::get('sub-unit-active/{id}', [SubUnitController::class, 'subUnitActive'])->name('subunit.active');
    Route::get('sub-unit-inactive/{id}', [SubUnitController::class, 'subUnitInactive'])->name('subunit.inactive');
    // product
    Route::resource('product', ProductController::class);
    Route::post('product-unit-ajax', [ProductController::class, 'unitIdAjax'])->name('unitid.ajax');
    Route::get('product-category/ajax/{category_id}', [ProductController::class, 'productCategory']);
    Route::get('product-subcategory/ajax/{subcategory_id}', [ProductController::class, 'productSubcategory']);
    // slider
    Route::resource('slider', SliderController::class);
    Route::get('slider-active/{id}', [SliderController::class, 'sliderActive'])->name('slider.active');
    Route::get('slider-inactive/{id}', [SliderController::class, 'sliderInactive'])->name('slider.inactive');
    // happy client 
    Route::resource('happy-client', HappyClientController::class);
    Route::get('client-active/{id}', [HappyClientController::class, 'clientActive'])->name('client.active');
    Route::get('client-inactive/{id}', [HappyClientController::class, 'clientInactive'])->name('client.inactive');
    // banner
    Route::resource('banner', BannerController::class);
    Route::get('banner-active/{id}', [BannerController::class, 'bannerActive'])->name('banner.active');
    Route::get('banner-inactive/{id}', [BannerController::class, 'bannerInactive'])->name('banner.inactive');
    
});

// customer routes 
Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    Route::get('/information', [InformationController::class, 'index'])->name('information');
});