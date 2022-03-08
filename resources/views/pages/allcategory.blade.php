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

    <section class="category-section pt-2">
        <div class="container-fluid">
            <div class="categories-area">
                <div class="row">
                    @foreach($categories as $category)
                        @if($category->id == 1)
                        @else
                            <div class="col-xl-2 col-lg-3 col-md-3 col-4 mb-3">
                                <div class="single-category">
                                    <div class="icon">
                                        <a href="{{ route('category', $category->slug) }}">
                                            <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        </a>
                                    </div>
                                    <h4 class="category-name">
                                        <a href="{{ route('category', $category->slug) }}">{{ $category->name }}</a>
                                    </h4>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')

@endpush