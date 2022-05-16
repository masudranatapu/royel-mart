<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\ApiController;
use \App\Http\Controllers\api\ApiProductController;
use \App\Http\Controllers\api\ApiAuthController;

Route::Group(['middleware' => 'CheckApiKey'], function () {

    Route::post('/settings', [ApiController::class,'settings']);

});

Route::Group(['middleware' => 'CheckApiKey'], function () {

    Route::post('/slider', [ApiController::class,'slider']);
    Route::post('/banner', [ApiController::class,'banner']);
    Route::post('/slider_bottom_banner', [ApiController::class,'slider_bottom_banner']);


    Route::post('/new-arrivals', [ApiProductController::class,'newArrivals']);
    Route::post('/top-rated-products', [ApiProductController::class,'topRatedProducts']);
    Route::post('/featured-products', [ApiProductController::class,'featuredroducts']);
    Route::post('/all-products', [ApiProductController::class,'allproducts']);

    Route::post('/brands', [ApiController::class,'brands']);
    Route::post('/categories', [ApiController::class,'categories']);
    Route::post('/categories_new', [ApiController::class,'categoriesNew']);
    Route::post('/sub-categories_or_products', [ApiController::class,'subCategoriesOrProducts']);
    Route::post('/sub-categories', [ApiController::class,'subCategories']);

    Route::post('/products/by/brand', [ApiProductController::class,'productsByBrand']);
    Route::post('/products/by/category', [ApiProductController::class,'productsByCategory']);
    Route::post('/products/by/sub-category', [ApiController::class,'productsBySubCategory']);

    Route::post('/search', [ApiProductController::class,'search']);
    Route::post('/search_filter_option', [ApiController::class,'searchFilterOption']);

    Route::post('/products/by/price', [ApiController::class,'productsByPrice']);
    Route::post('/product/by/id', [ApiProductController::class,'productById']);
    Route::post('/product/by_slug/{slug}', [ApiProductController::class,'productBySlug']);


    Route::post('/divisions', [ApiController::class,'divisions']);
    Route::post('/districts', [ApiController::class,'districts']);



    Route::post('/ads', [ApiController::class,'ads']);
    Route::post('/campaining', [ApiController::class,'campaining']);
    Route::post('/campaining_products', [ApiController::class,'productsByCampaining']);
    Route::post('/campain', [ApiController::class,'campain']);
    Route::post('/all-reviews/by/product', [ApiController::class,'allReviewsByProduct']);

    Route::post('/contact', [ApiController::class,'contact']);



    Route::post('/fav-list', [ApiController::class,'testGal']);

});


Route::Group(['middleware' => 'CheckApiKey'], function () {

    Route::post('/phone_verify_for_sign_up', [ApiAuthController::class,'phoneVerifyForsignUp']);
    Route::post('/sign-up', [ApiAuthController::class,'signUp']);
    Route::post('/sign-in', [ApiAuthController::class,'signIn']);

    Route::post('/reset-password', [ApiAuthController::class,'resetPass']);
    Route::post('/verify-otp', [ApiAuthController::class,'verifyOtp']);
    Route::post('/reset_password_by_otp', [ApiAuthController::class,'resetPasswordByOtp']);

});


Route::Group(['middleware' => ['CheckApiKey', 'auth:api']], function () {


    Route::post('/sign-out', [ApiAuthController::class,'signOut']);

    Route::post('/details', [ApiAuthController::class,'details']);
    Route::post('/profile-details', [ApiAuthController::class,'profileDetails']);
    Route::post('/update-profile', [ApiAuthController::class,'updateProfile']);
    Route::post('/update-profile-image', [ApiAuthController::class,'updateProfileImage']);
    Route::post('/change-password', [ApiAuthController::class,'changePassword']);

    Route::post('/wishlist', [ApiAuthController::class,'wishlist']);
    Route::post('/send-review', [ApiAuthController::class,'sendReview']);

    Route::post('/shipping-addresses', [ApiAuthController::class,'shippingAddresses']);
    Route::post('/billing-addresses', [ApiAuthController::class,'billingAddresses']);
    Route::post('/shipping-methods', [ApiAuthController::class,'shippingMethods']);
    Route::post('/save/billing-address', [ApiAuthController::class,'saveBillingAddress']);
    Route::post('/save/shipping-address', [ApiAuthController::class,'saveShippingAddress']);
    Route::post('/delete/shipping-address', [ApiAuthController::class,'deleteShippingAddress']);
    Route::post('/place-order', [ApiAuthController::class,'placeOrder']);
    Route::post('/voucher_check', [ApiAuthController::class,'voucherCheck']);


    Route::post('/place-order-one', [ApiAuthController::class,'placseOrderOne']);
    Route::post('/place-order-two', [ApiAuthController::class,'placseOrderTwo']);
    Route::post('/place-order-three', [ApiAuthController::class,'placseOrderThree']);
    Route::post('/payment-methods', [ApiAuthController::class,'paymentMethods']);
    Route::post('/payment_success', [ApiAuthController::class,'payment_success']);
    Route::post('/order-history', [ApiAuthController::class,'orderHistory']);
    Route::post('/order-details', [ApiAuthController::class,'orderDetails']);
    Route::post('/update/order-seen', [ApiAuthController::class,'updateOrderSeen']);
    Route::post('/wallet-balance', [ApiAuthController::class,'eWalletBalance']);

});


