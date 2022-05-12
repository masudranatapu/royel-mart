<div class="products-area">
    <input type="hidden" id="cat_id" value="{{ $cat_id }}">
    <div class="row responsive" id="product-list">
        @foreach($products as $product)
            @php $last_id = $product->id; @endphp
            <div class="col-lg-3 col-md-3 col-4 px-2 mb-3">
                <div class="single-product">
                    <div class="inner-product">
                        <figure>
                            <a href="{{ route('productdetails', $product->slug) }}">
                                <img loading="eager|lazy" src="@if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $product->name }}">
                            </a>
                            @if ($product->product_type == 'New Arrival')
                                <span class="arrival new">New</span>
                            @elseif ($product->product_type == 'Features')
                                <span class="arrival featured">Featured</span>
                            @endif
                        </figure>
                        <div class="product-bottom">

                            {{ product_review($product->id) }}

                            <h3 class="product-name">
                                <a href="{{ route('productdetails', $product->slug) }}">{{ Stichoza\GoogleTranslate\GoogleTranslate::trans($product->name, $lan, 'en') }}</a>
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
    <div class="btn-outer text-center mt-md-3 mt-2">
        <img src="{{ asset('media/general-image/loading.gif') }}" height="100px" width="100px" alt="Loading Image" style="display: none;" id="loadingImage">
        <a class="lg-btn" href="javascript:;" onclick="loadMoreProduct()" id="loadMoreBtn">See More...</a>
    </div>
    {{-- @include('pages.partials.product-paginate', ['paginator' => $products]) --}}
</div>
