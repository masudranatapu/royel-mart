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

    @if($products->count() > 0)
        <section class="all-products-section pt-2">
            <div class="container-fluid">
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row">
                        @foreach($products as $product)
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
                                                    {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($product->name, $lan, 'en') }}
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
                                                    {{ Stichoza\GoogleTranslate\GoogleTranslate::trans('Shop', $lan, 'en') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @include('pages.partials.product-paginate', ['paginator' => $products])
                </div>
            </div>
        </section>
    @else
        <section class="all-products-section pt-2">
            <div class="container-fluid">
                <div class="sidebar-products-area d-flex justify-content-center">
                    <img loading="eager|lazy" src="{{ asset('media/general-image/empty.webp') }}" alt="Product Not Found">
                </div>
            </div>
        </section>

    @endif
@endsection

@push('js')

@endpush
