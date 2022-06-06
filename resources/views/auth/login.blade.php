@extends('layouts.frontend.app')

@section('title')
    Login
@endsection
    @php
        $search = '';
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
					<div class="category-area checknav">
                        <ul class="category-list">
                            @include('layouts.frontend.partial.breadcrumb_category')
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
			<div class="login-reg-box">
				<div class="inner-box">
					<form method="POST" action="{{ route('login') }}">
                        @csrf
						<div class="icon-box">
							<div class="icon"><span class="material-icons">account_circle</span></div>
						</div>
						<div class="single-input">
							<input class="form-control" type="text" name="phone" placeholder="Phone/Email">
						</div>
						<div class="single-input">
							<input class="form-control" type="password" name="password" placeholder="Enter password">
						</div>
						<div class="label-group">
							<div class="single">
								<input type="checkbox" id="Remember" name="remember">
								<label for="Remember">Remember me</label>
							</div>
							<div class="single">
								<a href="{{ route('reset-password') }}">Forget password ?</a>
							</div>
						</div>
						<button type="submit" class="submit-btn">Sign In</button>
						<div class="login-options">
							<div class="single-option">
								<a href="{{ url('login/facebook') }}">
									<span class="icon"><img src="{{asset('frontend/images/icons/facebook.png')}}" alt=""></span>
									<span>SignIn With Facebook</span>
								</a>
							</div>
							<div class="single-option">
								<a href="{{ url('login/google') }}">
									<span class="icon"><img src="{{asset('frontend/images/icons/google.png')}}" alt=""></span>
									<span>SignIn With Google</span>
								</a>
							</div>
						</div>
						<div class="signup-option">
							<label for="">Need an account? <a href="{{ route('customer.register') }}">SignUp</a></label>
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
