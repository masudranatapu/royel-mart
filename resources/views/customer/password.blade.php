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
                        <div class="col-md-12">
                            <form action="{{ route('customer.password.update', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>Old Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="oldpassword" placeholder="Old Password">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>New Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label>Confirm Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="submit" class="btn btn-success" value="Change Password">
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

@endpush