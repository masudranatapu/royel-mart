<div class="products-area">
    <div class="row responsive">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-3 col-4 px-2 mb-3">
                <div class="single-product">
                    <div class="inner-product">
                        <figure>
                            <img loading="eager|lazy" src=" @if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $product->name }}">
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
                                <a href="{{ route('productdetails', $product->slug) }}">{{ Stichoza\GoogleTranslate\GoogleTranslate::trans($product->name, $lan, 'en') }}</a>
                            </h3>
                            <div class="price-cart">
                                <div class="product-price">
                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                    @if ($product->discount > 0)
                                        <div class="old-price-discount">
                                            <del class="old-price">৳ {{$product->regular_price}} </del>
                                        </div>
                                    @endif
                                </div>
                                <a class="cart-btn" href="{{ route('productdetails', $product->slug) }}">
                                    <i class="bi bi-cart-plus"></i>
                                    Shop Now
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
