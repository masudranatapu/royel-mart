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
                        <div class="col-md-8">
                            <div class="contact-form-area mt-4" id="personal_info_area">
                                <div class="form-wrapper">
                                    <h2 class="form-title">Update Password</h2>
                                    <form action="{{ route('customer.password.update', Auth::user()->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12 px-2 mb-3">
                                                <input class="form-control" type="password" placeholder="Oldpassword:" name="oldpassword">
                                            </div>
                                            <div class="col-sm-12 px-2 mb-3">
                                                <input class="form-control" type="password" placeholder="New Passwoed:" name="password">
                                            </div>
                                            <div class="col-sm-12 px-2 mb-3">
                                                <input class="form-control" type="password" readonly placeholder="Confirm Password:" name="password_confirmation">
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="submit-contact">Update</button>
                                            </div>
                                        </div>
                                    </form>
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

@endpush
