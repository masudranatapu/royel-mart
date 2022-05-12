@extends('layouts.frontend.app')

@section('title')
    {{$title}}
@endsection

@section('meta')

@endsection

@push('css')

@endpush

@section('content')
    @include('layouts.frontend.partial.general-breadcrumb')
	<!-- End Breadcrumb -->
	<section class="category-page-slider-section">
		<div class="container-fluid">
            <div class="category-page-slider owl-carousel">
                @foreach($categorybanners as $categorybanner)
                    <div class="single-slide">
                        <a href="{{ $categorybanner->link }}">
                            <img loading="eager|lazy" src="@if($categorybanner->image) {{ asset($categorybanner->image) }}  @else {{ asset('demomedia/category.png') }} @endif">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
	</section>
	<!-- End Category Page Slider -->
    <section class="category-section pt-2">
        <div class="container-fluid">
            <div class="heading-area">
                <h1 class="heading">{{ $title }}</h1>
            </div>

            <div class="categories-area">
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                            <div class="single-category">
                                <div class="icon">
                                    <a href="{{ route('more-category', $category->slug) }}">
                                        <img loading="eager|lazy" src="@if(file_exists($category->image)) {{ asset($category->image) }} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="">
                                    </a>
                                </div>
                                <h4 class="category-name">
                                    <a href="{{ route('more-category', $category->slug) }}">
                                        {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($category->name, $lan, 'en') }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
@endsection

@push('js')

@endpush
