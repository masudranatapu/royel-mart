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
					<img loading="eager|lazy" src="@if($categorybanner->image) {{ asset($categorybanner->image) }}  @else {{ asset('demomedia/category.png') }} @endif">
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
            @if($relatedcategory->count() > 0)
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
            @endif
			<div class="title-filter-area pb-40">
				<div class="title-area">
					<h3 class="category-title">{{ $title }} - Royelmart</h3>
				</div>
				<div class="filter-area">
					<ul class="filter-items">
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>Latest</option>
							    <option value="1">Price low to hogh</option>
							    <option value="2">Price low to hogh</option>
							</select>
						</li>
						<li>
							<select class="form-select" aria-label="Default select">
							    <option selected>20</option>
							    <option value="1">40</option>
							    <option value="2">60</option>
							    <option value="3">100</option>
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

    </script>
@endpush
