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
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\CategoryBannerController;
use App\Http\Controllers\Admin\AboutController;

// customer controller 
use App\Http\Controllers\Customer\InformationController;

// all controller
use App\Http\Controllers\ViewController;

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

Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about');
// category product
Route::get('category/{slug}', [ViewController::class, 'categoryProduct'])->name('category');

// details and  view
Route::get('product-details/{slug}', [ViewController::class, 'productDetails'])->name('productdetails');

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
    Route::get('parent-category-view/{id}', [CategoryController::class, 'viewParentCategory'])->name('viewparentcategory');
    Route::get('child-category-view/{id}', [CategoryController::class, 'viewChildCategory'])->name('viewchildcategory');
    // categoryBanner
    Route::resource('category-banner', CategoryBannerController::class);
    Route::get('category-banner-active/{id}', [CategoryBannerController::class, 'categoryBannerActive'])->name('categorybanner.active');
    Route::get('category-banner-inactive/{id}', [CategoryBannerController::class, 'categoryBannerInactive'])->name('categorybanner.inactive');
    // brand
    Route::resource('brand', BrandController::class);
    Route::get('brand-active/{id}', [BrandController::class, 'brandActive'])->name('brand.active');
    Route::get('brand-inactive/{id}', [BrandController::class, 'brandInactive'])->name('brand.inactive');
    // about
    Route::resource('abouts', AboutController::class);
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
    // mission vision
    Route::resource('mission-vision', MissionVisionController::class);
    Route::get('missionvison-active/{id}', [MissionVisionController::class, 'missionVisionActive'])->name('missionvision.active');
    Route::get('missionvison-inactive/{id}', [MissionVisionController::class, 'missionVisionInactive'])->name('missionvision.inactive');
    
});

// customer routes 
Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    Route::get('/information', [InformationController::class, 'index'])->name('information');
});