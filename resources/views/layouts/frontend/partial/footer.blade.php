@php
    $website = App\Models\Website::latest()->first();
    $clients = App\Models\Client::latest()->get();
@endphp
<section class="informations-section padding-20-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-3 mb-md-0 mb-sm-4 mb-3">
                <div class="single-info">
                    <h4 class="title">payment method</h4>
                    <ul class="payments">
                        <li><img src="{{asset('frontend/images/payments/1.jpg')}}" alt=""></li>
                        <li><img src="{{asset('frontend/images/payments/2.jpg')}}" alt=""></li>
                        <li><img src="{{asset('frontend/images/payments/3.jpg')}}" alt=""></li>
                        <li><img src="{{asset('frontend/images/payments/4.jpg')}}" alt=""></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-8 mb-md-0 mb-sm-4 mb-3 mx-auto">
                <div class="single-info">
                    <h4 class="title text-center">client slide set</h4>
                    <ul class="client-carousel owl-carousel">
                        @foreach($clients as $client)
                            <li><img src="{{ asset($client->image) }}" alt=""></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3 mb-md-0 mb-4">
                <div class="single-info">
                    <h4 class="title">Social Link</h4>
                    <ul class="social">
                        @php
                            $icon = explode("|",$website->icon);
                            $link = explode("|",$website->link);
                        @endphp
                        @foreach($icon as $key=>$icon)
                            <li class="{{$icon}}"><a href="@if(isset($link[$key])){{$link[$key]}}@endif"><i class="fa fa-{{$icon}}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a class="chat-btn" href="#"><i class="bi bi-chat-square-text"></i> live chat</a>
</section>
<!-- End Informations -->
<footer class="footer-section">
    <div class="footer-top pt-40 pb-40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-6 mb-lg-0 mb-sm-4 mb-3">
                    <div class="footer-logo">
                        <a href="{{ route('home') }}"><img src="{{asset('frontend/images/logo/logo.png')}}" alt=""></a>
                    </div>
                    <p class="footer-contact">
                        <span class="d-block">Address : {{ $website->address }}</span>
                        <span class="d-block">Email: {{ $website->email }}</span>
                        <span class="d-block">Contact no: {{ $website->phone }}</span>
                    </p>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-lg-0 mb-sm-4 mb-3">
                    <h3 class="footer-title">information</h3>
                    <ul class="footer-links">
                        <li><a href="#">new arrival</a></li>
                        <li><a href="#">specials</a></li>
                        <li><a href="#">hot deals</a></li>
                        <li><a href="#">backpacks</a></li>
                        <li><a href="#">women's fashion</a></li>
                    </ul>
                </div>
                <div class="mobile-border"></div>
                <div class="col-lg-2 col-md-3 col-6 mb-lg-0 mb-sm-4 mb-3">
                    <h3 class="footer-title">our services</h3>
                    <ul class="footer-links">
                        <li><a href="#">about us</a></li>
                        <li><a href="#">return policy</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">cookie policy</a></li>
                        <li><a href="#">purchasing policy</a></li>
                        <li><a href="#">terms & conditions</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-6 mb-lg-0 mb-sm-4 mb-3">
                    <h3 class="footer-title">download app</h3>
                    <div class="download-wrapper">
                        <div class="qrcode-area">
                            <img src="{{asset('frontend/images/icons/qrcode.png')}}" alt="">
                        </div>
                        <div class="btn-area">
                            <a href="#"><img src="{{asset('frontend/images/icons/appstore.png')}}" alt=""></a>
                            <a href="#"><img src="{{asset('frontend/images/icons/playstore.png')}}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->

    <div class="footer-bottom">
        <div class="container-fluid">
            <p class="copyright">copyright @ 2022 All rights reserved and developed by <a href="https://projanmoit.com/" target="__blank">Projanmo IT</a></p>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!-- End Footer -->

<div class="mobile-footer-bar">
    <div class="inner-footer-bar">
        <ul>
            <li><a class="home" href="{{ route('home') }}"><i class="bi bi-house-door"></i><span>home</span></a></li>
            <li><a class="mobile-nav-trigger" href="#"><i class="ri-function-line"></i><span>Categories</span></a></li>
            <li><a class="shop" href="#"><span class="img"><img src="assets/images/logo/icon.png" alt=""></span><span>shop</span></a></li>
            <li><a class="mobile-search-trigger" href="#"><i class="bi bi-search"></i><span>search</span></a></li>
            <li><a class="privacy-trigger" href="#"><i class="ri-user-line"></i><span>account</span></a></li>
        </ul>
    </div>
</div>
<!-- End Footer Bar -->

<div class="mobile-privacy-nav">
    <div class="nav-header">
        <div class="user-area">
            <div class="user-img">
                <span class="material-icons">account_circle</span>
            </div>
            <div class="user-login">
                <ul>
                    <li><a href="{{ route('login') }}">sign in</a></li>
                </ul>
            </div>
        </div>
        <div class="language-area">
            <div class="switch">
                <a href="#">
                    <span>EN</span>
                    <span class="icon">
                        <i class="material-icons en">toggle_off</i>
                    </span>
                    <span>BN</span>
                </a>
            </div>
        </div>
        <button type="button" class="close-nav"><i class="bi bi-x"></i></button>
    </div>
    <div class="nav-body">
        <div class="top-area">
            <div class="top-nav">
                <ul>
                    <li><a href="{{ route('home') }}"><i class="bi bi-house-door"></i>home</a></li>
                    <li><a href="#"><i class="bi bi-person-fill"></i>account information</a></li>
                    <li><a href="#"><i class="material-icons">content_paste</i>my orders</a></li>
                    <li><a href="#"><i class="bi bi-heart"></i>my wishlist</a></li>
                    <li><a href="#"><i class="material-icons-outlined">lock</i>change password</a></li>
                    <li><a href="#"><i class="material-icons">logout</i>logout</a></li>
                </ul>
            </div>
            <div class="divider"></div>
            <div class="bottom-nav">
                <ul>
                    <li><a href="#"><i class="bi bi-telephone-plus"></i><span><strong>helpline</strong> <br> 01712690082</span></a></li>
                </ul>
            </div>
            <div class="divider"></div>
            <div class="links">
                <ul>
                    <li><a href="#">privacy policy</a></li>
                    <li><a href="#">track order</a></li>
                    <li><a href="#">return</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom-area">
            <div class="divider"></div>
            <div class="download-area">
                <button class="download-app-btn"><span>download app</span><i class="android ri-android-fill"></i><i class="ios bi bi-apple"></i></button>
            </div>
            <div class="divider"></div>
            <div class="social-area">
                <ul class="social">
                    <li class="facebook"><a href="#"><i class="ri-facebook-fill"></i></a></li>
                    <li class="twitter"><a href="#"><i class="ri-twitter-fill"></i></a></li>
                    <li class="youtube"><a href="#"><i class="ri-youtube-fill"></i></a></li>
                    <li class="dribbble"><a href="#"><i class="ri-dribbble-fill"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Mobile Privacy Nav -->

<div class="mobile-nav">
    <div class="inner-mobile-nav checknav">
        <div class="nav-head">
            <div class="logo-area">
                <a href="{{ route('home') }}"><img src="{{asset('frontend/images/logo/logo.png')}}" alt=""></a>
                <button type="button" class="close-nav"><i class="bi bi-x"></i></button>
            </div>
            <div class="title-area">
                <h3 class="title">categories</h3>
                <a href="#">see all</a>
            </div>
        </div>
        <ul>
            <li><a href="#"><span>Daily Needs</span></a>
                <ul>
                    <li><a href="#">Daily Needs</a>
                        <ul>
                            <li><a href="#">Daily Needs</a></li>
                            <li><a href="#">Needs</a></li>
                            <li><a href="#">Daily Needs</a></li>
                            <li><a href="#">Needs</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                </ul>
            </li>
            <li><a href="#"><span>Electronics &amp; Home Appliance</span></a>
                <ul>
                    <li><a href="#">Daily Needs</a>
                        <ul>
                            <li><a href="#">Daily Needs</a></li>
                            <li><a href="#">Needs</a></li>
                            <li><a href="#">Daily Needs</a></li>
                            <li><a href="#">Needs</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                    <li><a href="#">Daily Needs</a></li>
                </ul>
            </li>
            <li><a href="#"><span>Health &amp; Nutrition </span></a></li>
            <li><a href="#"><span>Cosmetics &amp; Beauty Care</span></a></li>
            <li><a href="#"><span>Baby Food &amp; Fashions</span></a></li>
            <li><a href="#"><span>Women’s Fashions</span></a></li>
            <li><a href="#"><span>Men’s Fashions </span></a></li>
            <li><a href="#"><span>Stationery, Toys &amp; Games </span></a></li>
            <li><a href="#"><span>Sports &amp; Fitness </span></a></li>
            <li><a href="#"><span>Lifestyle &amp; Home Decor</span></a></li>
            <li><a href="#"><span>Real Estate &amp; Property </span></a></li>
            <li><a href="#"><span>Automobile &amp; Motor Bikes </span></a></li>
            <li><a href="#"><span>Daily Needs</span></a></li>
            <li><a href="#"><span>Electronics &amp; Home Appliance</span></a></li>
            <li><a href="#"><span>Health &amp; Nutrition </span></a></li>
            <li><a href="#"><span>Cosmetics &amp; Beauty Care</span></a></li>
            <li><a href="#"><span>Baby Food &amp; Fashions</span></a></li>
            <li><a href="#"><span>Women’s Fashions</span></a></li>
            <li><a href="#"><span>Men’s Fashions </span></a></li>
            <li><a href="#"><span>Stationery, Toys &amp; Games </span></a></li>
            <li><a href="#"><span>Sports &amp; Fitness </span></a></li>
            <li><a href="#"><span>Lifestyle &amp; Home Decor</span></a></li>
            <li><a href="#"><span>Real Estate &amp; Property </span></a></li>
            <li><a href="#"><span>Automobile &amp; Motor Bikes </span></a></li>
        </ul>
    </div>
</div>
<!-- End Mobile Nav -->

<div class="mobile-cart">
    <div class="inner-mobile-cart">
        <div class="cart-head">
            <h3 class="title">16 items in cart</h3>
            <button type="button" class="close-cart"><i class="bi bi-x"></i></button>
        </div>
        <div class="cart-body">
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/1.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/2.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum iusto quidem.</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/3.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/1.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/2.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum iusto quidem.</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/3.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/1.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/2.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum iusto quidem.</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/3.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/2.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum iusto quidem.</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
            <div class="single-item">
                <figure><a href="#"><img src="{{asset('frontend/images/products/3.jpg')}}" alt=""></a></figure>
                <div class="contents">
                    <h5 class="product-name"><a href="#">Syntax Chair</a></h5>
                    <div class="qty-price">
                        <span>1</span> * <span>৳ 2592.00</span>
                    </div>
                </div>
                <button class="remove" type="button"><i class="bi bi-x"></i></button>
            </div>
        </div>
        <div class="cart-footer">
            <button type="button" class="sm-btn">Checkout</button>
            <button type="button" class="sm-btn">View cart</button>
        </div>
    </div>
</div>