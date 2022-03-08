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
	@if($categorybanners->count() > 0)
		<section class="category-page-slider-section">
			<div class="category-page-slider owl-carousel">
				@foreach($categorybanners as $categorybanner)
					<div class="single-slide">
						<img src="@if($categorybanner->image) {{ asset($categorybanner->image) }}  @else {{ asset('demomedia/category.png') }} @endif">
					</div>
				@endforeach
			</div>
		</section>
	@endif
	<!-- End Category Page Slider -->
	<section class="featured-category-section pt-20">
		<div class="container-fluid">
			<div class="row">
                @foreach($latestcategoryads as $category)
					<div class="col-md-4 px-md-2 px-1">
						<div class="single-featured-category">
							<figure>
								<a href="{{ $category->link }}">
									<img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
								</a>
							</figure>
							<h3 class="title">
								<a href="{{ $category->link }}">
									{{ $category->name }}
								</a>
							</h3>
						</div>
					</div>
                @endforeach
			</div>
		</div>
	</section>
	<!-- End Featured Category -->
	<section class="single-categories-section pb-60 pt-20">
		<div class="container-fluid">
			<div class="title-filter-area">
				<div class="title-area w-100">
					<h3 class="category-title">Related Categories - Royelmart.com</h3>
				</div>
				<div class="categories">
					<ul class="row">
                        @foreach($relatedcategory as $category)
							@if($category->id == 1)
							@else
								<li class="col-md-3">
									<a href="{{ route('category', $category->slug) }}">
										<img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
										<span>{{ $category->name }}</span>
									</a>
								</li>
							@endif
                        @endforeach
                    </ul>
				</div>
			</div>
			<div class="title-filter-area pb-40">
				<div class="title-area">
					<h3 class="category-title">{{ $title }} - Royelmart</h3>
				</div>
				<div class="filter-area">
					<ul class="filter-items">
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>Latest</option>
							    <option value="1">One</option>
							    <option value="2">Two</option>
							    <option value="3">Three</option>
							</select>
						</li>
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>30</option>
							    <option value="1">One</option>
							    <option value="2">Two</option>
							    <option value="3">Three</option>
							</select>
						</li>
					</ul>
				</div>
			</div>
			<div class="sidebar-products-area">
				<div class="sidebar-area">
					<aside class="sidebar">
						<div class="inner-sidebar">
							<div class="single-widget">
								<h3 class="widget-title">brand</h3>
								<div class="filter-list-wrapper exerp-menu">
									<ul class="filter-list">
										@foreach($brands as $brand)
											@if($brand->id == 1)
											@else
												<li class="{{ route('brand', $brand->slug) }}">
													<a href="{{ route('brand', $brand->slug) }}">{{ $brand->name }}</a>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">color family</h3>
								<div class="color-filter exerp-menu">
									<ul class="colors">
										@foreach($units as $unit)
											<li class="">
												<a style="background-color: {{ $unit->name }}" href="{{ route('color.product', $unit->slug) }}"></a>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">size</h3>
								<div class="filter-size">
									<ul class="filter-list">
										@foreach($subunits as $subunit)
											<li class="">
												<a href="{{ route('size.product', $subunit->slug) }}">{{ $subunit->name }}</a>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">filters</h3>
								<div class="price-filter">
									<span class="label">price</span>
									<div class="prices-wrapper">
										<div class="single-price">
											<div class="price">
												<span>0</span><span>-</span><span>500</span>
											</div>
											<a href="{{ route('price', ['min_price'=>0, 'max_price'=>500]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>500</span><span>-</span><span>1000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>500, 'max_price'=>1000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>1000</span><span>-</span><span>2000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>1000, 'max_price'=>2000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
										<div class="single-price">
											<div class="price">
												<span>2000</span><span>-</span><span>5000</span>
											</div>
											<a href="{{ route('price', ['min_price'=>2000, 'max_price'=>5000]) }}">
												<i class="bi bi-chevron-right"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="single-widget">
								<h3 class="widget-title">Latest Products</h3>
								<div class="latest-products">
                                    @php
                                        $latestproducts = App\Models\Product::where('category_id', $category->id)->latest()->limit(5)->get();
                                    @endphp
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
					</aside>
				</div>
				<div class="products-area">
					<div class="row responsive">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-3 col-4 px-2 mb-3">
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
                                                <a href="{{ route('productdetails', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="price-cart">
                                                <div class="product-price">
                                                    <span class="current-price">৳ {{$product->sale_price}}</span>
                                                    <div class="old-price-discount">
                                                        <del class="old-price">৳ {{$product->regular_price}} </del>
                                                        <span class="discount">{{ $product->discount }} %</span>
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
		</div>
	</section>
	<!-- End Single Categories Section -->
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