@extends('layouts.frontend.app')

@section('title')
    {{$title}}
@endsection

@section('meta')

@endsection

@push('css')

@endpush

@section('content')
    <section class="dashboard-breadcrumb-section">
		<div class="container">
			<div class="breadcrumb">
				<ul>
					<li><a href="{{ route('home') }}">home</a></li>
					<li>profile</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb Section -->
	<section class="dashboard-section">
		<div class="navigation-area">
			<div class="container">
				<ul>
					<li>
                        <a href="#">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <span>profile</span>
                    </li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="sidebar-main-wrapper">
				<div class="sidebar-area">
				    <div class="logo">
				        <a target="_blank" href="index.html">
				        	<img src="{{asset('frontend/images/logo/logo.png')}}" alt="Logo">
				        	<img src="{{asset('frontend/images/logo/favicon.png')}}" alt="">
				        </a>
						<button type="button" class="expand-trigger"><i class="bi bi-chevron-double-right"></i></button>
				    </div>
				    <div class="sidebar-wrapper">
				        <ul class="nav">
				            <li class="nav-item {{ Route::is('customer.information') ? 'active' : '' }}">
				                <a class="nav-link" href="{{ route('customer.information') }}">
				                    <i class="material-icons">person</i>
				                    <p>Account Information</p>
				                </a>
				            </li>
				            <li class="nav-item {{ Route::is('customer.order') ? 'active' : '' }}">
				                <a class="nav-link" href="{{ route('customer.order') }}">
				                    <i class="material-icons">content_paste</i>
				                    <p>My Orders</p>
				                </a>
				            </li>
				            <li class="nav-item {{ Route::is('customer.password.change') ? 'active' : '' }}">
				                <a class="nav-link" href="{{ route('customer.password.change') }}">
				                    <i class="material-icons">lock</i>
				                    <p>change passowrd</p>
				                </a>
				            </li>
				            <li class="nav-item ">
				                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				                    <i class="material-icons">directions_run</i>
				                    <p>Logout</p>
				                </a>
				            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
				        </ul>
					</div>
				</div>
				<div class="main-area">
					<div class="row">
						<div class="col-12 px-2">
							<div class="card">
								<div class="card-header">
							    	<div class="wrapper">
								        <h4 class="card-title">change password</h4>
								        <p class="card-category">change your password here</p>
							    	</div>
							    </div>
							    <div class="card-body">
							    	<div class="wrapper">
							    		<form action="{{ route('customer.profile.update', Auth::user()->id) }}" enctype="multipart/form-data" method="POST">
                                            @csrf
							    			<div class="single-input">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Name </label>
                                                        <input class="form-control" name="name" value="{{ Auth::user()->name }}" type="text">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Email </label>
                                                        <input class="form-control"  name="email" value="{{ Auth::user()->email }}" type="email">
                                                    </div>
                                                </div>
											</div>
							    			<div class="single-input mb-3">
												<label>Image </label>
												<input class="form-control" name="image" onChange="profileUpdate(this)"  type="file">
											</div>
							    			<div class="single-input mt-2">
                                                <img width="100" height="100" src=" @if(Auth::user()->image) {{ asset(Auth::user()->image) }} @else {{ asset('demomedia/demoprofile.png') }} @endif" id="profileShow" alt="">
											</div>
							    			<div class="single-input mt-2">
												<label>Phone Number</label>
												<input class="form-control" name="phone" value="{{ Auth::user()->phone }}" placeholder="Phone Number" type="text">
											</div>
							    			<div class="single-input mt-2">
												<label>Address</label>
                                                <textarea name="address" id="" class="form-control" cols="30" rows="4" placeholder="">{{ Auth::user()->address }}</textarea>
											</div>
							    			<div class="single-input mt-2">
                                                <input type="submit" value="Update Profile" class="btn btn-success">
											</div>
							    		</form>
							    	</div>
							    </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Dashboard Section -->

@endsection

@push('js')
    <script>
        function profileUpdate(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profileShow').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush