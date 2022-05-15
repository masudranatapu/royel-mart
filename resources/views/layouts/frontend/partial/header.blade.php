@php
    $website = App\Models\Website::latest()->first();
    $policies = App\Models\Policy::where('status', 1)->oldest()->limit(4)->get();
    $lan = session()->get('lan');
@endphp
<header>
    <div class="header-top">
        <div class="container-fluid">
            <div class="inner-header-top">
                <div class="left-area">
                    <ul class="list">
                        <li><a href="{{ route('language-change',['lan'=>'en']) }}">EN</a></li>
                        <li><a href="{{ route('language-change',['lan'=>'bn']) }}">BN </a></li>
                        <li><a href="tel: (+88) {{ $website->phone }}"><span class="material-icons-outlined">call</span>(+88) {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($website->phone, $lan, 'en') }}</a></li>
                    </ul>
                </div>
                <div class="right-area">
                    <ul class="list">
                        @foreach($policies as $policy)
                            <li><a href="{{ route('policy', $policy->slug) }}">{{ $policy->name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('track.my.order') }}">track my order</a></li>
                        <li><a href="{{ route('contact') }}">contact us</a></li>
                    </ul>
                    <ul class="social-list">
                        @php
                            $icon = explode("|", $website->icon);
                            $link = explode("|", $website->link);
                        @endphp
                        @foreach($icon as $key=>$icon)
                            <li><a target="blank" href="@if(isset($link[$key])){{$link[$key]}}@endif"><i class="fa fa-{{$icon}}"></i></a></li>
                        @endforeach
                    </ul>
                    <ul class="download-area">
                        <li>
                            <a href="#">
                                <i class="ri-download-2-fill"></i>
                                download app
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top -->
    <!-- End Header Top -->
    <div class="header-bottom">
        <div class="container-fluid">
            <div class="inner-header-bottom">
                <div class="logo-area">
                    <button class="privacy-trigger"><span class="material-icons">reorder</span></button>
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img loading="eager|lazy" src="@if($website->logo){{ asset($website->logo) }} @else {{ asset('frontend/images/logo/logo.png') }} @endif" alt="">
                        </a>
                    </div>
                </div>
                <div class="search-area">
                    <div class="search-wrapper">
                        <form action="{{ route('searching') }}" method="get">
                            <input name="search_product" autocomplete="off" value="{{ $search }}" class="form-control js--search" type="text">
                            <button type="submit" class="submit-search"><i class="ri-search-line"></i></button>
                        </form>
                    </div>
                    <button class="close-search"><i class="bi bi-x"></i></button>
                </div>
                <div class="icon-area">
                    <ul>
                        <li class="dropdown user">
                            <a class="user-trigger" href="javascript:;"><i class="bi bi-person-fill"></i></a>
                            <div class="dropdown-menu">
                                <ul class="user-nav">
                                    @auth
                                        @if(Auth::check() && auth()->user()->role_id == 1)
                                            <li><a href="{{ route('admin.dashboard') }}" target="_blank">Dashboard</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif
                                        @if(Auth::check() && auth()->user()->role_id == 2)
                                            <li><a href="{{ route('customer.information') }}">My Account</a></li>
                                            <li><a href="{{ route('customer.order') }}">My Orders</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif
                                    @else
                                        <li><a href="{{ route('login') }}">Sign In</a></li>
                                        <li><a href="{{ route('customer.register') }}">Sign Up</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="cart-trigger" href="javascript:;">
                                <i class="bi bi-cart"></i>
                                <span class="quantity">
                                    @if(session('cart'))
                                        {{ count(session('cart')) }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </a>
                            <div class="dropdown-menu cart">
                                <div class="dropdown-cart">
                                    <div class="cart-header">
                                        <h4 class="title">
                                            @if(session('cart'))
                                                {{ count(session('cart')) }}
                                            @else
                                                0
                                            @endif

                                            iteam in cart
                                        </h4>
                                    </div>
                                    <div class="cart-body">
                                        @if(session('cart'))
                                            @foreach(session('cart') as $key => $cartdetails)
                                                <div class="single-item">
                                                    <figure>
                                                        <a href="javascript:;">
                                                            <img loading="eager|lazy" src="{{ asset($cartdetails['image']) }}" alt="">
                                                        </a>
                                                    </figure>
                                                    <div class="contents">
                                                        <h5 class="product-name">
                                                            <a href="javascript:;">{{ $cartdetails['name'] }}</a>
                                                        </h5>
                                                        <div class="qty-price">
                                                            <span>{{ $cartdetails['quantity'] }}</span> * <span>{{$cartdetails['price']}} ৳</span>
                                                        </div>
                                                    </div>
                                                    <a class="remove" href="{{ route('cart.remove', $key) }}" onclick="return confirm('Are you sure, you want to remove this product from cart ? ')" type="button">
                                                        <i class="bi bi-x"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="single-item cart-footer">
                                            @auth
                                                <a href="{{ route('customer.checkout.index') }}" type="button" class="sm-btn">Checkout</a>
                                            @else
                                                <a href="{{ route('customer.guest-checkout.index') }}" type="button" class="sm-btn">Checkout</a>
                                            @endauth
                                            <a href="{{ route('cart') }}" type="button" class="sm-btn">View cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
