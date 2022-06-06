@extends('layouts.frontend.app')

@section('title')
    {{$title}}
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
						<li>{{$title}}</li>
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
					<form method="POST" action="{{ route('customer.register.confirm') }}">
                        @csrf
						<div class="title-box">
							<h3 class="title">Create an account</h3>
						</div>
						<div class="single-input">
							<input class="form-control" type="text" name="name" placeholder="Full name">
						</div>
						<div class="single-input">
							<input class="form-control" type="email" name="email" placeholder="Email Address">
						</div>
						<div class="single-input">
							<input class="form-control" type="number" name="phone" placeholder="Mobile Number">
						</div>
						<div class="single-input">
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3" required placeholder="Address"></textarea>
						</div>
						<button type="submit" class="submit-btn">Next</button>
						<label for="" class="alter">Or</label>
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
							<label for="">Already have an account? <a href="{{ route('login') }}">Login</a></label>
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
