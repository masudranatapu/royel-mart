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
					<li><a href="javascript:;">{{ $title }}</a></li>
				</ul>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb Section -->
	<section class="dashboard-section">
		<div class="navigation-area">
			<div class="container">
				<ul>
					<li><a href="javascript:;"><i class="bi bi-arrow-left"></i></a><span>order view</span></li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="sidebar-main-wrapper">
				<div class="main-area">
					<div class="row">
						<div class="col-12 px-2">
							<div class="card">
							    <div class="card-header">
							    	<div class="wrapper">
								        <h4 class="card-title">Order  {{ $orders->order_code }}</h4>
								        <p class="card-category">{{ $orders->created_at->format('d M Y h:i A') }}</p>
							    	</div>
							    </div>
							    <div class="card-body">
							    	<div class="wrapper">
							    		<div class="tracking-wrapper">
							    			<div class="tracking">
							    				<div class="tracking-head">
							    					<h3 class="title">Your Order Delivery Information</h3>
							    				</div>
							    				<div class="tracking-body">
							    					<ul class="steps">
							    						<li class="step @if($orders->status == 'Pending') active @endif">
							    							<span class="icon">
                                                                <img src="{{asset('frontend/images/icons/shopping-bag.png')}}" alt="">
                                                            </span>
							    							<p class="mb-0">
							    								<span class="info">Order Pending</span>
							    							    <span class="date">
                                                                    @if($orders->updated_at)
                                                                        {{ $orders->updated_at->format('d M Y h:i A') }}
                                                                    @else
                                                                        {{ $orders->created_at->format('d M Y h:i A') }}
                                                                    @endif
                                                                </span>
							    							</p>
							    						</li>
							    						<li class="step @if($orders->status == 'Confirmed') active @endif">
							    							<span class="icon">
                                                                <img src="{{asset('frontend/images/icons/packaging.png')}}" alt="">
                                                            </span>
							    							<p class="mb-0">
								    							<span class="info">Order Confirmed</span>
							    							    <span class="date">
                                                                    @if($orders->updated_at)
                                                                        {{ $orders->updated_at->format('d M Y h:i A') }}
                                                                    @else
                                                                        {{ $orders->created_at->format('d M Y h:i A') }}
                                                                    @endif
                                                                </span>
							    							</p>
							    						</li>
							    						<li class="step @if($orders->status == 'Processing') active @endif">
							    							<span class="icon">
                                                                <img src="{{asset('frontend/images/icons/box.png')}}" alt="">
                                                            </span>
							    							<p class="mb-0">
								    							<span class="info">Order Processing</span>
							    							    <span class="date">
                                                                    @if($orders->updated_at)
                                                                        {{ $orders->updated_at->format('d M Y h:i A') }}
                                                                    @else
                                                                        {{ $orders->created_at->format('d M Y h:i A') }}
                                                                    @endif
                                                                </span>
							    							</p>
							    						</li>
							    						<li class="step @if($orders->status == 'Delivered') active @endif">
							    							<span class="icon">
                                                                <img src="{{asset('frontend/images/icons/truck.png')}}" alt="">
                                                            </span>
							    							<p class="mb-0">
								    							<span class="info">Order Delivered</span>
							    							    <span class="date">
                                                                    @if($orders->updated_at)
                                                                        {{ $orders->updated_at->format('d M Y h:i A') }}
                                                                    @else
                                                                        {{ $orders->created_at->format('d M Y h:i A') }}
                                                                    @endif
                                                                </span>
							    							</p>
							    						</li>
							    						<li class="step @if($orders->status == 'Successed') active @endif">
							    							<span class="icon">
                                                                <img src="{{asset('frontend/images/icons/deliver.png')}}" alt="">
                                                            </span>
							    							<p class="mb-0">
								    							<span class="info">Order Successed</span>
							    							    <span class="date">
                                                                    @if($orders->updated_at)
                                                                        {{ $orders->updated_at->format('d M Y h:i A') }}
                                                                    @else
                                                                        {{ $orders->created_at->format('d M Y h:i A') }}
                                                                    @endif
                                                                </span>
							    							</p>
							    						</li>
							    					</ul>
							    				</div>
							    			</div>
							    		</div>
							    		<div class="row mb-20">
							    			<div class="col-sm-6 mb-sm-0 mb-3">
							    				<div class="card">
							    					<div class="card-body">
							    						<h4 class="card-title">Shipping Address:</h4>
							    						<p><label for="">name : </label><span>Forhad Hossain</span></p>
							    						<p><label for="">Phone : </label><span>09877676543</span></p>
							    						<p><label for="">Mail : </label><span>rr@gmail.com</span></p>
							    						<p><label for="">Address : </label><span>House #8 (1st Floor), Road # 14, lorem ipsum city, Dhaka-1209.</span></p>
							    					</div>
							    				</div>
							    			</div>
							    			<div class="col-sm-6 mb-sm-0 mb-3">
							    				<div class="card">
							    					<div class="card-body">
							    						<h4 class="card-title">Billing Address:</h4>
							    						<p><label for="">name : </label><span>Forhad Hossain</span></p>
							    						<p><label for="">Phone : </label><span>09877676543</span></p>
							    						<p><label for="">Mail : </label><span>rr@gmail.com</span></p>
							    						<p><label for="">Address : </label><span>House #8 (1st Floor), Road # 14, lorem ipsum city, Dhaka-1209.</span></p>
							    					</div>
							    				</div>
							    			</div>
							    		</div>
							    		<div class="payment-info mb-3">
							    			<p><label for="">Payment Method : </label><span>{{ $orders->payment_method }}</span></p>
							    			<p><label for="">Payment Status : </label><span>{{ $orders->status }}</span></p>
							    		</div>
								    	<table class="table order-view-table">
								    		<thead>
								    			<tr>
								    				<th width="100px">Photo</th>
								    				<th>Product</th>
								    				<th>Qty</th>
								    				<th width="100px">Price</th>
								    			</tr>
								    		</thead>
								    		<tbody>
                                                @php
                                                    $product_id = explode(',', $orders->product_id);
                                                    $size_id = explode(',', $orders->size_id);
                                                    $color_id = explode(',', $orders->color_id);
                                                    $quantity = explode(',', $orders->quantity);
                                                    $i = 1;
                                                @endphp
                                                @foreach($product_id as $key => $product_id)
                                                    @php
                                                        $products = App\Models\Product::findOrFail($product_id);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <figure class="product-image">
                                                                <img src="{{ asset($products->thambnail) }}" alt="">
                                                            </figure>
                                                        </td>
                                                        <td>
                                                            <span class="product-name">
                                                                {{ $products->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span style="white-space: nowrap;" class="qty">
                                                                <strong class="d-sm-none d-inline">
                                                                    qty :
                                                                </strong>
                                                                {{ $quantity[$key] }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span style="white-space: nowrap;" class="price">
                                                                <strong class="d-sm-none d-inline">
                                                                    price :
                                                                </strong>
                                                                {{ $products->sale_price }} ৳
                                                            <span>
                                                        </td>
                                                    </tr>
                                                    @php 
                                                        $i++;
                                                    @endphp
                                                @endforeach
								    		</tbody>
								    	</table>
								    	<table class="total-table table mb-0">
								    		<tbody>
								    			<tr>
								    				<th colspan="4">Subtotal : </th>
								    				<td width="100px"><span class="subtotal">{{$orders->sub_total}} ৳</span></td>
								    			</tr>
								    			<tr>
								    				<th colspan="4">Shipping Charge : </th>
								    				<td width="100px"><span class="charge">{{$orders->shipping_amount}} ৳</span></td>
								    			</tr>
								    			<tr>
								    				<th colspan="4">Grand Total : </th>
								    				<td width="100px"><span class="grand-total">{{$orders->total}} ৳</span></td>
								    			</tr>
								    		</tbody>
								    	</table>
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