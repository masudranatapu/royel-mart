<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// admin controller
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
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
use App\Http\Controllers\Admin\CategoryAdsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\QuickSaleController;

// customer controller
use App\Http\Controllers\Customer\InformationController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\GuestCheckoutController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\RegisterController;

// all controller
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TrackingOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CustomOrderController;

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
Route::get('language-change', [HomeController::class, 'language_change'])->name('language-change');

Auth::routes();

Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about');
Route::get('policy/{slug}', [HomeController::class, 'policy'])->name('policy');
Route::get('contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('contact-us', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('new-arrival-product', [HomeController::class, 'newArrival'])->name('arrival');
Route::get('all-product', [HomeController::class, 'allProduct'])->name('allproduct');
Route::post('load-more-product', [HomeController::class, 'load_more_product'])->name('load-more-product');
Route::get('all-category', [HomeController::class, 'all_category'])->name('all-category');
Route::get('policy-details/{slug}', [HomeController::class, 'policy'])->name('policy.details');
// category & brand product
Route::get('category/{slug}', [ViewController::class, 'categoryProduct'])->name('category');
Route::get('brand', [ViewController::class, 'brandProduct'])->name('brand');
Route::get('product-price', [ViewController::class, 'priceProduct'])->name('price');
Route::get('unit-product', [ViewController::class, 'unit_product'])->name('unit-product');
Route::get('filter-with-color', [ViewController::class, 'filter_with_color'])->name('filter-with-color');
// searching
Route::get('searching-product', [SearchController::class, 'searching'])->name('searching');
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
Route::get('quick-sale-product-details/{qs_slug}/{slug}', [ViewController::class, 'quick_sale_product_details'])->name('quick-sale-product-details');
Route::get('more-quick-sale-product/{slug}', [HomeController::class, 'more_quick_sale_product'])->name('more-quick-sale-product');

Route::post('color-size-ajax', [ViewController::class, 'colorSizeAjax'])->name('color-size.ajax');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// register for customer
Route::get('customer-register', [RegisterController::class, 'customerRegister'])->name('customer.register');
Route::post('customer-register-confirm', [RegisterController::class, 'customerRegisterConfirm'])->name('customer.register.confirm');
Route::get('customer-otp-send', [RegisterController::class, 'customerOtpSend'])->name('customer.otp.send');
Route::post('customer-otp-check', [RegisterController::class, 'customerOtpCheck'])->name('customer.otp.check');
Route::get('customer-otp-resend', [RegisterController::class, 'customerOtpResend'])->name('customer.otp.resend');
Route::post('customer-info-save', [RegisterController::class, 'customerInfoSave'])->name('customer.info.save');
// order track my order
Route::get('tracking-order', [TrackingOrderController::class, 'trackingOrder'])->name('track.my.order');
Route::get('tracking-order-view', [TrackingOrderController::class, 'trackingorderView'])->name('trackingorder.view');

// custom order route-------------
Route::post('custom-order-submit', [CustomOrderController::class, 'store'])->name('custom-order-submit');


// admin routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('pass-updated/{id}', [DashboardController::class, 'updatePass'])->name('password.update');
    Route::get('contact-massage', [DashboardController::class, 'contactMassage'])->name('contact-massage');
    Route::get('contact-delete/{id}', [DashboardController::class, 'contactDelete'])->name('contact.delete');

    // system setting-------------------------
    Route::resource('system-setting', SystemSettingController::class);

    // website seeting
    Route::resource('website', WebsiteController::class);
    Route::post('get-add-row-', [WebsiteController::class, 'addRemoveRow'])->name('row.addremove');
    // category
    Route::resource('category', CategoryController::class);
    Route::get('category-active/{id}', [CategoryController::class, 'categoryActive'])->name('category.active');
    Route::get('category-inactive/{id}', [CategoryController::class, 'categoryInactive'])->name('category.inactive');
    Route::get('parent-category-view/{slug}', [CategoryController::class, 'viewParentCategory'])->name('view-parent-category');
    Route::get('child-category-view/{slug}', [CategoryController::class, 'viewChildCategory'])->name('viewchildcategory');
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
    // Color routes
    Route::resource('color', ColorController::class);
    Route::get('color-active/{id}', [ColorController::class, 'colorActive'])->name('color.active');
    Route::get('color-inactive/{id}', [ColorController::class, 'colorInactive'])->name('color.inactive');
    // Size routes
    Route::resource('size', SizeController::class);
    Route::get('size-active/{id}', [SizeController::class, 'sizeActive'])->name('size.active');
    Route::get('size-inactive/{id}', [SizeController::class, 'sizeInactive'])->name('size.inactive');
    // sub unit
    Route::resource('sub-unit', SubUnitController::class);
    Route::get('sub-unit-active/{id}', [SubUnitController::class, 'subUnitActive'])->name('subunit.active');
    Route::get('sub-unit-inactive/{id}', [SubUnitController::class, 'subUnitInactive'])->name('subunit.inactive');
    // product
    Route::resource('product', ProductController::class);
    Route::post('product-unit-ajax', [ProductController::class, 'unitIdAjax'])->name('unitid.ajax');
    Route::post('product-color-ajax', [ProductController::class, 'colorIdAjax'])->name('color_id.ajax');
    Route::get('product-category/ajax/{category_id}', [ProductController::class, 'productCategory']);
    Route::post('parent-category-for-product', [ProductController::class, 'parent_category_for_product'])->name('parent-category-for-product');
    Route::post('child-category-for-product', [ProductController::class, 'child_category_for_product'])->name('child-category-for-product');
    Route::post('get-category-product-for-qs', [ProductController::class, 'get_category_product_for_qs'])->name('get-category-product-for-qs');
    Route::post('add-product-to-qs-list', [ProductController::class, 'add_product_to_qs_list'])->name('add-product-to-qs-list');
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

    // report---------------------
    Route::get('stock-report', [StockController::class, 'stock_report'])->name('stock-report');
    Route::get('sold-product-report-search', [StockController::class, 'showReportSearch'])->name('sold-product-report.search');

    Route::post('add-product-for-purchase', [PurchaseController::class, 'add_product_for_purchase'])->name('add-product-for-purchase');
    Route::post('store-product-for-purchase', [PurchaseController::class, 'store'])->name('store-product-for-purchase');
    Route::post('update-product-for-purchase/{code}', [PurchaseController::class, 'update'])->name('update-product-for-purchase');

    // location
    Route::resource('division', DivisionController::class);
    Route::get('division-active/{id}', [DivisionController::class, 'divisionActive'])->name('division.active');
    Route::get('division-inactive/{id}', [DivisionController::class, 'divisionInactive'])->name('division.inactive');
    Route::resource('district', DistrictController::class);
    Route::get('district-active/{id}', [DistrictController::class, 'districtActive'])->name('district.active');
    Route::get('district-inactive/{id}', [DistrictController::class, 'districtInactive'])->name('district.inactive');
    // Message
    Route::resource('message', MessageController::class);
    Route::resource('category-ads', CategoryAdsController::class);
    Route::get('category-ads-active/{id}', [CategoryAdsController::class, 'categoryAdsActive'])->name('category-ads.active');
    Route::get('category-ads-inactive/{id}', [CategoryAdsController::class, 'categoryAdsInactive'])->name('category-ads.inactive');

    // Voucher routes
    Route::resource('voucher', VoucherController::class);
    Route::get('voucher-activity/{id}', [VoucherController::class, 'voucher_activity'])->name('voucher-activity');

    // Quick sale routes
    Route::resource('quick-sale', QuickSaleController::class);
    Route::get('quick-sale-activity/{id}', [QuickSaleController::class, 'quick_sale_activity'])->name('quick-sale-activity');
    Route::get('quick-sale-product/{id}', [QuickSaleController::class, 'quick_sale_product'])->name('quick-sale-product');
    Route::post('update-quick-sale-product', [QuickSaleController::class, 'update_quick_sale_product'])->name('update-quick-sale-product');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::get('orders-pending', [OrderController::class, 'ordersPending'])->name('orders.pending');
    Route::get('orders-confirmed', [OrderController::class, 'ordersConfirmed'])->name('orders.confirmed');
    Route::get('orders-processing', [OrderController::class, 'ordersProcessing'])->name('orders.processing');
    Route::get('orders-delivered', [OrderController::class, 'ordersDelivered'])->name('orders.delivered');
    Route::get('orders-successed', [OrderController::class, 'ordersSuccessed'])->name('orders.successed');
    Route::get('orders-canceled', [OrderController::class, 'ordersCanceled'])->name('orders.canceled');

    Route::get('custom-order', [OrderController::class, 'custom_order'])->name('custom-order');
    Route::post('custom-order-status-change', [OrderController::class, 'custom_order_status_change'])->name('custom-order-status-change');
    // order status change
    Route::post('order-status-change', [OrderController::class, 'order_status_change'])->name('order-status-change');
    Route::post('order-due-payment/{id}', [OrderController::class, 'order_due_payment'])->name('order-due-payment');
    Route::post('adjust-order-shipping-charge/{id}', [OrderController::class, 'adjust_order_shipping_charge'])->name('adjust-order-shipping-charge');

});

// customer routes
Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    Route::get('/information', [InformationController::class, 'index'])->name('information');
    Route::get('password-change', [InformationController::class, 'passChangeView'])->name('password.change');
    Route::post('pass-updated/{id}', [InformationController::class, 'updatePass'])->name('password.update');
    Route::resource('checkout', CheckoutController::class);
    Route::get('division-district/ajax/{div_id}', [CheckoutController::class, 'getDivDis']);
    Route::get('district-division/ajax/{dis_id}', [CheckoutController::class, 'getDisDiv']);
    Route::post('voucher-check-with-auth', [CheckoutController::class, 'voucher_check_with_auth'])->name('voucher-check-with-auth');
    Route::get('delete-shipping-address/{id}', [CheckoutController::class, 'deleteShippingAddress'])->name('deleteshipping.address');
    Route::get('shipping-address-update/{id}', [CheckoutController::class, 'shippingAddressUpdate'])->name('shippingaddress.update');
    // my order view
    Route::get('my-order', [WishlistController::class, 'orderIndex'])->name('order');
    Route::get('my-order-view/{id}', [WishlistController::class, 'orderView'])->name('order.view');
    Route::post('review', [WishlistController::class, 'review'])->name('review');
    // checkout
});

Route::group(['as' => 'customer.', 'prefix' => 'customer'], function () {
    // wishlist area with un authentication
    Route::resource('guest-checkout', GuestCheckoutController::class);
    Route::post('division-district', [GuestCheckoutController::class, 'getDivDis'])->name('division-district');
    Route::post('district-division', [GuestCheckoutController::class, 'getDisDiv'])->name('district-division');
    Route::get('voucher-check-with-guest', [GuestCheckoutController::class, 'voucher_check_with_guest'])->name('voucher-check-with-guest');

    Route::post('guest-register-otp-send', [RegisterController::class, 'customerGuestRegisterSend'])->name('guestregister.send');
    Route::get('guest-otp-confirm', [RegisterController::class, 'customerGuestOtpConfirm'])->name('guestotp.send');
    Route::post('guest-otp-resend', [RegisterController::class, 'customerGuestOtpResend'])->name('guestotp.resend');
    Route::post('guest-checkout-product', [RegisterController::class, 'customerGuestOtpCheck'])->name('guestotp.check');
});
