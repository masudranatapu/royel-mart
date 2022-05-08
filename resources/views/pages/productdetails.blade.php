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
	<!-- End Breadcrumb -->
	<section class="single-product-section pt-2">
		<div class="container">
			<div class="media-details-policy-wrapper">
				<div class="media-info">
					<div class="row">
						<div class="col-lg-6 mb-4">
							<div class="product-media-area">
								<div class="product-zoom-photo">
									<div class="zoom-wrapper">
										<div class="zoom" id="zoom">
										    <a class="zoom-trigger" href="@if(file_exists($products->thumbnail)) {{asset($products->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif"></a>
                                            <img width='555' height='455' src="@if(file_exists($products->thumbnail)) {{asset($products->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="Thumbnail">
                                        </div>
									</div>
								</div>
								<div class="product-photos swiper" id="image-gallery">
									<button class="button-prev">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
									<ul class="swiper-wrapper">
										<li class="swiper-slide">
                                            <a class="active" data-image="@if(file_exists($products->thumbnail)) {{asset($products->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" href="javascript:;">
                                                <img loading="eager|lazy" src="@if(file_exists($products->thumbnail)) {{asset($products->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="">
                                            </a>
                                        </li>
                                        @if($products->more_image)
                                            @php
                                                $multimages = explode("|", $products->more_image);
                                            @endphp
                                            @foreach($multimages as $key=>$multimage)
                                                <li class="swiper-slide">
                                                    <a data-image="{{asset($multimage)}}" href="javascript:;">
                                                        <img loading="eager|lazy" src="{{asset($multimage)}}" alt="">
                                                    </a>
                                                </li>
                                            @endforeach
										@endif
                                    </ul>
									<button class="button-next">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-2">
							<form action="{{ route('addtocart.withSizeColorQuantity') }}" method="POST" id="cart_form">
                        		@csrf
                        		<input type="hidden" name="product_id" value="{{ $products->id }}" id="product_id">
								<div class="product-info-area">
									<h4 class="product-name">{{ $products->name }}</h4>

                                    {{ product_review_details_page($products->id) }}

									<div class="divider"></div>
									<div class="category-brand">
										@if($products->brand)
											<div class="brand">
												<label for="">brand:</label><a href="javascript:;">{{ $products['brand']['name'] }}</a>
											</div>
										@endif
										<div class="category">
											<label for="">category:</label><a href="{{ route('category', $products['category']['slug']) }}">{{ $products['category']['name'] }}</a>
										</div>
                                        @if($products->unit_id != NULL )
                                            <div class="category">
                                                <label for="">Unit:</label><a href="javascript:;">{{ $products->unit->name }}</a>
                                            </div>
                                        @endif
                                        <div class="category">
                                            <label for="">Shipping Charge:</label><a href="javascript:;">৳ {{ $products->shipping_charge }}</a>
                                        </div>
									</div>
									<div class="price">
										<span class="product-price">৳ {{ $products->sale_price }}</span>
                                        <input type="hidden" name="regular_price" value="{{ $products->regular_price }}">
                                        <input type="hidden" name="sale_price" value="{{ $products->sale_price }}">
                                        @if ($products->discount > 0 )
                                            <div class="old-price-discount">
                                                <del class="old-price">৳ {{ $products->regular_price }}</del>
                                                <span class="discount">৳ {{ $products->discount_tk }} Off</span>
                                            </div>
                                        @endif
                                        <input type="hidden" name="discount" value="{{ $products->discount_tk }}">
									</div>
									@if($colors->count() > 0 )
										<div class="divider"></div>
										<div class="colors">
											<label for="">colors:</label>
											<ul class="colors-wrapper">
                                                @foreach($colors as $key => $color)
                                                    <li class="" onclick="getColorId({{$color->Color->id}})" style="background-color: {{ $color->Color->code }}"></li>
                                                @endforeach
											</ul>
                                            <input type="hidden" value="1" id="coloe_exist">
											<input type="hidden" name="color_id" value="" id="viewValue">
										</div>
                                    @else
                                        <input type="hidden" value="0" id="coloe_exist">
                                    @endif
                                    <div class="divider" id="showDivider" style="display:none;"></div>
                                    <div class="size" id="showSize" style="display:none;">
                                        {{-- <a id="size-chart" href="#">Size Chart</a>
                                        <div id="chart-popup" class="chart-popup">
                                            <div class="inner-popup">
                                                <a href="javascript:;" class="close-chart">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                                <img loading="eager|lazy" src="{{asset('frontend/images/info/chart.jpg')}}" alt="">
                                            </div>
                                        </div> --}}
                                    </div>

									<div class="divider"></div>
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
                                    <input type="hidden" name="cart_type" id="cart_type" value="Add to cart">
									<div class="action-buttons">
										<button type="button" class="product-btn cart-btn" onclick="addToCartBtn()">
											<i class="bi bi-cart2"></i>
											add to cart
										</button>
										<button type="button" class="product-btn buy-btn" onclick="buyBtn()">
											<i class="bi bi-heart"></i>
											buy now
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="policy-wrapper">
					<div class="row">
						<div class="col-12">
							<div class="policy-area">
								<div class="title-area">
									<label for=""><i class="bi bi-geo-alt"></i>delivery</label>
								</div>
								<div class="delivery-options text-wrap">
									<div class="single-option">
										<span class="icon"><img loading="eager|lazy" src="{{asset('frontend/images/icons/door-to-door.png')}}" alt=""></span>
                                        <span class="text-wrap">
                                            {{ $products->inside_delivery }}
                                        </span>
									</div>
									<div class="single-option">
										<span class="icon"><img loading="eager|lazy" src="{{asset('frontend/images/icons/door-to-door.png')}}" alt=""></span>
                                        <span class="text-wrap">
                                            {{ $products->outside_delivery }}
                                        </span>
									</div>
								</div>
								<div class="divider"></div>
								<div class="title-area">
									<label for=""><i class="bi bi-credit-card-fill"></i>Payment Method</label>
								</div>
								<div class="delivery-options text-wrap">
									<div class="single-option">
										<span class="icon"><img loading="eager|lazy" src="{{asset('frontend/images/icons/cash-on-delivery.png')}}" alt=""></span>
                                        @if ($products->payment_method != NULL)
                                            @php
                                                $payment_method = explode("|",$products->payment_method);
                                            @endphp
                                            @foreach($payment_method as $key=>$payment_method)
                                                <span class="text-wrap">
                                                    {{ $key+1 }}. {{ $payment_method }}
                                                </span>
                                            @endforeach
                                        @endif
									</div>
								</div>
								<div class="divider"></div>
								<div class="title-area">
									<label for=""><span class="material-icons">policy</span>Return & Warranty policy</label>
								</div>
								<div class="return-warranty text-wrap">
									<div class="single-policy">
										<span class="icon"><img loading="eager|lazy" src="{{asset('frontend/images/icons/time-check.png')}}" alt=""></span>
										<div class="wrapper">
                                            @if ($products->guarantee_policy != NULL)
                                                @php
                                                    $guarantee_policy = explode("|",$products->guarantee_policy);
                                                @endphp
                                                @foreach($guarantee_policy as $key=>$guarantee_policy)
                                                    <span class="text-wrap">
                                                        {{ $key+1 }}. {{ $guarantee_policy }}
                                                    </span>
                                                @endforeach
                                            @endif
										</div>
									</div>
									<div class="single-policy">
										<span class="icon"><img loading="eager|lazy" src="{{asset('frontend/images/icons/warranty.png')}}" alt=""></span>
										<div class="wrapper">
                                            @if ($products->warranty_policy != NULL)
                                                @php
                                                    $warranty_policy = explode("|",$products->warranty_policy);
                                                @endphp
                                                @foreach($warranty_policy as $key=>$warranty_policy)
                                                    <span class="text-wrap">
                                                        {{ $key+1 }}. {{ $warranty_policy }}
                                                    </span>
                                                @endforeach
                                            @endif
										</div>
									</div>
								</div>
								{{-- <div class="divider"></div>
								<div class="title-area">
									<label for=""><span class="material-icons">share</span>Social Share</label>
								</div>
								<div class="share-area text-wrap">
									<ul class="social">
                                        <div class="addthis_inline_share_toolbox_9zg8"></div>
									 </ul>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="details" class="product-details-info pt-40 pb-40">
				<h3 class="title">Product Details </h3>
                <p>
                    {!! $products->description  !!}
                </p>
            </div>
		</div>
	</section>
	<!-- End Single Product Section -->
	<section class="reviews-section pt-40 pb-40">
		<div class="container">
			<div class="graphical-reviews-area">
				<h3 class="title">Product Rating & Reviews </h3>
				<div class="review-wrapper">
					<div class="left-area">
						<h2 class="rating">{{ final_rating($products->id) }}</h2>
						<span class="count-rating">{{ total_review($products->id) }} ratings</span>
					</div>
					<div class="right-area">
						<div class="rating-wrapper">
							<div class="star-area">
								<a href="#">
									<div class="single-stars">
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
									</div>
								</a>
								<a href="#">
									<div class="single-stars">
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
									</div>
								</a>
								<a href="#">
									<div class="single-stars">
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
									</div>
								</a>
								<a href="#">
									<div class="single-stars">
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
									</div>
								</a>
								<a href="#">
									<div class="single-stars">
										<i class="bi bi-star-fill"></i>
									</div>
								</a>
							</div>
							<div class="count-area">
								<div class="single-count">
									<span class="count-line" style="width: 60%"></span>
									<span class="count">{{ $fiveStarReviews->count() }}</span>
								</div>
								<div class="single-count">
									<span class="count-line" style="width: 30%"></span>
									<span class="count">{{ $fourStarReviews->count() }}</span>
								</div>
								<div class="single-count">
									<span class="count-line" style="width: 20%"></span>
									<span class="count">{{ $threeStarReviews->count() }}</span>
								</div>
								<div class="single-count">
									<span class="count-line" style="width: 15%"></span>
									<span class="count">{{ $twoStarReviews->count() }}</span>
								</div>
								<div class="single-count">
									<span class="count-line" style="width: 5%"></span>
									<span class="count">{{ $oneStarReviews->count() }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="reviews-sidebar-area pt-40">
				<div class="sidebar-area">
					<div class="single-widget add-review">
						<h3 class="widget-title">Review this product</h3>
						<label for="">Share your thoughts with other customers</label>
						<button id="add-review-btn" class="add-review-btn">
                            <i class="bi bi-pencil-fill"></i>
                            Write a review
                        </button>
                        <form id="review_form" action="{{ url('product-review') }}" method="POST" enctype="multipart/form-data">
                            @csrf
							<input type="hidden" value="{{ $products->id }}" name="product_id">
                            <div class="add-review-popup" id="add-review-popup">
                                <div class="inner-popup">
                                    <button class="close-popup" type="button">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    <h3 class="title">give your review</h3>
                                    <div class="review-stars">
                                        <label>rating</label>
                                        <div class="wrapper">
                                            <i class="bi bi-star" onclick="reviewVal(1)"></i>
                                            <i class="bi bi-star" onclick="reviewVal(2)"></i>
                                            <i class="bi bi-star" onclick="reviewVal(3)"></i>
                                            <i class="bi bi-star" onclick="reviewVal(4)"></i>
                                            <i class="bi bi-star" onclick="reviewVal(5)"></i>
                                        </div>
                                    </div>
									<input name="rating" class="form-control" id="review-val" type="hidden" placeholder="Your Name">
                                    <div class="single-input">
                                        <label>Your Name</label>
                                        <input name="name" class="form-control" type="text" required value="@auth {{ Auth::user()->name }} @endauth" placeholder="Your Name">
                                    </div>
                                    <div class="single-input">
                                        <label >Your Email</label>
                                        <input name="email" class="form-control" type="email" value="@auth {{ Auth::user()->email }} @endauth" placeholder="Your Email">
                                    </div>
                                    <div class="single-input">
                                        <label>Your Phone</label>
                                        <input name="phone" class="form-control" type="number" value="@auth {{ Auth::user()->phone }} @endauth" required placeholder="Your Phone">
                                    </div>
                                    <div class="single-input">
                                        <label>Review detail</label>
                                        <textarea name="opinion" class="form-control" rows="4" type="text" placeholder="Please share your feedback about the product:Was the product as described? What is the quality like?"></textarea>
                                    </div>
                                    <div class="single-input">
                                        <label>File</label>
                                        <input type="file" class="form-control" name="image[]" multiple>
                                    </div>
                                    <div class="text-center mt-20">
                                        <button type="submit" class="submit-review">submit review</button>
                                    </div>
                                </div>
                            </div>
                        </form>
						<!-- End Review Popup -->
					</div>
					<div class="single-widget">
						<h3 class="widget-title">Latest Products</h3>
						<div class="latest-products">
							<ul>
                                @foreach($latestproducts as $product)
                                    <li>
                                        <figure>
                                            <a href="{{ route('productdetails', $product->slug) }}">
                                                <img loading="eager|lazy" src="@if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="">
                                            </a>
                                        </figure>
                                        <div class="content">

                                            {{ product_review($product->id) }}

                                            <h3 class="product-name">
                                                <a href="{{ route('productdetails', $product->slug) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="price-cart">
                                                <span class="price">৳ {{$product->sale_price}}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="reviews-area">
					<div class="header-area">
						<span>{{ total_review($products->id) }} reviews</span>
					</div>
					<div class="all-reviews">
                    	@if($reviews->count() > 0)
                            @foreach($reviews as $review)
								<div class="single-review">
									<div class="review-head">
										<div class="user-area">
											<div class="user-photo">
												<img loading="eager|lazy" src="@if($review->user_id) {{ asset( user_image($review->user_id) ) }} @else {{ asset('demomedia/demoprofile.png') }} @endif" alt="">
											</div>
											<div class="user-meta">
												@if($review->name == NULL)
													<h4 class="username">No Name Reviewer</h4>
												@else
													<h4 class="username">{{$review->name}}</h4>
												@endif

                                                {{ review_rating($review->rating) }}
											</div>
										</div>
										<div class="date-area">
											<span class="date">
												{{ $review->created_at->format('d M Y h:i A') }}
											</span>
										</div>
									</div>
									<div class="review-body">
										<p>{!! $review->opinion !!}</p>
                                        {{ review_image($review->id) }}
									</div>

                                    {{-- {{ replay_this_review($review->id) }} --}}
                                    @include('pages.partials.replay-review')
                                    @auth
                                        @if(Auth::check() && auth()->user()->role_id == 1)
                                            <div class="review-footer">
                                                <button class="helpful-btn" onclick="replayReview({{ $review->id }})">
                                                    <span class="material-icons-outlined round">replay</span> Replay
                                                </button>
                                            </div>
                                        @endif
                                    @endauth
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Reviews Section -->
    @if($relatedProducts->count() > 0)
        <section class="related-products-section pt-60 pb-60">
            <div class="container">
                <div class="heading-area pb-20 mb-40">
                    <h1 class="heading">related products</h1>
                </div>
                <div class="row responsive">
                    @foreach($relatedProducts as $product)
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
            </div>
        </section>
    @endif
	<!-- End Related Products Section -->
@endsection

@push('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-61385eedbd8b385d"></script>
	<script>
		 function reviewVal(val){
			$('#review-val').val(val);
		}
		function getColorId(val){
			$("#viewValue").val(val);
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
                        if(data != ''){
                            $("#showDivider").show();
                            $("#showSize").show();
                            $('#showSize').html(data);
                        }else{
                            $("#showDivider").hide();
                            $("#showSize").hide();
                            $("#showSize").empty();
                        }
					},
				});
			}else {
				alert("Please select your color");
			}
		}

        function addToCartBtn(){
            var coloe_exist = $('#coloe_exist').val();
            var coloe_id = $('#viewValue').val();
            if(coloe_exist == 1 && coloe_id == ''){
                alert('Please select color first');
            }else{
                if ($('#size_id').length){
                    var size_id = $('#size_id').val();
                    if(size_id == ''){
                        alert('Please select size first');
                    }else{
                        $('#cart_type').val('Add to cart');
                        $('#cart_form').submit();
                    }
                }else{
                    $('#cart_type').val('Add to cart');
                    $('#cart_form').submit();
                }
            }
        }

        function buyBtn(){
            var coloe_exist = $('#coloe_exist').val();
            var coloe_id = $('#viewValue').val();
            if(coloe_exist == 1 && coloe_id == ''){
                alert('Please select color first');
            }else{
                if ($('#size_id').length){
                    var size_id = $('#size_id').val();
                    if(size_id == ''){
                        alert('Please select size first');
                    }else{
                        $('#cart_type').val('Buy now');
                        $('#cart_form').submit();
                    }
                }else{
                    $('#cart_type').val('Buy now');
                    $('#cart_form').submit();
                }
            }
        }


        function replayReview(review_id){
            let popupSelector = document.querySelector('#add-review-popup');
            popupSelector.classList.add('show');

            var base_url = window.location.origin;
            var url = base_url+"/replay-review/"+review_id;

            $('#review_form').attr('action', url);
        }
	</script>
@endpush
