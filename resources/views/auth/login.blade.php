@extends('layouts.frontend.app')

@section('title')
    Login
@endsection
    @php
        $website = App\Models\Website::latest()->first();
    @endphp
@section('meta')

@endsection

@push('css')

@endpush

@section('content')
    <section class="breadcrumb-section">
		<div class="container-fluid">
			<div class="category-breadcrumb">
				<div class="category-wrapper">
					<h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
					<div class="category-area">
						<div class="scroll-btn">
							<span class="prev hide"><i class="bi bi-chevron-up"></i></span>
							<span class="next"><i class="bi bi-chevron-down"></i></span>
						</div>
						<button class="close-menu"><i class="bi bi-x"></i></button>
						<h3 class="mobile-title">categories</h3>
						<ul class="category-list">
							<li><a href="#"><img src="{{asset('frontend/images/icons/vegetable.png')}}" alt=""><span>Daily Needs</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/tv.png')}}" alt=""><span>Electronics &amp; Home Appliance</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/first-aid-kit.png')}}" alt=""><span>Health &amp; Nutrition </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/skincare.png')}}" alt=""><span>Cosmetics &amp; Beauty Care</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/baby.png')}}" alt=""><span>Baby Food &amp; Fashions</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/fashion.png')}}" alt=""><span>Women’s Fashions</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/sport-watch.png')}}" alt=""><span>Men’s Fashions </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/console.png')}}" alt=""><span>Stationery, Toys &amp; Games </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/sport.pn')}}g" alt=""><span>Sports &amp; Fitness </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/decorating.png')}}" alt=""><span>Lifestyle &amp; Home Decor</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/real-estate.png')}}" alt=""><span>Real Estate &amp; Property </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/motorcycle.png')}}" alt=""><span>Automobile &amp; Motor Bikes </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/vegetable.png')}}" alt=""><span>Daily Needs</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/tv.png')}}" alt=""><span>Electronics &amp; Home Appliance</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/first-aid-kit.png')}}" alt=""><span>Health &amp; Nutrition </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/skincare.png')}}" alt=""><span>Cosmetics &amp; Beauty Care</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/baby.png')}}" alt=""><span>Baby Food &amp; Fashions</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/fashion.png')}}" alt=""><span>Women’s Fashions</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/sport-watch.png')}}" alt=""><span>Men’s Fashions </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/console.png')}}" alt=""><span>Stationery, Toys &amp; Games </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/sport.png')}}" alt=""><span>Sports &amp; Fitness </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/decorating.png')}}" alt=""><span>Lifestyle &amp; Home Decor</span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/real-estate.png')}}" alt=""><span>Real Estate &amp; Property </span></a></li>
							<li><a href="#"><img src="{{asset('frontend/images/icons/motorcycle.png')}}" alt=""><span>Automobile &amp; Motor Bikes </span></a></li>
						</ul>
					</div>
				</div>
				<div class="breadcrumb-area">
					<ul class="breadcrumb">
						<li><a href="{{ route('home') }}">Home</a></li>
						<li>Login</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb -->
	<section class="login-register-section">
		<div class="container">
			<h1 class="wc-title">Welcome to</h1>
			<div class="logo-area">
                <img src="{{asset( $website->log )}}" alt="">
            </div>
			<div class="login-reg-box">
				<div class="inner-box">
					<form method="POST" action="{{ route('login') }}">
                        @csrf
						<div class="icon-box">
							<div class="icon"><span class="material-icons">account_circle</span></div>
						</div>
						<div class="single-input">
							<input class="form-control" type="text" name="email" placeholder="Enter email">
						</div>
						<div class="single-input">
							<input class="form-control" type="password" name="password" placeholder="Enter password">
						</div>
						<div class="label-group">
							<div class="single">
								<input type="checkbox" id="Remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
								<label for="Remember">Remember me</label>
							</div>
							<div class="single">
								<a href="{{ route('password.request') }}">Forget password ?</a>
							</div>
						</div>
						<button type="submit" class="submit-btn">Sign In</button>
						<div class="login-options">
							<div class="single-option">
								<a href="#">
									<span class="icon"><img src="{{asset('frontend/images/icons/facebook.png')}}" alt=""></span>
									<span>SignIn With Facebook</span>
								</a>
							</div>
							<div class="single-option">
								<a href="#">
									<span class="icon"><img src="{{asset('frontend/images/icons/google.png')}}" alt=""></span>
									<span>SignIn With Google</span>
								</a>
							</div>
						</div>
						<div class="signup-option">
							<label for="">Need an account? <a href="{{ route('register') }}">SignUp</a></label>							
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- End Login Register Section -->

@endsection

@push('js')

@endpush