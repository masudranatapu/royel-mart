@php
    $website = App\Models\Website::latest()->first();
@endphp
<header>
    <div class="header-top">
        <div class="container-fluid">
            <div class="inner-header-top">
                <div class="left-area">
                    <ul class="list">
                        <li><a href="#">EN</a></li>
                        <li><a href="#">BN</a></li>
                        <li><a href="tel:{{ $website->phone }}"><span class="material-icons-outlined">Call</span>(+88) {{ $website->phone }}</a></li>
                    </ul>
                </div>
                <div class="right-area">
                    <ul class="list">
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">find a store</a></li>
                        <li><a href="#">track my order</a></li>
                        <li><a href="#">contact us</a></li>
                        <li><a href="#">return</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                    <ul class="social-list">
                        <li><a href="#"><i class="ri-facebook-fill"></i></a></li>
                        <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
                        <li><a href="#"><i class="ri-youtube-fill"></i></a></li>
                        <li><a href="#"><i class="ri-whatsapp-fill"></i></a></li>
                    </ul>
                    <ul class="download-area">
                        <li><a href="#"><i class="ri-download-2-fill"></i>download app</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top -->
    <div class="header-bottom">
        <div class="container-fluid">
            <div class="inner-header-bottom">
                <div class="logo-area">
                    <button class="privacy-trigger"><span class="material-icons">reorder</span></button>
                    <div class="logo"><a href="{{ route('home') }}"><img src="{{asset('frontend/images/logo/logo.png')}}" alt=""></a></div>
                </div>
                <div class="search-area">
                    <div class="search-wrapper">
                        <form action="">
                            <input class="form-control js--search" type="text">
                            <button type="submit" class="submit-search"><i class="ri-search-line"></i></button>
                        </form>
                    </div>
                    <button class="close-search"><i class="bi bi-x"></i></button>
                </div>
                <div class="icon-area">
                    <ul>
                        <li class="dropdown">
                            <a class="cart-trigger" href="javascript:;"><i class="bi bi-cart"></i><span class="quantity">4</span></a>
                            <div class="dropdown-menu cart">
                                <div class="dropdown-cart">
                                    <div class="cart-header">
                                        <h4 class="title">3 iteam in cart</h4>
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
                                        <div class="single-item cart-footer">
                                            <button type="button" class="sm-btn">Checkout</button>
                                            <button type="button" class="sm-btn">View cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown user">
                            <a class="user-trigger" href="javascript:;"><i class="bi bi-person-fill"></i></a>
                            <div class="dropdown-menu">
                                <ul class="user-nav">
                                    @auth
                                        @if(Auth::check() && auth()->user()->role_id == 1)
                                            <li><a href="{{ route('admin.dashboard') }}" target="_blank">My Account</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif
                                        @if(Auth::check() && auth()->user()->role_id == 2)
                                            <li><a href="{{ route('customer.information') }}">My Account</a></li>
                                            <li><a href="#">My Orders</a></li>
                                            <li><a href="#">My List</a></li>
                                            <li><a href="#">My Wishlist</a></li>
                                            <li><a href="#">My Rating Reviews</a></li>
                                            <li><a href="#">My Points</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif
                                    @else
                                        <li><a href="{{ route('login') }}">Sign In</a></li>
                                        <li><a href="{{ route('register') }}">Sign Up</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>