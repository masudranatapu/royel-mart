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
                <div class="row" id="product-list">
                    @foreach($products as $product)
                        @php $last_id = $product->id; @endphp
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 px-2 mb-3 mb-3">
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
                                            <a href="{{ route('productdetails', $product->slug) }}">{{ $product->name }}</a>
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
                                                Shop
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" value="{{ $last_id }}" id="last_id">
                <div class="btn-outer text-center mt-md-3 mt-2 mb-4">
                    <img src="{{ asset('media/general-image/loading.gif') }}" height="100px" width="100px" alt="Loading Image" style="display: none;" id="loadingImage">
                    <a class="lg-btn" href="javascript:;" onclick="loadMoreProduct()" id="loadMoreBtn">See More...</a>
                </div>
                {{-- @include('pages.partials.product-paginate', ['paginator' => $products]) --}}
            </div>
        </div>
    </section>
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
                url     : "{{ route('load-more-newarrival-product') }}",
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
