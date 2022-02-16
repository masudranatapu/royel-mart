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
                            <ul class="category-list">
                                @php
                                    $categories = App\Models\Category::where('status', 1)->latest()->get();
                                @endphp
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('category',$category->slug) }}">
                                            <img src="{{ asset($category->image) }}" alt="">
                                            <span>
                                                {{ $category->name }}
                                            </span>
                                        </a>
                                        @php
                                            $parentcategories = App\Models\SubCategory::where('category_id', $category->id)->latest()->get();
                                        @endphp
                                        @if (count($parentcategories) > 0)
                                            <ul>
                                                @foreach($parentcategories as $parentcategory)
                                                    <li>
                                                        <a href="{{ route('category',$parentcategory->slug) }}">{{ $parentcategory->name }}</a>
                                                        @php
                                                            $childcategories = App\Models\SubSubCategory::where('subcategory_id', $parentcategory->id)->latest()->get();
                                                        @endphp
                                                        @if (count($childcategories) > 0)
                                                            <ul>
                                                                @foreach($childcategories as $childcategory)
                                                                    <li><a href="{{ route('category',$childcategory->slug) }}">{{ $childcategory->name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="slider-area">
                            <div class="main-slider owl-carousel">
                                @foreach($sliders as $slider)
                                    <div class="single-slide">
                                        <img src="{{ asset($slider->image) }}" alt="">
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
                                    <a href="#">
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
    <!-- End Flash Sale -->
    <section class="category-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">Category</h1>
                <div class="button-area">
                    <a href="#">See More</a>
                </div>
            </div>
            <!-- End Heading Area -->
            
            <div class="categories-area">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/vegetable-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">daily needs</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/tv-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Electronics & Home Appliance</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/first-aid-kit-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Health & Nutrition</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/skincare-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Cosmetics & Beauty Care</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/baby-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Baby Food & Fashions</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/fashion-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Women’s Fashions</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/sport-watch-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Men’s Fashions</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/console-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Stationery, Toys & Games</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/sport-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Sports & Fitness</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/decorating-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Lifestyle & Home Decor</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/real-estate-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Real Estate & Property</a></h4>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                        <div class="single-category">
                            <div class="icon">
                                <a href="#"><img src="{{asset('frontend/images/icons/motorcycle-1.png')}}" alt=""></a>
                            </div>
                            <h4 class="category-name"><a href="#">Automobile & Motor Bikes</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Area -->			
        </div>
    </section>
    <!-- End Categories -->
    <section class="new-arrival-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">new arrival</h1>
                <div class="button-area">
                    <a href="#">See More</a>
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
    <!-- End New Arrival -->
    <section class="all-products-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">Only for You</h1>
                <div class="button-area">
                    <a href="#">See More</a>
                </div>
            </div>
            <!-- End Heading Area -->
            <div class="product-area">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.pn')}}g" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/1.jpg')}}" alt="">
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/11.png')}}" alt="">
                                    <span class="discount">-15% </span>
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
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                        <div class="single-product">
                            <div class="inner-product">
                                <figure>
                                    <img src="{{asset('frontend/images/products/12.png')}}" alt="">
                                </figure>
                                <div class="product-bottom">
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
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="single-product.html">Orient Chair - Crisscross - Sandle Wood (4 pcs) - 6581</a>
                                    </h3>
                                    <div class="price-cart">
                                        <div class="product-price">
                                            <span class="current-price">৳675,00</span>
                                            <div class="old-price-discount">
                                                <del class="old-price">৳534,33</del>
                                                <span class="discount">24%</span>
                                            </div>											
                                        </div>
                                        <a class="cart-btn" href="#"><i class="bi bi-cart-plus"></i>cart</a>
                                    </div>						
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-outer text-center mt-md-3 mt-2">
                    <a class="lg-btn" href="#">See More...</a>
                </div>
            </div>
        </div>
    </section>
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

@endpush