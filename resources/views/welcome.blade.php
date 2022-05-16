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
                                @foreach(main_categories() as $category)
                                    <li class="@if(parent_categories($category->id)->count() > 0) has-sub @endif">
                                        <a href="{{ route('category', $category->slug) }}">
                                            <img loading="eager|lazy" src="@if(file_exists($category->image)) {{ asset($category->image) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="Cat">
                                            {{ language_convert($category->name) }}
                                        </a>
                                        @if(parent_categories($category->id)->count() > 0)
                                            <ul>
                                                @foreach(parent_categories($category->id) as $parentcategory)
                                                    <li @if(parent_categories($category->id)->count() > 0) has-sub @endif>
                                                        <a href="{{ route('category', $parentcategory->slug) }}">
                                                            {{ language_convert($parentcategory->name) }}
                                                        </a>
                                                        @if(child_categories($parentcategory->id)->count() > 0)
                                                            <ul>
                                                                @foreach(child_categories($parentcategory->id) as $childcategory)
                                                                    <li>
                                                                        <a href="{{ route('category', $childcategory->slug) }}">
                                                                            {{ language_convert($childcategory->name) }}
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
                                @endforeach
                            </ul>
						</div>
                        <div class="slider-area">
                            <div class="main-slider owl-carousel">
                                @foreach($sliders as $slider)
                                    <div class="single-slide">
                                        <a href="{{ $slider->link }}">
                                            <img loading="eager|lazy" src="@if(file_exists($slider->image)) {{asset($slider->image)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="Slider">
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
                        <div class="col-lg-3 col-12 px-1 mb-lg-0 mb-2 single">
                            <div class="sendlist-area">
                                <div class="sendlist">
                                    <div class="icon">
                                        <img loading="eager|lazy" src="{{asset('frontend/images/icons/note.png')}}" alt="">
                                    </div>
                                    <div class="upload-field">
                                        <input class="form-control" type="button" data-bs-toggle="modal" data-bs-target="#custom-order">
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
                            <div class="address-area">
                                <div class="addresses">
                                    @include('pages.partials.custom-order-modal')
                                </div>
                            </div>
                        </div>
                        @foreach($banners as $banner)
                            <div class="col-lg-3 col-6 px-1 mb-lg-0 mb-2 single">
                                <div class="single-banner">
                                    <a href="#">
                                        <img loading="eager|lazy" src="@if(file_exists($banner->image)) {{asset($banner->image)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="Banner">
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
    @if ($quick_sale)
        <section class="flash-sale-section pt-20">
            <div class="container-fluid">
                <div class="heading-area flash-sale-heading-area">
                    <h1 class="heading">quick sale</h1>
                    <div class="countdown-area">
                        <label class="me-4 d-lg-block d-none" for="">on sale now</label>
                        <label class="me-2" for="">ending in </label>
                        <div class="countdown" data-time="{{ change_date_format($quick_sale->end_date_time) }}"></div>
                    </div>
                    <div class="button-area">
                        <a href="{{ route('more-quick-sale-product', $quick_sale->slug) }}">shop more </a>
                    </div>
                </div>
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row">

                        @foreach($qs_products as $qs_product)
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3">
                                <div class="single-product">
                                    <div class="inner-product">
                                        <figure>
                                            <a href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
                                                <img loading="eager|lazy" src=" @if(file_exists($qs_product->product->thumbnail)) {{asset($qs_product->product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $qs_product->product->name }}">
                                            </a>
                                        </figure>
                                        <div class="product-bottom">

                                            {{ product_review($qs_product->product->id) }}

                                            <h3 class="product-name">
                                                <a href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
                                                    {{ language_convert($qs_product->product->name) }}
                                                </a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    @if ($quick_sale->discount > 0)
                                                        @php
                                                            $regular_price = $qs_product->product->regular_price;
                                                            if($quick_sale->discount_type == 'Solid'){
                                                                $sale_price = $regular_price - $quick_sale->discount;
                                                            }else{
                                                                $dis_price = floor(($quick_sale->discount * $regular_price)/100);
                                                                $sale_price = $regular_price - $dis_price;
                                                            }
                                                        @endphp
                                                    @else
                                                        @php
                                                            $regular_price = $qs_product->product->regular_price;
                                                            if($qs_product->discount_type == 'Solid'){
                                                                $sale_price = $regular_price - $qs_product->discount;
                                                            }else{
                                                                $dis_price = floor(($qs_product->discount * $regular_price)/100);
                                                                $sale_price = $regular_price - $dis_price;
                                                            }
                                                        @endphp
                                                    @endif
                                                    <span class="current-price">
                                                        ৳ {{$sale_price}}
                                                    </span>
                                                    @if ($quick_sale->discount > 0)
                                                        <div class="old-price-discount">
                                                            <del class="old-price">৳ {{$qs_product->product->regular_price}} </del>
                                                            <span class="discount">
                                                                @if ($quick_sale->discount_type == 'Solid')
                                                                    ৳ {{ $quick_sale->discount }}
                                                                @else
                                                                    {{ $quick_sale->discount }}%
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @elseif ($qs_product->discount > 0)
                                                        <div class="old-price-discount">
                                                            <del class="old-price">৳ {{$qs_product->product->regular_price}} </del>
                                                            <span class="discount">
                                                                @if ($qs_product->discount_type == 'Solid')
                                                                    ৳ {{ $qs_product->discount }}
                                                                @else
                                                                    {{ $qs_product->discount }}%
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <a class="cart-btn" href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
													<i class="bi bi-cart-plus"></i>
                                                    {{ language_convert('Shop') }}
												</a>
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
    <!-- End Flash Sale -->
    <section class="category-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">Category</h1>
            </div>
            <!-- End Heading Area -->
            <div class="categories-area">
                <div class="row">
                    @foreach(main_categories() as $category)
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                            <div class="single-category">
                                <div class="icon">
                                    <a href="{{ route('more-category', $category->slug) }}">
                                        <img loading="eager|lazy" src="@if(file_exists($category->image)) {{ asset($category->image) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="">
                                    </a>
                                </div>
                                <h4 class="category-name">
                                    <a href="{{ route('more-category', $category->slug) }}">
                                        {{ language_convert($category->name) }}
                                    </a>
                                </h4>
                            </div>
                        </div>
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
                    <h1 class="heading">
                        {{ language_convert('New Arrival') }}
                        </h1>
                    <div class="button-area">
                        <a href="{{ route('arrival') }}">
                            {{ language_convert('See More') }}
                        </a>
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
                                                <img loading="eager|lazy" src=" @if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $product->name }}">
                                            </a>
                                        </figure>
                                        <div class="product-bottom">

                                            {{ product_review($product->id) }}

                                            <h3 class="product-name">
                                                <a href="{{ route('productdetails', $product->slug) }}">
                                                    {{ language_convert($product->name) }}
                                                </a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    @if ($product->discount > 0)
                                                        <div class="old-price-discount">
                                                            <del class="old-price">৳ {{$product->regular_price}} </del>
                                                            <span class="discount">{{$product->discount}}%</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <a class="cart-btn" href="{{ route('productdetails', $product->slug) }}">
													<i class="bi bi-cart-plus"></i>
                                                    {{ language_convert('Shop') }}
												</a>
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
                    <h1 class="heading">
                        {{ language_convert('Only For You') }}
                    </h1>
                    <div class="button-area">
                        <a href="{{ route('allproduct') }}">
                            {{ language_convert('See More') }}
                        </a>
                    </div>
                </div>
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row" id="product-list">
                        @foreach($products as $product)
                            @php $last_id = $product->id; @endphp
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                                <div class="single-product">
                                    <div class="inner-product">
                                        <figure>
                                            <a href="{{ route('productdetails', $product->slug) }}">
                                                <img loading="eager|lazy" src="@if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $product->name }}">
                                            </a>
                                        </figure>
                                        <div class="product-bottom">

                                            {{ product_review($product->id) }}

                                            <h3 class="product-name">
                                                <a href="{{ route('productdetails', $product->slug) }}">
                                                    {{ language_convert($product->name) }}
                                                </a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    @if ($product->discount > 0)
                                                        <div class="old-price-discount">
                                                            <del class="old-price">৳ {{$product->regular_price}} </del>
                                                            <span class="discount">{{$product->discount}}%</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <a class="cart-btn" href="{{ route('productdetails', $product->slug) }}">
													<i class="bi bi-cart-plus"></i>
                                                    {{ language_convert('Shop') }}
												</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" value="{{ $last_id }}" id="last_id">
                    <div class="btn-outer text-center mt-md-3 mt-2">
                        <img src="{{ asset('media/general-image/loading.gif') }}" height="100px" width="100px" alt="Loading Image" style="display: none;" id="loadingImage">
                        <a class="lg-btn" href="javascript:;" onclick="loadMoreProduct()" id="loadMoreBtn">See More...</a>
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
                                <img loading="eager|lazy" src="@if(file_exists($missionvission->image)) {{asset($missionvission->image)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="Mission & Vission">
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
        function loadMoreProduct(){
            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            setTimeout(function(){
                loadProduct();
            }, 1000);
        }

        function loadProduct() {
            $("#loadingImage").hide();
            var last_id = $('#last_id').val();
            $.ajax({
                type    : "POST",
                url     : "{{ route('load-more-product') }}",
                data    : {
                    last_id : last_id,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                        $('#loadMoreBtn').show();
                    }
                },
            });
        };

    </script>
@endpush
