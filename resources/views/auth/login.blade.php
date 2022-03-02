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
					<div class="category-area checknav">
                        @php
                            $categories = App\Models\Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->orderBy('serial_number', 'DESC')->limit(18)->get();
                        @endphp
                        <ul class="category-list">
                            @foreach($categories as $category)
								@if($category->id == 1)
								@else
									<li>
										<a href="{{ route('category', $category->slug) }}">
											<img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
											<span>{{ $category->name }}</span>
										</a>
										@php
											$parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->orderBy('serial_number', 'DESC')->get();
										@endphp
										<ul>
											@foreach($parentcategories as $parentcategory)
												<li>
													<a href="{{ route('category', $parentcategory->slug) }}">
														{{ $parentcategory->name }}
													</a>
													@php
														$childcategories = App\Models\Category::where('child_id', $parentcategory->id)->orderBy('serial_number', 'DESC')->get();
													@endphp
													<ul>
														@foreach($childcategories as $childcategory)
															<li>
																<a href="{{ route('category', $childcategory->slug) }}">
																	{{ $childcategory->name }}
																</a>
															</li>
														@endforeach
													</ul>
												</li>
											@endforeach
										</ul>
									</li>
								@endif
                            @endforeach
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
								<input type="checkbox" id="Remember" name="remember">
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