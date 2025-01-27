@extends('layouts.frontend.app')

@section('title')
    {{$title}}
@endsection

@section('meta')

@endsection

@push('css')

@endpush

@section('content')
    <section class="category-slider-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-1">
                    <div class="inner-category-slider">
						<div class="category-area checknav">
                            @php
                                $categories = App\Models\Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->orderBy('serial_number', 'asc')->limit(18)->get();
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
                                                $parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->orderBy('serial_number', 'asc')->get();
                                            @endphp
                                            @if($parentcategories->count() > 0)
                                                <ul>
                                                    @foreach($parentcategories as $parentcategory)
                                                        <li>
                                                            <a href="{{ route('category', $parentcategory->slug) }}">
                                                                {{ $parentcategory->name }}
                                                            </a>
                                                            @php
                                                                $childcategories = App\Models\Category::where('child_id', $parentcategory->id)->orderBy('serial_number', 'asc')->get();
                                                            @endphp
                                                            @if($childcategories->count() > 0)
                                                                <ul>
                                                                    @foreach($childcategories as $childcategory)
                                                                        <li>
                                                                            <a href="{{ route('category', $childcategory->slug) }}">
                                                                                {{ $childcategory->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
						</div>
                        <div class="slider-area">
                            <div class="main-slider owl-carousel">
                                @foreach($sliders as $slider)
                                    <div class="single-slide">
                                        <a href="{{ $slider->link }}">
                                            <img src="{{ asset($slider->image) }}" alt="">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Category Main Slider -->
    <section class="sendlist-featuredbanner-section">
        <div class="container-fluid">
            <div class="inner-sendlist-featuredbanner">
                <div class="banners-area">
                    <div class="row">
                        <div class="col-lg-3 col-6 px-1 mb-lg-0 mb-2 single">
                            <div class="sendlist-area">
                                <div class="sendlist">
                                    <div class="icon">
                                        <img src="{{asset('frontend/images/icons/note.png')}}" alt="">
                                    </div>
                                    <div class="upload-field">
                                        <input class="form-control" type="file">
                                        <div class="img-group">
                                            <i class="bi bi-cloud-upload"></i>
                                            <i class="bi bi-chevron-down"></i>
                                        </div>
                                    </div>
                                    <div class="label">
                                        <label for="">Drop your shoplist & get home</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($banners as $banner)
                            <div class="col-lg-3 col-6 px-1 mb-lg-0 mb-2 single">
                                <div class="single-banner">
                                    <a href="{{ $banner->link }}">
                                        <img src="{{asset($banner->image)}}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Send List Banners -->
    {{-- 
    <section class="flash-sale-section pt-20">
        <div class="container-fluid">
            <div class="heading-area flash-sale-heading-area">
                <h1 class="heading">quick sale</h1>
                <div class="countdown-area">
                    <label class="me-4 d-lg-block d-none" for="">on sale now</label>
                    <label class="me-2" for="">ending in </label>
                    <div class="countdown" data-time="2022/03/02"></div>
                </div>
                <div class="button-area">
                    <a href="#">shop more </a>
                </div>
            </div>
            <!-- End Heading Area -->
            <div class="product-area">
                <div class="row">
                    
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
                                    <div class="reviews">
                                        <div class="reviews-inner">
                                            <div class="reviewed" style="width: 70%">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="blanked">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/2.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
                                    <div class="reviews">
                                        <div class="reviews-inner">
                                            <div class="reviewed">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="blanked">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/3.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
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
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/4.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
                                    <div class="reviews">
                                        <div class="reviews-inner">
                                            <div class="reviewed">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="blanked">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/5.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
                                    <div class="reviews">
                                        <div class="reviews-inner">
                                            <div class="reviewed" style="width: 50%">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="blanked">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/6.jpg')}}" alt="">
                                </figure>
                                <div class="product-bottom">
                                    <h3 class="product-name">
                                        <a href="single-product.html">Fashion Sports shoes</a>
                                    </h3>
                                    <div class="reviews">
                                        <div class="reviews-inner">
                                            <div class="reviewed">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="blanked">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">৳675,00</span>
                                        <div class="old-price-discount">
                                            <del class="old-price">৳534,33</del>
                                            <span class="discount">24% Off</span>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Product Area -->
        </div>
    </section>
    --}}
    <!-- End Flash Sale -->
    <section class="category-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">Category</h1>
                <div class="button-area">
                    <a href="{{ route('all.category') }}">See More</a>
                </div>
            </div>
            <!-- End Heading Area -->
            <div class="categories-area">
                <div class="row">
                    @foreach($categories as $category)
                        @if($category->id == 1)
                        @else
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                                <div class="single-category">
                                    <div class="icon">
                                        <a href="{{ route('category', $category->slug) }}">
                                            <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        </a>
                                    </div>
                                    <h4 class="category-name">
                                        <a href="{{ route('category', $category->slug) }}">{{ $category->name }}</a>
                                    </h4>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- End Product Area -->
        </div>
    </section>
    <!-- End Categories -->
    @if($newArrivals->count() > 0)
        <section class="new-arrival-section pt-2">
            <div class="container-fluid">
                <div class="heading-area">
                    <h1 class="heading">New Arrival</h1>
                    <div class="button-area">
                        <a href="{{ route('arrival') }}">See More</a>
                    </div>
                </div>
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row">
                        @foreach($newArrivals as $product)
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                                <div class="single-product">
                                    <div class="inner-product">
                                        <figure>
                                            <a href="{{ route('productdetails', $product->slug) }}">
                                                <img src="{{asset($product->thambnail)}}" alt="">
                                            </a>
                                        </figure>
                                        <div class="product-bottom">
                                            <div class="reviews">
                                                <div class="reviews-inner">
                                                    <div class="reviewed" style="width: 60%">
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
                                                <a href="{{ route('productdetails', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    <div class="old-price-discount">
                                                        <del class="old-price">৳ {{$product->regular_price}}</del>
                                                        <span class="discount">{{ $product->discount }} % </span>
                                                    </div>
                                                </div>
										        <a class="cart-btn" data-bs-toggle="modal" data-bs-target="#quickSelect_{{ $product->id }}" href="javascript:;">
                                                    <i class="bi bi-cart-plus"></i>
                                                    cart
                                                </a>
                                            </div>
                                            <div class="modal fade" id="quickSelect_{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="{{ route('addtocart.withSizeColorQuantity') }}" method="POST">
                        		                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}" id="product_id">
                                                                <div class="overflow-hidden">
                                                                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                @php
                                                                    $colors = App\Models\ProductUnit::where('product_id', $product->id)->get();
                                                                @endphp
                                                                @if($colors->count() > 0 )
                                                                    <div class="colors">
                                                                        <label for="">colors:</label>
                                                                        <ul class="colors-wrapper">
                                                                            @foreach($colors as $key => $color)
                                                                                @php
                                                                                    $colorname = App\Models\Unit::where('id', $color->unit_id)->first();
                                                                                @endphp
                                                                                <li onclick="getColorId({{ $product->id }} , {{ $colorname->id }})" class="" style="background-color: {{ $colorname->name }}"></li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <input type="hidden" name="color_id" value="" id="viewValue{{ $product->id }}">
                                                                    </div>
                                                                    <div class="divider" id="showDivider{{ $product->id }}" style="display:none;"></div>
                                                                    <div class="size" id="showSize{{ $product->id }}" style="display:none;">
                                                                        <label for="">size:</label>
                                                                        <select name="size_id" class="form-select" id="sizeShow{{ $product->id }}" required>

                                                                        </select>
                                                                    </div>
                                                                    <div class="divider"></div>
                                                                @endif
                                                                <div class="quantity">
                                                                    <label for="">quantity:</label>
                                                                    <div class="quantity-wrapper">
                                                                        <button type="button" class="qty qty-minus">
                                                                            <i class="bi bi-dash"></i>
                                                                        </button>
                                                                        <div class="input-wrapper">
                                                                            <input type="number" name="quantity" value="1">
                                                                        </div>
                                                                        <button type="button" class="qty qty-plus">
                                                                            <i class="bi bi-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="divider"></div>
                                                                <div class="action-buttons">
                                                                    <button type="submit" class="product-btn buy-btn">Go to Process</button>
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
                        @endforeach
                    </div>
                </div>
                <!-- End Product Area -->
            </div>
        </section>
    @endif
    <!-- End New Arrival -->
    @if($products->count() > 0)
        <section class="all-products-section pt-2">
            <div class="container-fluid">
                <div class="heading-area">
                    <!-- <h1 class="heading">Only for You</h1> -->
                    <h1 class="heading">Only For You</h1>
                    <div class="button-area">
                        <a href="{{ route('allproduct') }}">See More</a>
                    </div>
                </div>
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                                <div class="single-product">
                                    <div class="inner-product">
                                        <figure>
                                            <a href="{{ route('productdetails', $product->slug) }}">
                                                <img src="{{asset($product->thambnail)}}" alt="">
                                            </a>
                                        </figure>
                                        <div class="product-bottom">
                                            <div class="reviews">
                                                <div class="reviews-inner">
                                                    <div class="reviewed" style="width: 60%">
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
                                                <a href="{{ route('productdetails', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    <div class="old-price-discount">
                                                        <del class="old-price">৳ {{$product->regular_price}} </del>
                                                        <span class="discount">{{ $product->discount }} % </span>
                                                    </div>
                                                </div>
										        <a class="cart-btn" data-bs-toggle="modal" data-bs-target="#quickSelect_{{ $product->id }}" href="javascript:;">
                                                    <i class="bi bi-cart-plus"></i>
                                                    cart
                                                </a>
                                            </div>
                                            <div class="modal fade" id="quickSelect_{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="{{ route('addtocart.withSizeColorQuantity') }}" method="POST">
                        		                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}" id="product_id">
                                                                <div class="overflow-hidden">
                                                                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                @php
                                                                    $colors = App\Models\ProductUnit::where('product_id', $product->id)->get();
                                                                @endphp
                                                                @if($colors->count() > 0 )
                                                                    <div class="colors">
                                                                        <label for="">colors:</label>
                                                                        <ul class="colors-wrapper">
                                                                            @foreach($colors as $key => $color)
                                                                                @php
                                                                                    $colorname = App\Models\Unit::where('id', $color->unit_id)->first();
                                                                                @endphp
                                                                                <li onclick="getColorId({{ $product->id }}, {{ $colorname->id }})" class="" style="background-color: {{ $colorname->name }}"></li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <input type="hidden" name="color_id" value="" id="viewValue{{ $product->id }}">
                                                                    </div>
                                                                    <div class="divider" id="showDivider{{ $product->id }}" style="display:none;"></div>
                                                                    <div class="size" id="showSize{{ $product->id }}" style="display:none;">
                                                                        <label for="">size:</label>
                                                                        <select name="size_id" class="form-select" id="sizeShow{{ $product->id }}" required>

                                                                        </select>
                                                                    </div>
                                                                    <div class="divider"></div>
                                                                @endif
                                                                <div class="quantity">
                                                                    <label for="">quantity:</label>
                                                                    <div class="quantity-wrapper">
                                                                        <button type="button" class="qty qty-minus">
                                                                            <i class="bi bi-dash"></i>
                                                                        </button>
                                                                        <div class="input-wrapper">
                                                                            <input type="number" name="quantity" value="1">
                                                                        </div>
                                                                        <button type="button" class="qty qty-plus">
                                                                            <i class="bi bi-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="divider"></div>
                                                                <div class="action-buttons">
                                                                    <button type="submit" class="product-btn buy-btn">Go to Process</button>
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
                        @endforeach
                    </div>
                    <div class="btn-outer text-center mt-md-3 mt-2">
                        <a class="lg-btn" href="">See More...</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- End All Products -->
    <section class="mission-vision-section pt-20">
        <div class="container-fluid">
            <div class="content-area">
                <div class="info-carousel owl-carousel">
                    @foreach($missionvissions as $missionvission)
                        <div class="single-item">
                            <figure>
                                <img src="{{ asset($missionvission->image) }}" alt="">
                            </figure>
                            <div class="content">
                                <h2 class="title">{{ $missionvission->name }}</h2>
                                <p class="desc">
                                    {!! $missionvission->details !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> 
        </div>
    </section>
    <!-- End Mission Vision -->
@endsection

@push('js')
    <script>
		function getColorId(productId, val){
			$("#viewValue"+ productId).val(val);
			var product_id = $("#product_id").val();
			if(val) {
				// alert(val);
				$.ajax({
					type    : "POST",
					url     : "{{ route('color-size.ajax') }}",
					data    : {
						id      : val,
						p_id 	: product_id,
						_token  : '{{csrf_token()}}',
					},
					success:function(data) {
						console.log(data);
						$("#showDivider" + productId).show();
						$("#showSize" + productId).show();
                        $("#sizeShow" + productId).empty();
						$("#sizeShow" + productId).html(data);
					},
				});
			}else {
				alert("Please select your color");
			}
		}
    </script>
@endpush