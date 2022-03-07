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
					<div class="row mb-3">
						<div class="col-md-6 px-2 single-profile">
							<div class="card">
							    <div class="card-header">
							    	<a href="{{ route('customer.profile.updateview') }}" class="edit-btn" type="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
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
						</div>
					</div>
					@if($shippingaddresses->count() > 0)
						<div class="row mt-4">
							<div class="col-md-12 px-2 single-profile">
								<div class="card">
									<div class="card-header card-header-primary">
										<div class="wrapper">
											<h4 class="card-title">Shipping Address</h4>
											<p class="card-category">edit Shipping address</p>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											@foreach($shippingaddresses as $shippingaddres)
												<div class="col-md-6">
													<div class="wrapper">
														<p><label for="">name : </label><span>{{$shippingaddres->shipping_name}}</span></p>
														<p><label for="">Phone : </label><span>{{$shippingaddres->shipping_name}}</span></p>
														<p><label for="">Mail : </label><span>{{$shippingaddres->shipping_email}}</span></p>
														<p><label for="">Address : </label><span>{{$shippingaddres->shipping_address}}</span></p>
													</div>
													<a href="{{ route('customer.deleteshipping.address', $shippingaddres->id) }}" class="btn btn-danger">
														Delete
													</a>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
	<!-- End Dashboard Section -->

@endsection

@push('js')

@endpush