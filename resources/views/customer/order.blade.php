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
                    <li>orders</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Breadcrumb Section -->
    <section class="dashboard-section">
        <div class="navigation-area">
            <div class="container">
                <ul>
                    <li><a href="#"><i class="bi bi-arrow-left"></i></a><span>orders view</span></li>
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
				            <li class="nav-item ">
				                <a class="nav-link" href="/ui-notifications.html">
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
                                        <h4 class="card-title">Order List</h4>
                                        <p class="card-category">view your all orders</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="wrapper">
                                        <div class="orders-table">
                                            @foreach($orders as $order)
                                                <div class="single-order">
                                                    <div class="order-head">
                                                        <div class="left-area">
                                                            <div class="order-id">
                                                                <span>Order ID</span>
                                                                <a href="#">#{{ $order->order_code }}</a>
                                                            </div>
                                                            <div class="order-time">
                                                                <span>Placed on {{ $order->created_at->format('d M Y h:i A') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="right-area">
                                                            <a href="{{ route('customer.order.view', $order->id) }}">View</a>
                                                            <span class="pay-type">COD</span>
                                                        </div>
                                                    </div>
                                                    <div class="order-body">
                                                        @php
                                                            $product_id = explode(',', $order->product_id);
                                                            $size_id = explode(',', $order->size_id);
                                                            $color_id = explode(',', $order->color_id);
                                                            $quantity = explode(',', $order->quantity);
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($product_id as $key => $product_id)
                                                            @php
                                                                $products = App\Models\Product::findOrFail($product_id);
                                                            @endphp
                                                                <div class="single-item">
                                                                    <figure class="item-img">
                                                                        <a href="#">
                                                                            <img src="{{ asset($products->thambnail) }}" alt="">
                                                                        </a>
                                                                    </figure>
                                                                    <div class="item-name">
                                                                        <h5 class="title">
                                                                            {{ $products->name }}
                                                                        </h5>
                                                                    </div>
                                                                    <div class="item-qty">
                                                                        <label for="">Qty:</label>
                                                                        <strong>{{ $quantity[$key] }}</strong>
                                                                    </div>
                                                                    <div class="item-price">
                                                                        <span class="price">{{ $products->sale_price }} TK</span>
                                                                    </div>
                                                                    <div class="item-responsive">
                                                                        <div class="item-name">
                                                                            <h5 class="title">
                                                                                {{ $products->name }}
                                                                            </h5>
                                                                        </div>
                                                                        <div class="item-qty">
                                                                            <label for="">Qty:</label>
                                                                            <strong>{{ $quantity[$key] }}</strong>
                                                                        </div>
                                                                        <div class="item-price">
                                                                            <span class="price">{{ $products->sale_price }} TK</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @php 
                                                                $i++;
                                                            @endphp
                                                        @endforeach
                                                    </div>
                                                    <div class="order-footer">
                                                        <div class="order-status left-area">
                                                            @if($order->order_status == "Canceled")
                                                                <label for="">delivery status : </label>
                                                                <span class="delivered">delivered</span>
                                                            @else
                                                                @if($order->order_status == 'Successed')
                                                                    <label for="">delivery status : </label>
                                                                    <span class="delivered">delivered</span>
                                                                @else
                                                                
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="right-area">
                                                            <div class="single">
                                                                <label for="">subtotal : </label>
                                                                <span>{{$order->sub_total}} TK</span>
                                                            </div>
                                                        </div>
                                                        <div class="left-area blank"></div>
                                                        <div class="right-area">
                                                            <div class="single">
                                                                <label for="">delivery-charge :</label>
                                                                <span>{{$order->shipping_amount}} TK</span>
                                                            </div>
                                                        </div>
                                                        <div class="left-area blank"></div>
                                                        <div class="right-area">
                                                            <div class="single">
                                                                <label for=""><strong>total :</strong></label>
                                                                <strong>{{$order->total}} TK</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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

@endpush