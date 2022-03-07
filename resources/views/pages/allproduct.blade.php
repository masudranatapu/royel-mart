@extends('layouts.frontend.app')

@section('title')
    {{$title}}
@endsection

@section('meta')

@endsection

@push('css')

@endpush

@section('content')
    @include('layouts.frontend.partial.breadcrumbcategory')
	<!-- End Breadcrumb -->
	<section class="category-page-slider-section">
		<div class="category-page-slider owl-carousel">
			@foreach($categorybanners as $categorybanner)
				<div class="single-slide">
					<img src="@if($categorybanner->image) {{ asset($categorybanner->image) }}  @else {{ asset('demomedia/category.png') }} @endif">
				</div>
			@endforeach
		</div>
	</section>
	<!-- End Featured Category -->
	<section class="single-categories-section pb-60 pt-20">
		<div class="container-fluid">
			<div class="title-filter-area">
				<div class="title-area w-100">
					<h3 class="category-title">Categories</h3>
				</div>
				<div class="categories">
					<ul class="row">
                        @foreach($categories as $category)
                            @if($category->id == 1)

                            @else
                                <li class="col-md-4">
                                    <a href="{{ route('category', $category->slug) }}">
                                        <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        <span>{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
				</div>
			</div>
			<div class="title-filter-area pb-40">
				<div class="title-area">
					<h3 class="category-title">{{ $title }} - Royelmart</h3>
				</div>
				<div class="filter-area">
					<ul class="filter-items">
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>Latest</option>
							    <option value="1">One</option>
							    <option value="2">Two</option>
							    <option value="3">Three</option>
							</select>
						</li>
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>30</option>
							    <option value="1">One</option>
							    <option value="2">Two</option>
							    <option value="3">Three</option>
							</select>
						</li>
					</ul>
				</div>
			</div>
			<div class="sidebar-products-area">
				<div class="sidebar-area">
					<aside class="sidebar">
						<div class="inner-sidebar">
							<div class="single-widget">
								<h3 class="widget-title">brand</h3>
								<div class="filter-list-wrapper exerp-menu">
									<ul class="filter-list">
										@foreach($brands as $brand)
											@if($brand->id == 1)

											@else
												<li class="{{ route('brand', $brand->slug) }}">
													<a href="{{ route('brand', $brand->slug) }}">{{ $brand->name }}</a>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">color family</h3>
								<div class="color-filter exerp-menu">
									<ul class="colors">
										<li class="active"><a class="black" style="background-color: #020202;" href="#"></a></li>
										<li><a class="grey" style="background-color: #95A9B2;" href="#"></a></li>
										<li><a class="red" style="background-color: #B82222;" href="#"></a></li>
										<li><a class="brown" style="background-color: #E2BB8D;" href="#"></a></li>
										<li><a class="grey" style="background-color: #95A9B2;" href="#"></a></li>
										<li><a class="red" style="background-color: #B82222;" href="#"></a></li>
										<li><a class="brown" style="background-color: #E2BB8D;" href="#"></a></li>
									</ul>
									<div class="text-end pe-2">
										<a class="viewmore-btn" href="#">view more<i class="bi bi-chevron-right"></i></a>
									</div>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">filters</h3>
								<div class="price-filter">
									<span class="label">price</span>
									<div class="prices-wrapper">
										<div class="single-price">
											<div class="price">
												<span>0</span><span>-</span><span>500</span>
											</div>
											<a href="{{ route('price', ['min_price'=>0, 'max_price'=>500]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>500</span><span>-</span><span>1000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>500, 'max_price'=>1000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>1000</span><span>-</span><span>2000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>1000, 'max_price'=>2000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>2000</span><span>-</span><span>5000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>2000, 'max_price'=>5000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">size</h3>
								<div class="filter-size">
									<ul class="filter-list">
										<li class="active"><a href="#">36</a></li>
										<li><a href="#">36</a></li>
										<li><a href="#">38</a></li>
										<li><a href="#">40</a></li>
										<li><a href="#">42</a></li>
										<li><a href="#">44</a></li>
									</ul>
								</div>
							</div>
						</div>
					</aside>
				</div>
				<div class="products-area">
					<div class="row responsive">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-3 col-4 px-2 mb-3">
                                <div class="single-product">
                                    <div class="inner-product">
                                        <figure>
                                            <img src="{{ asset($product->thambnail) }}" alt="">
                                        </figure>
                                        <div class="product-bottom">
                                            <div class="reviews">
                                                <div class="reviews-inner">
                                                    <div class="reviewed" style="width: 80%">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                    </div>
                                                    <div class="blanked">
                                                        <i class="bi bi-star"></i>
                                                        <i class="bi bi-star"></i>
                                                        <i class="bi bi-star"></i>
                                                        <i class="bi bi-star"></i>
                                                        <i class="bi bi-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3 class="product-name">
                                                <a href="{{ route('productdetails', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    <div class="old-price-discount">
                                                        <del class="old-price">৳ {{$product->buying_price}} </del>
                                                        <span class="discount">৳ {{ $product->discount }}</span>
                                                    </div>										
                                                </div>
                                                <a class="cart-btn" href="{{ route('add_to_cart', $product->id) }}">
													<i class="bi bi-cart-plus"></i>
													cart
												</a>
                                            </div>						
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Single Categories Section -->
@endsection

@push('js')

@endpush