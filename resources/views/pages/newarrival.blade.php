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
    <section class="all-products-section pt-2">
        <div class="container-fluid">
            <div class="product-area">
                <div class="row">
                    @foreach($newArrivals as $product)
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
                            <div class="single-product">
                                <div class="inner-product">
                                    <figure>
                                        <img src="{{asset($product->thambnail)}}" alt="">
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
                                            <a href="{{ route('productdetails', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="price-cart">
                                            <div class="product-price">
                                                <span class="current-price">৳ {{$product->sale_price}}</span>
                                                <div class="old-price-discount">
                                                    <del class="old-price">৳ {{$product->regular_price}} </del>
                                                    <span class="discount">{{ $product->discount }} % </span>
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
    </section>
@endsection

@push('js')

@endpush