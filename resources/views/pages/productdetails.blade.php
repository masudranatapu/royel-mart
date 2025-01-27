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
										<a class="popup-image" id="zoom-trigger" href="{{asset($products->thambnail)}}">
                                            <img width="466" height="466" id="zoomImg" src="{{asset($products->thambnail)}}" alt="">
                                        </a>
									</div>
								</div>
								<div class="product-photos swiper" id="image-gallery">
									<button class="button-prev">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
									<ul class="swiper-wrapper">
										<li class="swiper-slide">
                                            <a class="active" data-image="{{asset($products->thambnail)}}" href="javascript:;">
                                                <img src="{{asset($products->thambnail)}}" alt="">
                                            </a>
                                        </li>
                                        @if($products->multi_thambnail)
                                            @php
                                                $multimages = explode("|", $products->multi_thambnail);
                                            @endphp
                                            @foreach($multimages as $key=>$multimage)
                                                <li class="swiper-slide">
                                                    <a data-image="{{asset($multimage)}}" href="javascript:;">
                                                        <img src="{{asset($multimage)}}" alt="">
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
							<form action="{{ route('addtocart.withSizeColorQuantity') }}" method="POST">
                        		@csrf
                        		<input type="hidden" name="product_id" value="{{ $products->id }}">
								<div class="product-info-area">
									<h4 class="product-name">{{ $products->name }}</h4>
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
										<div class="reviews-answer">
											<span class="count-reviews">( {{ $reviews->count() }} ratings)</span>
										</div>
									</div>
									<div class="divider"></div>
									<div class="category-brand">
										@if($products->brand)
											<div class="brand">
												<label for="">brand:</label><a href="javascript:;">{{ $products['brand']['name'] }}</a>
											</div>
										@endif
										<div class="category">
											<label for="">category:</label><a href="javascript:;">{{ $products['category']['name'] }}</a>
										</div>
									</div>
									<div class="price">
										<span class="product-price">৳ {{ $products->sale_price }}</span>
										<div class="old-price-discount">
											<del class="old-price">৳ {{ $products->regular_price }}</del>
											<span class="discount">{{ $products->discount_tk }} ৳ Off</span>
										</div>
									</div>
									@php
										$colors = App\Models\ProductUnit::where('product_id', $products->id)->get();
									@endphp
									@if($colors->count() > 0 )
										<div class="divider"></div>
										<div class="colors">
											<label for="">colors:</label>
											<ul class="colors-wrapper">
													@foreach($colors as $key => $color)
														@php
															$colorname = App\Models\Unit::where('id', $color->unit_id)->first();
														@endphp
														<li class="" onclick="getColorId({{$colorname->id}})" style="background-color: {{ $colorname->name }}"></li>
													@endforeach
											</ul>
											<input type="hidden" name="color_id" value="" id="viewValue">
											<input type="hidden" name="product_id" value="{{ $products->id }}" id="product_id">
										</div>
										<div class="divider" id="showDivider" style="display:none;"></div>
										<div class="size" id="showSize" style="display:none;">
											<label for="">Size </label>
											<select name="size_id" class="form-select" id="sizeShow" required>

											</select>
											<a id="size-chart" href="#">Size Chart</a>
											<div id="chart-popup" class="chart-popup">
												<div class="inner-popup">
													<a href="javascript:;" class="close-chart">
														<i class="bi bi-x"></i>
													</a>
													<img src="{{asset('frontend/images/info/chart.jpg')}}" alt="">
												</div>
											</div>
										</div>
									@endif
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
									<div class="action-buttons">
										<button type="submit" class="product-btn cart-btn">
											<i class="bi bi-cart2"></i>
											add to cart
										</button>
										<a href="javascript:;" class="product-btn buy-btn" onclick="buynow_product_submit({{$products->id}})">
											<i class="bi bi-heart"></i>
											buy now
										</a>
									</div>
								</div>
							</form>
							<form action="{{ route('buynow') }}" method="POST" id="buynow_product_submit_form_{{ $products->id }}">
								@csrf
								<!-- this form only for buynow  -->
								<input type="hidden" name="product_id" value="{{ $products->id }}">
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
								<div class="delivery-options">
									<div class="single-option">
										<span class="icon"><img src="{{asset('frontend/images/icons/door-to-door.pn')}}g" alt=""></span>
                                        {{ $products->inside_delivery }}
									</div>
									<div class="single-option">
										<span class="icon"><img src="{{asset('frontend/images/icons/door-to-door.png')}}" alt=""></span>
                                        {{ $products->outside_delivery }}
									</div>
									<div class="single-option">
										<span class="icon"><img src="{{asset('frontend/images/icons/cash-on-delivery.png')}}" alt=""></span>
                                        <span>
                                            {{ $products->cash_delivery }}
                                        </span>
									</div>
								</div>
								<div class="divider"></div>
								<div class="title-area">
									<label for=""><span class="material-icons">policy</span>Return & Warranty policy</label>
								</div>
								<div class="return-warranty">
									<div class="single-policy">
										<span class="icon"><img src="{{asset('frontend/images/icons/time-check.png')}}" alt=""></span>
										<div class="wrapper">
                                            <span>
                                                {{ $products->return_status }}
                                            </span>
										</div>
									</div>
									<div class="single-policy">
										<span class="icon"><img src="{{asset('frontend/images/icons/warranty.png')}}" alt=""></span>
										<div class="wrapper">
                                            <span>
                                                {{ $products->warranty_policy }}
                                            </span>
										</div>
									</div>
								</div>
								<div class="divider"></div>
								<div class="title-area">
									<label for=""><span class="material-icons">share</span>Social Share</label>
								</div>
								<div class="share-area">
									<ul class="social">
                                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                        <div class="addthis_inline_share_toolbox_9zg8"></div>
									 </ul>
								</div>
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
						<h2 class="rating">4.3</h2>
						<span class="count-rating">{{ $reviews->count() }} ratings</span>
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
                        <form action="{{ route('customer.review') }}" method="POST" enctype="multipart/form-data">
                            @csrf
							<input type="hidden" value="{{ $products->id }}" name="product_id">
							@auth
								<input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
							@endauth
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
                                        <label>Product Review Image</label>
                                        <input name="image[]" class="form-control" id="multi_tham" type="file" multiple="">
                                    </div>
                                    <div class="single-input">
                                        <div class="row" id="preview_image"></div>
									</div>
                                    <div class="single-input">
                                        <label>Your Name</label>
                                        <input name="name" class="form-control" type="text" placeholder="Your Name">
                                    </div>
                                    <div class="single-input">
                                        <label >Your Email</label>
                                        <input name="email" class="form-control" type="email" placeholder="Your Email">
                                    </div>
                                    <div class="single-input">
                                        <label>Your Phone</label>
                                        <input name="phone" class="form-control" type="number" placeholder="Your Phone">
                                    </div>
                                    <div class="single-input">
                                        <label>Review detail</label>
                                        <textarea name="opinion" class="form-control" rows="4" type="text" placeholder="Please share your feedback about the product:Was the product as described? What is the quality like?"></textarea>
                                    </div>
                                    <div class="text-center mt-20">
                                        <button type="submit" class="submit-review">submit review</button>
                                    </div>
                                </div>
                            </div>
                        </form>
						<!-- End Review Popup -->
					</div>
                    @php
                        $latestproducts = App\Models\Product::where('id', '!=', $products->id)->latest()->limit(8)->get();
                    @endphp
					<div class="single-widget">
						<h3 class="widget-title">Latest Products</h3>
						<div class="latest-products">
							<ul>
                                @foreach($latestproducts as $product)
                                    <li>
                                        <figure>
                                            <a href="{{ route('productdetails', $product->slug) }}">
                                                <img src="{{asset($product->thambnail)}}" alt="">
                                            </a>
                                        </figure>
                                        <div class="content">
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
                                                <span class="count-reviews">(4)</span>
                                            </div>
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
						<span>8 reviews</span>
					</div>
					<div class="all-reviews">
                    	@if($reviews->count() > 0)
                            @foreach($reviews as $review)
								<div class="single-review">
									<div class="review-head">
										<div class="user-area">
											<div class="user-photo">
												<img src="@if($review->user_id) {{ asset($review['reviewuser']['image']) }} @else {{ asset('demomedia/demoprofile.png') }} @endif" alt="">
											</div>
											<div class="user-meta">
												@if($review->name == NULL)
													<h4 class="username">No Name Reviewer</h4>
												@else
													<h4 class="username">{{$review->name}}</h4>
												@endif
												@if($review->rating == 5)
													<div class="reviews">
														<div class="reviews-inner">
															<div class="reviewed" style="width: 100%">
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
												@elseif($review->rating == 4)
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
												@elseif($review->rating == 3)
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
												@elseif($review->rating == 2)
													<div class="reviews">
														<div class="reviews-inner">
															<div class="reviewed" style="width: 40%">
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
												@elseif($review->rating == 1)
													<div class="reviews">
														<div class="reviews-inner">
															<div class="reviewed" style="width: 20%">
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
                                                @endif
											</div>
										</div>
										<div class="date-area">
											<span class="date">
												{{ $review->created_at->format('d M Y h:i A') }}
											</span>
										</div>
									</div>
									<div class="review-body">
										<p>
											{!! $review->opinion !!}
										</p>
                                        @if($review->image)
                                            @php
                                                $multimagesreviewer = explode("|", $review->image);
                                            @endphp
                                            @foreach($multimagesreviewer as $key=>$multimagesreview)
												<img class="mr-2" width="80" height="80" src="{{ asset($multimagesreview) }}" alt="">
                                            @endforeach
										@endif
									</div>
									<div class="review-footer">
										<button class="helpful-btn">Helpful
											<span class="material-icons-outlined round">thumb_up</span>
										</button>
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Reviews Section -->
    @php
        $relatedProducts = App\Models\Product::where('category_id', $products->category_id)->where('id', '!=', $products->id)->limit(12)->get();
    @endphp
    @if($relatedProducts->count() > 0)
        <section class="related-products-section pt-60 pb-60">
            <div class="container">
                <div class="heading-area pb-20 mb-40">
                    <h1 class="heading">related products</h1>
                </div>
                <div class="row responsive">
                    @foreach($relatedProducts as $product)
                        <div class="col-xl-2 col-md-3 col-4 px-2 mb-3">
                            <div class="single-product">
                                <div class="inner-product">
                                    <figure>
                                        <img src="{{asset($product->thambnail)}}" alt="">
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
	<!-- buy now product  -->
	<script>
		function buynow_product_submit(id) {
		    document.getElementById('buynow_product_submit_form_'+id).submit();
		}
	</script>
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
						$("#showDivider").show();
						$("#showSize").show();
                        $("#sizeShow").empty();
						$('#sizeShow').html(data);
					},
				});
			}else {
				alert("Please select your color");
			}
		}
	</script>
    <script>
        $(document).ready(function(){
            $('#multi_tham').on('change', function(){ //on file input change
                if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data
                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(50)
                            .height(50); //create image element 
                                $('#preview_image').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
                }else{
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
@endpush