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
	<section class="category-page-slider-section">
        <div class="category-page-slider owl-carousel">
            @foreach($categorybanners as $categorybanner)
                <div class="single-slide">
                    <a href="{{ $categorybanner->link }}">
                        <img loading="eager|lazy" src="@if($categorybanner->image) {{ asset($categorybanner->image) }}  @else {{ asset('demomedia/category.png') }} @endif">
                    </a>
                </div>
            @endforeach
        </div>
	</section>
	<!-- End Category Page Slider -->
	<section class="featured-category-section pt-20">
		<div class="container-fluid">
			<div class="row">
                @foreach($latestcategoryads as $category)
                    <div class="col-md-4 px-md-2 px-1">
                        <div class="single-featured-category">
                            <figure>
                                <a href="{{ $category->link }}">
                                    <img loading="eager|lazy" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt=""></a>
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
            {{-- @if($relatedcategory->count() > 0)
                <div class="title-filter-area">
                    <div class="title-area w-100">
                        <h3 class="category-title">Related Categories - Royelmart.com</h3>
                    </div>
                    <div class="categories w-100">
                        <ul class="row">
                            @foreach($relatedcategory as $category)
                                <li class="col-md-3">
                                    <a href="{{ route('more-category', $category->slug) }}">
                                        <img loading="eager|lazy" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        <span>{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif --}}
			<div class="title-filter-area pb-40">
				<div class="title-area">
					<h3 class="category-title">{{ $title }} - Royelmart</h3>
				</div>
				<div class="filter-area">
					<ul class="filter-items">
						<li>
							<select class="form-select" aria-label="Default select" id="filter_high_low_price" onchange="filterByHighLow()">
							    <option value="latest" selected>Latest</option>
							    <option value="low">Price low to high</option>
							    <option value="high">Price high to low</option>
							</select>
						</li>
						<li>
							<select class="form-select" aria-label="Default select" id="filter_product_limit" onchange="filterByProLimit()">
							    <option value="20" selected>20</option>
							    <option value="40">40</option>
							    <option value="60">60</option>
							    <option value="100">100</option>
							</select>
						</li>
					</ul>
				</div>
			</div>

			@if ($products->count() > 0)
                <div class="sidebar-products-area">
                    @include('pages.partials.product-sidebar')

                    @include('pages.partials.product')
                </div>
            @else
                <div class="sidebar-products-area d-flex justify-content-center">
                    <img loading="eager|lazy" src="{{ asset('media/general-image/empty.webp') }}" alt="Product Not Found">
                </div>
            @endif
		</div>
	</section>
	<!-- End Single Categories Section -->
@endsection

@push('js')
    <script>
        function filterByHighLow(){
            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                loadHihhLowProduct();
            }, 1000);
        }

        function loadHihhLowProduct() {
            $("#loadingImage").hide();
            var filter_high_low_price = $('#filter_high_low_price').val();
            var filter_product_limit = $('#filter_product_limit').val();
            var cat_id = $('#cat_id').val();
            $.ajax({
                type    : "POST",
                url     : "{{ route('load-high-low-product') }}",
                data    : {
                    filter_product_limit : filter_product_limit,
                    filter_high_low_price : filter_high_low_price,
                    cat_id : cat_id,
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

        function filterByProLimit(){
            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                loadLimitProduct();
            }, 1000);
        }

        function loadLimitProduct() {
            $("#loadingImage").hide();
            var filter_high_low_price = $('#filter_high_low_price').val();
            var filter_product_limit = $('#filter_product_limit').val();
            var cat_id = $('#cat_id').val();
            $.ajax({
                type    : "POST",
                url     : "{{ route('load-limit-range-product') }}",
                data    : {
                    filter_product_limit : filter_product_limit,
                    filter_high_low_price : filter_high_low_price,
                    cat_id : cat_id,
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


        function loadMoreProduct(){
            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            setTimeout(function(){
                loadProduct();
            }, 1000);
        }

        function loadProduct() {
            $("#loadingImage").hide();
            var cat_id = $('#cat_id').val();
            var last_id = $('#last_id').val();
            $.ajax({
                type    : "POST",
                url     : "{{ route('load-more-category-product') }}",
                data    : {
                    cat_id : cat_id,
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

        function filterByPrice(obj){
            var price_range = obj.getAttribute('data-price');
            var cat_id = $('#cat_id').val();

            $('.price-range').removeClass("price-filter-active");
            $('.price-range').addClass("price-filter-de-active");

            var id = obj.id;
            $('#'+id).removeClass("price-filter-de-active");
            $('#'+id).addClass("price-filter-active");

            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                priceFilterProduct(cat_id, price_range);
            }, 1000);
        }


        function priceFilterProduct(cat_id, price_range) {
            $("#loadingImage").hide();

            $.ajax({
                type    : "POST",
                url     : "{{ route('product-filter-by-price-range') }}",
                data    : {
                    cat_id : cat_id,
                    price_range : price_range,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                    }
                },
            });
        };


        function filterByColor(color_id){
            var cat_id = $('#cat_id').val();

            $('.filter-color').removeClass("active");

            $('#filter_color_'+color_id).addClass("active");

            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                colorFilterProduct(cat_id, color_id);
            }, 1000);
        }

        function colorFilterProduct(cat_id, color_id) {
            $("#loadingImage").hide();

            $.ajax({
                type    : "POST",
                url     : "{{ route('product-filter-by-color') }}",
                data    : {
                    cat_id : cat_id,
                    color_id : color_id,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                    }
                },
            });
        };

        function filterBySize(size_id){
            var cat_id = $('#cat_id').val();

            $('.filter-size').removeClass("active");

            $('#filter_size_'+size_id).addClass("active");

            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                sizeFilterProduct(cat_id, size_id);
            }, 1000);
        }

        function sizeFilterProduct(cat_id, size_id) {
            $("#loadingImage").hide();

            $.ajax({
                type    : "POST",
                url     : "{{ route('product-filter-by-size') }}",
                data    : {
                    cat_id : cat_id,
                    size_id : size_id,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                    }
                },
            });
        };

        function filterByUnit(unit_id){
            var cat_id = $('#cat_id').val();

            $('.filter-unit').removeClass("active");

            $('#filter_unit_'+unit_id).addClass("active");

            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                unitFilterProduct(cat_id, unit_id);
            }, 1000);
        }

        function unitFilterProduct(cat_id, unit_id) {
            $("#loadingImage").hide();

            $.ajax({
                type    : "POST",
                url     : "{{ route('product-filter-by-unit') }}",
                data    : {
                    cat_id : cat_id,
                    unit_id : unit_id,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                    }
                },
            });
        };

        function filterByBrand(brand_id){
            var cat_id = $('#cat_id').val();

            $('.filter-brand').removeClass("active");

            $('#filter_brand_'+brand_id).addClass("active");

            $('#loadMoreBtn').hide();
            $("#loadingImage").show();
            $("#product-list" ).empty();
            setTimeout(function(){
                brandFilterProduct(cat_id, brand_id);
            }, 1000);
        }

        function brandFilterProduct(cat_id, brand_id) {
            $("#loadingImage").hide();

            $.ajax({
                type    : "POST",
                url     : "{{ route('product-filter-by-brand') }}",
                data    : {
                    cat_id : cat_id,
                    brand_id : brand_id,
                    _token  : '{{csrf_token()}}',
                },
                success:function(data) {
                    if(data['html'] == ''){
                        $('#loadMoreBtn').remove();
                    }else{
                        $('#loadMoreBtn').hide();
                        $("#product-list" ).append( data['html'] );
                        $("#last_id" ).val( data['last_id'] );
                    }
                },
            });
        };

    </script>
@endpush
