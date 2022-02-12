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
});

// customer routes 
Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    Route::get('/information', [InformationController::class, 'index'])->name('information');
});