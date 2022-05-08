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
						<div class="col-md-6 px-2 single-profile">
							<div class="card">
							    <div class="card-header">
							    	<button class="edit-btn" type="button" onclick="updatePersonalInfo()">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
							    	<div class="wrapper">
								        <h4 class="card-title">Personal Information</h4>
								        <p class="card-category">edit profile Information</p>
							    	</div>
							    </div>
							    <div class="card-body">
							    	<div class="wrapper">
								    	<p><label for="">name : </label><span>{{ Auth::user()->name }}</span></p>
								    	<p><label for="">Phone : </label><span>{{ Auth::user()->phone }}</span></p>
								    	<p><label for="">Mail : </label><span>{{ Auth::user()->email }}</span></p>
								    	<p><label for="">Address : </label><span>{{ Auth::user()->address }}</span></p>
							    	</div>
							    </div>
							</div>
						</div>
						<div class="col-md-6 px-2 single-profile">
							<div class="card">
							    <div class="card-header card-header-primary">
                                        {{-- <button class="edit-btn" type="button">
                                            <i class="bi bi-pencil-square"></i>
                                        </button> --}}
							    	<div class="wrapper">
								        <h4 class="card-title">Shipping Address</h4>
								        <p class="card-category">edit Shipping address</p>
							    	</div>
							    </div>
							    <div class="card-body">
							    	<div class="wrapper">
                                        @if (!empty($shipping_information))
                                            <p><label for="">name : </label><span>{{ $shipping_information->shipping_name }}</span></p>
                                            <p><label for="">Phone : </label><span>{{ $shipping_information->shipping_phone }}</span></p>
                                            <p><label for="">Mail : </label><span>{{ $shipping_information->shipping_email }}</span></p>
                                            <p><label for="">Address : </label><span>{{ $shipping_information->shipping_address }}</span></p>
                                        @else
                                            <p><label for="">name : </label><span>{{ Auth::user()->name }}</span></p>
                                            <p><label for="">Phone : </label><span>{{ Auth::user()->phone }}</span></p>
                                            <p><label for="">Mail : </label><span>{{ Auth::user()->email }}</span></p>
                                            <p><label for="">Address : </label><span>{{ Auth::user()->address }}</span></p>
                                        @endif
							    	</div>
							    </div>
							</div>
						</div>
						{{-- <div class="col-md-4 px-2 single-profile">
							<div class="card">
							    <div class="card-header card-header-primary">
							    	<button class="edit-btn" type="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
							    	<div class="wrapper">
								        <h4 class="card-title">billing Address</h4>
								        <p class="card-category">edit billing address</p>
							    	</div>
							    </div>
							    <div class="card-body">
							    	<div class="wrapper">
								    	<p><label for="">name : </label><span>{{ Auth::user()->name }}</span></p>
								    	<p><label for="">Phone : </label><span>{{ Auth::user()->phone }}</span></p>
								    	<p><label for="">Mail : </label><span>{{ Auth::user()->email }}</span></p>
								    	<p><label for="">Address : </label><span>{{ Auth::user()->address }}</span></p>
							    	</div>
							    </div>
							</div>
						</div> --}}
					</div>
                    <div class="contact-form-area mt-4 d-none" id="personal_info_area">
                        <div class="form-wrapper">
                            <h2 class="form-title">Update Personal Information</h2>
                            <form action="{{ route('customer.update-personal-information') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4 px-2 mb-3">
                                        <input class="form-control" type="text" placeholder="Name:" name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="col-sm-4 px-2 mb-3">
                                        <input class="form-control" type="email" placeholder="Email:" name="email" value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="col-sm-4 px-2 mb-3">
                                        <input class="form-control" type="number" readonly placeholder="Phone:" name="phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                    <div class="col-12 px-2 mb-3">
                                        <textarea class="form-control" name="address" placeholder="Address" id="" cols="30" rows="3">{{ Auth::user()->address }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="submit-contact">Update</button>
                                        <button type="button" class="submit-contact" onclick="hidePersonalInfo()">Close</button>
                                    </div>
                                </div>
                            </form>
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
        function updatePersonalInfo(){
            $("#personal_info_area").removeClass("d-none");
            $("#personal_info_area").show();
        }

        function hidePersonalInfo(){
            $("#personal_info_area").addClass("d-none");
            $("#personal_info_area").hide();
        }
    </script>
@endpush
