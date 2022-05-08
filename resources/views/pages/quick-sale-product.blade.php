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

                                        {{ product_review($product->id) }}

                                        <h3 class="product-name">
                                            <a href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
                                                {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($qs_product->product->name, $lan, 'en') }}
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
                                                                {{ $quick_sale->discount }} %
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
                                                                {{ $qs_product->discount }} %
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <a class="cart-btn" href="{{ route('quick-sale-product-details', [$quick_sale->slug, $qs_product->product->slug]) }}">
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
                @include('pages.partials.quick-sale-product-paginate', ['paginator' => $qs_products])
            </div>
        </div>
    </section>
@endsection

@push('js')

@endpush
