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
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\MessageController;

// customer controller 
use App\Http\Controllers\Customer\InformationController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\RegisterController;

// all controller
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CartController;

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
Route::get('policy/{slug}', [HomeController::class, 'policy'])->name('policy');
Route::get('contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('contact-us', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('new-arrival-product', [HomeController::class, 'newArrival'])->name('arrival');
Route::get('all-product', [HomeController::class, 'allProduct'])->name('allproduct');
// category product
Route::get('category/{slug}', [ViewController::class, 'categoryProduct'])->name('category');

// cart area routes
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{product_id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::post('add-to-cart-with-quantity', [CartController::class, 'addToCartWithQuantity'])->name('addtocart.withQuantity');
Route::post('add-to-cart-with-size-color-quantity', [CartController::class, 'addToCartWithSizeColorQuantity'])->name('addtocart.withSizeColorQuantity');
Route::post('buy-product-with-quantity', [CartController::class, 'buyNowWithQuantity'])->name('buynow');
Route::post('buy-product-with-size-color-quantity', [CartController::class, 'buyNowWithSizeColorQuantity'])->name('buynow.sizecolor.quantity');
Route::get('cart-remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');
Route::patch('update-cart', [CartController::class, 'cartUpdate'])->name('update_cart');
// details and  view
Route::get('product-details/{slug}', [ViewController::class, 'productDetails'])->name('productdetails');
Route::post('color-size-ajax', [ViewController::class, 'colorSizeAjax'])->name('color-size.ajax');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// register for customer
Route::get('customer-register', [RegisterController::class, 'customerRegister'])->name('customer.register');
Route::post('customer-register-confirm', [RegisterController::class, 'customerRegisterConfirm'])->name('customer.register.confirm');
Route::get('customer-otp-send', [RegisterController::class, 'customerOtpSend'])->name('customer.otp.send');
Route::post('customer-otp-check', [RegisterController::class, 'customerOtpCheck'])->name('customer.otp.check');
Route::get('customer-otp-resend', [RegisterController::class, 'customerOtpResend'])->name('customer.otp.resend');
Route::post('customer-info-save', [RegisterController::class, 'customerInfoSave'])->name('customer.info.save');

// admin routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('pass-updated/{id}', [DashboardController::class, 'updatePass'])->name('password.update');
    Route::get('contact-massage', [DashboardController::class, 'contactMassage'])->name('contact-massage');
    Route::get('contact-delete/{id}', [DashboardController::class, 'contactDelete'])->name('contact.delete');
    
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
    // policy
    Route::resource('policy', PolicyController::class);
    Route::get('policy-inactive/{id}', [PolicyController::class, 'policyInactive'])->name('policy.inactive');
    Route::get('policy-active/{id}', [PolicyController::class, 'policyActive'])->name('policy.active');
    // purchase
    Route::resource('purchase', PurchaseController::class);
    Route::post('stock-purchase', [PurchaseController::class, 'stockPurchase'])->name('stock.purchase');
    Route::resource('sold-product', StockController::class);
    Route::get('sold-search', [StockController::class, 'soldSearch'])->name('sold.search');
    Route::get('sold-product-report', [StockController::class, 'showReport'])->name('sold-product.report');
    Route::get('sold-product-report-search', [StockController::class, 'showReportSearch'])->name('sold-product-report.search');
    // location
    Route::resource('division', DivisionController::class);
    Route::get('division-active/{id}', [DivisionController::class, 'divisionActive'])->name('division.active');
    Route::get('division-inactive/{id}', [DivisionController::class, 'divisionInactive'])->name('division.inactive');
    Route::resource('district', DistrictController::class);
    Route::get('district-active/{id}', [DistrictController::class, 'districtActive'])->name('district.active');
    Route::get('district-inactive/{id}', [DistrictController::class, 'districtInactive'])->name('district.inactive');
    // Message
    Route::resource('message', MessageController::class);
});

// customer routes 
Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    Route::get('/information', [InformationController::class, 'index'])->name('information');
    
    Route::resource('checkout', CheckoutController::class);
});

Route::group(['as' => 'customer.', 'prefix' => 'customer', 'namespace' => 'Customer'], function () {
    // wishlist area with un authentication
    Route::post('review', [WishlistController::class, 'review'])->name('review');
});