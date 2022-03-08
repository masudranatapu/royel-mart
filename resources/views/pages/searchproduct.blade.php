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

    @if($searchProducts->count() > 0)
        <section class="all-products-section pt-2">
            <div class="container-fluid">
                <!-- End Heading Area -->
                <div class="product-area">
                    <div class="row">
                        @foreach($searchProducts as $product)
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
                </div>
            </div>
        </section>
    @endif
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