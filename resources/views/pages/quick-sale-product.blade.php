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
    <section class="flash-sale-section pt-20">
        <div class="container-fluid">
            <div class="heading-area flash-sale-heading-area">
                <h1 class="heading">quick sale</h1>
                <div class="countdown-area">
                    <label class="me-4 d-lg-block d-none" for="">on sale now</label>
                    <label class="me-2" for="">ending in </label>
                    <div class="countdown" data-time="{{ \Carbon\Carbon::parse($quick_sale->end_date_time)->format('Y/m/d')}}"></div>
                </div>
            </div>
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
                                            <a href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
                                                {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($qs_product->product->name, $lan, 'en') }}
                                            </a>
                                        </h3>
                                        <div class="price-cart">
                                            <div class="product-price">
                                                <span class="current-price">৳ {{$qs_product->sale_price}}</span>
                                                @if ($qs_product->product->discount > 0)
                                                    <div class="old-price-discount">
                                                        <del class="old-price">৳ {{$qs_product->product->regular_price}} </del>
                                                    </div>
                                                @endif
                                            </div>
                                            <a class="cart-btn" href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
                                                <i class="bi bi-cart-plus"></i>
                                                {{ Stichoza\GoogleTranslate\GoogleTranslate::trans('Shop Now', $lan, 'en') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                @include('pages.partials.quick-sale-product-paginate', ['paginator' => $qs_products])
            </div>
        </div>
    </section>
@endsection

@push('js')

@endpush
